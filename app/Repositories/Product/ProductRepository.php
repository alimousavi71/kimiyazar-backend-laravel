<?php

namespace App\Repositories\Product;

use App\Enums\Database\ProductStatus;
use App\Models\Product;
use Illuminate\Contracts\Pagination\LengthAwarePaginator;
use Illuminate\Database\Eloquent\Collection;
use Illuminate\Database\Eloquent\ModelNotFoundException;
use Spatie\QueryBuilder\AllowedFilter;
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

    /**
     * Get active published products.
     *
     * @param int|null $limit
     * @return Collection
     */
    public function getActivePublishedProducts(?int $limit = null): Collection
    {
        $query = Product::where('is_published', true)
            ->where('status', ProductStatus::ACTIVE)
            ->with(['category', 'photos', 'prices'])
            ->orderBy('created_at', 'desc');

        if ($limit !== null) {
            $query->limit($limit);
        }

        return $query->get();
    }

    /**
     * Get paginated active published products with filters.
     *
     * @param int $perPage
     * @param int|null $categoryId
     * @param string|null $search
     * @param string|null $sort
     * @param array|null $categoryIds
     * @return LengthAwarePaginator
     */
    public function getPaginatedActivePublishedProducts(
        int $perPage = 50,
        ?int $categoryId = null,
        ?string $search = null,
        ?string $sort = null,
        ?array $categoryIds = null
    ): LengthAwarePaginator {
        $query = Product::where('is_published', true)
            ->where('status', ProductStatus::ACTIVE)
            ->with(['category', 'photos']);

        // Apply category filter
        if ($categoryIds !== null && !empty($categoryIds)) {
            $query->whereIn('category_id', $categoryIds);
        } elseif ($categoryId !== null) {
            $query->where('category_id', $categoryId);
        }

        // Apply search filter
        if ($search !== null && trim($search) !== '') {
            $searchValue = trim($search);
            $query->where(function ($q) use ($searchValue) {
                $q->where('name', 'like', "%{$searchValue}%")
                    ->orWhere('slug', 'like', "%{$searchValue}%")
                    ->orWhere('sale_description', 'like', "%{$searchValue}%")
                    ->orWhere('body', 'like', "%{$searchValue}%");
            });
        }

        // Apply sorting
        if ($sort === 'product_price') {
            $query->orderBy('current_price', 'asc');
        } elseif ($sort === 'price_date') {
            $query->orderBy('price_updated_at', 'desc');
        } else {
            $query->orderBy('created_at', 'desc');
        }

        return $query->paginate($perPage);
    }

    /**
     * Get latest price update date from active published products.
     *
     * @return string|null
     */
    public function getLatestPriceUpdateDate(): ?string
    {
        return Product::where('is_published', true)
            ->where('status', ProductStatus::ACTIVE)
            ->whereNotNull('price_updated_at')
            ->max('price_updated_at');
    }

    /**
     * Get all products.
     *
     * @return Collection
     */
    public function all(): Collection
    {
        return Product::all();
    }

    /**
     * Get products by IDs.
     *
     * @param array $ids
     * @return Collection
     */
    public function findByIds(array $ids): Collection
    {
        if (empty($ids)) {
            return new Collection();
        }

        return Product::whereIn('id', $ids)->get();
    }

    /**
     * Get products with search and category filters for price management.
     *
     * @param string|null $search
     * @param array|null $categoryIds
     * @param int $perPage
     * @return LengthAwarePaginator
     */
    public function getProductsForPriceManagement(?string $search = null, ?array $categoryIds = null, int $perPage = 15): LengthAwarePaginator
    {
        $query = Product::query();

        // Apply search filter
        if ($search !== null && trim($search) !== '') {
            $searchValue = trim($search);
            $query->where(function ($q) use ($searchValue) {
                $q->where('name', 'like', "%{$searchValue}%")
                    ->orWhere('slug', 'like', "%{$searchValue}%");
            });
        }

        // Apply category filter (including all children)
        if ($categoryIds !== null && !empty($categoryIds)) {
            $query->whereIn('category_id', $categoryIds);
        }

        // Apply sorting
        $query->orderBy('sort_order');

        return $query->paginate($perPage)->withQueryString();
    }
}
