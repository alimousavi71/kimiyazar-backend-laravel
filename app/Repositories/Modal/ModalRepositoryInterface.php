<?php

namespace App\Repositories\Modal;

use App\Models\Modal;
use Illuminate\Contracts\Pagination\LengthAwarePaginator;
use Illuminate\Database\Eloquent\ModelNotFoundException;

/**
 * Interface for Modal Repository
 */
interface ModalRepositoryInterface
{
    /**
     * Get all modals with pagination.
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
     * Find modal by ID.
     *
     * @param int|string $id
     * @return Modal|null
     */
    public function findById(int|string $id): ?Modal;

    /**
     * Find modal by ID or fail.
     *
     * @param int|string $id
     * @return Modal
     * @throws ModelNotFoundException
     */
    public function findByIdOrFail(int|string $id): Modal;

    /**
     * Create a new modal.
     *
     * @param array $data
     * @return Modal
     */
    public function create(array $data): Modal;

    /**
     * Update an existing modal.
     *
     * @param int|string $id
     * @param array $data
     * @return Modal
     */
    public function update(int|string $id, array $data): Modal;

    /**
     * Delete a modal.
     *
     * @param int|string $id
     * @return bool
     */
    public function delete(int|string $id): bool;
}
