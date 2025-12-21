<?php

namespace App\Http\Controllers;

use App\Services\Category\CategoryService;
use App\Services\Product\ProductService;
use App\Services\Setting\SettingService;
use Illuminate\Database\Eloquent\ModelNotFoundException;
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

        // Get current category if selected
        $currentCategory = null;
        $breadcrumbPath = collect();
        $categoriesToShow = collect();

        if ($categoryId) {
            try {
                $currentCategory = $this->categoryService->findById($categoryId);

                // Only proceed if category is active
                if ($currentCategory && $currentCategory->is_active) {
                    // Get breadcrumb path from root to current category
                    $breadcrumbPath = $this->categoryService->getBreadcrumbPath($currentCategory);

                    // Get children of current category
                    $categoriesToShow = $this->categoryService->getActiveChildren($currentCategory);
                } else {
                    // Category not found or inactive, reset to root
                    $categoryId = null;
                    $currentCategory = null;
                }
            } catch (ModelNotFoundException $e) {
                // Category not found, reset to root
                $categoryId = null;
                $currentCategory = null;
            }
        }

        // If no category selected or category was invalid, show root categories
        if (!$currentCategory) {
            $categoriesToShow = $this->categoryService->getActiveChildren(null);
        }

        // Get all category IDs including descendants for product filtering
        $categoryIdsForFiltering = null;
        if ($currentCategory) {
            $categoryIdsForFiltering = $this->categoryService->getCategoryAndActiveDescendantIds($currentCategory->id);
        }

        // Get paginated products
        $products = $this->productService->getPaginatedActivePublishedProducts(
            50,
            $categoryId,
            $search,
            $sort,
            $categoryIdsForFiltering
        );

        // Get latest price update date (from products)
        $latestPriceUpdate = $this->productService->getLatestPriceUpdateDate();

        return view('products.index', compact(
            'products',
            'settings',
            'categoryId',
            'search',
            'sort',
            'latestPriceUpdate',
            'currentCategory',
            'breadcrumbPath',
            'categoriesToShow'
        ));
    }
}
