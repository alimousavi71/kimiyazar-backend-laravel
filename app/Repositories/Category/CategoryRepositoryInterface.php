<?php

namespace App\Repositories\Category;

use App\Models\Category;
use Illuminate\Contracts\Pagination\LengthAwarePaginator;
use Illuminate\Database\Eloquent\Collection;
use Illuminate\Database\Eloquent\ModelNotFoundException;

/**
 * Interface for Category Repository
 */
interface CategoryRepositoryInterface
{
    /**
     * Get all categories with pagination.
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
     * Find category by ID.
     *
     * @param int|string $id
     * @return Category|null
     */
    public function findById(int|string $id): ?Category;

    /**
     * Find category by ID or fail.
     *
     * @param int|string $id
     * @return Category
     * @throws ModelNotFoundException
     */
    public function findByIdOrFail(int|string $id): Category;

    /**
     * Get all root categories (no parent).
     *
     * @return Collection
     */
    public function getRootCategories(): Collection;

    /**
     * Get categories by parent ID.
     *
     * @param int $parentId
     * @return Collection
     */
    public function getByParentId(int $parentId): Collection;

    /**
     * Create a new category.
     *
     * @param array $data
     * @return Category
     */
    public function create(array $data): Category;

    /**
     * Update an existing category.
     *
     * @param int|string $id
     * @param array $data
     * @return Category
     */
    public function update(int|string $id, array $data): Category;

    /**
     * Delete a category.
     *
     * @param int|string $id
     * @return bool
     */
    public function delete(int|string $id): bool;

    /**
     * Get all categories ordered by sort_order.
     *
     * @return \Illuminate\Database\Eloquent\Collection
     */
    public function getAllOrdered(): \Illuminate\Database\Eloquent\Collection;

    /**
     * Get category IDs by parent ID with active filter.
     *
     * @param int $parentId
     * @param bool $activeOnly
     * @return array
     */
    public function getCategoryIdsByParentId(int $parentId, bool $activeOnly = false): array;

    /**
     * Get root categories with active filter and children relation.
     *
     * @param bool $activeOnly
     * @return \Illuminate\Database\Eloquent\Collection
     */
    public function getRootCategoriesWithChildren(bool $activeOnly = true): \Illuminate\Database\Eloquent\Collection;
}

