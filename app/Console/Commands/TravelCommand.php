<?php

namespace App\Console\Commands;

use App\Actions\ErrorDispatchHandle;
use App\Models\Railway\Planning\RailwayPlanning;
use App\Notifications\SendMessageAdminNotification;
use App\Services\Models\User\Railway\RailwayPlanningAction;
use App\Services\Models\User\Railway\UserRailwayEngineAction;
use Illuminate\Console\Command;

class TravelCommand extends Command
{
    protected $signature = 'travel {action}';

    protected $description = 'Command description';

    public function handle(): void
    {
        match ($this->option('action')) {
            'prepare' => $this->prepare(),
            'departure' => $this->departure(),
            'transit' => $this->transit()
        };
    }

    private function prepare()
    {
        $plannings = RailwayPlanning::where('date_depart', [now()->addMinutes(20)->startOfMinute(), now()->addMinutes(20)->endOfMinute()])
            ->where('status', 'initialized')
            ->orWhere('status', 'retarded')
            ->get();

        foreach ($plannings as $planning) {
            if((new UserRailwayEngineAction($planning->userRailwayEngine))->verifEngine()) {
                $planning->update(['status' => 'cancelled']);
                $planning->logs()->create([
                    'message' => "Rame {$planning->userRailwayEngine->number} indisponible",
                    'railway_planning_id' => $planning->id
                ]);
                $planning->user->notify(new SendMessageAdminNotification(
                    title: "Matériel Indisponible pour le trajet: {$planning->userRailwayLigne->railwayLigne->name}",
                    sector: 'alert',
                    type: 'warning',
                    message: "La rame {$planning->userRailwayEngine->number}/{$planning->userRailwayEngine->railwayEngine->name} n'est pas disponible car il doit effectuer une maintenance préventive."
                ));
            } else {
                try {
                    (new RailwayPlanningAction($planning))->prepareVoyageur();
                    $planning->update(['status' => 'departure']);
                    $planning->userRailwayEngine()->update(['status' => 'travel']);
                    $planning->logs()->create([
                        'message' => "Départ de la rame {$planning->userRailwayEngine->number} en direction de la gare de départ",
                        'railway_planning_id' => $planning->id
                    ]);
                    $planning->user->notify(new SendMessageAdminNotification(
                        title: "Trajet {$planning->userRailwayEngine->number} en cours",
                        sector: 'alert',
                        type: 'info',
                        message: "Départ de la rame {$planning->userRailwayEngine->number} en direction de la gare de départ"
                    ));
                } catch (\Exception $exception) {
                    (new ErrorDispatchHandle())->handle($exception);
                }
            }
        }
    }

    private function departure()
    {
        $plannings = RailwayPlanning::whereBetween('date_depart', [now()->startOfMinute(), now()->endOfMinute()])
            ->get();

        foreach ($plannings as $planning) {
            $planning->logs()->create([
                'message' => "Rame {$planning->userRailwayEngine->number} prêt au départ pour la gare de {$planning->userRailwayLigne->railwayLigne->end->name}",
                'railway_planning_id' => $planning->id
            ]);
            $planning->user->notify(new SendMessageAdminNotification(
                title: "Attention au départ",
                sector: 'alert',
                type: 'info',
                message: "Rame {$planning->userRailwayEngine->number} prêt au départ pour la gare de {$planning->userRailwayLigne->railwayLigne->end->name}"
            ));
        }
    }

    private function transit()
    {
        $plannings = RailwayPlanning::whereBetween('date_depart', [now()->subMinutes(2)->startOfMinute(), now()->subMinutes(2)->endOfMinute()])
            ->get();

        try {
            foreach ($plannings as $planning) {
                $planning->update(['status' => 'travel']);
                $planning->logs()->create([
                    'message' => "Rame {$planning->userRailwayEngine->number} en transit pour la gare de {$planning->userRailwayLigne->railwayLigne->end->name}",
                    'railway_planning_id' => $planning->id
                ]);
                $planning->user->notify(new SendMessageAdminNotification(
                    title: "En transit",
                    sector: 'alert',
                    type: 'info',
                    message: "Rame {$planning->userRailwayEngine->number} en transit pour la gare de {$planning->userRailwayLigne->railwayLigne->end->name}"
                ));
            }
        } catch (\Exception $exception) {
            (new ErrorDispatchHandle())->handle($exception);
        }
    }

}
