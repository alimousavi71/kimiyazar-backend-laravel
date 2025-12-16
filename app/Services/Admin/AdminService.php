<?php

namespace App\Services\Admin;

use App\Models\Admin;
use App\Repositories\Admin\AdminRepositoryInterface;
use Illuminate\Contracts\Pagination\LengthAwarePaginator;
use Illuminate\Database\Eloquent\ModelNotFoundException;
use Illuminate\Support\Facades\Hash;
use Spatie\QueryBuilder\AllowedFilter;

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
     * @param int $perPage
     * @return LengthAwarePaginator
     */
    public function search(int $perPage = 15): LengthAwarePaginator
    {
        $allowedFilters = [
            AllowedFilter::partial('first_name'),
            AllowedFilter::partial('last_name'),
            AllowedFilter::partial('email'),
            AllowedFilter::exact('is_block'),
            AllowedFilter::callback('search', function ($query, $value) {
                $query->where(function ($q) use ($value) {
                    $q->where('first_name', 'like', "%{$value}%")
                        ->orWhere('last_name', 'like', "%{$value}%")
                        ->orWhere('email', 'like', "%{$value}%");
                });
            }),
        ];

        $allowedSorts = [
            'id',
            'first_name',
            'last_name',
            'email',
            'is_block',
            'last_login',
            'created_at',
            'updated_at',
        ];

        $defaultSort = '-created_at';

        return $this->repository->search($allowedFilters, $allowedSorts, $defaultSort, $perPage);
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
        // The AppendsRandomStringOnSoftDelete trait will automatically
        // modify unique fields before soft deletion
        return $this->repository->delete($id);
    }
}

