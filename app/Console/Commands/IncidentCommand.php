<?php

namespace App\Console\Commands;

use App\Actions\IncidentAction;
use App\Models\Railway\Planning\RailwayPlanning;
use App\Models\User\Railway\UserRailwayEngine;
use App\Notifications\SendMessageAdminNotification;
use App\Services\Models\User\Railway\UserRailwayEngineAction;
use Illuminate\Console\Command;
use Illuminate\Database\Eloquent\Builder;

class IncidentCommand extends Command
{
    protected $signature = 'incident {action}';

    protected $description = 'Command description';

    public function handle(): void
    {
        match ($this->argument('action')) {
            'before' => $this->before(),
            'after' => $this->after(),
        };
    }

    private function before(): void
    {
        $plannings = RailwayPlanning::whereBetween('date_depart', [now()->startOfMinute(), now()->addMinutes(10)->endOfMinute()])
            ->where('status', '!=', 'cancelled')
            ->get();

        if ($plannings->count() > 0) {
            foreach ($plannings as $planning) {
                $probability = $this->calculateIncidentProbability($planning->userRailwayEngine);
                if ($this->shouldTriggerIncident($probability)) {
                    $incident = (new IncidentAction())->newIncident($planning);
                    $this->createIncident($planning, $incident);
                    $retarded_time = $incident['retarded_time'];

                    if ($incident['niveau'] <= 2) {
                        $this->retardedIncident($planning, $incident, $retarded_time);
                    } else {
                        $this->cancelledIncident($planning, $incident);
                    }
                }
            }
        }
    }

    private function after(): void
    {
        $plannings = RailwayPlanning::where(function (Builder $query) {
            $query->where('status', 'travel')
                ->orWhere('status', 'in_station');
        })->get();

        if ($plannings->count() > 0) {
            foreach ($plannings as $planning) {
                $probability = $this->calculateIncidentProbability($planning->userRailwayEngine);
                if ($this->shouldTriggerIncident($probability)) {
                    $incident = (new IncidentAction())->newIncident($planning);
                    $this->createIncident($planning, $incident);
                    $retarded_time = $incident['retarded_time'];

                    if ($incident['niveau'] <= 2) {
                        $this->retardedIncident($planning, $incident, $retarded_time);
                    } else {
                        $this->cancelledIncident($planning, $incident);
                    }
                }
            }
        }
    }

    public function createIncident(RailwayPlanning $planning, array $incident)
    {
        return $planning->incidents()->create([
            'type_incident' => $incident['type_incident'],
            'niveau' => $incident['niveau'],
            'designation' => $incident['designation'],
            'note' => $incident['note'],
            'created_at' => now(),
            'updated_at' => now(),
            'user_id' => $planning->user->id,
            'railway_planning_id' => $planning->id,
            'user_railway_engine_id' => $planning->userRailwayEngine->id,
            'user_railway_hub_id' => $planning->userRailwayHub->id,
            'amount_reparation' => (new IncidentAction())->getAmountReparation($incident['niveau']),
        ]);
    }

    private function retardedIncident(RailwayPlanning $planning, array $incident, int $retarded_time): void
    {
        $planning->retarded_time += $retarded_time;
        $planning->status = 'retarded';
        $planning->save();

        $planning->date_depart = $planning->date_depart->addMinutes($retarded_time);
        $planning->date_arrived = $planning->date_arrived->addMinutes($retarded_time);
        $planning->save();

        $planning->userRailwayEngine->use_percent += (new UserRailwayEngineAction($planning->userRailwayEngine))->getVitesseUsure();
        $planning->userRailwayEngine->save();

        foreach ($planning->stations()->where('status', '!=', 'done')->get() as $station) {
            $station->update([
                'arrival_at' => $station->arrival_at->addMinutes($retarded_time),
                'departure_at' => $station->departure_at->addMinutes($retarded_time),
            ]);
        }

        $planning->user->notify(new SendMessageAdminNotification(
            title: 'Incident',
            sector: 'alert',
            type: $incident['niveau'] == 1 ? 'info' : 'warning',
            message: "Incident lors de la préparation du train N°{$planning->userRailwayEngine->number}.<br>Le train à été retardé de {$retarded_time} minutes.",
        ));
    }

    private function cancelledIncident(RailwayPlanning $planning, array $incident): void
    {
        $planning->status = 'cancelled';
        $planning->save();

        $planning->userRailwayEngine->use_percent += (new UserRailwayEngineAction($planning->userRailwayEngine))->getVitesseUsure() * 2;
        $planning->userRailwayEngine->save();

        foreach ($planning->stations()->where('status', '!=', 'done')->get() as $station) {
            $station->update([
                'status' => 'done',
            ]);
        }

        $planning->user->notify(new SendMessageAdminNotification(
            title: 'Incident',
            sector: 'alert',
            type: $incident['niveau'] == 1 ? 'info' : 'warning',
            message: "Incident Grave lors de la préparation du train N°{$planning->userRailwayEngine->number}.<br>Le train à été annulé",
        ));
    }

    private function calculateIncidentProbability(UserRailwayEngine $engine)
    {
        $wearFactor = $engine->actual_usure; // Assuming 'wear' is a percentage value (0-100)
        $ageFactor = $engine->indice_ancien;   // Assuming 'age' is a value from 0 to 5

        // Calculate the probability
        return ($wearFactor / 100) * ($ageFactor / 5);
    }

    private function shouldTriggerIncident($probability)
    {
        // Generate a random number between 0 and 1
        $randomNumber = mt_rand() / mt_getrandmax();

        // If the random number is less than the probability, trigger an incident
        return $randomNumber < $probability;
    }
}
