<?php

namespace App\Providers;

use App\Helpers\DirectionHelper;
use App\Repositories\Admin\AdminRepository;
use App\Repositories\Admin\AdminRepositoryInterface;
use App\Repositories\Admin\TwoFactorRepository;
use App\Repositories\Admin\TwoFactorRepositoryInterface;
use App\Repositories\Category\CategoryRepository;
use App\Repositories\Category\CategoryRepositoryInterface;
use Illuminate\Support\ServiceProvider;

class AppServiceProvider extends ServiceProvider
{
    /**
     * Register any application services.
     */
    public function register(): void
    {
        // Bind Admin Repository
        $this->app->bind(
            AdminRepositoryInterface::class,
            AdminRepository::class
        );

        // Bind TwoFactor Repository
        $this->app->bind(
            TwoFactorRepositoryInterface::class,
            TwoFactorRepository::class
        );

        // Bind Category Repository
        $this->app->bind(
            CategoryRepositoryInterface::class,
            CategoryRepository::class
        );
    }

    /**
     * Bootstrap any application services.
     */
    public function boot(): void
    {
        // Share direction with all views
        view()->share('direction', DirectionHelper::getDirection());
        view()->share('isRtl', DirectionHelper::isRtl());
        view()->share('isLtr', DirectionHelper::isLtr());
    }
}
