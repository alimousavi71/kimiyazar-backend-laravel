<?php

namespace App\Services\State;

use App\Models\State;
use App\Repositories\State\StateRepositoryInterface;
use Illuminate\Contracts\Pagination\LengthAwarePaginator;
use Illuminate\Database\Eloquent\Collection;
use Illuminate\Database\Eloquent\ModelNotFoundException;
use Spatie\QueryBuilder\AllowedFilter;

/**
 * Service class for State business logic
 */
class StateService
{
    /**
     * @param StateRepositoryInterface $repository
     */
    public function __construct(
        private readonly StateRepositoryInterface $repository
    ) {
    }

    /**
     * Get all states with optional filters.
     *
     * @param int $perPage
     * @return LengthAwarePaginator
     */
    public function search(int $perPage = 15): LengthAwarePaginator
    {
        $allowedFilters = [
            AllowedFilter::partial('name'),
            AllowedFilter::exact('country_id'),
            AllowedFilter::callback('search', function ($query, $value) {
                $query->where(function ($q) use ($value) {
                    $q->where('name', 'like', "%{$value}%");
                });
            }),
        ];

        $allowedSorts = [
            'id',
            'name',
            'country_id',
        ];

        $defaultSort = 'name';

        return $this->repository->search($allowedFilters, $allowedSorts, $defaultSort, $perPage);
    }

    /**
     * Find state by ID.
     *
     * @param int|string $id
     * @return State
     * @throws ModelNotFoundException
     */
    public function findById(int|string $id): State
    {
        return $this->repository->findByIdOrFail($id);
    }

    /**
     * Create a new state.
     *
     * @param array $data
     * @return State
     */
    public function create(array $data): State
    {
        return $this->repository->create($data);
    }

    /**
     * Update an existing state.
     *
     * @param int|string $id
     * @param array $data
     * @return State
     */
    public function update(int|string $id, array $data): State
    {
        return $this->repository->update($id, $data);
    }

    /**
     * Delete a state.
     *
     * @param int|string $id
     * @return bool
     */
    public function delete(int|string $id): bool
    {
        return $this->repository->delete($id);
    }

    /**
     * Get states by country ID.
     *
     * @param int $countryId
     * @return Collection
     */
    public function getByCountryId(int $countryId): Collection
    {
        return $this->repository->getByCountryId($countryId);
    }

    /**
     * Get all states.
     *
     * @return Collection
     */
    public function all(): Collection
    {
        return $this->repository->all();
    }
}
