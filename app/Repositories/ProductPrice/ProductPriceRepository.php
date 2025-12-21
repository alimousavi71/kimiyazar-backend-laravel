<?php

namespace App\Repositories\ProductPrice;

use App\Models\ProductPrice;
use Illuminate\Database\Eloquent\Collection;
use Illuminate\Database\Eloquent\ModelNotFoundException;

/**
 * Repository implementation for ProductPrice model
 */
class ProductPriceRepository implements ProductPriceRepositoryInterface
{
    /**
     * Get all product prices.
     *
     * @return Collection
     */
    public function all(): Collection
    {
        return ProductPrice::all();
    }

    /**
     * Get prices by product ID.
     *
     * @param int $productId
     * @return Collection
     */
    public function getByProductId(int $productId): Collection
    {
        return ProductPrice::where('product_id', $productId)
            ->orderBy('created_at', 'desc')
            ->get();
    }

    /**
     * Get latest price for a product.
     *
     * @param int $productId
     * @return ProductPrice|null
     */
    public function getLatestByProductId(int $productId): ?ProductPrice
    {
        return ProductPrice::where('product_id', $productId)
            ->latest('created_at')
            ->first();
    }

    /**
     * Get latest prices for multiple products.
     *
     * @param array $productIds
     * @return Collection
     */
    public function getLatestByProductIds(array $productIds): Collection
    {
        if (empty($productIds)) {
            return ProductPrice::whereRaw('1 = 0')->get();
        }

        // Get the latest price for each product
        $latestIds = ProductPrice::whereIn('product_id', $productIds)
            ->selectRaw('MAX(id) as id')
            ->groupBy('product_id')
            ->pluck('id')
            ->toArray();

        return ProductPrice::whereIn('id', $latestIds)->get();
    }

    /**
     * Find product price by ID.
     *
     * @param int|string $id
     * @return ProductPrice|null
     */
    public function findById(int|string $id): ?ProductPrice
    {
        return ProductPrice::find($id);
    }

    /**
     * Find product price by ID or fail.
     *
     * @param int|string $id
     * @return ProductPrice
     * @throws ModelNotFoundException
     */
    public function findByIdOrFail(int|string $id): ProductPrice
    {
        return ProductPrice::findOrFail($id);
    }

    /**
     * Create a new product price.
     *
     * @param array $data
     * @return ProductPrice
     */
    public function create(array $data): ProductPrice
    {
        return ProductPrice::create($data);
    }

    /**
     * Update an existing product price.
     *
     * @param int|string $id
     * @param array $data
     * @return ProductPrice
     */
    public function update(int|string $id, array $data): ProductPrice
    {
        $productPrice = $this->findByIdOrFail($id);
        $productPrice->update($data);

        return $productPrice->fresh();
    }

    /**
     * Create or update product price.
     *
     * @param array $attributes
     * @param array $values
     * @return ProductPrice
     */
    public function updateOrCreate(array $attributes, array $values): ProductPrice
    {
        return ProductPrice::updateOrCreate($attributes, $values);
    }

    /**
     * Bulk create product prices.
     *
     * @param array $prices
     * @return bool
     */
    public function bulkCreate(array $prices): bool
    {
        return ProductPrice::insert($prices);
    }

    /**
     * Delete a product price.
     *
     * @param int|string $id
     * @return bool
     */
    public function delete(int|string $id): bool
    {
        $productPrice = $this->findByIdOrFail($id);

        return $productPrice->delete();
    }

    /**
     * Find product price by product ID and date.
     *
     * @param int $productId
     * @param \Carbon\Carbon $date
     * @return ProductPrice|null
     */
    public function findByProductIdAndDate(int $productId, \Carbon\Carbon $date): ?ProductPrice
    {
        return ProductPrice::where('product_id', $productId)
            ->whereDate('created_at', $date)
            ->first();
    }
}
