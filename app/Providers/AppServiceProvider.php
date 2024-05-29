<?php

namespace App\Providers;

use App\Services\RailwayService;
use Illuminate\Support\ServiceProvider;

class AppServiceProvider extends ServiceProvider
{
    /**
     * Register any application services.
     */
    public function register(): void
    {
        \Carbon\Carbon::setLocale('fr');
        $railwayService = (new RailwayService())->getRailwayService();
        \View::composer('*', function ($view) use ($railwayService) {
            $view->with('service', $railwayService);
            $view->with('version', $railwayService->latest_version->version.'-'.$railwayService->latest_version->published_at);
            if (\Auth::check()) {
                $view->with('isPremium', auth()->user()->services()->where('service_id', $railwayService->id)->exists() ? auth()->user()->services()->where('service_id', $railwayService->id)->first()->premium : null);
            }
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
