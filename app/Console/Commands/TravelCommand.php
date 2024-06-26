<?php

namespace App\Console\Commands;

use App\Actions\Compta;
use App\Actions\ErrorDispatchHandle;
use App\Models\Railway\Config\RailwaySetting;
use App\Models\Railway\Planning\RailwayPlanning;
use App\Models\Railway\Planning\RailwayPlanningStation;
use App\Notifications\SendMessageAdminNotification;
use App\Services\Models\User\Railway\RailwayPlanningAction;
use App\Services\Models\User\Railway\UserRailwayAction;
use App\Services\Models\User\Railway\UserRailwayEngineAction;
use Carbon\Carbon;
use Illuminate\Console\Command;

class TravelCommand extends Command
{
    protected $signature = 'travel {action}';

    protected $description = 'Command description';

    public function handle(): void
    {
        match ($this->argument('action')) {
            'prepare' => $this->prepare(),
            'departure' => $this->departure(),
            'transit' => $this->transit(),
            'in_station' => $this->inStation(),
            'in_station_arrival' => $this->inStationArrival(),
            'in_station_departure' => $this->inStationDeparture(),
            'arrival' => $this->arrival(),
        };
    }

    private function prepare(): void
    {
        $plannings = RailwayPlanning::where('date_depart', [now()->addMinutes(20)->startOfMinute(), now()->addMinutes(20)->endOfMinute()])
            ->where('status', 'initialized')
            ->orWhere('status', 'retarded')
            ->get();

        foreach ($plannings as $planning) {
            if ((new UserRailwayEngineAction($planning->userRailwayEngine))->verifEngine()) {
                $planning->update(['status' => 'cancelled']);
                $planning->logs()->create([
                    'message' => "Rame {$planning->userRailwayEngine->number} indisponible",
                    'railway_planning_id' => $planning->id,
                ]);
                $planning->user->notify(new SendMessageAdminNotification(
                    title: "Matériel Indisponible pour le trajet: {$planning->userRailwayLigne->railwayLigne->name}",
                    sector: 'alert',
                    type: 'warning',
                    message: "La rame {$planning->userRailwayEngine->number}/{$planning->userRailwayEngine->railwayEngine->name} n'est pas disponible car il doit effectuer une maintenance préventive."
                ));
            } else {
                try {
                    $planning->update(['status' => 'departure']);
                    $planning->userRailwayEngine()->update(['status' => 'travel']);
                    $planning->logs()->create([
                        'message' => "Départ de la rame {$planning->userRailwayEngine->number} en direction de la gare de départ",
                        'railway_planning_id' => $planning->id,
                    ]);
                } catch (\Exception $exception) {
                    (new ErrorDispatchHandle())->handle($exception);
                }
            }
        }
    }

    private function departure(): void
    {
        $plannings = RailwayPlanning::whereBetween('date_depart', [now()->startOfMinute(), now()->endOfMinute()])
            ->get();

        foreach ($plannings as $planning) {
            $planning->logs()->create([
                'message' => "Rame {$planning->userRailwayEngine->number} prêt au départ pour la gare de {$planning->userRailwayLigne->railwayLigne->end->name}",
                'railway_planning_id' => $planning->id,
            ]);
            $planning->user->notify(new SendMessageAdminNotification(
                title: 'Attention au départ',
                sector: 'alert',
                type: 'info',
                message: "Rame {$planning->userRailwayEngine->number} prêt au départ pour la gare de {$planning->userRailwayLigne->railwayLigne->end->name}"
            ));
        }
    }

    private function transit(): void
    {
        $plannings = RailwayPlanning::whereBetween('date_depart', [now()->subMinutes(2)->startOfMinute(), now()->subMinutes(2)->endOfMinute()])
            ->get();

        try {
            foreach ($plannings as $planning) {
                $planning->update(['status' => 'travel']);
                $planning->logs()->create([
                    'message' => "Rame {$planning->userRailwayEngine->number} en transit pour la gare de {$planning->userRailwayLigne->railwayLigne->end->name}",
                    'railway_planning_id' => $planning->id,
                ]);
            }
        } catch (\Exception $exception) {
            (new ErrorDispatchHandle())->handle($exception);
        }
    }

