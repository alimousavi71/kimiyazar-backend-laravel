<?php

namespace App\Http\Controllers\Admin\Auth;

use App\Http\Controllers\Controller;
use App\Http\Requests\Admin\Auth\LoginRequest;
use App\Models\Admin;
use App\Repositories\Admin\AdminRepositoryInterface;
use App\Services\Admin\TwoFactorService;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\View\View;

class AdminAuthController extends Controller
{
    private const SESSION_EXPIRATION_TIME = 600; // 10 minutes in seconds

    public function __construct(
        private readonly AdminRepositoryInterface $adminRepository,
        private readonly TwoFactorService $twoFactorService
    ) {
        // Middleware is applied in routes
    }

    /**
     * Show the login form.
     */
    public function showLoginForm(): View
    {
        return view('admin.auth.login');
    }

    /**
     * Handle a login request.
     */
    public function login(LoginRequest $request): RedirectResponse
    {
        $admin = $this->findAndValidateAdmin($request);

        if (!$admin) {
            return $this->handleInvalidCredentials($request);
        }

        if ($this->isAdminBlocked($admin)) {
            return $this->handleBlockedAdmin($request);
        }

        if ($this->twoFactorService->isEnabled($admin)) {
            return $this->handleTwoFactorRequired($request, $admin);
        }

        return $this->handleDirectLogin($request, $admin);
    }

    /**
     * Log the user out.
     */
    public function logout(Request $request): RedirectResponse
    {
        Auth::guard('admin')->logout();
        $request->session()->invalidate();
        $request->session()->regenerateToken();

        return redirect()->route('admin.login');
    }

    /**
     * Find and validate admin credentials.
     */
    private function findAndValidateAdmin(LoginRequest $request): ?Admin
    {
        $email = $request->input('email');
        $password = $request->input('password');

        $admin = $this->adminRepository->findByEmail($email);

        if (!$admin || !Hash::check($password, $admin->password)) {
            return null;
        }

        return $admin;
    }

    /**
     * Check if admin is blocked.
     */
    private function isAdminBlocked(Admin $admin): bool
    {
        return $admin->is_block === true;
    }

    /**
     * Handle invalid credentials.
     */
    private function handleInvalidCredentials(LoginRequest $request): RedirectResponse
    {
        return back()->withErrors([
            'email' => __('admin/auth.messages.invalid_credentials'),
        ])->withInput($request->only('email'));
    }

    /**
     * Handle blocked admin.
     */
    private function handleBlockedAdmin(LoginRequest $request): RedirectResponse
    {
        return back()->withErrors([
            'email' => __('admin/auth.messages.account_blocked'),
        ])->withInput($request->only('email'));
    }

    /**
     * Handle 2FA required flow.
     */
    private function handleTwoFactorRequired(LoginRequest $request, Admin $admin): RedirectResponse
    {
        $this->storePendingLogin($request, $admin);

        return redirect()->route('admin.two-factor.login');
    }

    /**
     * Handle direct login (2FA not enabled).
     */
    private function handleDirectLogin(LoginRequest $request, Admin $admin): RedirectResponse
    {
        $remember = $request->boolean('remember');

        Auth::guard('admin')->login($admin, $remember);
        $admin->updateLastLogin();
        $request->session()->regenerate();

        return redirect()->intended(route('admin.dashboard'));
    }

    /**
     * Store pending login data in session for 2FA verification.
     */
    private function storePendingLogin(LoginRequest $request, Admin $admin): void
    {
        $request->session()->put('admin_login_id', $admin->id);
        $request->session()->put('admin_remember', $request->boolean('remember'));
        $request->session()->put('admin_login_timestamp', now()->timestamp);
    }
}
