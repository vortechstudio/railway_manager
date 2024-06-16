<?php

namespace App\Console\Commands;

use App\Actions\Account\MailboxAction;
use App\Actions\Compta;
use App\Models\Railway\Config\RailwaySetting;
use App\Models\Railway\Gare\RailwayGare;
use App\Models\User\Railway\UserRailway;
use App\Models\User\Railway\UserRailwayHub;
use App\Models\User\Railway\UserRailwayLigne;
use App\Models\User\User;
use App\Notifications\SendMessageAdminNotification;
use App\Services\Models\Railway\Ligne\RailwayLigneStationAction;
use App\Services\Models\User\Railway\UserRailwayAction;
use App\Services\Models\User\Railway\UserRailwayLigneAction;
use App\Services\RailwayService;
use App\Services\WeatherService;
use Carbon\Carbon;
use Illuminate\Console\Command;
use Illuminate\Database\Eloquent\Builder;

class SystemActionCommand extends Command
{
    protected $signature = 'system {action}';

    protected $description = 'Command description';

    public function handle(): void
    {
        match ($this->argument('action')) {
            'planning_today' => $this->planningToday(),
            'update_weather' => $this->updateWeather(),
            'tarif_today' => $this->tarifToday(),
            'updateReward' => $this->updateReward(),
            'transfertResearch' => $this->transfertResearch(),
            'rent_commerce' => $this->rentCommerce(),
            'ca_daily_calculate' => $this->caDailyCalculate(),
            'rent_publicities' => $this->rentPublicities(),
            'rent_parking' => $this->rentParking()
        };
    }

    private function planningToday(): void
    {
        $service = (new RailwayService())->getRailwayService();
        $service_id = $service->id;
        $users = User::with('railway')->whereHas('services', function (Builder $query) use ($service_id) {
            $query->where('service_id', $service_id);
        })->get();
        $dayWork = Carbon::today()->locale('fr_FR')->dayOfWeekIso;

        foreach ($users as $user) {
            if ($user->railway()->exists()) {
                \Log::info("Inscription du planning pour l'utilisateur: {$user->id}");
                if ($user->railway->automated_planning) {
                    foreach ($user->userRailwayLigne()->where('active', true)->get() as $ligne) {
                        for ($i = 0; $i <= $ligne->nb_depart_jour; $i++) {
                            $minDay = now()->startOfDay()->diffInMinutes(now()->endOfDay());
                            $diff = $minDay / $ligne->nb_depart_jour;

                            $planning = $ligne->plannings()->create([
                                'date_depart' => now()->startOfDay()->addMinutes($diff * $i),
                                'status' => 'initialized',
                                'kilometer' => $ligne->railwayLigne->distance,
                                'date_arrived' => now()->startOfDay()->addMinutes($diff * $i)->addMinutes($ligne->railwayLigne->time_min),
                                'user_railway_hub_id' => $ligne->userRailwayHub->id,
                                'user_railway_ligne_id' => $ligne->id,
                                'user_railway_engine_id' => $ligne->userRailwayEngine->id,
                                'user_id' => $user->id,
                            ]);

                            $planning->travel()->create([
                                'ca_billetterie' => 0,
                                'ca_other' => 0,
                                'fee_electrique' => 0,
                                'fee_gasoil' => 0,
                                'fee_other' => 0,
                                'railway_planning_id' => $planning->id,
                            ]);

                            foreach ($ligne->railwayLigne->stations as $station) {
                                if ($station->gare->id == $ligne->railwayLigne->start->id || $station->gare->id == $ligne->railwayLigne->end->id) {
                                    $planning->stations()->create([
                                        'name' => $station->gare->name,
                                        'departure_at' => $planning->date_depart->addMinutes($station->time),
                                        'arrival_at' => $planning->date_depart->addMinutes($station->time),
                                        'railway_planning_id' => $planning->id,
                                        'railway_ligne_station_id' => $station->id,
                                    ]);
                                } else {
                                    $previous_station = $planning->stations()->orderBy('id', 'desc')->first();
                                    $planning->stations()->create([
                                        'name' => $station->gare->name,
                                        'departure_at' => $planning->date_depart->addMinutes($station->time + (new RailwayLigneStationAction($station))->timeStopStation()),
                                        'arrival_at' => $planning->date_depart->addMinutes($station->time),
                                        'railway_planning_id' => $planning->id,
                                        'railway_ligne_station_id' => $station->id,
                                    ]);
                                }
                            }
                        }
                    }
                } else {
                    foreach ($user->railway_planning_constructors as $constructor) {
                        if (in_array($dayWork, json_decode($constructor->day_of_week))) {
                            $planning = $constructor->userRailwayEngine->plannings()->create([
                                'date_depart' => now()->setTime($constructor->start_at->hour, $constructor->start_at->minute),
                                'status' => 'initialized',
                                'kilometer' => $constructor->userRailwayEngine->userRailwayLigne->railwayLigne->distance,
                                'date_arrived' => now()->setTime($constructor->end_at->hour, $constructor->end_at->minute),
                                'user_railway_hub_id' => $constructor->userRailwayEngine->userRailwayHub->id,
                                'user_railway_ligne_id' => $constructor->userRailwayEngine->userRailwayLigne->id,
                                'user_railway_engine_id' => $constructor->userRailwayEngine->id,
                                'user_id' => $user->id,
                            ]);

                            $planning->travel()->create([
                                'ca_billetterie' => 0,
                                'ca_other' => 0,
                                'fee_electrique' => 0,
                                'fee_gasoil' => 0,
                                'fee_other' => 0,
                                'railway_planning_id' => $planning->id,
                            ]);

                            foreach ($planning->userRailwayLigne->railwayLigne->stations as $station) {

                                if ($station->gare->id == $constructor->userRailwayEngine->userRailwayLigne->railwayLigne->start->id) {
                                    $planning->stations()->create([
                                        'name' => $station->gare->name,
                                        'departure_at' => $planning->date_depart,
                                        'arrival_at' => $planning->date_depart->subMinutes(2),
                                        'railway_planning_id' => $planning->id,
                                        'railway_ligne_station_id' => $station->id,
                                    ]);
                                } elseif ($station->gare->id == $constructor->userRailwayEngine->userRailwayLigne->railwayLigne->end->id) {
                                    $previous_station = $planning->stations()->orderBy('id', 'desc')->first();
                                    $arrival_at = (new RailwayLigneStationAction($station))->timeStopStation();
                                    $planning->stations()->create([
                                        'name' => $station->gare->name,
                                        'departure_at' => $previous_station->arrival_at->addMinutes($station->time + $arrival_at),
                                        'arrival_at' => $previous_station->departure_at->addMinutes($station->time),
                                        'railway_planning_id' => $planning->id,
                                        'railway_ligne_station_id' => $station->id,
                                    ]);
                                    $planning->update([
                                        'date_arrived' => $previous_station->departure_at->addMinutes($station->time),
                                    ]);
                                } else {
                                    $previous_station = $planning->stations()->orderBy('id', 'desc')->first();
                                    $arrival_at = (new RailwayLigneStationAction($station))->timeStopStation();
                                    $planning->stations()->create([
                                        'name' => $station->gare->name,
                                        'departure_at' => $previous_station->arrival_at->addMinutes($station->time + $arrival_at),
                                        'arrival_at' => $previous_station->departure_at->addMinutes($station->time),
                                        'railway_planning_id' => $planning->id,
                                        'railway_ligne_station_id' => $station->id,
                                    ]);
                                }
                            }
                        }
                    }
                }
            }
        }
    }