    private function inStation(): void
    {
        $stations = RailwayPlanningStation::whereBetween('arrival_at', [now()->startOfMinute(), now()->endOfMinute()])
            ->get();

        try {
            foreach ($stations as $station) {
                $station->railwayPlanning->update([
                    'status' => 'in_station',
                ]);

                if ($station->railwayLigneStation->id != $station->railwayPlanning->userRailwayLigne->railwayLigne->start->id || $station->railwayLigneStation->id != $station->railwayPlanning->userRailwayLigne->railwayLigne->end->id) {
                    if ($station->railwayPlanning->userRailwayEngine->railwayEngine->type_transport->value == 'ter' || $station->railwayPlanning->userRailwayEngine->railwayEngine->type_transport->value == 'other') {
                        $actualPassengers = $station->railwayPlanning->passengers()->where('type', 'unique')->sum('nb_passengers');
                        $limitPassengerEngine = $station->railwayPlanning->userRailwayLigne->userRailwayEngine->siege;
                        if ($limitPassengerEngine > $actualPassengers) {
                            $station->railwayPlanning->passengers()->create([
                                'type' => 'unique',
                                'nb_passengers' => rand(0, $limitPassengerEngine - $actualPassengers),
                                'railway_planning_id' => $station->railwayPlanning->id,
                            ]);
                        } else {
                            $station->railwayPlanning->passengers()->create([
                                'type' => 'unique',
                                'nb_passengers' => 0,
                                'railway_planning_id' => $station->railwayPlanning->id,
                            ]);
                        }
                    } else {
                        $actualPassengersFirst = $station->railwayPlanning->passengers()->where('type', 'first')->sum('nb_passengers');
                        $limitPassengerFirstEngine = $station->railwayPlanning->userRailwayLigne->userRailwayEngine->siege * 20 / 100;
                        if($limitPassengerFirstEngine > $actualPassengersFirst) {
                            $station->railwayPlanning->passengers()->create([
                                'type' => 'first',
                                'nb_passengers' => rand(0, $limitPassengerFirstEngine - $actualPassengersFirst),
                                'railway_planning_id' => $station->railwayPlanning->id,
                            ]);
                        } else {
                            $station->railwayPlanning->passengers()->create([
                                'type' => 'first',
                                'nb_passengers' => 0,
                                'railway_planning_id' => $station->railwayPlanning->id,
                            ]);
                        }

                        $actualPassengersSecond = $station->railwayPlanning->passengers()->where('type', 'second')->sum('nb_passengers');
                        $limitPassengerSecondEngine = $station->railwayPlanning->userRailwayLigne->userRailwayEngine->siege * 80 / 100;
                        if($limitPassengerSecondEngine > $actualPassengersSecond) {
                            $station->railwayPlanning->passengers()->create([
                                'type' => 'second',
                                'nb_passengers' => rand(0, $limitPassengerSecondEngine - $actualPassengersSecond),
                                'railway_planning_id' => $station->railwayPlanning->id,
                            ]);
                        } else {
                            $station->railwayPlanning->passengers()->create([
                                'type' => 'second',
                                'nb_passengers' => 0,
                                'railway_planning_id' => $station->railwayPlanning->id,
                            ]);
                        }
                    }
                }

                $station->railwayPlanning->logs()->create([
                    'message' => "Le {$station->railwayPlanning->userRailwayEngine->railwayEngine->type_transport->name} N° {$station->railwayPlanning->userRailwayEngine->number} est en gare de {$station->name}",
                    'railway_planning_id' => $station->railwayPlanning->id,
                ]);
            }
        } catch (\Exception $exception) {
            (new ErrorDispatchHandle())->handle($exception);
        }
    }

    private function inStationDeparture(): void
    {
        $stations = RailwayPlanningStation::whereBetween('departure_at', [now()->startOfMinute(), now()->endOfMinute()])
            ->get();

        foreach ($stations as $station) {
            $station->update([
                'status' => 'done',
            ]);

            $station->railwayPlanning->update([
                'status' => 'travel',
            ]);

            $station->railwayPlanning->logs()->create([
                'message' => "Le {$station->railwayPlanning->userRailwayEngine->railwayEngine->type_transport->name} N° {$station->railwayPlanning->userRailwayEngine->number} part de la gare de {$station->name}",
                'railway_planning_id' => $station->railwayPlanning->id,
            ]);
        }
    }

    private function inStationArrival(): void
    {
        $stations = RailwayPlanningStation::whereBetween('arrival_at', [now()->addMinutes(2)->startOfMinute(), now()->addMinutes(2)->endOfMinute()])
            ->get();

        foreach ($stations as $station) {
            $station->update([
                'status' => 'arrival',
            ]);

            $station->railwayPlanning->logs()->create([
                'message' => "Le {$station->railwayPlanning->userRailwayEngine->railwayEngine->type_transport->name} N° {$station->railwayPlanning->userRailwayEngine->number} va entrer en gare de {$station->name}",
                'railway_planning_id' => $station->railwayPlanning->id,
            ]);
        }
    }

