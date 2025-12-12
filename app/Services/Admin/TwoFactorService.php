<?php

namespace App\Services\Admin;

use App\Models\Admin;
use App\Repositories\Admin\AdminRepositoryInterface;
use App\Repositories\Admin\TwoFactorRepositoryInterface;
use Illuminate\Database\Eloquent\ModelNotFoundException;
use Illuminate\Support\Collection;
use PragmaRX\Google2FA\Google2FA;
use SimpleSoftwareIO\QrCode\Facades\QrCode;

/**
 * Service class for TwoFactor business logic
 */
class TwoFactorService
{
    /**
     * @param TwoFactorRepositoryInterface $twoFactorRepository
     * @param AdminRepositoryInterface $adminRepository
     */
    public function __construct(
        private readonly TwoFactorRepositoryInterface $twoFactorRepository,
        private readonly AdminRepositoryInterface $adminRepository
    ) {
    }

    /**
     * Generate a new secret key for two-factor authentication.
     *
     * @return string
     */
    public function generateSecret(): string
    {
        $google2fa = new Google2FA();
        return $google2fa->generateSecretKey();
    }

    /**
     * Generate QR code data URL for the secret.
     *
     * @param Admin $admin
     * @param string $secret
     * @return string
     */
    public function generateQrCode(Admin $admin, string $secret): string
    {
        $google2fa = new Google2FA();

        $companyName = config('app.name', 'Admin Panel');
        $companyEmail = $admin->email;

        $qrCodeUrl = $google2fa->getQRCodeUrl(
            $companyName,
            $companyEmail,
            $secret
        );

        return QrCode::format('svg')
            ->size(200)
            ->generate($qrCodeUrl);
    }

    /**
     * Generate recovery codes.
     *
     * @param int $count
     * @return Collection
     */
    public function generateRecoveryCodes(int $count = 8): Collection
    {
        return collect(range(1, $count))->map(function () {
            return strtoupper(bin2hex(random_bytes(4)));
        });
    }

    /**
     * Enable two-factor authentication for an admin.
     *
     * @param int|string $adminId
     * @param string $secret
     * @return array Returns ['admin', 'qrCode', 'recoveryCodes']
     * @throws ModelNotFoundException
     */
    public function enable(int|string $adminId, string $secret): array
    {
        $admin = $this->adminRepository->findByIdOrFail($adminId);

        $recoveryCodes = $this->generateRecoveryCodes();

        $this->twoFactorRepository->enable(
            $adminId,
            $secret,
            $recoveryCodes->toArray()
        );

        $admin = $admin->fresh();
        $qrCode = $this->generateQrCode($admin, $secret);

        return [
            'admin' => $admin,
            'qrCode' => $qrCode,
            'recoveryCodes' => $recoveryCodes,
        ];
    }

    /**
     * Disable two-factor authentication for an admin.
     *
     * @param int|string $adminId
     * @return Admin
     * @throws ModelNotFoundException
     */
    public function disable(int|string $adminId): Admin
    {
        return $this->twoFactorRepository->disable($adminId);
    }

    /**
     * Regenerate recovery codes for an admin.
     *
     * @param int|string $adminId
     * @return Collection
     * @throws ModelNotFoundException
     */
    public function regenerateRecoveryCodes(int|string $adminId): Collection
    {
        $recoveryCodes = $this->generateRecoveryCodes();

        $this->twoFactorRepository->updateRecoveryCodes(
            $adminId,
            $recoveryCodes->toArray()
        );

        return $recoveryCodes;
    }

    /**
     * Verify a TOTP code.
     *
     * @param Admin $admin
     * @param string $code
     * @return bool
     */
    public function verifyCode(Admin $admin, string $code): bool
    {
        if (!$admin->two_factor_enabled || !$admin->two_factor_secret) {
            return false;
        }

        $google2fa = new Google2FA();
        $secret = $admin->two_factor_secret; // Already decrypted by model cast

        // In development environment, allow "123456" as a valid code
        $isDevEnvironment = app()->environment('local', 'development', 'dev');
        $devCode = '123456';

        if ($isDevEnvironment && $code === $devCode) {
            return true;
        }

        // Verify the code with a window of 1 (allows previous/next 30 seconds)
        return $google2fa->verifyKey($secret, $code, 1);
    }

    /**
     * Verify a recovery code.
     *
     * @param Admin $admin
     * @param string $recoveryCode
     * @return bool
     */
    public function verifyRecoveryCode(Admin $admin, string $recoveryCode): bool
    {
        if (!$admin->two_factor_enabled || !$admin->two_factor_recovery_codes) {
            return false;
        }

        $recoveryCodes = $admin->two_factor_recovery_codes; // Already decrypted by model cast

        if (!is_array($recoveryCodes)) {
            return false;
        }

        $index = array_search(strtoupper($recoveryCode), array_map('strtoupper', $recoveryCodes));

        if ($index === false) {
            return false;
        }

        // Remove used recovery code
        unset($recoveryCodes[$index]);
        $recoveryCodes = array_values($recoveryCodes); // Re-index array

        $this->twoFactorRepository->updateRecoveryCodes($admin->id, $recoveryCodes);

        return true;
    }

    /**
     * Check if admin has two-factor authentication enabled.
     *
     * @param Admin $admin
     * @return bool
     */
    public function isEnabled(Admin $admin): bool
    {
        return $admin->two_factor_enabled === true && !empty($admin->two_factor_secret);
    }
}

