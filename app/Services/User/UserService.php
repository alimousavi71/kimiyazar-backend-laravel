<?php

namespace App\Services\User;

use App\Models\User;
use App\Repositories\User\UserRepositoryInterface;
use Illuminate\Contracts\Pagination\LengthAwarePaginator;
use Illuminate\Database\Eloquent\ModelNotFoundException;
use Illuminate\Support\Facades\Hash;
use Spatie\QueryBuilder\AllowedFilter;

class UserService
{
    public function __construct(
        private readonly UserRepositoryInterface $repository
    ) {
    }

    public function search(int $perPage = 15): LengthAwarePaginator
    {
        $allowedFilters = [
            AllowedFilter::partial('first_name'),
            AllowedFilter::partial('last_name'),
            AllowedFilter::partial('email'),
            AllowedFilter::partial('phone_number'),
            AllowedFilter::exact('is_active'),
            AllowedFilter::callback('search', function ($query, $value) {
                $query->where(function ($q) use ($value) {
                    $q->where('first_name', 'like', "%{$value}%")
                        ->orWhere('last_name', 'like', "%{$value}%")
                        ->orWhere('email', 'like', "%{$value}%")
                        ->orWhere('phone_number', 'like', "%{$value}%");
                });
            }),
        ];

        $allowedSorts = [
            'id',
            'first_name',
            'last_name',
            'email',
            'phone_number',
            'is_active',
            'last_login',
            'created_at',
            'updated_at',
        ];

        $defaultSort = '-created_at';

        return $this->repository->search($allowedFilters, $allowedSorts, $defaultSort, $perPage);
    }

    public function findById(int|string $id): User
    {
        return $this->repository->findByIdOrFail($id);
    }

    public function create(array $data): User
    {
        // Hash password if provided
        if (isset($data['password'])) {
            $data['password'] = Hash::make($data['password']);
        }

        if (isset($data['is_active']) && is_bool($data['is_active'])) {
            $data['is_active'] = $data['is_active'] ? 1 : 0;
        }

        return $this->repository->create($data);
    }

    public function update(int|string $id, array $data): User
    {
        // Don't update password through this method
        unset($data['password']);

        if (isset($data['is_active']) && is_bool($data['is_active'])) {
            $data['is_active'] = $data['is_active'] ? 1 : 0;
        }

        return $this->repository->update($id, $data);
    }

    public function changePassword(int|string $id, string $newPassword): User
    {
        $user = $this->repository->findByIdOrFail($id);
        $user->update(['password' => Hash::make($newPassword)]);

        return $user->fresh();
    }

    public function delete(int|string $id): bool
    {
        return $this->repository->delete($id);
    }

    public function findByEmail(string $email): ?User
    {
        return $this->repository->findByEmail($email);
    }

    public function findByPhoneNumber(string $phoneNumber): ?User
    {
        return $this->repository->findByPhoneNumber($phoneNumber);
    }

    public function toggleStatus(int|string $id): User
    {
        $user = $this->repository->findByIdOrFail($id);
        $user->update(['is_active' => !$user->is_active]);

        return $user->fresh();
    }

    /**
     * Authenticate user by email or phone number.
     *
     * @param string $emailOrPhone
     * @param string $password
     * @return User|null
     */
    public function authenticateByEmailOrPhone(string $emailOrPhone, string $password): ?User
    {
        $user = User::findByEmailOrPhone($emailOrPhone);

        if (!$user || !Hash::check($password, $user->password)) {
            return null;
        }

        return $user;
    }
}
