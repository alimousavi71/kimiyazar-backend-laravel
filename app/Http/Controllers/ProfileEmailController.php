<?php

namespace App\Http\Controllers;

use App\Http\Requests\Profile\UpdateEmailRequest;
use App\Http\Requests\Profile\VerifyEmailOtpRequest;
use App\Models\Otp;
use App\Services\Otp\OtpNotificationService;
use App\Services\Otp\OtpService;
use App\Services\User\UserService;
use Illuminate\Http\RedirectResponse;
use Illuminate\View\View;

class ProfileEmailController extends Controller
{
    public function __construct(
        private readonly UserService $userService,
        private readonly OtpService $otpService,
        private readonly OtpNotificationService $notificationService,
    ) {
    }

    /**
     * Show the form for updating email.
     *
     * @return View
     */
    public function edit(): View
    {
        /** @var \App\Models\User $user */
        $user = auth()->user();

        return view('user.profile.email.edit', compact('user'));
    }

    /**
     * Send OTP to new email address.
     *
     * @param UpdateEmailRequest $request
     * @return RedirectResponse
     */
    public function sendOtp(UpdateEmailRequest $request): RedirectResponse
    {
        /** @var \App\Models\User $user */
        $user = auth()->user();
        $newEmail = $request->input('email');

        // Create OTP for email verification
        $otp = $this->otpService->create($user, 'email', 10);

        // Store in session
        session([
            'profile_email_update.new_email' => $newEmail,
            'profile_email_update.otp_id' => $otp->id,
            'profile_email_update.started_at' => now(),
        ]);

        // Send OTP to new email
        $this->notificationService->send($otp->code, 'email', $newEmail);

        return redirect()->route('user.profile.email.verify')
            ->with('success', __('user/profile/email.messages.otp_sent'));
    }

    /**
     * Show OTP verification form.
     *
     * @return View|RedirectResponse
     */
    public function showVerifyForm(): View|RedirectResponse
    {
        $newEmail = session('profile_email_update.new_email');

        if (!$newEmail) {
            return redirect()->route('user.profile.email.edit')
                ->with('error', __('user/profile/email.messages.session_expired'));
        }

        return view('user.profile.email.verify', [
            'new_email' => $newEmail,
        ]);
    }

    /**
     * Verify OTP and update email.
     *
     * @param VerifyEmailOtpRequest $request
     * @return RedirectResponse
     */
    public function verify(VerifyEmailOtpRequest $request): RedirectResponse
    {
        /** @var \App\Models\User $user */
        $user = auth()->user();
        $newEmail = session('profile_email_update.new_email');
        $otpId = session('profile_email_update.otp_id');

        if (!$newEmail || !$otpId) {
            return redirect()->route('user.profile.email.edit')
                ->with('error', __('user/profile/email.messages.session_expired'));
        }

        $otp = Otp::find($otpId);

        if (!$otp || $otp->user_id !== $user->id || $otp->type !== 'email') {
            return redirect()->route('user.profile.email.edit')
                ->with('error', __('user/profile/email.messages.invalid_otp'));
        }

        // Verify the code matches the stored OTP
        if ($otp->code !== $request->input('code')) {
            $this->otpService->incrementAttempts($otp->id);
            return back()
                ->withInput()
                ->with('error', __('user/profile/email.messages.invalid_otp'));
        }

        // Check if OTP is valid (not expired, not used, not max attempts)
        if ($otp->isExpired()) {
            return back()
                ->withInput()
                ->with('error', __('otp.messages.expired'));
        }

        if ($otp->is_used) {
            return back()
                ->withInput()
                ->with('error', __('otp.messages.already_used'));
        }

        if ($otp->hasReachedMaxAttempts()) {
            return back()
                ->withInput()
                ->with('error', __('otp.messages.max_attempts_reached'));
        }

        // Mark as used
        $this->otpService->markAsUsed($otp->id);

        // Update user email
        $this->userService->update($user->id, ['email' => $newEmail]);

        // Clear session
        session()->forget(['profile_email_update.new_email', 'profile_email_update.otp_id', 'profile_email_update.started_at']);

        return redirect()->route('user.profile.show')
            ->with('success', __('user/profile/email.messages.email_updated'));
    }

    /**
     * Resend OTP code.
     *
     * @return RedirectResponse
     */
    public function resendOtp(): RedirectResponse
    {
        /** @var \App\Models\User $user */
        $user = auth()->user();
        $newEmail = session('profile_email_update.new_email');

        if (!$newEmail) {
            return redirect()->route('user.profile.email.edit')
                ->with('error', __('user/profile/email.messages.session_expired'));
        }

        // Create new OTP
        $otp = $this->otpService->create($user, 'email', 10);

        // Update session
        session(['profile_email_update.otp_id' => $otp->id]);

        // Send OTP
        $this->notificationService->send($otp->code, 'email', $newEmail);

        return back()->with('success', __('user/profile/email.messages.otp_resent'));
    }
}
