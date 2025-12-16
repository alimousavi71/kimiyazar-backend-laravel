<?php

namespace App\Repositories\Otp;

use App\Models\Otp;
use App\Models\User;
use Illuminate\Contracts\Pagination\LengthAwarePaginator;

interface OtpRepositoryInterface
{
    public function search(
        array $allowedFilters = [],
        array $allowedSorts = [],
        ?string $defaultSort = null,
        int $perPage = 15
    ): LengthAwarePaginator;

    public function findById(int|string $id): ?Otp;

    public function findByIdOrFail(int|string $id): Otp;

    public function create(array $data): Otp;

    public function update(int|string $id, array $data): Otp;

    public function delete(int|string $id): bool;

    public function findByCode(string $code): ?Otp;

    public function findActiveByUserAndType(int|User $user, string $type): ?Otp;

    public function markAsUsed(int|string $id): bool;

    public function deleteExpired(): int;
}
