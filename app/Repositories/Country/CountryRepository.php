<?php

namespace App\Repositories\Country;

use App\Models\Country;
use Illuminate\Contracts\Pagination\LengthAwarePaginator;
use Illuminate\Database\Eloquent\Collection;
use Illuminate\Database\Eloquent\ModelNotFoundException;
use Spatie\QueryBuilder\AllowedFilter;
use Spatie\QueryBuilder\QueryBuilder;

/**
 * Repository implementation for Country model
 */
class CountryRepository implements CountryRepositoryInterface
{
    /**
     * Get all countries with pagination using QueryBuilder.
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
    ): LengthAwarePaginator {
        $query = QueryBuilder::for(Country::class);

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
     * Find country by ID.
     *
     * @param int|string $id
     * @return Country|null
     */
    public function findById(int|string $id): ?Country
    {
        return Country::find($id);
    }

    /**
     * Find country by ID or fail.
     *
     * @param int|string $id
     * @return Country
     * @throws ModelNotFoundException
     */
    public function findByIdOrFail(int|string $id): Country
    {
        return Country::findOrFail($id);
    }

    /**
     * Create a new country.
     *
     * @param array $data
     * @return Country
     */
    public function create(array $data): Country
    {
        return Country::create($data);
    }

    /**
     * Update an existing country.
     *
     * @param int|string $id
     * @param array $data
     * @return Country
     */
    public function update(int|string $id, array $data): Country
    {
        $country = $this->findByIdOrFail($id);
        $country->update($data);

        return $country->fresh();
    }

    /**
     * Delete a country.
     *
     * @param int|string $id
     * @return bool
     */
    public function delete(int|string $id): bool
    {
        $country = $this->findByIdOrFail($id);

        return $country->delete();
    }

    /**
     * Get all countries.
     *
     * @return Collection
     */
    public function all(): Collection
    {
        return Country::all();
    }
}
