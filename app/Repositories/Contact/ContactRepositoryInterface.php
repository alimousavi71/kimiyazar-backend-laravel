<?php

namespace App\Repositories\Contact;

use App\Models\Contact;
use Illuminate\Contracts\Pagination\LengthAwarePaginator;
use Illuminate\Database\Eloquent\ModelNotFoundException;

/**
 * Interface for Contact Repository
 */
interface ContactRepositoryInterface
{
    /**
     * Get all contacts with pagination.
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
     * Find contact by ID.
     *
     * @param int|string $id
     * @return Contact|null
     */
    public function findById(int|string $id): ?Contact;

    /**
     * Find contact by ID or fail.
     *
     * @param int|string $id
     * @return Contact
     * @throws ModelNotFoundException
     */
    public function findByIdOrFail(int|string $id): Contact;

    /**
     * Create a new contact.
     *
     * @param array $data
     * @return Contact
     */
    public function create(array $data): Contact;
}