    private function updateWeather(): void
    {
        $gares = RailwayGare::all();
        $bar = $this->output->createProgressBar(count($gares));

        $bar->start();
        foreach ($gares as $gare) {
            $weather = (new WeatherService())->getWeather($gare->name);

            if (isset($weather->current)) {
                if ($gare->weather()->exists()) {
                    $gare->weather()->update([
                        'weather' => $weather->current->condition->text,
                        'temperature' => $weather->current->temp_c,
                        'latest_update' => now(),
                        'railway_gare_id' => $gare->id,
                    ]);
                } else {
                    $gare->weather()->create([
                        'weather' => $weather->current->condition->text,
                        'temperature' => $weather->current->temp_c,
                        'latest_update' => now(),
                        'railway_gare_id' => $gare->id,
                    ]);
                }
            } else {
                $gare->weather()->updateOrCreate(['gare_id' => $gare->id], [
                    'weather' => 'inconnue',
                    'temperature' => 0,
                    'latest_update' => now(),
                    'railway_gare_id' => $gare->id,
                ]);
            }

            $bar->advance();
        }

        $bar->finish();
        \Log::notice('Mise à jour de la météo terminé');
    }

    private function tarifToday(): void
    {
        foreach (UserRailwayLigne::where('active', true)->get() as $ligne) {
            if (! $ligne->tarifs()->whereDate('date_tarif', Carbon::today())->exists()) {
                (new UserRailwayLigneAction($ligne))->createTarif();
            }
        }
    }

    private function updateReward(): void
    {
        $service = (new RailwayService())->getRailwayService();
        $service_id = $service->id;
        $users = User::with('railway')->whereHas('services', function (Builder $query) use ($service_id) {
            $query->where('service_id', $service_id);
        })->get();
        $response = \Http::get("https://api.github.com/repos/vortechstudio/$service->repository/releases/latest")->object();

        foreach ($users as $user) {
            if ($user->railway()->exists()) {
                (new MailboxAction())->newMessage(
                    user: $user,
                    subject: 'Compensation de mise à jour',
                    message: $this->contentMessageUpdate($user, $response),
                    type: 'account',
                    rewards: [
                        [
                            'type' => 'argent',
                            'value' => '200000',
                        ],
                        [
                            'type' => 'tpoint',
                            'value' => '50',
                        ],
                    ]
                );
            }
        }
    }

