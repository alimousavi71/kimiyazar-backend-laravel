<?php

namespace App\Repositories\Country;

use App\Models\Country;
use Illuminate\Contracts\Pagination\LengthAwarePaginator;
use Illuminate\Database\Eloquent\Collection;
use Illuminate\Database\Eloquent\ModelNotFoundException;

/**
 * Interface for Country Repository
 */
interface CountryRepositoryInterface
{
    /**
     * Get all countries with pagination.
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
     * Find country by ID.
     *
     * @param int|string $id
     * @return Country|null
     */
    public function findById(int|string $id): ?Country;

    /**
     * Find country by ID or fail.
     *
     * @param int|string $id
     * @return Country
     * @throws ModelNotFoundException
     */
    public function findByIdOrFail(int|string $id): Country;

    /**
     * Create a new country.
     *
     * @param array $data
     * @return Country
     */
    public function create(array $data): Country;

    /**
     * Update an existing country.
     *
     * @param int|string $id
     * @param array $data
     * @return Country
     */
    public function update(int|string $id, array $data): Country;

    /**
     * Delete a country.
     *
     * @param int|string $id
     * @return bool
     */
    public function delete(int|string $id): bool;

    /**
     * Get all countries.
     *
     * @return Collection
     */
    public function all(): Collection;
}
