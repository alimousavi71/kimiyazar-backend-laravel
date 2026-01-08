<?php

namespace App\Services\ProductPrice;

use App\Models\ProductPrice;
use App\Repositories\Category\CategoryRepositoryInterface;
use App\Repositories\Product\ProductRepositoryInterface;
use App\Repositories\ProductPrice\ProductPriceRepositoryInterface;
use Illuminate\Contracts\Pagination\LengthAwarePaginator;
use Illuminate\Database\Eloquent\Collection;
use Illuminate\Database\Eloquent\ModelNotFoundException;

/**
 * Service class for ProductPrice business logic
 */
class ProductPriceService
{
    /**
     * @param ProductPriceRepositoryInterface $repository
     * @param ProductRepositoryInterface $productRepository
     * @param CategoryRepositoryInterface $categoryRepository
     */
    public function __construct(
        private readonly ProductPriceRepositoryInterface $repository,
        private readonly ProductRepositoryInterface $productRepository,
        private readonly CategoryRepositoryInterface $categoryRepository
    ) {
    }

    /**
     * Get all product prices.
     *
     * @return Collection
     */
    public function all(): Collection
    {
        return $this->repository->all();
    }

    /**
     * Get prices by product ID.
     *
     * @param int $productId
     * @return Collection
     */
    public function getByProductId(int $productId): Collection
    {
        return $this->repository->getByProductId($productId);
    }

    /**
     * Get latest price for a product.
     *
     * @param int $productId
     * @return ProductPrice|null
     */
    public function getLatestByProductId(int $productId): ?ProductPrice
    {
        return $this->repository->getLatestByProductId($productId);
    }

    /**
     * Get products with their latest prices for price management page.
     *
     * @param string|null $search
     * @param int|null $categoryId
     * @param int $perPage
     * @return LengthAwarePaginator
     */
    public function getProductsWithLatestPrices(?string $search = null, ?int $categoryId = null, int $perPage = 15): LengthAwarePaginator
    {
        // Get category IDs including children if category is specified
        $categoryIds = null;
        if ($categoryId) {
            $categoryIds = $this->getCategoryIdsIncludingChildren($categoryId);
        }

        // Get products using repository
        $products = $this->productRepository->getProductsForPriceManagement($search, $categoryIds, $perPage);

        // Get latest prices for products on current page
        $productIds = $products->items() ? collect($products->items())->pluck('id')->toArray() : [];
        $latestPrices = $this->repository->getLatestByProductIds($productIds);

        // Attach latest prices to products
        collect($products->items())->each(function ($product) use ($latestPrices) {
            $latestPrice = $latestPrices->firstWhere('product_id', $product->id);
            $product->latest_price = $latestPrice;
        });

        return $products;
    }

    /**
     * Get all category IDs including the category itself and all its children recursively.
     *
     * @param int $categoryId
     * @return array
     */
    private function getCategoryIdsIncludingChildren(int $categoryId): array
    {
        $categoryIds = [$categoryId];

        $getChildren = function ($parentId) use (&$getChildren, &$categoryIds) {
            $children = $this->categoryRepository->getCategoryIdsByParentId($parentId, false);
            foreach ($children as $childId) {
                $categoryIds[] = $childId;
                $getChildren($childId);
            }
        };

        $getChildren($categoryId);

        return $categoryIds;
    }

    /**
     * Create or update product price.
     * Creates a new price record and updates the product's current_price.
     *
     * @param int $productId
     * @param array $data
     * @return ProductPrice
     */
    public function createOrUpdate(int $productId, array $data): ProductPrice
    {
        $data['product_id'] = $productId;

        // Create new price record (database trigger will update product, but we ensure it's updated)
        $price = $this->repository->create($data);

        // Manually update product to ensure current_price is updated
        // (Trigger should handle this, but we ensure it's updated)
        $product = $this->productRepository->findById($productId);
        if ($product) {
            $product->update([
                'current_price' => $data['price'],
                'currency_code' => $data['currency_code'],
                'price_updated_at' => now(),
                'price_effective_date' => now()->toDateString(),
            ]);
        }

        return $price;
    }

    /**
     * Bulk update product prices.
     * Creates new price records and updates each product's current_price.
     * Uses the same logic as createOrUpdate for consistency.
     *
     * @param array $prices Array of ['product_id' => int, 'price' => string, 'currency_code' => string]
     * @return int Number of prices created
     */
    public function bulkUpdate(array $prices): int
    {
        $created = 0;
        $now = now();

        foreach ($prices as $priceData) {
            if (isset($priceData['product_id']) && isset($priceData['price']) && isset($priceData['currency_code'])) {
                $productId = (int) $priceData['product_id'];
                // Store price exactly as received (already cleaned of commas in frontend)
                // Just ensure it's a string for the decimal column
                $price = (string) $priceData['price'];
                $currencyCode = $priceData['currency_code'];

                // Create new price record (same as single update)
                $this->repository->create([
                    'product_id' => $productId,
                    'price' => $price,
                    'currency_code' => $currencyCode,
                    'created_at' => $now,
                    'updated_at' => $now,
                ]);

                // Manually update product to ensure current_price is updated
                // (Trigger should handle this, but we ensure it's updated - same as single update)
                $product = $this->productRepository->findById($productId);
                if ($product) {
                    $product->update([
                        'current_price' => $price,
                        'currency_code' => $currencyCode,
                        'price_updated_at' => $now,
                        'price_effective_date' => $now->toDateString(),
                    ]);
                }

                $created++;
            }
        }

        return $created;
    }

