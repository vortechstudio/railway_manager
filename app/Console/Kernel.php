<?php

namespace App\Console;

use Illuminate\Console\Scheduling\Schedule;
use Illuminate\Foundation\Console\Kernel as ConsoleKernel;

class Kernel extends ConsoleKernel
{
    /**
     * Define the application's command schedule.
     */
    protected function schedule(Schedule $schedule): void
    {
        // $schedule->command('inspire')->hourly();
        $schedule->command('system planning_today')->daily()->description('Définie le planning des trajets du jour');
        $schedule->command('system update_weather')->everySixHours()->description('Met à jour la météo des gares');
        $schedule->command('system tarif_today')->daily()->description('Met à jour les tarif des lignes');
        $schedule->command('system transfertResearch')->daily()->description('Met à jour les bases de recherche');
        $schedule->command('system rent_commerce')->daily()->after(function ($schedule) {
            $schedule->command('system ca_daily_calculate')->describe('Met à jour les CA des commerces');
        })->description('Effectue les paiements des différents commerces de users');
        $schedule->command('system rent_publicities')->daily()->description('Met à jour les CA des publicités');
        $schedule->command('system rent_parking')->daily()->description('Met à jour les CA des parkings');
        $schedule->command('system prlv_impot')->weeklyOn(1, '1:00')->description('Prélèvement des Impots hebdomadaires');

        $schedule->command('travel prepare')->everyMinute();
        $schedule->command('travel departure')->everyMinute();
        $schedule->command('travel transit')->everyMinute();
        $schedule->command('travel in_station')->everyMinute();
        $schedule->command('travel in_station_arrival')->everyMinute();
        $schedule->command('travel in_station_departure')->everyMinute();
        $schedule->command('travel arrival')->everyMinute();

        $schedule->command('incident before')->everyFiveMinutes();
        $schedule->command('incident after')->everyFifteenMinutes();
    }

    /**
     * Register the commands for the application.
     */
    protected function commands(): void
    {
        $this->load(__DIR__.'/Commands');

        require base_path('routes/console.php');
    }
}
