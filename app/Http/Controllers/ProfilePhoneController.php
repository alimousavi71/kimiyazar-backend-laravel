<?php

namespace App\Http\Controllers;

use App\Http\Requests\Profile\UpdatePhoneRequest;
use App\Http\Requests\Profile\VerifyPhoneOtpRequest;
use App\Models\Otp;
use App\Services\Otp\OtpNotificationService;
use App\Services\Otp\OtpService;
use App\Services\User\UserService;
use Illuminate\Http\RedirectResponse;
use Illuminate\View\View;

class ProfilePhoneController extends Controller
{
    public function __construct(
        private readonly UserService $userService,
        private readonly OtpService $otpService,
        private readonly OtpNotificationService $notificationService,
    ) {
    }

    /**
     * Show the form for updating phone number.
     *
     * @return View
     */
    public function edit(): View
    {
        /** @var \App\Models\User $user */
        $user = auth()->user();

        return view('user.profile.phone.edit', compact('user'));
    }

    /**
     * Send OTP to new phone number.
     *
     * @param UpdatePhoneRequest $request
     * @return RedirectResponse
     */
    public function sendOtp(UpdatePhoneRequest $request): RedirectResponse
    {
        /** @var \App\Models\User $user */
        $user = auth()->user();
        $newPhone = $request->input('phone_number');
        $countryCode = $request->input('country_code');

        // Create OTP for phone verification
        $otp = $this->otpService->create($user, 'sms', 10);

        // Store in session
        session([
            'profile_phone_update.new_phone' => $newPhone,
            'profile_phone_update.country_code' => $countryCode,
            'profile_phone_update.otp_id' => $otp->id,
            'profile_phone_update.started_at' => now(),
        ]);

        // Send OTP to new phone
        $fullPhone = $countryCode ? ($countryCode . $newPhone) : $newPhone;
        $this->notificationService->send($otp->code, 'sms', $fullPhone);

        return redirect()->route('user.profile.phone.verify')
            ->with('success', __('user/profile/phone.messages.otp_sent'));
    }

    /**
     * Show OTP verification form.
     *
     * @return View|RedirectResponse
     */
    public function showVerifyForm(): View|RedirectResponse
    {
        $newPhone = session('profile_phone_update.new_phone');
        $countryCode = session('profile_phone_update.country_code');

        if (!$newPhone) {
            return redirect()->route('user.profile.phone.edit')
                ->with('error', __('user/profile/phone.messages.session_expired'));
        }

        return view('user.profile.phone.verify', [
            'new_phone' => $newPhone,
            'country_code' => $countryCode,
        ]);
    }

    /**
     * Verify OTP and update phone number.
     *
     * @param VerifyPhoneOtpRequest $request
     * @return RedirectResponse
     */
    public function verify(VerifyPhoneOtpRequest $request): RedirectResponse
    {
        /** @var \App\Models\User $user */
        $user = auth()->user();
        $newPhone = session('profile_phone_update.new_phone');
        $countryCode = session('profile_phone_update.country_code');
        $otpId = session('profile_phone_update.otp_id');

        if (!$newPhone || !$otpId) {
            return redirect()->route('user.profile.phone.edit')
                ->with('error', __('user/profile/phone.messages.session_expired'));
        }

        $otp = Otp::find($otpId);

        if (!$otp || $otp->user_id !== $user->id || $otp->type !== 'sms') {
            return redirect()->route('user.profile.phone.edit')
                ->with('error', __('user/profile/phone.messages.invalid_otp'));
        }

        // Verify the code matches the stored OTP
        if ($otp->code !== $request->input('code')) {
            $this->otpService->incrementAttempts($otp->id);
            return back()
                ->withInput()
                ->with('error', __('user/profile/phone.messages.invalid_otp'));
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

        // Update user phone
        $updateData = ['phone_number' => $newPhone];
        if ($countryCode) {
            $updateData['country_code'] = $countryCode;
        }
        $this->userService->update($user->id, $updateData);

        // Clear session
        session()->forget(['profile_phone_update.new_phone', 'profile_phone_update.country_code', 'profile_phone_update.otp_id', 'profile_phone_update.started_at']);

        return redirect()->route('user.profile.show')
            ->with('success', __('user/profile/phone.messages.phone_updated'));
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
        $newPhone = session('profile_phone_update.new_phone');
        $countryCode = session('profile_phone_update.country_code');

        if (!$newPhone) {
            return redirect()->route('user.profile.phone.edit')
                ->with('error', __('user/profile/phone.messages.session_expired'));
        }

        // Create new OTP
        $otp = $this->otpService->create($user, 'sms', 10);

        // Update session
        session(['profile_phone_update.otp_id' => $otp->id]);

        // Send OTP
        $fullPhone = $countryCode ? ($countryCode . $newPhone) : $newPhone;
        $this->notificationService->send($otp->code, 'sms', $fullPhone);

        return back()->with('success', __('user/profile/phone.messages.otp_resent'));
    }
}
