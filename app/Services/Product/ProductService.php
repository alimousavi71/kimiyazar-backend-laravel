<?php

namespace App\Services\Product;

use App\Models\Product;
use App\Repositories\Product\ProductRepositoryInterface;
use Illuminate\Contracts\Pagination\LengthAwarePaginator;
use Illuminate\Database\Eloquent\Collection;
use Illuminate\Database\Eloquent\ModelNotFoundException;
use Spatie\QueryBuilder\AllowedFilter;

/**
 * Service class for Product business logic
 */
class ProductService
{
    /**
     * @param ProductRepositoryInterface $repository
     */
    public function __construct(
        private readonly ProductRepositoryInterface $repository
    ) {
    }

    /**
     * Get all products with optional filters using QueryBuilder.
     *
     * @param int $perPage
     * @return LengthAwarePaginator
     */
    public function search(int $perPage = 15): LengthAwarePaginator
    {
        $allowedFilters = [
            AllowedFilter::partial('name'),
            AllowedFilter::partial('slug'),
            AllowedFilter::exact('is_published'),
            AllowedFilter::exact('status'),
            AllowedFilter::exact('unit'),
            AllowedFilter::callback('category_id', function ($query, $value) {
                if ($value === null || $value === '' || strtolower((string) $value) === 'null') {
                    $query->whereNull('category_id');
                } else {
                    $query->where('category_id', $value);
                }
            }),
            AllowedFilter::callback('search', function ($query, $value) {
                $query->where(function ($q) use ($value) {
                    $q->where('name', 'like', "%{$value}%")
                        ->orWhere('slug', 'like', "%{$value}%")
                        ->orWhere('sale_description', 'like', "%{$value}%");
                });
            }),
        ];

        $allowedSorts = [
            'id',
            'name',
            'slug',
            'is_published',
            'status',
            'unit',
            'category_id',
            'sort_order',
            'current_price',
            'created_at',
            'updated_at',
        ];

        $defaultSort = 'sort_order';

        return $this->repository->search($allowedFilters, $allowedSorts, $defaultSort, $perPage);
    }

    /**
     * Find product by ID.
     *
     * @param int|string $id
     * @return Product
     * @throws ModelNotFoundException
     */
    public function findById(int|string $id): Product
    {
        return $this->repository->findByIdOrFail($id);
    }

    /**
     * Find product by slug.
     *
     * @param string $slug
     * @return Product|null
     */
    public function findBySlug(string $slug): ?Product
    {
        return $this->repository->findBySlug($slug);
    }

    /**
     * Get products by category ID.
     *
     * @param int $categoryId
     * @return Collection
     */
    public function getByCategoryId(int $categoryId): Collection
    {
        return $this->repository->getByCategoryId($categoryId);
    }

    /**
     * Create a new product.
     *
     * @param array $data
     * @return Product
     */
    public function create(array $data): Product
    {
        if (!isset($data['sort_order'])) {
            $data['sort_order'] = 0;
        }

        if (isset($data['is_published']) && is_bool($data['is_published'])) {
            $data['is_published'] = $data['is_published'] ? 1 : 0;
        }

        return $this->repository->create($data);
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
        if (!isset($data['sort_order'])) {
            $data['sort_order'] = 0;
        }

        if (isset($data['is_published']) && is_bool($data['is_published'])) {
            $data['is_published'] = $data['is_published'] ? 1 : 0;
        }

        return $this->repository->update($id, $data);
    }

    /**
     * Delete a product.
     *
     * @param int|string $id
     * @return bool
     */
    public function delete(int|string $id): bool
    {
        return $this->repository->delete($id);
    }
}
