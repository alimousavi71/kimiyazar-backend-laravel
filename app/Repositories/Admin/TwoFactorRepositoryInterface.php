<?php

namespace App\Repositories\Admin;

use App\Models\Admin;

/**
 * Interface for TwoFactor Repository
 */
interface TwoFactorRepositoryInterface
{
    /**
     * Enable two-factor authentication for an admin.
     *
     * @param int|string $adminId
     * @param string $secret
     * @param array $recoveryCodes
     * @return Admin
     */
    public function enable(int|string $adminId, string $secret, array $recoveryCodes): Admin;

    /**
     * Disable two-factor authentication for an admin.
     *
     * @param int|string $adminId
     * @return Admin
     */
    public function disable(int|string $adminId): Admin;

    /**
     * Update recovery codes for an admin.
     *
     * @param int|string $adminId
     * @param array $recoveryCodes
     * @return Admin
     */
    public function updateRecoveryCodes(int|string $adminId, array $recoveryCodes): Admin;
}