    private function contentMessageUpdate(mixed $user, ?object $response)
    {
        ob_start();
        ?>
        <span class="fw-bold">Cher directeur,</span>
        <p>
            La mise à jour <strong><?= $response->tag_name ?></strong> a été déployé avec succès.<br>
            Veuillez trouver ci-joint la compensation pour ce désagrément.
        </p>
        <span class="fst-italic">
            Cordialement,
            <span class="fw-semibold"><?= $user->railway->name_conseiller ?></span>
        </span>
        <?php
        return ob_get_clean();
    }

    private function transfertResearch()
    {
        $set = RailwaySetting::where('name', 'exchange_tpoint')->first();
        $date = Carbon::today();
        foreach (UserRailway::all() as $user) {
            $amount_transfert = $user->research + ($user->user->railway_company->research_coast_base * $set->value);
            $user->update([
                'research' => $amount_transfert,
            ]);
            (new Compta())->create(
                user: $user->user,
                title: "Transfert R&D - {$date}",
                amount: $amount_transfert,
                type_amount: 'charge',
                type_mvm: 'research',
                valorisation: false,
            );
        }
    }

    private function rentCommerce()
    {
        foreach (UserRailwayHub::all() as $hub) {
            $amount = 0;
            $count_commerce = 0;
            foreach ($hub->commerces as $commerce) {
                (new Compta())->create(
                    user: $hub->user,
                    title: 'Paiement de la societe '.$commerce->societe,
                    amount: $commerce->ca_daily,
                    type_amount: 'revenue',
                    type_mvm: 'commerce',
                    valorisation: false,
                    user_railway_hub_id: $commerce->userRailwayHub->id
                );
                $amount += $commerce->ca_daily;
                $count_commerce++;
            }
            $amount = \Helpers::eur($amount);
            (new UserRailwayAction($hub->user->railway))->addExperience(25 * $count_commerce);
            $hub->user->notify(new SendMessageAdminNotification(
                title: 'Paiement des Contrats Commercials',
                sector: 'alert',
                type: 'info',
                message: "L'ensemble des commerces de vos hubs vous ont rapporter: {$amount} aujourd'hui"
            ));
        }
    }

    private function caDailyCalculate()
    {
        foreach (User::all() as $user) {
            foreach ($user->userRailwayHub as $hub) {
                foreach ($hub->commerces as $commerce) {
                    $commerce->update([
                        'ca_daily' => $commerce->ca_daily + ($commerce->ca_daily * $user->railway_company->rent_aux / 100) * $commerce->nb_slot_commerce,
                    ]);
                }
            }
        }
    }

    private function rentPublicities()
    {
        foreach (UserRailwayHub::all() as $hub) {
            $amount = 0;
            $count_publicity = 0;

            foreach ($hub->publicities as $publicity) {
                (new Compta())->create(
                    user: $hub->user,
                    title: 'Paiement publicitaire: '.$publicity->societe,
                    amount: $publicity->ca_daily,
                    type_amount: 'revenue',
                    type_mvm: 'publicite',
                    valorisation: false,
                    user_railway_hub_id: $hub->id,
                );

                $amount += $publicity->ca_daily;
                $count_publicity++;
            }

            $amount = \Helpers::eur($amount);
            (new UserRailwayAction($hub->user->railway))->addExperience(25 * $count_publicity);
            $hub->user->notify(new SendMessageAdminNotification(
                'Paiement des contrats publicitaires',
                sector: 'alert',
                type: 'info',
                message: "L'ensemble des publicités de vos hubs vous ont rapporter: {$amount} aujourd'hui"
            ));
        }
    }

    private function rentParking()
    {
        foreach (UserRailwayHub::all() as $hub) {
            $price_parking = RailwaySetting::where('name', 'price_parking')->first()->value;
            $nb_passengers = 0;

            foreach ($hub->plannings()->whereBetween('date_depart', [now()->startOfDay(), now()->endOfDay()])->get() as $planning) {
                $nb_passengers += $planning->passengers()->sum('nb_passengers');
            }
            $ca_parking = ($price_parking * 20) * $nb_passengers;

            (new Compta())->create(
                user: $hub->user,
                title: 'Revenue journalier du parking du hub: '.$hub->railwayHub->gare->name,
                amount: $ca_parking,
                type_amount: 'revenue',
                type_mvm: 'parking',
                valorisation: false,
                user_railway_hub_id: $hub->id
            );

            (new UserRailwayAction($hub->user->railway))->addExperience(100);
            $amount = \Helpers::eur($ca_parking);
            $hub->user->notify(new SendMessageAdminNotification(
                'Revenue des parkings',
                sector: 'alert',
                type: 'info',
                message: "Le parking du hub {$hub->railwayHub->gare->name} vous à rapporter {$amount} aujourd'hui"
            ));
        }
    }
}
