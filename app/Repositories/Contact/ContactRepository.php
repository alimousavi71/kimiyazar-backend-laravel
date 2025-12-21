<?php

namespace App\Repositories\Contact;

use App\Models\Contact;
use Illuminate\Contracts\Pagination\LengthAwarePaginator;
use Illuminate\Database\Eloquent\ModelNotFoundException;
use Spatie\QueryBuilder\QueryBuilder;

/**
 * Repository implementation for Contact model
 */
class ContactRepository implements ContactRepositoryInterface
{
    /**
     * Get all contacts with pagination using QueryBuilder.
     *
     * @param array $allowedFilters Allowed filters configuration (Spatie\QueryBuilder\AllowedFilter instances or field names)
     * @param array $allowedSorts   Allowed sorts configuration (field names)
     * @param string|null $defaultSort Default sort (e.g. 'created_at' or '-created_at'), can be null to skip default sort
     * @param int $perPage
     * @return LengthAwarePaginator
     */
    public function search(
        array $allowedFilters = [],
        array $allowedSorts = [],
        ?string $defaultSort = null,
        int $perPage = 15
    ): LengthAwarePaginator {
        $query = QueryBuilder::for(Contact::class);

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
     * Find contact by ID.
     *
     * @param int|string $id
     * @return Contact|null
     */
    public function findById(int|string $id): ?Contact
    {
        return Contact::find($id);
    }

    /**
     * Find contact by ID or fail.
     *
     * @param int|string $id
     * @return Contact
     * @throws ModelNotFoundException
     */
    public function findByIdOrFail(int|string $id): Contact
    {
        return Contact::findOrFail($id);
    }

    /**
     * Create a new contact.
     *
     * @param array $data
     * @return Contact
     */
    public function create(array $data): Contact
    {
        return Contact::create($data);
    }
}

