<?php

namespace App\Http\Controllers\Admin\Auth;

use App\Http\Controllers\Controller;
use App\Http\Requests\Admin\Auth\TwoFactorVerifyRequest;
use App\Models\Admin;
use App\Repositories\Admin\AdminRepositoryInterface;
use App\Services\Admin\TwoFactorService;
use Illuminate\Http\RedirectResponse;
use Illuminate\Support\Facades\Auth;
use Illuminate\View\View;

class TwoFactorController extends Controller
{
    private const SESSION_EXPIRATION_TIME = 600; // 10 minutes in seconds

    public function __construct(
        private readonly TwoFactorService $twoFactorService,
        private readonly AdminRepositoryInterface $adminRepository
    ) {
    }

    /**
     * Show the two-factor authentication challenge form.
     */
    public function showChallenge(): View|RedirectResponse
    {
        $admin = $this->validatePendingLogin();

        if (!$admin) {
            return $this->redirectToLoginWithError('two_factor_session_expired');
        }

        $this->ensureNotAuthenticated();

        return view('auth.two-factor-challenge');
    }

    /**
     * Verify the two-factor authentication code.
     */
    public function verify(TwoFactorVerifyRequest $request): RedirectResponse
    {
        $admin = $this->validatePendingLogin();

        if (!$admin) {
            return $this->redirectToLoginWithError('two_factor_session_expired');
        }

        $this->ensureNotAuthenticated();

        if (!$this->verifyTwoFactorCode($request, $admin)) {
            return back()->withErrors([
                'code' => __('admin/auth.messages.two_factor_invalid_code'),
            ])->withInput($request->only('code'));
        }

        return $this->completeLogin($request, $admin);
    }

    /**
     * Validate pending login session and return admin if valid.
     */
    private function validatePendingLogin(): ?Admin
    {
        $adminId = session('admin_login_id');
        $loginTimestamp = session('admin_login_timestamp');

        if (!$adminId || !$loginTimestamp) {
            $this->clearPendingLogin();
            return null;
        }

        if ($this->isSessionExpired($loginTimestamp)) {
            $this->clearPendingLogin();
            return null;
        }

        $admin = $this->adminRepository->findById($adminId);

        if (!$admin) {
            $this->clearPendingLogin();
            return null;
        }

        if (!$this->twoFactorService->isEnabled($admin)) {
            $this->clearPendingLogin();
            return null;
        }

        return $admin;
    }

    /**
     * Check if session has expired.
     */
    private function isSessionExpired(int $loginTimestamp): bool
    {
        return (now()->timestamp - $loginTimestamp) > self::SESSION_EXPIRATION_TIME;
    }

    /**
     * Verify 2FA code or recovery code.
     */
    private function verifyTwoFactorCode(TwoFactorVerifyRequest $request, Admin $admin): bool
    {
        $code = $request->input('code');
        $recoveryCode = $request->input('recovery_code');

        if ($recoveryCode) {
            return $this->twoFactorService->verifyRecoveryCode($admin, $recoveryCode);
        }

        return $this->twoFactorService->verifyCode($admin, $code);
    }

    /**
     * Complete the login process after successful 2FA verification.
     */
    private function completeLogin(TwoFactorVerifyRequest $request, Admin $admin): RedirectResponse
    {
        $remember = session('admin_remember', false);

        $this->clearPendingLogin();

        Auth::guard('admin')->login($admin, $remember);
        $admin->updateLastLogin();
        $request->session()->regenerate();

        return redirect()->intended(route('admin.dashboard'))
            ->with('success', __('admin/auth.messages.two_factor_verified'));
    }

    /**
     * Ensure user is not authenticated before 2FA verification.
     */
    private function ensureNotAuthenticated(): void
    {
        if (Auth::guard('admin')->check()) {
            Auth::guard('admin')->logout();
        }
    }

    /**
     * Redirect to login with error message.
     */
    private function redirectToLoginWithError(string $errorKey): RedirectResponse
    {
        return redirect()->route('admin.login')
            ->withErrors(['code' => __('admin/auth.messages.' . $errorKey)]);
    }

    /**
     * Clear pending login session data.
     */
    private function clearPendingLogin(): void
    {
        session()->forget('admin_login_id');
        session()->forget('admin_remember');
        session()->forget('admin_login_timestamp');
    }
}
