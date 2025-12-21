<?php

namespace App\Repositories\Category;

use App\Models\Category;
use Illuminate\Contracts\Pagination\LengthAwarePaginator;
use Illuminate\Database\Eloquent\Collection;
use Illuminate\Database\Eloquent\ModelNotFoundException;
use Spatie\QueryBuilder\QueryBuilder;

/**
 * Repository implementation for Category model
 */
class CategoryRepository implements CategoryRepositoryInterface
{
    /**
     * Get all categories with pagination using QueryBuilder.
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
        $query = QueryBuilder::for(Category::class);

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
     * Find category by ID.
     *
     * @param int|string $id
     * @return Category|null
     */
    public function findById(int|string $id): ?Category
    {
        return Category::find($id);
    }

    /**
     * Find category by ID or fail.
     *
     * @param int|string $id
     * @return Category
     * @throws ModelNotFoundException
     */
    public function findByIdOrFail(int|string $id): Category
    {
        return Category::findOrFail($id);
    }

    /**
     * Get all root categories (no parent).
     *
     * @return Collection
     */
    public function getRootCategories(): Collection
    {
        return Category::whereNull('parent_id')
            ->orderBy('sort_order')
            ->get();
    }

    /**
     * Get categories by parent ID.
     *
     * @param int $parentId
     * @return Collection
     */
    public function getByParentId(int $parentId): Collection
    {
        return Category::where('parent_id', $parentId)
            ->orderBy('sort_order')
            ->get();
    }

    /**
     * Create a new category.
     *
     * @param array $data
     * @return Category
     */
    public function create(array $data): Category
    {
        return Category::create($data);
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
        $category = $this->findByIdOrFail($id);
        $category->update($data);

        return $category->fresh();
    }

    /**
     * Delete a category.
     *
     * @param int|string $id
     * @return bool
     */
    public function delete(int|string $id): bool
    {
        $category = $this->findByIdOrFail($id);

        return $category->delete();
    }

    /**
     * Get all categories ordered by sort_order.
     *
     * @return \Illuminate\Database\Eloquent\Collection
     */
    public function getAllOrdered(): \Illuminate\Database\Eloquent\Collection
    {
        return Category::orderBy('sort_order')->get();
    }

    /**
     * Get category IDs by parent ID with active filter.
     *
     * @param int $parentId
     * @param bool $activeOnly
     * @return array
     */
    public function getCategoryIdsByParentId(int $parentId, bool $activeOnly = false): array
    {
        $query = Category::where('parent_id', $parentId);

        if ($activeOnly) {
            $query->where('is_active', true);
        }

        return $query->pluck('id')->toArray();
    }

    /**
     * Get root categories with active filter and children relation.
     *
     * @param bool $activeOnly
     * @return \Illuminate\Database\Eloquent\Collection
     */
    public function getRootCategoriesWithChildren(bool $activeOnly = true): \Illuminate\Database\Eloquent\Collection
    {
        $query = Category::whereNull('parent_id');

        if ($activeOnly) {
            $query->where('is_active', true);
        }

        return $query->with([
            'children' => function ($query) use ($activeOnly) {
                if ($activeOnly) {
                    $query->where('is_active', true)->orderBy('sort_order');
                } else {
                    $query->orderBy('sort_order');
                }
            }
        ])
            ->orderBy('sort_order')
            ->get();
    }
}

