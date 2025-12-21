<?php

namespace App\Repositories\Product;

use App\Models\Product;
use Illuminate\Contracts\Pagination\LengthAwarePaginator;
use Illuminate\Database\Eloquent\Collection;
use Illuminate\Database\Eloquent\ModelNotFoundException;

/**
 * Interface for Product Repository
 */
interface ProductRepositoryInterface
{
    /**
     * Get all products with pagination.
     *
     * @param array $allowedFilters
     * @param array $allowedSorts
     * @param string|null $defaultSort
     * @param int $perPage
     * @return LengthAwarePaginator
     */
    public function search(
        array $allowedFilters = [],
        array $allowedSorts = [],
        ?string $defaultSort = null,
        int $perPage = 15
    ): LengthAwarePaginator;

    /**
     * Find product by ID.
     *
     * @param int|string $id
     * @return Product|null
     */
    public function findById(int|string $id): ?Product;

    /**
     * Find product by ID or fail.
     *
     * @param int|string $id
     * @return Product
     * @throws ModelNotFoundException
     */
    public function findByIdOrFail(int|string $id): Product;

    /**
     * Find product by slug.
     *
     * @param string $slug
     * @return Product|null
     */
    public function findBySlug(string $slug): ?Product;

    /**
     * Get products by category ID.
     *
     * @param int $categoryId
     * @return Collection
     */
    public function getByCategoryId(int $categoryId): Collection;

    /**
     * Create a new product.
     *
     * @param array $data
     * @return Product
     */
    public function create(array $data): Product;

    /**
     * Update an existing product.
     *
     * @param int|string $id
     * @param array $data
     * @return Product
     */
    public function update(int|string $id, array $data): Product;

    /**
     * Delete a product.
     *
     * @param int|string $id
     * @return bool
     */
    public function delete(int|string $id): bool;
}
