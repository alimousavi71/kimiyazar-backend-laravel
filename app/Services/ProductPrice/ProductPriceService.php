<?php

namespace App\Services\ProductPrice;

use App\Models\Product;
use App\Models\ProductPrice;
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
     */
    public function __construct(
        private readonly ProductPriceRepositoryInterface $repository
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
     * @param int $perPage
     * @return LengthAwarePaginator
     */
    public function getProductsWithLatestPrices(?string $search = null, int $perPage = 15): LengthAwarePaginator
    {
        $query = Product::query();

        if ($search) {
            $query->where(function ($q) use ($search) {
                $q->where('name', 'like', "%{$search}%")
                    ->orWhere('slug', 'like', "%{$search}%");
            });
        }

        $products = $query->orderBy('sort_order')->orderBy('name')->paginate($perPage);

        // Get latest prices for products on current page
        $productIds = $products->pluck('id')->toArray();
        $latestPrices = $this->repository->getLatestByProductIds($productIds);

        // Attach latest prices to products
        $products->getCollection()->each(function ($product) use ($latestPrices) {
            $latestPrice = $latestPrices->firstWhere('product_id', $product->id);
            $product->latest_price = $latestPrice;
        });

        return $products;
    }

    /**
     * Create or update product price.
     *
     * @param int $productId
     * @param array $data
     * @return ProductPrice
     */
    public function createOrUpdate(int $productId, array $data): ProductPrice
    {
        $data['product_id'] = $productId;

        return $this->repository->create($data);
    }

    /**
     * Bulk update product prices.
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
                $this->repository->create([
                    'product_id' => $priceData['product_id'],
                    'price' => $priceData['price'],
                    'currency_code' => $priceData['currency_code'],
                    'created_at' => $now,
                    'updated_at' => $now,
                ]);
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
     * Sync today's prices - create or update prices for all products based on their latest prices.
     *
     * @return array ['created' => int, 'updated' => int]
     */
    public function syncTodayPrices(): array
    {
        $today = now()->startOfDay();
        $created = 0;
        $updated = 0;

        // Get all products
        $products = Product::all();

        foreach ($products as $product) {
            // Get the latest price for this product
            $latestPrice = $this->repository->getLatestByProductId($product->id);

            if ($latestPrice) {
                // Check if a price already exists for today
                $todayPrice = ProductPrice::where('product_id', $product->id)
                    ->whereDate('created_at', $today)
                    ->first();

                if ($todayPrice) {
                    // Update existing today's price
                    $todayPrice->update([
                        'price' => $latestPrice->price,
                        'currency_code' => $latestPrice->currency_code,
                    ]);
                    $updated++;
                } else {
                    // Create new price for today
                    $this->repository->create([
                        'product_id' => $product->id,
                        'price' => $latestPrice->price,
                        'currency_code' => $latestPrice->currency_code,
                        'created_at' => now(),
                        'updated_at' => now(),
                    ]);
                    $created++;
                }
            }
        }

        return [
            'created' => $created,
            'updated' => $updated,
            'total' => $created + $updated,
        ];
    }
}
