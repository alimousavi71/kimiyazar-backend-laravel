<?php

namespace App\Repositories\State;

use App\Models\State;
use Illuminate\Contracts\Pagination\LengthAwarePaginator;
use Illuminate\Database\Eloquent\Collection;
use Illuminate\Database\Eloquent\ModelNotFoundException;
use Spatie\QueryBuilder\AllowedFilter;
use Spatie\QueryBuilder\QueryBuilder;

/**
 * Repository implementation for State model
 */
class StateRepository implements StateRepositoryInterface
{
    /**
     * Get all states with pagination using QueryBuilder.
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
        $query = QueryBuilder::for(State::class)
            ->with('country');

        if (!empty($allowedFilters)) {
            $query->allowedFilters($allowedFilters);
        }

        if (!empty($allowedSorts)) {
            $query->allowedSorts($allowedSorts);
        }

        if ($defaultSort !== null) {
            $query->defaultSort($defaultSort);
        }

        return $query->paginate($perPage);
    }

    /**
     * Find state by ID.
     *
     * @param int|string $id
     * @return State|null
     */
    public function findById(int|string $id): ?State
    {
        return State::with('country')->find($id);
    }

    /**
     * Find state by ID or fail.
     *
     * @param int|string $id
     * @return State
     * @throws ModelNotFoundException
     */
    public function findByIdOrFail(int|string $id): State
    {
        return State::with('country')->findOrFail($id);
    }

    /**
     * Create a new state.
     *
     * @param array $data
     * @return State
     */
    public function create(array $data): State
    {
        return State::create($data);
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
        $state = $this->findByIdOrFail($id);
        $state->update($data);

        return $state->fresh();
    }

    /**
     * Delete a state.
     *
     * @param int|string $id
     * @return bool
     */
    public function delete(int|string $id): bool
    {
        $state = $this->findByIdOrFail($id);

        return $state->delete();
    }

    /**
     * Get states by country ID.
     *
     * @param int $countryId
     * @return Collection
     */
    public function getByCountryId(int $countryId): Collection
    {
        return State::where('country_id', $countryId)
            ->with('country')
            ->orderBy('name')
            ->get();
    }

    /**
     * Get all states.
     *
     * @return Collection
     */
    public function all(): Collection
    {
        return State::with('country')->get();
    }
}
