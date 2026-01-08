<?php

namespace App\Repositories\Otp;

use App\Models\Otp;
use App\Models\User;
use Illuminate\Contracts\Pagination\LengthAwarePaginator;
use Spatie\QueryBuilder\QueryBuilder;

class OtpRepository implements OtpRepositoryInterface
{
    public function search(
        array $allowedFilters = [],
        array $allowedSorts = [],
        ?string $defaultSort = null,
        int $perPage = 15
    ): LengthAwarePaginator {
        $query = QueryBuilder::for(Otp::class);

        if (!empty($allowedFilters)) {
            $query->allowedFilters($allowedFilters);
        }

        if (!empty($allowedSorts)) {
            $query->allowedSorts($allowedSorts);
        }

        if ($defaultSort !== null) {
            $query->defaultSort($defaultSort);
        }

        return $query->paginate($perPage)->withQueryString();
    }

    public function findById(int|string $id): ?Otp
    {
        return Otp::find($id);
    }

    public function findByIdOrFail(int|string $id): Otp
    {
        return Otp::findOrFail($id);
    }

    public function create(array $data): Otp
    {
        return Otp::create($data);
    }

    public function update(int|string $id, array $data): Otp
    {
        $otp = $this->findByIdOrFail($id);
        $otp->update($data);

        return $otp->fresh();
    }

    public function delete(int|string $id): bool
    {
        $otp = $this->findByIdOrFail($id);

        return $otp->delete();
    }

    public function findByCode(string $code): ?Otp
    {
        return Otp::where('code', $code)->first();
    }

    public function findActiveByUserAndType(int|User $user, string $type): ?Otp
    {
        $userId = $user instanceof User ? $user->id : $user;

        return Otp::where('user_id', $userId)
            ->where('type', $type)
            ->active()
            ->first();
    }

    public function markAsUsed(int|string $id): bool
    {
        $otp = $this->findByIdOrFail($id);
        $otp->markAsUsed();

        return true;
    }

    public function deleteExpired(): int
    {
        return Otp::where('expired_at', '<', now())->delete();
    }
}
