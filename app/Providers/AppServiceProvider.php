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
use App\Repositories\Modal\ModalRepository;
use App\Repositories\Modal\ModalRepositoryInterface;
use App\Repositories\Product\ProductRepository;
use App\Repositories\Product\ProductRepositoryInterface;
use App\Repositories\ProductPrice\ProductPriceRepository;
use App\Repositories\ProductPrice\ProductPriceRepositoryInterface;
use App\Repositories\Setting\SettingRepository;
use App\Repositories\Setting\SettingRepositoryInterface;
use App\Repositories\Tag\TagRepository;
use App\Repositories\Tag\TagRepositoryInterface;
use App\Repositories\Menu\MenuRepository;
use App\Repositories\Menu\MenuRepositoryInterface;
use App\Repositories\Order\OrderRepository;
use App\Repositories\Order\OrderRepositoryInterface;
use App\Repositories\Country\CountryRepository;
use App\Repositories\Country\CountryRepositoryInterface;
use App\Repositories\State\StateRepository;
use App\Repositories\State\StateRepositoryInterface;
use App\Repositories\Bank\BankRepository;
use App\Repositories\Bank\BankRepositoryInterface;
use App\Services\Auth\AuthService;
use App\Services\Otp\OtpNotificationService;
use App\Services\Otp\OtpService;
use App\Services\User\UserService;
use App\View\Composers\SettingComposer;
use App\View\Composers\MenuComposer;
use App\View\Composers\ModalComposer;
use Illuminate\Support\Facades\View;
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

        // Bind Modal Repository
        $this->app->bind(
            ModalRepositoryInterface::class,
            ModalRepository::class
        );

        // Bind Setting Repository
        $this->app->bind(
            SettingRepositoryInterface::class,
            SettingRepository::class
        );

        // Bind Product Repository
        $this->app->bind(
            ProductRepositoryInterface::class,
            ProductRepository::class
        );

        // Bind ProductPrice Repository
        $this->app->bind(
            ProductPriceRepositoryInterface::class,
            ProductPriceRepository::class
        );

        // Bind Tag Repository
        $this->app->bind(
            TagRepositoryInterface::class,
            TagRepository::class
        );

        // Bind Menu Repository
        $this->app->bind(
            MenuRepositoryInterface::class,
            MenuRepository::class
        );

        // Bind PriceInquiry Repository
        $this->app->bind(
            \App\Repositories\PriceInquiry\PriceInquiryRepositoryInterface::class,
            \App\Repositories\PriceInquiry\PriceInquiryRepository::class
        );

        // Bind Order Repository
        $this->app->bind(
            OrderRepositoryInterface::class,
            OrderRepository::class
        );

        // Bind Country Repository
        $this->app->bind(
            CountryRepositoryInterface::class,
            CountryRepository::class
        );

        // Bind State Repository
        $this->app->bind(
            StateRepositoryInterface::class,
            StateRepository::class
        );

        // Bind Bank Repository
        $this->app->bind(
            BankRepositoryInterface::class,
            BankRepository::class
        );

        // Bind Auth Service
        $this->app->singleton(AuthService::class, function ($app) {
            return new AuthService(
                $app->make(UserService::class),
                $app->make(OtpService::class),
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

        // Share settings with frontend views only (not admin)
        View::composer([
            'components.layouts.app',
            'layouts.app',
            'components.web.*',
            'home',
            'contact',
            'price-inquiry.*',
            'products.*',
            'articles.*',
            'news.*',
            'tags.*',
            'orders.*',
            'about',
            'faqs.*',
        ], SettingComposer::class);

        // Share menus with frontend views only (not admin)
        View::composer([
            'components.layouts.app',
            'layouts.app',
            'components.web.*',
            'home',
            'contact',
            'price-inquiry.*',
            'products.*',
            'articles.*',
            'news.*',
            'tags.*',
            'orders.*',
            'about',
            'faqs.*',
        ], MenuComposer::class);

        // Share active modals with frontend views only (not admin)
        View::composer([
            'components.layouts.app',
            'layouts.app',
            'components.web.*',
            'home',
            'contact',
            'price-inquiry.*',
            'products.*',
            'articles.*',
            'news.*',
            'tags.*',
            'orders.*',
            'about',
            'faqs.*',
        ], ModalComposer::class);
    }
}
