<?php

namespace App\Services\Otp;

use App\Models\Otp;
use App\Models\User;
use App\Repositories\Otp\OtpRepositoryInterface;
use Illuminate\Contracts\Pagination\LengthAwarePaginator;
use Spatie\QueryBuilder\AllowedFilter;

class OtpService
{
    public function __construct(
        private readonly OtpRepositoryInterface $repository
    ) {
    }

    public function search(int $perPage = 15): LengthAwarePaginator
    {
        $allowedFilters = [
            AllowedFilter::exact('type'),
            AllowedFilter::exact('user_id'),
            AllowedFilter::exact('is_used'),
        ];

        $allowedSorts = [
            'id',
            'user_id',
            'code',
            'type',
            'attempts',
            'max_attempts',
            'expired_at',
            'used_at',
            'is_used',
            'created_at',
            'updated_at',
        ];

        $defaultSort = '-created_at';

        return $this->repository->search($allowedFilters, $allowedSorts, $defaultSort, $perPage);
    }

    public function findById(int|string $id): Otp
    {
        return $this->repository->findByIdOrFail($id);
    }

    public function create(int|User $user, string $type = 'sms', int $expirationMinutes = 10): Otp
    {
        $userId = $user instanceof User ? $user->id : $user;

        $data = [
            'user_id' => $userId,
            'code' => $this->generateOtpCode(),
            'type' => $type,
            'attempts' => 0,
            'max_attempts' => 5,
            'expired_at' => now()->addMinutes($expirationMinutes),
            'is_used' => false,
        ];

        return $this->repository->create($data);
    }

    public function generateOtpCode(int $length = 6): string
    {
        $code = '';
        for ($i = 0; $i < $length; $i++) {
            $code .= random_int(0, 9);
        }

        return $code;
    }

    public function verifyOtp(string $code, bool $markAsUsed = true): array
    {
        $otp = $this->repository->findByCode($code);

        if (!$otp) {
            return [
                'success' => false,
                'message' => __('otp.messages.not_found'),
                'otp' => null,
            ];
        }

        // Check if already used
        if ($otp->is_used) {
            return [
                'success' => false,
                'message' => __('otp.messages.already_used'),
                'otp' => $otp,
            ];
        }

        // Check if expired
        if ($otp->isExpired()) {
            return [
                'success' => false,
                'message' => __('otp.messages.expired'),
                'otp' => $otp,
            ];
        }

        // Check if max attempts reached
        if ($otp->hasReachedMaxAttempts()) {
            return [
                'success' => false,
                'message' => __('otp.messages.max_attempts_reached'),
                'otp' => $otp,
            ];
        }

        // OTP is valid
        if ($markAsUsed) {
            $this->markAsUsed($otp->id);
        }

        return [
            'success' => true,
            'message' => __('otp.messages.verified_successfully'),
            'otp' => $otp,
        ];
    }

    public function incrementAttempts(int|string $id): Otp
    {
        $otp = $this->repository->findByIdOrFail($id);
        $otp->incrementAttempts();

        return $otp->fresh();
    }

    public function markAsUsed(int|string $id): bool
    {
        return $this->repository->markAsUsed($id);
    }

    public function delete(int|string $id): bool
    {
        return $this->repository->delete($id);
    }

    public function cleanupExpired(): int
    {
        return $this->repository->deleteExpired();
    }

    public function getActiveOtpForUser(int|User $user, string $type = 'sms'): ?Otp
    {
        return $this->repository->findActiveByUserAndType($user, $type);
    }

    public function resendOtp(int|string $id, int $expirationMinutes = 10): Otp
    {
        $otp = $this->repository->findByIdOrFail($id);

        // Generate new code and reset attempts
        $otp->update([
            'code' => $this->generateOtpCode(),
            'attempts' => 0,
            'expired_at' => now()->addMinutes($expirationMinutes),
        ]);

        return $otp->fresh();
    }
}
