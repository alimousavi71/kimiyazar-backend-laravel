<?php

namespace App\Services\Admin;

use App\Models\Admin;
use App\Repositories\Admin\AdminRepositoryInterface;
use Illuminate\Contracts\Pagination\LengthAwarePaginator;
use Illuminate\Database\Eloquent\ModelNotFoundException;
use Illuminate\Support\Facades\Hash;

/**
 * Service class for Admin business logic
 */
class AdminService
{
    /**
     * @param AdminRepositoryInterface $repository
     */
    public function __construct(
        private readonly AdminRepositoryInterface $repository
    ) {
    }

    /**
     * Get all admins with optional filters using QueryBuilder.
     *
     * @param array $filters
     * @param int $perPage
     * @return LengthAwarePaginator
     */
    public function getAll(array $filters = [], int $perPage = 15): LengthAwarePaginator
    {
        return $this->repository->getAll($filters, $perPage);
    }

    /**
     * Find admin by ID.
     *
     * @param int|string $id
     * @return Admin
     * @throws ModelNotFoundException
     */
    public function findById(int|string $id): Admin
    {
        return $this->repository->findByIdOrFail($id);
    }

    /**
     * Create a new admin.
     *
     * @param array $data
     * @return Admin
     */
    public function create(array $data): Admin
    {
        // Hash password
        if (isset($data['password'])) {
            $data['password'] = Hash::make($data['password']);
        }

        return $this->repository->create($data);
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
        // Hash password if provided
        if (isset($data['password']) && !empty($data['password'])) {
            $data['password'] = Hash::make($data['password']);
        } else {
            unset($data['password']);
        }

        return $this->repository->update($id, $data);
    }

    /**
     * Delete an admin.
     *
     * @param int|string $id
     * @return bool
     */
    public function delete(int|string $id): bool
    {
        $admin = $this->repository->findByIdOrFail($id);

        // Append random string to email for safe unique constraint
        $randomString = '_deleted_' . bin2hex(random_bytes(8));
        $newEmail = $admin->email . $randomString;

        // Update email before soft delete using repository
        $this->repository->update($id, ['email' => $newEmail]);

        return $this->repository->delete($id);
    }
}

