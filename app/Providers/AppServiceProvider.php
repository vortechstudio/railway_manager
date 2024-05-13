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
            $railwayService = (new RailwayService())->getRailwayService();
            $view->with('service', $railwayService);
            $view->with('version', $railwayService->latest_version->version.'-'.$railwayService->latest_version->published_at);
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
