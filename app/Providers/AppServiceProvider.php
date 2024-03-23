<?php

namespace App\Providers;

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
