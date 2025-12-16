<?php

namespace App\Repositories\User;

use App\Models\User;
use Illuminate\Contracts\Pagination\LengthAwarePaginator;
use Illuminate\Database\Eloquent\ModelNotFoundException;

interface UserRepositoryInterface
{
    public function search(
        array $allowedFilters = [],
        array $allowedSorts = [],
        ?string $defaultSort = null,
        int $perPage = 15
    ): LengthAwarePaginator;

    public function findById(int|string $id): ?User;

    public function findByIdOrFail(int|string $id): User;

    public function create(array $data): User;

    public function update(int|string $id, array $data): User;

    public function delete(int|string $id): bool;

    public function findByEmail(string $email): ?User;

    public function findByPhoneNumber(string $phoneNumber): ?User;

}
