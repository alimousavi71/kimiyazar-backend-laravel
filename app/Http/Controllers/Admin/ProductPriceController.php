<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Http\Requests\Admin\ProductPrice\BulkUpdateProductPriceRequest;
use App\Http\Requests\Admin\ProductPrice\SyncTodayPricesRequest;
use App\Http\Requests\Admin\ProductPrice\UpdateProductPriceRequest;
use App\Http\Traits\ApiResponseTrait;
use App\Services\Category\CategoryService;
use App\Services\ProductPrice\ProductPriceService;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use Illuminate\View\View;

class ProductPriceController extends Controller
{
    use ApiResponseTrait;

    /**
     * @param ProductPriceService $service
     * @param CategoryService $categoryService
     */
    public function __construct(
        private readonly ProductPriceService $service,
        private readonly CategoryService $categoryService
    ) {
    }

    /**
     * Display the product price management page.
     *
     * @param Request $request
     * @return View
     */
    public function index(Request $request): View
    {
        $search = $request->query('search');
        $categoryId = $request->query('category_id') ? (int) $request->query('category_id') : null;
        $perPage = (int) $request->query('per_page', 15);
        $perPage = in_array($perPage, [10, 25, 50, 100]) ? $perPage : 15;

        $products = $this->service->getProductsWithLatestPrices($search, $categoryId, $perPage);
        $categories = $this->categoryService->getAllCategoriesTree();

        return view('admin.product-prices.index', compact('products', 'search', 'categoryId', 'perPage', 'categories'));
    }

    /**
     * Update a single product price (via axios).
     *
     * @param UpdateProductPriceRequest $request
     * @param int $productId
     * @return JsonResponse
     */
    public function updatePrice(UpdateProductPriceRequest $request, int $productId): JsonResponse
    {
        try {
            $price = $this->service->createOrUpdate($productId, [
                'price' => $request->input('price'),
                'currency_code' => $request->input('currency_code'),
            ]);

            return $this->successResponse([
                'price' => $price,
                'message' => __('admin/product-prices.messages.updated'),
            ]);
        } catch (\Exception $e) {
            return $this->errorResponse(__('admin/product-prices.messages.update_failed') . ': ' . $e->getMessage(), 500);
        }
    }

    /**
     * Bulk update product prices (via axios).
     *
     * @param BulkUpdateProductPriceRequest $request
     * @return JsonResponse
     */
    public function bulkUpdate(BulkUpdateProductPriceRequest $request): JsonResponse
    {
        try {
            $count = $this->service->bulkUpdate($request->input('prices'));

            return $this->successResponse([
                'count' => $count,
                'message' => __('admin/product-prices.messages.bulk_updated', ['count' => $count]),
            ]);
        } catch (\Exception $e) {
            return $this->errorResponse(__('admin/product-prices.messages.bulk_update_failed') . ': ' . $e->getMessage(), 500);
        }
    }

    /**
     * Sync today's prices - create or update prices for selected products.
     *
     * @param SyncTodayPricesRequest $request
     * @return JsonResponse
     */
    public function syncTodayPrices(SyncTodayPricesRequest $request): JsonResponse
    {
        try {
            $productIds = $request->input('product_ids');
            $result = $this->service->syncTodayPrices($productIds);

            return $this->successResponse([
                'created' => $result['created'],
                'updated' => $result['updated'],
                'total' => $result['total'],
                'message' => __('admin/product-prices.messages.sync_completed', [
                    'created' => $result['created'],
                    'updated' => $result['updated'],
                ]),
            ]);
        } catch (\Exception $e) {
            return $this->errorResponse(__('admin/product-prices.messages.sync_failed') . ': ' . $e->getMessage(), 500);
        }
    }
}
