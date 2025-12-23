<?php

namespace App\Repositories\PriceInquiry;

use App\Models\PriceInquiry;
use Illuminate\Contracts\Pagination\LengthAwarePaginator;

interface PriceInquiryRepositoryInterface
{
    /**
     * Search price inquiries with filters and sorting.
     *
     * @param array $allowedFilters
     * @param array $allowedSorts
     * @param string $defaultSort
     * @param int $perPage
     * @return LengthAwarePaginator
     */
    public function search(array $allowedFilters, array $allowedSorts, string $defaultSort, int $perPage = 15): LengthAwarePaginator;

    /**
     * Find price inquiry by ID.
     *
     * @param int|string $id
     * @return PriceInquiry|null
     */
    public function findById(int|string $id): ?PriceInquiry;

    /**
     * Find price inquiry by ID or fail.
     *
     * @param int|string $id
     * @return PriceInquiry
     * @throws \Illuminate\Database\Eloquent\ModelNotFoundException
     */
    public function findByIdOrFail(int|string $id): PriceInquiry;

    /**
     * Create a new price inquiry.
     *
     * @param array $data
     * @return PriceInquiry
     */
    public function create(array $data): PriceInquiry;

    /**
     * Update price inquiry.
     *
     * @param int|string $id
     * @param array $data
     * @return PriceInquiry
     */
    public function update(int|string $id, array $data): PriceInquiry;

    /**
     * Delete price inquiry.
     *
     * @param int|string $id
     * @return bool
     */
    public function delete(int|string $id): bool;

    /**
     * Get all price inquiries.
     *
     * @return \Illuminate\Database\Eloquent\Collection
     */
    public function all();
}
