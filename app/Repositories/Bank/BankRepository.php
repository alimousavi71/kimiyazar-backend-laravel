<?php

namespace App\Repositories\Bank;

use App\Models\Bank;
use Illuminate\Contracts\Pagination\LengthAwarePaginator;
use Illuminate\Database\Eloquent\Collection;
use Illuminate\Database\Eloquent\ModelNotFoundException;
use Spatie\QueryBuilder\AllowedFilter;
use Spatie\QueryBuilder\QueryBuilder;

/**
 * Repository implementation for Bank model
 */
class BankRepository implements BankRepositoryInterface
{
    /**
     * Get all banks with pagination using QueryBuilder.
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
        $query = QueryBuilder::for(Bank::class);

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
     * Find bank by ID.
     *
     * @param int|string $id
     * @return Bank|null
     */
    public function findById(int|string $id): ?Bank
    {
        return Bank::find($id);
    }

    /**
     * Find bank by ID or fail.
     *
     * @param int|string $id
     * @return Bank
     * @throws ModelNotFoundException
     */
    public function findByIdOrFail(int|string $id): Bank
    {
        return Bank::findOrFail($id);
    }

    /**
     * Create a new bank.
     *
     * @param array $data
     * @return Bank
     */
    public function create(array $data): Bank
    {
        return Bank::create($data);
    }

    /**
     * Update an existing bank.
     *
     * @param int|string $id
     * @param array $data
     * @return Bank
     */
    public function update(int|string $id, array $data): Bank
    {
        $bank = $this->findByIdOrFail($id);
        $bank->update($data);

        return $bank->fresh();
    }

    /**
     * Delete a bank.
     *
     * @param int|string $id
     * @return bool
     */
    public function delete(int|string $id): bool
    {
        $bank = $this->findByIdOrFail($id);

        return $bank->delete();
    }

    /**
     * Get all banks.
     *
     * @return Collection
     */
    public function all(): Collection
    {
        return Bank::all();
    }
}
