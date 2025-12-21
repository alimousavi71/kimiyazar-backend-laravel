<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use App\Http\Requests\Auth\CompleteRegistrationRequest;
use App\Http\Requests\Auth\RegisterRequest;
use App\Http\Requests\Auth\ResendOtpRequest;
use App\Http\Requests\Auth\VerifyRegistrationOtpRequest;
use App\Http\Traits\ApiResponseTrait;
use App\Models\Otp;
use App\Services\Auth\AuthService;
use App\Services\Otp\OtpService;
use Exception;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\View\View;

class RegisterController extends Controller
{
    use ApiResponseTrait;

    public function __construct(
        private readonly AuthService $authService,
        private readonly OtpService $otpService,
    ) {
    }

    /**
     * Show registration form.
     */
    public function showRegistrationForm(): View
    {
        return view('auth.register');
    }

    /**
     * Process registration request and send OTP.
     */
    public function register(RegisterRequest $request): RedirectResponse|JsonResponse
    {
        try {
            $result = $this->authService->initiateRegistration(
                $request->input('email_or_phone')
            );

            if (!$result['success']) {
                return $this->validationErrorResponse(
                    ['email_or_phone' => $result['message']],
                    $result['message']
                );
            }

            // Store in session for web flow
            session([
                'registration.email_or_phone' => $request->input('email_or_phone'),
                'registration.otp_id' => $result['otp_id'],
                'registration.type' => $result['type'],
                'registration.started_at' => now(),
            ]);

            if ($request->expectsJson()) {
                return $this->successResponse(
                    $result,
                    __('auth.messages.registration_initiated')
                );
            }

            return redirect()->route('auth.register.verify-otp')
                ->with('success', __('auth.messages.registration_initiated'));
        } catch (Exception $e) {
            \Log::error('Registration error: ' . $e->getMessage());

            return $this->errorResponse(
                'An error occurred during registration',
                500
            );
        }
    }

    /**
     * Show OTP verification form.
     */
    public function showVerifyOtpForm(): View
    {
        $emailOrPhone = session('registration.email_or_phone');
        $type = session('registration.type');

        if (!$emailOrPhone) {
            return redirect()->route('auth.register')
                ->with('error', __('auth.messages.session_expired'));
        }

        return view('auth.verify-otp', [
            'email_or_phone' => $emailOrPhone,
            'type' => $type,
            'step' => 'registration',
        ]);
    }

    /**
     * Verify OTP code during registration.
     */
    public function verifyOtp(VerifyRegistrationOtpRequest $request): RedirectResponse|JsonResponse
    {
        try {
            $emailOrPhone = session('registration.email_or_phone');

            if (!$emailOrPhone) {
                return $this->errorResponse(
                    __('auth.messages.session_expired'),
                    422
                );
            }

            $result = $this->authService->verifyRegistrationOtp(
                $request->input('code'),
                $emailOrPhone
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
            session(['registration.otp_verified' => true]);

            if ($request->expectsJson()) {
                return $this->successResponse(
                    $result,
                    __('auth.messages.otp_verified')
                );
            }

            return redirect()->route('auth.register.complete')
                ->with('success', __('auth.messages.otp_verified'));
        } catch (Exception $e) {
            \Log::error('OTP verification error: ' . $e->getMessage());

            return $this->errorResponse(
                'An error occurred during verification',
                500
            );
        }
    }

    /**
     * Show registration completion form.
     */
    public function showCompleteRegistrationForm(): View
    {
        if (!session('registration.otp_verified')) {
            return redirect()->route('auth.register')
                ->with('error', __('auth.messages.session_expired'));
        }

        $emailOrPhone = session('registration.email_or_phone');

        return view('auth.complete-registration', [
            'email_or_phone' => $emailOrPhone,
        ]);
    }

    /**
     * Complete registration with password.
     */
    public function completeRegistration(CompleteRegistrationRequest $request): RedirectResponse|JsonResponse
    {
        try {
            if (!session('registration.otp_verified')) {
                return $this->errorResponse(
                    __('auth.messages.session_expired'),
                    422
                );
            }

            $emailOrPhone = session('registration.email_or_phone');

            $user = $this->authService->completeRegistration(
                $emailOrPhone,
                $request->input('password'),
                $request->only(['first_name', 'last_name', 'country_code'])
            );

            if (!$user) {
                return $this->errorResponse(
                    'Failed to create account',
                    500
                );
            }

            // Auto-login user
            $this->authService->performLogin($user);

            // Clear registration session
            session()->forget('registration');

            if ($request->expectsJson()) {
                return $this->successResponse(
                    ['user' => $user],
                    __('auth.messages.registration_completed'),
                    201
                );
            }

            return redirect()->intended('/')
                ->with('success', __('auth.messages.registration_completed'));
        } catch (Exception $e) {
            \Log::error('Registration completion error: ' . $e->getMessage());

            return $this->errorResponse(
                'An error occurred during registration',
                500
            );
        }
    }

    /**
     * Resend OTP code via AJAX.
     */
    public function resendOtp(ResendOtpRequest $request): JsonResponse
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
            $emailOrPhone = session('registration.email_or_phone');

            // Send OTP
            $this->authService->sendOtp($newOtp, $contactType, $emailOrPhone ?? '');

            return $this->successResponse(
                ['otp_id' => $newOtp->id],
                __('auth.messages.otp_resent')
            );
        } catch (Exception $e) {
            \Log::error('Resend OTP error: ' . $e->getMessage());

            return $this->errorResponse(
                'Failed to resend OTP',
                500
            );
        }
    }
}
