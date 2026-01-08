<?php

namespace App\Repositories\Banner;

use App\Models\Banner;
use Illuminate\Contracts\Pagination\LengthAwarePaginator;
use Illuminate\Database\Eloquent\ModelNotFoundException;
use Spatie\QueryBuilder\QueryBuilder;

/**
 * Repository implementation for Banner model
 */
class BannerRepository implements BannerRepositoryInterface
{
    /**
     * Get all banners with pagination using QueryBuilder.
     *
     * @param array $allowedFilters Allowed filters configuration
     * @param array $allowedSorts   Allowed sorts configuration
     * @param string|null $defaultSort Default sort
     * @param int $perPage
     * @return LengthAwarePaginator
     */
    public function search(
        array $allowedFilters = [],
        array $allowedSorts = [],
        ?string $defaultSort = null,
        int $perPage = 15
    ): LengthAwarePaginator {
        $query = QueryBuilder::for(Banner::class);

        if (!empty($allowedFilters)) {
            $query->allowedFilters($allowedFilters);
        }

        if (!empty($allowedSorts)) {
            $query->allowedSorts($allowedSorts);
        }

        if ($defaultSort !== null) {
            $query->defaultSort($defaultSort);
        }

        return $query->paginate($perPage)->withQueryString();
    }

    /**
     * Find banner by ID.
     *
     * @param int|string $id
     * @return Banner|null
     */
    public function findById(int|string $id): ?Banner
    {
        return Banner::find($id);
    }

    /**
     * Find banner by ID or fail.
     *
     * @param int|string $id
     * @return Banner
     * @throws ModelNotFoundException
     */
    public function findByIdOrFail(int|string $id): Banner
    {
        return Banner::findOrFail($id);
    }

    /**
     * Create a new banner.
     *
     * @param array $data
     * @return Banner
     */
    public function create(array $data): Banner
    {
        return Banner::create($data);
    }

    /**
     * Update an existing banner.
     *
     * @param int|string $id
     * @param array $data
     * @return Banner
     */
    public function update(int|string $id, array $data): Banner
    {
        $banner = $this->findByIdOrFail($id);
        $banner->update($data);

        return $banner->fresh();
    }

    /**
     * Delete a banner.
     *
     * @param int|string $id
     * @return bool
     */
    public function delete(int|string $id): bool
    {
        $banner = $this->findByIdOrFail($id);

        return $banner->delete();
    }
}

