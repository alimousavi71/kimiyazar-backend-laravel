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

        return view('home', compact('sliders', 'products', 'news', 'categories', 'rootCategories', 'settings'));
    }
}
