<?php

namespace App\Repositories\Product;

use App\Models\Product;
use Illuminate\Contracts\Pagination\LengthAwarePaginator;
use Illuminate\Database\Eloquent\Collection;
use Illuminate\Database\Eloquent\ModelNotFoundException;
use Spatie\QueryBuilder\QueryBuilder;

/**
 * Repository implementation for Product model
 */
class ProductRepository implements ProductRepositoryInterface
{
    /**
     * Get all products with pagination using QueryBuilder.
     *
     * @param array $allowedFilters Allowed filters configuration (Spatie\QueryBuilder\AllowedFilter instances or field names)
     * @param array $allowedSorts   Allowed sorts configuration (field names)
     * @param string|null $defaultSort Default sort (e.g. 'sort_order' or '-created_at'), can be null to skip default sort
     * @param int $perPage
     * @return LengthAwarePaginator
     */
    public function search(
        array $allowedFilters = [],
        array $allowedSorts = [],
        ?string $defaultSort = null,
        int $perPage = 15
    ): LengthAwarePaginator {
        $query = QueryBuilder::for(Product::class);

        if (!empty($allowedFilters)) {
            $query->allowedFilters($allowedFilters);
        }

        if (!empty($allowedSorts)) {
            $query->allowedSorts($allowedSorts);
        }

        if ($defaultSort !== null) {
            $query->defaultSort($defaultSort);
        }

        return $query->paginate($perPage);
    }

    /**
     * Find product by ID.
     *
     * @param int|string $id
     * @return Product|null
     */
    public function findById(int|string $id): ?Product
    {
        return Product::find($id);
    }

    /**
     * Find product by ID or fail.
     *
     * @param int|string $id
     * @return Product
     * @throws ModelNotFoundException
     */
    public function findByIdOrFail(int|string $id): Product
    {
        return Product::findOrFail($id);
    }

    /**
     * Find product by slug.
     *
     * @param string $slug
     * @return Product|null
     */
    public function findBySlug(string $slug): ?Product
    {
        return Product::where('slug', $slug)->first();
    }

    /**
     * Get products by category ID.
     *
     * @param int $categoryId
     * @return Collection
     */
    public function getByCategoryId(int $categoryId): Collection
    {
        return Product::where('category_id', $categoryId)
            ->orderBy('sort_order')
            ->get();
    }

    /**
     * Create a new product.
     *
     * @param array $data
     * @return Product
     */
    public function create(array $data): Product
    {
        return Product::create($data);
    }

    /**
     * Update an existing product.
     *
     * @param int|string $id
     * @param array $data
     * @return Product
     */
    public function update(int|string $id, array $data): Product
    {
        $product = $this->findByIdOrFail($id);
        $product->update($data);

        return $product->fresh();
    }

    /**
     * Delete a product.
     *
     * @param int|string $id
     * @return bool
     */
    public function delete(int|string $id): bool
    {
        $product = $this->findByIdOrFail($id);

        return $product->delete();
    }
}
