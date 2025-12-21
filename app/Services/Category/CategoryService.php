<?php

namespace App\Services\Category;

use App\Models\Category;
use App\Repositories\Category\CategoryRepositoryInterface;
use Illuminate\Contracts\Pagination\LengthAwarePaginator;
use Illuminate\Database\Eloquent\Collection as EloquentCollection;
use Illuminate\Database\Eloquent\ModelNotFoundException;
use Illuminate\Support\Collection;
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
     * Get all categories in a flat tree structure with depth information.
     * This method builds a hierarchical tree and flattens it for display.
     *
     * @param int|null $excludeCategoryId Category ID to exclude along with all its descendants
     * @return EloquentCollection
     */
    public function getAllCategoriesTree(?int $excludeCategoryId = null): EloquentCollection
    {
        $allCategories = Category::orderBy('sort_order')->get();

        // If excluding a category, remove it and all its descendants
        if ($excludeCategoryId !== null) {
            $excludeIds = $this->getCategoryAndDescendantIds($excludeCategoryId);
            $allCategories = $allCategories->reject(function ($category) use ($excludeIds) {
                return in_array($category->id, $excludeIds);
            });
        }

        // Build tree structure
        $tree = $this->buildCategoryTree($allCategories);

        // Flatten tree with depth information
        $flattened = new EloquentCollection();
        $this->flattenCategoryTree($tree, $flattened, 0);

        return $flattened;
    }

    /**
     * Get category ID and all its descendant IDs recursively.
     *
     * @param int $categoryId
     * @return array
     */
    private function getCategoryAndDescendantIds(int $categoryId): array
    {
        $ids = [$categoryId];

        $getChildren = function ($parentId) use (&$getChildren, &$ids) {
            $children = Category::where('parent_id', $parentId)->pluck('id')->toArray();
            foreach ($children as $childId) {
                $ids[] = $childId;
                $getChildren($childId);
            }
        };

        $getChildren($categoryId);

        return $ids;
    }

    /**
     * Build category tree from flat collection.
     *
     * @param EloquentCollection $categories
     * @return EloquentCollection
     */
    private function buildCategoryTree(EloquentCollection $categories): EloquentCollection
    {
        $grouped = $categories->groupBy('parent_id');

        $buildTree = function ($parentId = null) use (&$buildTree, $grouped) {
            $children = $grouped->get($parentId, new EloquentCollection());

            return $children->map(function ($category) use (&$buildTree, $grouped) {
                $category->children = $buildTree($category->id);
                return $category;
            });
        };

        return $buildTree();
    }

    /**
     * Flatten category tree with depth information and full path.
     *
     * @param EloquentCollection $tree
     * @param EloquentCollection $result
     * @param int $depth
     * @param array $path
     * @return void
     */
    private function flattenCategoryTree(EloquentCollection $tree, EloquentCollection $result, int $depth, array $path = []): void
    {
        foreach ($tree as $category) {
            $category->depth = $depth;

            // Build full path for this category
            $currentPath = array_merge($path, [$category->name]);
            $category->full_path = implode(' › ', $currentPath);
            $category->path_names = $currentPath;

            $result->push($category);

            if ($category->children && $category->children->isNotEmpty()) {
                $this->flattenCategoryTree($category->children, $result, $depth + 1, $currentPath);
            }
        }
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

