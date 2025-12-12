<?php

namespace App\Repositories\Admin;

use App\Models\Admin;
use Illuminate\Contracts\Pagination\LengthAwarePaginator;
use Illuminate\Database\Eloquent\Collection;
use Illuminate\Database\Eloquent\ModelNotFoundException;
use Spatie\QueryBuilder\AllowedFilter;
use Spatie\QueryBuilder\QueryBuilder;

/**
 * Repository implementation for Admin model
 */
class AdminRepository implements AdminRepositoryInterface
{
    /**
     * Get all admins with pagination using QueryBuilder.
     *
     * @param array $filters
     * @param int $perPage
     * @return LengthAwarePaginator
     */
    public function getAll(array $filters = [], int $perPage = 15): LengthAwarePaginator
    {
        return QueryBuilder::for(Admin::class)
            ->allowedFilters([
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
            ])
            ->allowedSorts([
                'id',
                'first_name',
                'last_name',
                'email',
                'is_block',
                'last_login',
                'created_at',
                'updated_at',
            ])
            ->defaultSort('-created_at')
            ->paginate($perPage);
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

    /**
     * Search admins by query.
     *
     * @param string $query
     * @param array $filters
     * @param int $perPage
     * @return LengthAwarePaginator
     */
    public function search(string $query, array $filters = [], int $perPage = 15): LengthAwarePaginator
    {
        return QueryBuilder::for(Admin::class)
            ->allowedFilters([
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
            ])
            ->allowedSorts([
                'id',
                'first_name',
                'last_name',
                'email',
                'is_block',
                'last_login',
                'created_at',
                'updated_at',
            ])
            ->defaultSort('-created_at')
            ->paginate($perPage);
    }
}

