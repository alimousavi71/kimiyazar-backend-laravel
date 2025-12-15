<?php

namespace App\Services\Category;

use App\Models\Category;
use App\Repositories\Category\CategoryRepositoryInterface;
use Illuminate\Contracts\Pagination\LengthAwarePaginator;
use Illuminate\Database\Eloquent\Collection;
use Illuminate\Database\Eloquent\ModelNotFoundException;
use Spatie\QueryBuilder\AllowedFilter;

/**
 * Service class for Category business logic
 */
class CategoryService
{
    /**
     * @param CategoryRepositoryInterface $repository
     */
    public function __construct(
        private readonly CategoryRepositoryInterface $repository
    ) {
    }

    /**
     * Get all categories with optional filters using QueryBuilder.
     *
     * @param int $perPage
     * @return LengthAwarePaginator
     */
    public function search(int $perPage = 15): LengthAwarePaginator
    {
        $allowedFilters = [
            AllowedFilter::partial('name'),
            AllowedFilter::partial('slug'),
            AllowedFilter::exact('is_active'),
            AllowedFilter::callback('parent_id', function ($query, $value) {
                if ($value === null || $value === '' || strtolower((string) $value) === 'null') {
                    $query->whereNull('parent_id');
                } else {
                    $query->where('parent_id', $value);
                }
            }),
            AllowedFilter::callback('search', function ($query, $value) {
                $query->where(function ($q) use ($value) {
                    $q->where('name', 'like', "%{$value}%")
                        ->orWhere('slug', 'like', "%{$value}%");
                });
            }),
        ];

        $allowedSorts = [
            'id',
            'name',
            'slug',
            'is_active',
            'parent_id',
            'sort_order',
            'created_at',
            'updated_at',
        ];

        $defaultSort = 'sort_order';

        return $this->repository->search($allowedFilters, $allowedSorts, $defaultSort, $perPage);
    }

    /**
     * Find category by ID.
     *
     * @param int|string $id
     * @return Category
     * @throws ModelNotFoundException
     */
    public function findById(int|string $id): Category
    {
        return $this->repository->findByIdOrFail($id);
    }

    /**
     * Get all root categories.
     *
     * @return Collection
     */
    public function getRootCategories(): Collection
    {
        return $this->repository->getRootCategories();
    }

    /**
     * Get categories by parent ID.
     *
     * @param int $parentId
     * @return Collection
     */
    public function getByParentId(int $parentId): Collection
    {
        return $this->repository->getByParentId($parentId);
    }

    /**
     * Create a new category.
     *
     * @param array $data
     * @return Category
     */
    public function create(array $data): Category
    {
        if (!isset($data['sort_order'])) {
            $data['sort_order'] = 0;
        }

        if (isset($data['is_active']) && is_bool($data['is_active'])) {
            $data['is_active'] = $data['is_active'] ? 1 : 0;
        }

        return $this->repository->create($data);
    }

    /**
     * Update an existing category.
     *
     * @param int|string $id
     * @param array $data
     * @return Category
     */
    public function update(int|string $id, array $data): Category
    {
        if (!isset($data['sort_order'])) {
            $data['sort_order'] = 0;
        }

        if (isset($data['is_active']) && is_bool($data['is_active'])) {
            $data['is_active'] = $data['is_active'] ? 1 : 0;
        }

        return $this->repository->update($id, $data);
    }

    /**
     * Delete a category.
     *
     * @param int|string $id
     * @return bool
     */
    public function delete(int|string $id): bool
    {
        return $this->repository->delete($id);
    }
}

