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
            $view->with('service', (new RailwayService())->getRailwayService());
            $view->with('version', (new RailwayService())->getRailwayService()->latest_version->version.'-'.(new RailwayService())->getRailwayService()->latest_version->published_at);
        });
        \View::composer('*', function ($view) {
            $view->with('user', auth()->user());
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
