<?php

namespace App\Repositories\Bank;

use App\Models\Bank;
use Illuminate\Contracts\Pagination\LengthAwarePaginator;
use Illuminate\Database\Eloquent\Collection;
use Illuminate\Database\Eloquent\ModelNotFoundException;

/**
 * Interface for Bank Repository
 */
interface BankRepositoryInterface
{
    /**
     * Get all banks with pagination.
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
     * Find bank by ID.
     *
     * @param int|string $id
     * @return Bank|null
     */
    public function findById(int|string $id): ?Bank;

    /**
     * Find bank by ID or fail.
     *
     * @param int|string $id
     * @return Bank
     * @throws ModelNotFoundException
     */
    public function findByIdOrFail(int|string $id): Bank;

    /**
     * Create a new bank.
     *
     * @param array $data
     * @return Bank
     */
    public function create(array $data): Bank;

    /**
     * Update an existing bank.
     *
     * @param int|string $id
     * @param array $data
     * @return Bank
     */
    public function update(int|string $id, array $data): Bank;

    /**
     * Delete a bank.
     *
     * @param int|string $id
     * @return bool
     */
    public function delete(int|string $id): bool;

    /**
     * Get all banks.
     *
     * @return Collection
     */
    public function all(): Collection;
}
