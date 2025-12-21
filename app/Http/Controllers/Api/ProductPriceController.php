<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Http\Traits\ApiResponseTrait;
use App\Services\Product\ProductService;
use App\Services\ProductPrice\ProductPriceService;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;

class ProductPriceController extends Controller
{
    use ApiResponseTrait;

    public function __construct(
        private readonly ProductPriceService $productPriceService,
        private readonly ProductService $productService
    ) {
    }

    /**
     * Get price history for a product by date range.
     *
     * @param Request $request
     * @param int $productId
     * @return JsonResponse
     */
    public function getPriceHistory(Request $request, int $productId): JsonResponse
    {
        try {
            // Validate product exists and is published
            $product = $this->productService->findById($productId);
            if (!$product || !$product->is_published) {
                return $this->notFoundResponse('Product not found');
            }

            // Get range parameter (default: 1m)
            $range = $request->get('range', '1m');
            if (!in_array($range, ['1m', '3m', '6m', '1y'])) {
                $range = '1m';
            }

            // Get price history data
            $chartData = $this->productPriceService->getPriceHistoryForChart($productId, $range);

            return $this->successResponse($chartData, 'Price history retrieved successfully');
        } catch (\Exception $e) {
            return $this->errorResponse('Failed to retrieve price history: ' . $e->getMessage(), 500);
        }
    }
}