    /**
     * Update a single product price.
     *
     * @param int|string $id
     * @param array $data
     * @return ProductPrice
     */
    public function update(int|string $id, array $data): ProductPrice
    {
        return $this->repository->update($id, $data);
    }

    /**
     * Delete a product price.
     *
     * @param int|string $id
     * @return bool
     */
    public function delete(int|string $id): bool
    {
        return $this->repository->delete($id);
    }

    /**
     * Sync today's prices - update if exists for today, create if not.
     * Uses the prices and currencies provided in the request (from form inputs).
     *
     * @param array $prices Array of ['product_id' => int, 'price' => string, 'currency_code' => string]
     * @return array ['created' => int, 'updated' => int, 'total' => int]
     */
    public function syncTodayPrices(array $prices): array
    {
        $today = now()->startOfDay();
        $created = 0;
        $updated = 0;

        foreach ($prices as $priceData) {
            if (isset($priceData['product_id']) && isset($priceData['price']) && isset($priceData['currency_code'])) {
                $productId = (int) $priceData['product_id'];
                // Store price exactly as received (already cleaned of commas in frontend)
                // Just ensure it's a string for the decimal column
                $price = (string) $priceData['price'];
                $currencyCode = $priceData['currency_code'];

                // Check if a price already exists for today
                $todayPrice = $this->repository->findByProductIdAndDate($productId, $today);

                if ($todayPrice) {
                    // Update existing today's price
                    $todayPrice->update([
                        'price' => $price,
                        'currency_code' => $currencyCode,
                    ]);
                    $updated++;
                } else {
                    // Create new price for today
                    $this->repository->create([
                        'product_id' => $productId,
                        'price' => $price,
                        'currency_code' => $currencyCode,
                        'created_at' => now(),
                        'updated_at' => now(),
                    ]);
                    $created++;
                }

                // Update product's current_price
                $product = $this->productRepository->findById($productId);
                if ($product) {
                    $product->update([
                        'current_price' => $price,
                        'currency_code' => $currencyCode,
                        'price_updated_at' => now(),
                        'price_effective_date' => now()->toDateString(),
                    ]);
                }
            }
        }

        return [
            'created' => $created,
            'updated' => $updated,
            'total' => $created + $updated,
        ];
    }

    /**
     * Get price history for a product by date range.
     *
     * @param int $productId
     * @param string $range Range: '1m', '3m', '6m', '1y'
     * @return array{labels: array, prices: array, stepSize: float|null, suggestedMin: float|null, suggestedMax: float|null}
     */
    public function getPriceHistoryForChart(int $productId, string $range = '1m'): array
    {
        $now = now();
        $startDate = match ($range) {
            '1m' => $now->copy()->subMonth(),
            '3m' => $now->copy()->subMonths(3),
            '6m' => $now->copy()->subMonths(6),
            '1y' => $now->copy()->subYear(),
            default => $now->copy()->subMonth(),
        };

        $prices = $this->repository->getPriceHistoryByDateRange($productId, $startDate, $now);

        // Format data for Chart.js
        $labels = [];
        $priceValues = [];
        $allPrices = [];

        foreach ($prices as $price) {
            $labels[] = $price->created_at->format('Y/m/d');
            $priceValue = (float) $price->price;
            $priceValues[] = $priceValue;
            $allPrices[] = $priceValue;
        }

        // Calculate step size and min/max for better chart display
        $stepSize = null;
        $suggestedMin = null;
        $suggestedMax = null;

        if (count($allPrices) > 0) {
            $minPrice = min($allPrices);
            $maxPrice = max($allPrices);
            $priceRange = $maxPrice - $minPrice;

            // Calculate step size (approximately 10-12 ticks)
            if ($priceRange > 0) {
                $stepSize = ceil($priceRange / 12 / 1000) * 1000; // Round to nearest 1000
            }

            // Add padding to min/max
            $padding = $priceRange * 0.1; // 10% padding
            $suggestedMin = max(0, $minPrice - $padding);
            $suggestedMax = $maxPrice + $padding;
        }

        return [
            'labels' => $labels,
            'prices' => $priceValues,
            'stepSize' => $stepSize,
            'suggestedMin' => $suggestedMin,
            'suggestedMax' => $suggestedMax,
        ];
    }
}
