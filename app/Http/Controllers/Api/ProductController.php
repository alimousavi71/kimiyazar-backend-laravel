<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Http\Traits\ApiResponseTrait;
use App\Models\Product;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;

class ProductController extends Controller
{
    use ApiResponseTrait;

    /**
     * Search for published products (for Select2).
     * Only returns published products for security.
     *
     * @param Request $request
     * @return JsonResponse
     */
    public function search(Request $request): JsonResponse
    {
        try {
            $search = (string) ($request->input('q') ?? $request->input('search') ?? '');
            $limit = (int) $request->input('limit', 50);

            // Query only published products
            $query = Product::where('is_published', true)
                ->select(['id', 'name', 'slug']);

            // Apply search filter if provided
            if (!empty($search)) {
                $query->where(function ($q) use ($search) {
                    $q->where('name', 'like', "%{$search}%")
                        ->orWhere('slug', 'like', "%{$search}%");
                });
            }

            // Order by name and limit results
            $products = $query->orderBy('name')
                ->limit($limit)
                ->get();

            // Format for Select2 component (expects array of objects with id and name/text)
            $formattedProducts = $products->map(function ($product) {
                return [
                    'id' => $product->id,
                    'name' => $product->name,
                    'text' => $product->name, // Select2 uses 'text' field
                ];
            })->values();

            return $this->successResponse($formattedProducts->toArray(), 'Products retrieved successfully.');
        } catch (\Exception $e) {
            return $this->errorResponse('Failed to search products: ' . $e->getMessage(), 500);
        }
    }
}
