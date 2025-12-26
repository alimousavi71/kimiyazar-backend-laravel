<?php

namespace App\Repositories\State;

use App\Models\State;
use Illuminate\Contracts\Pagination\LengthAwarePaginator;
use Illuminate\Database\Eloquent\Collection;
use Illuminate\Database\Eloquent\ModelNotFoundException;

/**
 * Interface for State Repository
 */
interface StateRepositoryInterface
{
    /**
     * Get all states with pagination.
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
     * Find state by ID.
     *
     * @param int|string $id
     * @return State|null
     */
    public function findById(int|string $id): ?State;

    /**
     * Find state by ID or fail.
     *
     * @param int|string $id
     * @return State
     * @throws ModelNotFoundException
     */
    public function findByIdOrFail(int|string $id): State;

    /**
     * Create a new state.
     *
     * @param array $data
     * @return State
     */
    public function create(array $data): State;

    /**
     * Update an existing state.
     *
     * @param int|string $id
     * @param array $data
     * @return State
     */
    public function update(int|string $id, array $data): State;

    /**
     * Delete a state.
     *
     * @param int|string $id
     * @return bool
     */
    public function delete(int|string $id): bool;

    /**
     * Get states by country ID.
     *
     * @param int $countryId
     * @return Collection
     */
    public function getByCountryId(int $countryId): Collection;

    /**
     * Get all states.
     *
     * @return Collection
     */
    public function all(): Collection;
}
