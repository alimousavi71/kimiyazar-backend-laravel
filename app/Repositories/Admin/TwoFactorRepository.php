<?php

namespace App\Repositories\Admin;

use App\Models\Admin;
use Illuminate\Database\Eloquent\ModelNotFoundException;

/**
 * Repository implementation for TwoFactor operations
 */
class TwoFactorRepository implements TwoFactorRepositoryInterface
{
    /**
     * Enable two-factor authentication for an admin.
     *
     * @param int|string $adminId
     * @param string $secret
     * @param array $recoveryCodes
     * @return Admin
     * @throws ModelNotFoundException
     */
    public function enable(int|string $adminId, string $secret, array $recoveryCodes): Admin
    {
        $admin = Admin::findOrFail($adminId);

        $admin->update([
            'two_factor_secret' => $secret, // Will be encrypted by model cast
            'two_factor_enabled' => true,
            'two_factor_recovery_codes' => $recoveryCodes, // Will be encrypted by model cast
        ]);

        return $admin->fresh();
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
        $admin = Admin::findOrFail($adminId);

        $admin->update([
            'two_factor_secret' => null,
            'two_factor_enabled' => false,
            'two_factor_recovery_codes' => null,
        ]);

        return $admin->fresh();
    }

    /**
     * Update recovery codes for an admin.
     *
     * @param int|string $adminId
     * @param array $recoveryCodes
     * @return Admin
     * @throws ModelNotFoundException
     */
    public function updateRecoveryCodes(int|string $adminId, array $recoveryCodes): Admin
    {
        $admin = Admin::findOrFail($adminId);

        $admin->update([
            'two_factor_recovery_codes' => $recoveryCodes, // Will be encrypted by model cast
        ]);

        return $admin->fresh();
    }
}

