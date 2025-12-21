<?php

namespace App\Repositories\ProductPrice;

use App\Models\ProductPrice;
use Illuminate\Database\Eloquent\Collection;
use Illuminate\Database\Eloquent\ModelNotFoundException;

/**
 * Interface for ProductPrice Repository
 */
interface ProductPriceRepositoryInterface
{
    /**
     * Get all product prices.
     *
     * @return Collection
     */
    public function all(): Collection;

    /**
     * Get prices by product ID.
     *
     * @param int $productId
     * @return Collection
     */
    public function getByProductId(int $productId): Collection;

    /**
     * Get latest price for a product.
     *
     * @param int $productId
     * @return ProductPrice|null
     */
    public function getLatestByProductId(int $productId): ?ProductPrice;

    /**
     * Get latest prices for multiple products.
     *
     * @param array $productIds
     * @return Collection
     */
    public function getLatestByProductIds(array $productIds): Collection;

    /**
     * Find product price by ID.
     *
     * @param int|string $id
     * @return ProductPrice|null
     */
    public function findById(int|string $id): ?ProductPrice;

    /**
     * Find product price by ID or fail.
     *
     * @param int|string $id
     * @return ProductPrice
     * @throws ModelNotFoundException
     */
    public function findByIdOrFail(int|string $id): ProductPrice;

    /**
     * Create a new product price.
     *
     * @param array $data
     * @return ProductPrice
     */
    public function create(array $data): ProductPrice;

    /**
     * Update an existing product price.
     *
     * @param int|string $id
     * @param array $data
     * @return ProductPrice
     */
    public function update(int|string $id, array $data): ProductPrice;

    /**
     * Create or update product price.
     *
     * @param array $attributes
     * @param array $values
     * @return ProductPrice
     */
    public function updateOrCreate(array $attributes, array $values): ProductPrice;

    /**
     * Bulk create product prices.
     *
     * @param array $prices
     * @return bool
     */
    public function bulkCreate(array $prices): bool;

    /**
     * Delete a product price.
     *
     * @param int|string $id
     * @return bool
     */
    public function delete(int|string $id): bool;
}
