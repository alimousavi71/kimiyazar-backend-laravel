<?php

namespace App\Services\Country;

use App\Models\Country;
use App\Repositories\Country\CountryRepositoryInterface;
use Illuminate\Contracts\Pagination\LengthAwarePaginator;
use Illuminate\Database\Eloquent\Collection;
use Illuminate\Database\Eloquent\ModelNotFoundException;
use Spatie\QueryBuilder\AllowedFilter;

/**
 * Service class for Country business logic
 */
class CountryService
{
    /**
     * @param CountryRepositoryInterface $repository
     */
    public function __construct(
        private readonly CountryRepositoryInterface $repository
    ) {
    }

    /**
     * Get all countries with optional filters.
     *
     * @param int $perPage
     * @return LengthAwarePaginator
     */
    public function search(int $perPage = 15): LengthAwarePaginator
    {
        $allowedFilters = [
            AllowedFilter::partial('name'),
            AllowedFilter::partial('code'),
            AllowedFilter::callback('search', function ($query, $value) {
                $query->where(function ($q) use ($value) {
                    $q->where('name', 'like', "%{$value}%")
                        ->orWhere('code', 'like', "%{$value}%");
                });
            }),
        ];

        $allowedSorts = [
            'id',
            'name',
            'code',
        ];

        $defaultSort = 'name';

        return $this->repository->search($allowedFilters, $allowedSorts, $defaultSort, $perPage);
    }

    /**
     * Find country by ID.
     *
     * @param int|string $id
     * @return Country
     * @throws ModelNotFoundException
     */
    public function findById(int|string $id): Country
    {
        return $this->repository->findByIdOrFail($id);
    }

    /**
     * Create a new country.
     *
     * @param array $data
     * @return Country
     */
    public function create(array $data): Country
    {
        return $this->repository->create($data);
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
        return $this->repository->update($id, $data);
    }

    /**
     * Delete a country.
     *
     * @param int|string $id
     * @return bool
     */
    public function delete(int|string $id): bool
    {
        return $this->repository->delete($id);
    }

    /**
     * Get all countries.
     *
     * @return Collection
     */
    public function all(): Collection
    {
        return $this->repository->all();
    }
}
