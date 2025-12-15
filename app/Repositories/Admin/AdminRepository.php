<?php

namespace App\Repositories\Admin;

use App\Models\Admin;
use Illuminate\Contracts\Pagination\LengthAwarePaginator;
use Illuminate\Database\Eloquent\ModelNotFoundException;
use Spatie\QueryBuilder\QueryBuilder;

/**
 * Repository implementation for Admin model
 */
class AdminRepository implements AdminRepositoryInterface
{
    /**
     * Get all admins with pagination using QueryBuilder.
     *
     * @param array $allowedFilters Allowed filters configuration (Spatie\QueryBuilder\AllowedFilter instances or field names)
     * @param array $allowedSorts   Allowed sorts configuration (field names)
     * @param string|null $defaultSort Default sort (e.g. '-created_at'), can be null to skip default sort
     * @param int $perPage
     * @return LengthAwarePaginator
     */
    public function search(
        array $allowedFilters = [],
        array $allowedSorts = [],
        ?string $defaultSort = null,
        int $perPage = 15
    ): LengthAwarePaginator {
        $query = QueryBuilder::for(Admin::class);

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
     * Find admin by ID.
     *
     * @param int|string $id
     * @return Admin|null
     */
    public function findById(int|string $id): ?Admin
    {
        return Admin::find($id);
    }

    /**
     * Find admin by ID or fail.
     *
     * @param int|string $id
     * @return Admin
     * @throws ModelNotFoundException
     */
    public function findByIdOrFail(int|string $id): Admin
    {
        return Admin::findOrFail($id);
    }

    /**
     * Find admin by email.
     *
     * @param string $email
     * @return Admin|null
     */
    public function findByEmail(string $email): ?Admin
    {
        return Admin::where('email', $email)->first();
    }

    /**
     * Create a new admin.
     *
     * @param array $data
     * @return Admin
     */
    public function create(array $data): Admin
    {
        return Admin::create($data);
    }

    /**
     * Update an existing admin.
     *
     * @param int|string $id
     * @param array $data
     * @return Admin
     */
    public function update(int|string $id, array $data): Admin
    {
        $admin = $this->findByIdOrFail($id);
        $admin->update($data);

        return $admin->fresh();
    }

    /**
     * Delete an admin.
     *
     * @param int|string $id
     * @return bool
     */
    public function delete(int|string $id): bool
    {
        $admin = $this->findByIdOrFail($id);

        return $admin->delete();
    }

}

