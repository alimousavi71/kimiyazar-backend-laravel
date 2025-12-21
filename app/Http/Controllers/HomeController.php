<?php

namespace App\Http\Controllers;

use App\Enums\Database\ContentType;
use App\Models\Product;
use App\Models\Setting;
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
        private readonly CategoryService $categoryService
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
        $sliders = \App\Models\Slider::where('is_active', true)
            ->orderBy('sort_order')
            ->limit(5)
            ->get();

        // Get last 20 published products
        $products = Product::where('is_published', true)
            ->where('status', \App\Enums\Database\ProductStatus::ACTIVE)
            ->with(['category', 'photos', 'prices'])
            ->orderBy('created_at', 'desc')
            ->limit(20)
            ->get();

        // Get latest news (3 items)
        $news = \App\Models\Content::where('type', ContentType::NEWS)
            ->where('is_active', true)
            ->orderBy('created_at', 'desc')
            ->limit(3)
            ->get();

        // Get all categories for filter
        $categories = $this->categoryService->getAllCategoriesTree();

        // Get root categories with first-level children for homepage
        $rootCategories = \App\Models\Category::whereNull('parent_id')
            ->where('is_active', true)
            ->with([
                'children' => function ($query) {
                    $query->where('is_active', true)->orderBy('sort_order');
                }
            ])
            ->orderBy('sort_order')
            ->get();

        // Get settings
        $settings = Setting::getAllAsArray();

        // Services data
        $services = [
            [
                'title' => 'واردات غلات',
                'description' => 'واردات غلات و نهاده های دامی که از جمله کالاهای اساسی هر کشور می‌باشد ما در کوتاه ترین زمان به صورت ریالی و دلاری در خدمت تمامی همکاران عزیز هستیم',
                'link' => '#',
                'icon_class' => 'fas fa-shipping-fast',
            ],
            [
                'title' => 'توزیع مستقیم',
                'description' => 'این مجموعه با داشتن نیروهای مجرب و قوی در عرضه مستقیم کالا از بنادر و کارخانجات، با یک نظم مشخص در امر خدمت رسانی به عزیزان تلاش مضاعف میکند',
                'link' => '#',
                'icon_class' => 'fas fa-truck',
            ],
            [
                'title' => 'اعلام قیمت روزانه',
                'description' => 'شما می‌توانید برای دسترسی بهتر به تمامی محصولات و قیمتهای ما از طریق سامانه پیامکی، کانال تلگرام، صفحه اینستاگرام ما را دنبال نمایید',
                'link' => '#',
                'icon_class' => 'fas fa-chart-line',
            ],
            [
                'title' => 'تولید خوراک دام و طیور',
                'description' => 'مرغداران و دامداران گرانقدر می‌توانند با توجه به جیره غذایی مورد نظر محصولات خوراک دام و طیور آبزیان تحت پوشش این مجموعه را به طور مستقیم و با بهترین قیمت دریافت نمایند',
                'link' => '#',
                'icon_class' => 'fas fa-seedling',
            ],
            [
                'title' => 'فروش ضایعات خوراک دام و طیور',
                'description' => 'ضایعات خوراک دام و طیور اعم از: گندم شکسته یا دانه مرغی، ذرت شکسته، بلغور ذرت، تفاله های دامی، کنجاله ها، گلوتن و پوسته ذرت را می‌توان از این مجموعه به طور گسترده دریافت نمود',
                'link' => '#',
                'icon_class' => 'fas fa-recycle',
            ],
            [
                'title' => 'ترخیص گمرکی کالا',
                'description' => 'تمامی واردکنندگان می‌توانند کالاهای خود را در کمترین زمان ممکن و بصرفه ترین قیمت روز هر کالا برای ترخیص را به تیم ترخیص کار کیمیا تجارت زر انتقال داده تا در اسرع وقت نسبت به آزاد سازی کالاهای مورد نظر از گمرک اقدام شود',
                'link' => '#',
                'icon_class' => 'fas fa-file-invoice',
            ],
        ];

        return view('home', compact('sliders', 'products', 'news', 'categories', 'rootCategories', 'services', 'settings'));
    }
}
