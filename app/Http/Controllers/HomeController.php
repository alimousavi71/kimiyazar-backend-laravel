<?php

namespace App\Http\Controllers;

use App\Enums\Database\BannerPosition;
use App\Enums\Database\ContentType;
use App\Services\Banner\BannerService;
use App\Services\Category\CategoryService;
use App\Services\Content\ContentService;
use App\Services\Product\ProductService;
use App\Services\Slider\SliderService;
use Illuminate\Http\Request;
use Illuminate\View\View;

class HomeController extends Controller
{
    public function __construct(
        private readonly ProductService $productService,
        private readonly SliderService $sliderService,
        private readonly ContentService $contentService,
        private readonly CategoryService $categoryService,
        private readonly BannerService $bannerService
    ) {
    }

    /**
     * Display the homepage.
     *
     * @param Request $request
     * @return View
     */
    public function index(Request $request): View
    {
        // Get active sliders
        $sliders = $this->sliderService->getActiveSliders(5);

        // Get last 20 published products
        $products = $this->productService->getActivePublishedProducts(20);

        // Get latest news (3 items)
        $news = $this->contentService->getActiveContentByType(ContentType::NEWS, 3);

        // Get all categories for filter
        $categories = $this->categoryService->getAllCategoriesTree();

        // Get root categories with first-level children for homepage
        $rootCategories = $this->categoryService->getRootCategoriesWithChildren();

        // Get banners by position
        $bannersA = $this->bannerService->getActiveBannersByPositions([BannerPosition::A1, BannerPosition::A2], 2);
        $bannersB = $this->bannerService->getActiveBannersByPositions([BannerPosition::B1, BannerPosition::B2], 2);
        $bannersC = $this->bannerService->getActiveBannersByPositions([BannerPosition::C1, BannerPosition::C2], 1);

        // Services data
        $services = [
            [
                'title' => 'واردات تخصصی غلات و نهاده‌های دامی',
                'description' => 'کیمیا تجارت زر با تکیه بر دهه‌ها تجربه، غلات و نهاده‌های دامی را از معتبرترین مبادی بین‌المللی (روسیه، قزاقستان، آرژانتین، آلمان، رومانی، هند و ترکیه) وارد می‌کند. تمام محصولات تحت کنترل کیفی سختگیرانه و انطباق با استانداردهای دام و طیور قرار می‌گیرند.',
                'link' => '#',
                'icon_class' => 'fas fa-shipping-fast',
            ],
            [
                'title' => 'تأمین و توزیع نهاده‌های دام، طیور و آبزیان',
                'description' => 'تأمین مستمر و پایدار نهاده‌های دامی برای دامداران، مرغداران، کارخانه‌های خوراک دام و پرورش‌دهندگان آبزیان. با شبکه توزیع فعال و همکاری بلندمدت، ما نیاز شما را به‌صورت مستقیم و با بهترین قیمت تأمین می‌کنیم.',
                'link' => '#',
                'icon_class' => 'fas fa-truck',
            ],
            [
                'title' => 'ترخیص تخصصی کالا و امور لجستیک',
                'description' => 'خدمات کامل ترخیص کالاهای کشاورزی از گمرکات با مدیریت تشریفات اداری، هماهنگی با سازمان‌های مرتبط و تسریع در آزادسازی کالا. هدف ما کاهش هزینه‌های انبارداری و تأخیر است.',
                'link' => '#',
                'icon_class' => 'fas fa-file-invoice',
            ],
            [
                'title' => 'تولید و تأمین خوراک دام و طیور',
                'description' => 'تولید خوراک دام و طیور با فرمولاسیون اصولی، استفاده از مواد اولیه باکیفیت و رعایت استانداردهای تغذیه‌ای برای دام سبک و سنگین، مرغ گوشتی و تخم‌گذار، و آبزیان پرورشی.',
                'link' => '#',
                'icon_class' => 'fas fa-seedling',
            ],
            [
                'title' => 'فروش ضایعات و مشتقات خوراک دام',
                'description' => 'فروش ضایعات و محصولات جانبی خوراک دام با قیمت اقتصادی و ارزش تغذیه‌ای مناسب. از جمله: گندم شکسته، ذرت شکسته، سبوس غلات، کنجاله‌ها و پوسته‌های ذرت غنی‌شده برای کاهش هزینه‌های تولید.',
                'link' => '#',
                'icon_class' => 'fas fa-recycle',
            ],
            [
                'title' => 'مشاوره تخصصی تغذیه و تأمین',
                'description' => 'ارائه مشاوره تخصصی در انتخاب نهاده‌های دامی و ترکیب خوراک برای افزایش بهره‌وری تولید، کاهش هزینه‌های خوراک و بهبود سلامت دام و طیور. با شناخت عمیق بازار نهاده‌های دامی ایران.',
                'link' => '#',
                'icon_class' => 'fas fa-lightbulb',
            ],
        ];

        return view('home', compact('sliders', 'products', 'news', 'categories', 'rootCategories', 'services', 'bannersA', 'bannersB', 'bannersC'));
    }
}
