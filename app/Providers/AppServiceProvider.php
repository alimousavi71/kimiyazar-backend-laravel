<?php

namespace App\Providers;

use App\Helpers\DirectionHelper;
use App\Repositories\Admin\AdminRepository;
use App\Repositories\Admin\AdminRepositoryInterface;
use App\Repositories\Admin\TwoFactorRepository;
use App\Repositories\Admin\TwoFactorRepositoryInterface;
use App\Repositories\Banner\BannerRepository;
use App\Repositories\Banner\BannerRepositoryInterface;
use App\Repositories\Category\CategoryRepository;
use App\Repositories\Category\CategoryRepositoryInterface;
use App\Repositories\Contact\ContactRepository;
use App\Repositories\Contact\ContactRepositoryInterface;
use App\Repositories\Content\ContentRepository;
use App\Repositories\Content\ContentRepositoryInterface;
use App\Repositories\Photo\PhotoRepository;
use App\Repositories\Photo\PhotoRepositoryInterface;
use App\Repositories\Slider\SliderRepository;
use App\Repositories\Slider\SliderRepositoryInterface;
use App\Repositories\User\UserRepository;
use App\Repositories\User\UserRepositoryInterface;
use App\Repositories\Faq\FaqRepository;
use App\Repositories\Faq\FaqRepositoryInterface;
use App\Repositories\Otp\OtpRepository;
use App\Repositories\Otp\OtpRepositoryInterface;
use App\Services\Auth\AuthService;
use App\Services\Otp\OtpNotificationService;
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

        // Bind Contact Repository
        $this->app->bind(
            ContactRepositoryInterface::class,
            ContactRepository::class
        );

        // Bind Banner Repository
        $this->app->bind(
            BannerRepositoryInterface::class,
            BannerRepository::class
        );

        // Bind Content Repository
        $this->app->bind(
            ContentRepositoryInterface::class,
            ContentRepository::class
        );

        // Bind Photo Repository
        $this->app->bind(
            PhotoRepositoryInterface::class,
            PhotoRepository::class
        );

        // Bind Slider Repository
        $this->app->bind(
            SliderRepositoryInterface::class,
            SliderRepository::class
        );

        // Bind User Repository
        $this->app->bind(
            UserRepositoryInterface::class,
            UserRepository::class
        );

        // Bind Faq Repository
        $this->app->bind(
            FaqRepositoryInterface::class,
            FaqRepository::class
        );

        // Bind Otp Repository
        $this->app->bind(
            OtpRepositoryInterface::class,
            OtpRepository::class
        );

        // Bind Auth Service
        $this->app->singleton(AuthService::class, function ($app) {
            return new AuthService(
                $app->make(\App\Services\User\UserService::class),
                $app->make(\App\Services\Otp\OtpService::class),
                $app->make(OtpNotificationService::class)
            );
        });
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
