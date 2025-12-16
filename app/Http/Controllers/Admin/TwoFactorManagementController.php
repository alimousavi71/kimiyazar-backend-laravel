<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Http\Requests\Admin\Auth\TwoFactorVerifyRequest;
use App\Services\Admin\TwoFactorService;
use Illuminate\Http\RedirectResponse;
use Illuminate\Support\Facades\Auth;
use Illuminate\View\View;
use PragmaRX\Google2FA\Google2FA;

class TwoFactorManagementController extends Controller
{
    /**
     * @param TwoFactorService $twoFactorService
     */
    public function __construct(
        private readonly TwoFactorService $twoFactorService
    ) {
    }

    /**
     * Show the form to enable two-factor authentication.
     *
     * @return View
     */
    public function showEnableForm(): View|RedirectResponse
    {
        /** @var \App\Models\Admin $admin */
        $admin = Auth::guard('admin')->user();

        if ($this->twoFactorService->isEnabled($admin)) {
            return redirect()->route('admin.two-factor.status')
                ->with('info', __('admin/auth.messages.two_factor_already_enabled'));
        }

        // Generate secret and QR code
        $secret = $this->twoFactorService->generateSecret();
        $qrCode = $this->twoFactorService->generateQrCode($admin, $secret);

        // Store secret temporarily in session for verification
        session(['two_factor_setup_secret' => $secret]);

        return view('admin.two-factor.enable', compact('secret', 'qrCode'));
    }

    /**
     * Enable two-factor authentication after verification.
     *
     * @param TwoFactorVerifyRequest $request
     * @return RedirectResponse
     */
    public function enable(TwoFactorVerifyRequest $request): RedirectResponse
    {
        /** @var \App\Models\Admin $admin */
        $admin = Auth::guard('admin')->user();
        $secret = session('two_factor_setup_secret');

        if (!$secret) {
            return redirect()->route('admin.two-factor.enable')
                ->withErrors(['code' => __('admin/auth.messages.two_factor_setup_expired')]);
        }

        $code = $request->input('code');

        // Verify the code with the temporary secret
        $google2fa = new Google2FA();
        $isValid = $google2fa->verifyKey($secret, $code, 1);

        // In development, also accept "123456"
        $isDevEnvironment = app()->environment('local', 'development', 'dev');
        if ($isDevEnvironment && $code === '123456') {
            $isValid = true;
        }

        if (!$isValid) {
            return back()->withErrors([
                'code' => __('admin/auth.messages.two_factor_invalid_code'),
            ])->withInput($request->only('code'));
        }

        // Enable 2FA
        $result = $this->twoFactorService->enable($admin->id, $secret);

        // Clear temporary secret
        session()->forget('two_factor_setup_secret');

        return redirect()->route('admin.two-factor.status')
            ->with('success', __('admin/auth.messages.two_factor_enabled'))
            ->with('recoveryCodes', $result['recoveryCodes']);
    }

    /**
     * Show two-factor authentication status and recovery codes.
     *
     * @return View
     */
    public function status(): View
    {
        /** @var \App\Models\Admin $admin */
        $admin = Auth::guard('admin')->user();
        $isEnabled = $this->twoFactorService->isEnabled($admin);
        $recoveryCodes = session('recoveryCodes');

        return view('admin.two-factor.status', compact('isEnabled', 'recoveryCodes'));
    }

    /**
     * Disable two-factor authentication.
     *
     * @return RedirectResponse
     */
    public function disable(): RedirectResponse
    {
        /** @var \App\Models\Admin $admin */
        $admin = Auth::guard('admin')->user();

        $this->twoFactorService->disable($admin->id);

        return redirect()->route('admin.two-factor.status')
            ->with('success', __('admin/auth.messages.two_factor_disabled'));
    }

    /**
     * Regenerate recovery codes.
     *
     * @return RedirectResponse
     */
    public function regenerateRecoveryCodes(): RedirectResponse
    {
        /** @var \App\Models\Admin $admin */
        $admin = Auth::guard('admin')->user();

        if (!$this->twoFactorService->isEnabled($admin)) {
            return redirect()->route('admin.two-factor.status')
                ->withErrors(['error' => __('admin/auth.messages.two_factor_not_enabled')]);
        }

        $recoveryCodes = $this->twoFactorService->regenerateRecoveryCodes($admin->id);

        return redirect()->route('admin.two-factor.status')
            ->with('success', __('admin/auth.messages.two_factor_recovery_codes_regenerated'))
            ->with('recoveryCodes', $recoveryCodes);
    }
}
