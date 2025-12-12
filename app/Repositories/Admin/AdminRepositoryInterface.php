<?php

namespace App\Repositories\Admin;

use App\Models\Admin;
use Illuminate\Contracts\Pagination\LengthAwarePaginator;
use Illuminate\Database\Eloquent\Collection;
use Illuminate\Database\Eloquent\ModelNotFoundException;

/**
 * Interface for Admin Repository
 */
interface AdminRepositoryInterface
{
    /**
     * Get all admins with pagination.
     *
     * @param array $filters
     * @param int $perPage
     * @return LengthAwarePaginator
     */
    public function getAll(array $filters = [], int $perPage = 15): LengthAwarePaginator;

    /**
     * Find admin by ID.
     *
     * @param int|string $id
     * @return Admin|null
     */
    public function findById(int|string $id): ?Admin;

    /**
     * Find admin by ID or fail.
     *
     * @param int|string $id
     * @return Admin
     * @throws ModelNotFoundException
     */
    public function findByIdOrFail(int|string $id): Admin;

    /**
     * Find admin by email.
     *
     * @param string $email
     * @return Admin|null
     */
    public function findByEmail(string $email): ?Admin;

    /**
     * Create a new admin.
     *
     * @param array $data
     * @return Admin
     */
    public function create(array $data): Admin;

    /**
     * Update an existing admin.
     *
     * @param int|string $id
     * @param array $data
     * @return Admin
     */
    public function update(int|string $id, array $data): Admin;

    /**
     * Delete an admin.
     *
     * @param int|string $id
     * @return bool
     */
    public function delete(int|string $id): bool;

    /**
     * Search admins by query.
     *
     * @param string $query
     * @param array $filters
     * @param int $perPage
     * @return LengthAwarePaginator
     */
    public function search(string $query, array $filters = [], int $perPage = 15): LengthAwarePaginator;
}

