<?php

namespace App\Services\Bank;

use App\Models\Bank;
use App\Repositories\Bank\BankRepositoryInterface;
use Illuminate\Contracts\Pagination\LengthAwarePaginator;
use Illuminate\Database\Eloquent\Collection;
use Illuminate\Database\Eloquent\ModelNotFoundException;
use Spatie\QueryBuilder\AllowedFilter;

/**
 * Service class for Bank business logic
 */
class BankService
{
    /**
     * @param BankRepositoryInterface $repository
     */
    public function __construct(
        private readonly BankRepositoryInterface $repository
    ) {
    }

    /**
     * Get all banks with optional filters.
     *
     * @param int $perPage
     * @return LengthAwarePaginator
     */
    public function search(int $perPage = 15): LengthAwarePaginator
    {
        $allowedFilters = [
            AllowedFilter::partial('name'),
            AllowedFilter::callback('search', function ($query, $value) {
                $query->where('name', 'like', "%{$value}%");
            }),
        ];

        $allowedSorts = [
            'id',
            'name',
        ];

        $defaultSort = 'name';

        return $this->repository->search($allowedFilters, $allowedSorts, $defaultSort, $perPage);
    }

    /**
     * Find bank by ID.
     *
     * @param int|string $id
     * @return Bank
     * @throws ModelNotFoundException
     */
    public function findById(int|string $id): Bank
    {
        return $this->repository->findByIdOrFail($id);
    }

    /**
     * Create a new bank.
     *
     * @param array $data
     * @return Bank
     */
    public function create(array $data): Bank
    {
        return $this->repository->create($data);
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
        return $this->repository->update($id, $data);
    }

    /**
     * Delete a bank.
     *
     * @param int|string $id
     * @return bool
     */
    public function delete(int|string $id): bool
    {
        return $this->repository->delete($id);
    }

    /**
     * Get all banks.
     *
     * @return Collection
     */
    public function all(): Collection
    {
        return $this->repository->all();
    }
}
