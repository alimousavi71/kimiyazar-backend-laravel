<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use App\Http\Requests\Auth\ForgotPasswordRequest;
use App\Http\Requests\Auth\ResendOtpRequest;
use App\Http\Requests\Auth\ResetPasswordRequest;
use App\Http\Requests\Auth\VerifyResetOtpRequest;
use App\Http\Traits\ApiResponseTrait;
use App\Models\Otp;
use App\Services\Auth\AuthService;
use App\Services\Otp\OtpService;
use Exception;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\RedirectResponse;
use Illuminate\View\View;

class ForgotPasswordController extends Controller
{
    use ApiResponseTrait;

    public function __construct(
        private readonly AuthService $authService,
        private readonly OtpService $otpService,
    ) {
    }

    /**
     * Show forgot password form.
     */
    public function showForgotPasswordForm(): View
    {
        return view('auth.forgot-password');
    }

    /**
     * Send reset OTP code.
     */
    public function sendResetOtp(ForgotPasswordRequest $request): RedirectResponse|JsonResponse
    {
        try {
            $result = $this->authService->initiateForgotPassword(
                $request->input('email_or_phone')
            );

            if (!$result['user_found']) {
                // For security, show same message even if user not found
                // But don't store in session
                if ($request->expectsJson()) {
                    return $this->successResponse(
                        null,
                        __('auth.messages.reset_link_sent')
                    );
                }

                return redirect()->route('auth.password.request')
                    ->with('success', __('auth.messages.reset_link_sent'));
            }

            // Store in session for web flow
            session([
                'password_reset.email_or_phone' => $request->input('email_or_phone'),
                'password_reset.otp_id' => $result['otp_id'],
                'password_reset.user_id' => $result['user_id'],
                'password_reset.started_at' => now(),
            ]);

            if ($request->expectsJson()) {
                return $this->successResponse(
                    $result,
                    __('auth.messages.reset_link_sent')
                );
            }

            return redirect()->route('auth.password.verify-otp')
                ->with('success', __('auth.messages.reset_link_sent'));
        } catch (Exception $e) {
            \Log::error('Forgot password error: ' . $e->getMessage());

            return $this->respondError(
                ['error' => 'Failed to send reset link'],
                'An error occurred',
                500
            );
        }
    }

    /**
     * Show reset OTP verification form.
     */
    public function showVerifyResetOtpForm(): View
    {
        $emailOrPhone = session('password_reset.email_or_phone');

        if (!$emailOrPhone) {
            return redirect()->route('auth.password.request')
                ->with('error', __('auth.messages.session_expired'));
        }

        return view('auth.verify-reset-otp', [
            'email_or_phone' => $emailOrPhone,
            'type' => session('password_reset.type'),
            'step' => 'password_reset',
        ]);
    }

    /**
     * Verify reset OTP code.
     */
    public function verifyResetOtp(VerifyResetOtpRequest $request): RedirectResponse|JsonResponse
    {
        try {
            if (!session('password_reset.email_or_phone')) {
                return $this->respondError(
                    ['error' => __('auth.messages.session_expired')],
                    __('auth.messages.session_expired')
                );
            }

            $result = $this->authService->verifyResetOtp(
                $request->input('code')
            );

            if (!$result['success']) {
                if ($request->expectsJson()) {
                    return $this->errorResponse(
                        $result['message'],
                        422,
                        ['code' => $result['message']]
                    );
                }

                return back()
                    ->withInput()
                    ->with('error', $result['message']);
            }

            // Mark OTP as verified in session
            session(['password_reset.otp_verified' => true, 'password_reset.code' => $request->input('code')]);

            if ($request->expectsJson()) {
                return $this->successResponse(
                    $result,
                    __('auth.messages.otp_verified')
                );
            }

            return redirect()->route('auth.password.reset')
                ->with('success', __('auth.messages.otp_verified'));
        } catch (Exception $e) {
            \Log::error('Reset OTP verification error: ' . $e->getMessage());

            return $this->respondError(
                ['error' => 'Verification failed'],
                'An error occurred during verification',
                500
            );
        }
    }

    /**
     * Show reset password form.
     */
    public function showResetPasswordForm(): View
    {
        if (!session('password_reset.otp_verified')) {
            return redirect()->route('auth.password.request')
                ->with('error', __('auth.messages.session_expired'));
        }

        return view('auth.reset-password', [
            'email_or_phone' => session('password_reset.email_or_phone'),
        ]);
    }

    /**
     * Process password reset.
     */
    public function resetPassword(ResetPasswordRequest $request): RedirectResponse|JsonResponse
    {
        try {
            if (!session('password_reset.otp_verified')) {
                return $this->respondError(
                    ['error' => __('auth.messages.session_expired')],
                    __('auth.messages.session_expired')
                );
            }

            $code = session('password_reset.code');

            $result = $this->authService->resetPassword(
                $code,
                $request->input('password')
            );

            if (!$result['success']) {
                return $this->respondError(
                    ['error' => $result['message']],
                    $result['message'],
                    400
                );
            }

            // Clear password reset session
            session()->forget('password_reset');

            if ($request->expectsJson()) {
                return $this->successResponse(
                    null,
                    __('auth.messages.password_reset_successful')
                );
            }

            return redirect()->route('auth.login')
                ->with('success', __('auth.messages.password_reset_successful'));
        } catch (Exception $e) {
            \Log::error('Password reset error: ' . $e->getMessage());

            return $this->respondError(
                ['error' => 'Password reset failed'],
                'An error occurred during password reset',
                500
            );
        }
    }

    /**
     * Resend reset OTP code via AJAX.
     */
    public function resendResetOtp(ResendOtpRequest $request): JsonResponse
    {
        try {
            $otpId = $request->input('otp_id');

            $otp = Otp::find($otpId);

            if (!$otp) {
                return $this->errorResponse(
                    __('auth.messages.invalid_otp'),
                    404
                );
            }

            // Check if OTP is not too old
            if ($otp->created_at->diffInMinutes(now()) > 60) {
                return $this->errorResponse(
                    __('auth.messages.session_expired'),
                    400
                );
            }

            // Resend OTP
            $newOtp = $this->otpService->resendOtp($otpId);

            $contactType = $otp->type;
            $emailOrPhone = session('password_reset.email_or_phone');

            // Send OTP
            $this->authService->sendOtp($newOtp, $contactType, $emailOrPhone ?? '');

            return $this->successResponse(
                ['otp_id' => $newOtp->id],
                __('auth.messages.otp_resent')
            );
        } catch (Exception $e) {
            \Log::error('Resend reset OTP error: ' . $e->getMessage());

            return $this->errorResponse(
                'Failed to resend OTP',
                500
            );
        }
    }
}
