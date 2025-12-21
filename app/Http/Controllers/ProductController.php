<?php

namespace App\Http\Controllers;

use App\Services\Category\CategoryService;
use App\Services\Product\ProductService;
use App\Services\Setting\SettingService;
use Illuminate\Http\Request;
use Illuminate\View\View;

class ProductController extends Controller
{
    public function __construct(
        private readonly ProductService $productService,
        private readonly CategoryService $categoryService,
        private readonly SettingService $settingService
    ) {
    }

    /**
     * Display the products list page.
     *
     * @param Request $request
     * @return View
     */
    public function index(Request $request): View
    {
        $settings = $this->settingService->getAllAsArray();

        // Get filter parameters
        $categoryId = $request->get('category') ? (int) $request->get('category') : null;
        $search = $request->get('search');
        $sort = $request->get('sort');

        // Get paginated products
        $products = $this->productService->getPaginatedActivePublishedProducts(
            50,
            $categoryId,
            $search,
            $sort
        );

        // Get all root categories for sidebar
        $rootCategories = $this->categoryService->getRootCategories()
            ->where('is_active', true)
            ->sortBy('sort_order');

        // Get latest price update date (from products)
        $latestPriceUpdate = \App\Models\Product::where('is_published', true)
            ->where('status', \App\Enums\Database\ProductStatus::ACTIVE)
            ->whereNotNull('price_updated_at')
            ->max('price_updated_at');

        return view('products.index', compact('products', 'rootCategories', 'settings', 'categoryId', 'search', 'sort', 'latestPriceUpdate'));
    }
}
