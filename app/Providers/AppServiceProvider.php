<?php

namespace App\Providers;

use App\Services\RailwayService;
use Illuminate\Support\ServiceProvider;
use Vortechstudio\VersionBuildAction\Facades\VersionBuildAction;

class AppServiceProvider extends ServiceProvider
{
    /**
     * Register any application services.
     */
    public function register(): void
    {
        \View::composer('*', function ($view) {
            $view->with('version', VersionBuildAction::getVersionInfo());
            $view->with('service', (new RailwayService())->getRailwayService());
        });
    }

    /**
     * Bootstrap any application services.
     */
    public function boot(): void
    {
        //
    }
}