    private function arrival(): void
    {
        $plannings = RailwayPlanning::where('status', 'travel')
            ->orWhere('status', 'in_station')
            ->get();

        foreach ($plannings as $planning) {
            if ($planning->date_arrived < now()) {
                $planning->update(['status' => 'arrival']);
                $ca_other = rand(0, $planning->passengers()->sum('nb_passengers')) * \Helpers::randomFloat(1, 20);

                $planning->travel()->update([
                    'ca_billetterie' => $this->resultatBilletterie($planning),
                    'ca_other' => $ca_other,
                    'fee_electrique' => $this->feeElectrique($planning),
                    'fee_gasoil' => $this->feeGasoil($planning),
                    'fee_other' => ($planning->userRailwayLigne->railwayLigne->hub->taxe_hub_price / $planning->userRailwayLigne->railwayLigne->distance) * 10 ,
                ]);

                $planning->userRailwayEngine->use_percent += (new UserRailwayEngineAction($planning->userRailwayEngine))->getTotalUsure();
                $planning->userRailwayEngine->save();

                (new Compta())->create(
                    user: $planning->user,
                    title: "Vente de la ligne: {$planning->userRailwayLigne->railwayLigne->name}",
                    amount: $this->resultatBilletterie($planning),
                    type_amount: 'revenue',
                    type_mvm: 'billetterie',
                    user_railway_ligne_id: $planning->userRailwayLigne->id,
                    user_railway_hub_id: $planning->userRailwayHub->id,
                );
                (new Compta())->create(
                    user: $planning->user,
                    title: "Vente Additionnel de la ligne: {$planning->userRailwayLigne->railwayLigne->name}",
                    amount: $ca_other,
                    type_amount: 'revenue',
                    type_mvm: 'rent_trajet_aux',
                    user_railway_ligne_id: $planning->userRailwayLigne->id,
                    user_railway_hub_id: $planning->userRailwayHub->id,
                );
                (new Compta())->create(
                    user: $planning->user,
                    title: "Taxe de passage en gare pour la ligne: {$planning->userRailwayLigne->railwayLigne->name}",
                    amount: ($planning->userRailwayLigne->railwayLigne->hub->taxe_hub_price / $planning->userRailwayLigne->railwayLigne->distance) * 10,
                    type_amount: 'charge',
                    type_mvm: 'taxe',
                    user_railway_ligne_id: $planning->userRailwayLigne->id,
                    user_railway_hub_id: $planning->userRailwayHub->id,
                );

                $planning->userRailwayEngine->update([
                    'status' => 'free',
                ]);

                $planning->logs()->create([
                    'message' => 'Arrivée du train en gare de '.$planning->userRailwayLigne->railwayLigne->end->name,
                    'railway_planning_id' => $planning->id,
                ]);

                $planning->user->notify(new SendMessageAdminNotification(
                    title: 'Arrivée en Gare !',
                    sector: 'alert',
                    type: 'info',
                    message: "La Rame {$planning->userRailwayEngine->railwayEngine->name} / {$planning->userRailwayEngine->number} vient d'arriver en gare de {$planning->userRailwayLigne->railwayLigne->end->name}"
                ));

                (new UserRailwayAction($planning->user->railway))->addExperience(100);
                $planning->user->railway->research_mat += intval(0.0458 * $planning->userRailwayLigne->railwayLigne->distance);
                $planning->user->railway->save();
            }
        }
    }

    private function resultatBilletterie(RailwayPlanning $planning)
    {
        $tarifs = $planning->userRailwayLigne->tarifs()
            ->whereDate('date_tarif', Carbon::today())
            ->get();
        $sum = 0;

        foreach ($tarifs as $tarif) {
            $sum += $tarif->price * $planning->passengers()->where('type', $tarif->type_tarif)->sum('nb_passengers');
        }

        return $sum;
    }

    private function feeElectrique(RailwayPlanning $planning)
    {
        $amount = RailwaySetting::where('name', 'price_electricity')->first()->value * $planning->userRailwayLigne->railwayLigne->distance;
        if ($planning->userRailwayEngine->railwayEngine->type_energy->value == 'electrique' || $planning->userRailwayEngine->railwayEngine->type_energy->value == 'hybrid') {
            (new Compta())->create(
                user: $planning->user,
                title: "Frais électrique pour la ligne: {$planning->userRailwayLigne->railwayLigne->name}",
                amount: $amount,
                type_amount: 'charge',
                type_mvm: 'electricite'
            );

            return $amount;
        } else {
            return 0;
        }
    }

    private function feeGasoil(mixed $planning)
    {
        $amount = RailwaySetting::where('name', 'price_diesel')->first()->value * $planning->userRailwayLigne->railwayLigne->distance;
        if ($planning->userRailwayEngine->railwayEngine->type_energy->value == 'diesel' || $planning->userRailwayEngine->railwayEngine->type_energy->value == 'hybrid') {
            (new Compta())->create(
                user: $planning->user,
                title: "Frais gasoil pour la ligne: {$planning->userRailwayLigne->railwayLigne->name}",
                amount: $amount,
                type_amount: 'charge',
                type_mvm: 'gasoil'
            );

            return $amount;
        } else {
            return 0;
        }
    }
}
