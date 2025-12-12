<?php

namespace App\Providers;

use Illuminate\Support\ServiceProvider;

class AppServiceProvider extends ServiceProvider
{
    /**
     * Register any application services.
     */
    public function register(): void
    {
        //
    }

    /**
     * Bootstrap any application services.
     */
    public function boot(): void
    {
        // Share direction with all views
        view()->share('direction', \App\Helpers\DirectionHelper::getDirection());
        view()->share('isRtl', \App\Helpers\DirectionHelper::isRtl());
        view()->share('isLtr', \App\Helpers\DirectionHelper::isLtr());
    }
}
