<?php

namespace App\Repositories\Banner;

use App\Models\Banner;
use Illuminate\Contracts\Pagination\LengthAwarePaginator;
use Illuminate\Database\Eloquent\ModelNotFoundException;

/**
 * Interface for Banner Repository
 */
interface BannerRepositoryInterface
{
    /**
     * Get all banners with pagination.
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
     * Find banner by ID.
     *
     * @param int|string $id
     * @return Banner|null
     */
    public function findById(int|string $id): ?Banner;

    /**
     * Find banner by ID or fail.
     *
     * @param int|string $id
     * @return Banner
     * @throws ModelNotFoundException
     */
    public function findByIdOrFail(int|string $id): Banner;

    /**
     * Create a new banner.
     *
     * @param array $data
     * @return Banner
     */
    public function create(array $data): Banner;

    /**
     * Update an existing banner.
     *
     * @param int|string $id
     * @param array $data
     * @return Banner
     */
    public function update(int|string $id, array $data): Banner;

    /**
     * Delete a banner.
     *
     * @param int|string $id
     * @return bool
     */
    public function delete(int|string $id): bool;
}

