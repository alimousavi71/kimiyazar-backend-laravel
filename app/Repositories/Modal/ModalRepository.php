<?php

namespace App\Repositories\Modal;

use App\Models\Modal;
use Illuminate\Contracts\Pagination\LengthAwarePaginator;
use Illuminate\Database\Eloquent\ModelNotFoundException;
use Spatie\QueryBuilder\QueryBuilder;

/**
 * Repository implementation for Modal model
 */
class ModalRepository implements ModalRepositoryInterface
{
    /**
     * Get all modals with pagination using QueryBuilder.
     *
     * @param array $allowedFilters Allowed filters configuration (Spatie\QueryBuilder\AllowedFilter instances or field names)
     * @param array $allowedSorts   Allowed sorts configuration (field names)
     * @param string|null $defaultSort Default sort (e.g. 'priority' or '-created_at'), can be null to skip default sort
     * @param int $perPage
     * @return LengthAwarePaginator
     */
    public function search(
        array $allowedFilters = [],
        array $allowedSorts = [],
        ?string $defaultSort = null,
        int $perPage = 15
    ): LengthAwarePaginator {
        $query = QueryBuilder::for(Modal::class);

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
     * Find modal by ID.
     *
     * @param int|string $id
     * @return Modal|null
     */
    public function findById(int|string $id): ?Modal
    {
        return Modal::find($id);
    }

    /**
     * Find modal by ID or fail.
     *
     * @param int|string $id
     * @return Modal
     * @throws ModelNotFoundException
     */
    public function findByIdOrFail(int|string $id): Modal
    {
        return Modal::findOrFail($id);
    }

    /**
     * Create a new modal.
     *
     * @param array $data
     * @return Modal
     */
    public function create(array $data): Modal
    {
        return Modal::create($data);
    }

    /**
     * Update an existing modal.
     *
     * @param int|string $id
     * @param array $data
     * @return Modal
     */
    public function update(int|string $id, array $data): Modal
    {
        $modal = $this->findByIdOrFail($id);
        $modal->update($data);

        return $modal->fresh();
    }

    /**
     * Delete a modal.
     *
     * @param int|string $id
     * @return bool
     */
    public function delete(int|string $id): bool
    {
        $modal = $this->findByIdOrFail($id);

        return $modal->delete();
    }
}
