<?php

namespace App\Services\Auth;

use App\Models\Otp;
use App\Models\User;
use App\Services\Otp\OtpNotificationService;
use App\Services\Otp\OtpService;
use App\Services\User\UserService;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;

class AuthService
{
    public function __construct(
        private readonly UserService $userService,
        private readonly OtpService $otpService,
        private readonly OtpNotificationService $notificationService,
    ) {
    }

    /**
     * Initiate user registration by creating OTP.
     *
     * @param string $emailOrPhone
     * @return array
     */
    public function initiateRegistration(string $emailOrPhone): array
    {
        $contactType = $this->determineContactType($emailOrPhone);

        if ($contactType === null) {
            return [
                'success' => false,
                'message' => __('auth.validation.email_or_phone_format'),
            ];
        }

        // Check if user already exists
        $existingUser = User::where('email', $emailOrPhone)
            ->orWhere('phone_number', $emailOrPhone)
            ->first();

        if ($existingUser) {
            return [
                'success' => false,
                'message' => __('auth.messages.user_already_exists'),
            ];
        }

        // Determine OTP type
        $otpType = $contactType === 'email' ? 'email' : 'sms';

        // Generate OTP
        $otp = $this->otpService->create(null, $otpType);

        // TODO: Send OTP via email or SMS
        $this->sendOtp($otp, $otpType, $emailOrPhone);

        return [
            'success' => true,
            'message' => __('auth.messages.registration_initiated'),
            'otp_id' => $otp->id,
            'type' => $otpType,
            'email_or_phone' => $emailOrPhone,
        ];
    }

    /**
     * Verify OTP code during registration.
     *
     * @param string $code
     * @param string $emailOrPhone
     * @return array
     */
    public function verifyRegistrationOtp(string $code, string $emailOrPhone): array
    {
        $result = $this->otpService->verifyOtp($code, false);

        if (!$result['success']) {
            return $result;
        }

        $otp = $result['otp'];

        // Verify OTP is not expired and not used
        if ($otp->isExpired()) {
            return [
                'success' => false,
                'message' => __('auth.messages.otp_expired'),
            ];
        }

        if ($otp->is_used) {
            return [
                'success' => false,
                'message' => __('auth.messages.otp_already_used'),
            ];
        }

        if ($otp->hasReachedMaxAttempts()) {
            return [
                'success' => false,
                'message' => __('auth.messages.otp_max_attempts'),
            ];
        }

        // Verify code matches
        if ($otp->code !== $code) {
            $otp->incrementAttempts();
            return [
                'success' => false,
                'message' => __('auth.messages.invalid_otp') . ' (' . ($otp->max_attempts - $otp->attempts) . ' ' . __('auth.messages.attempts_remaining') . ')',
            ];
        }

        return [
            'success' => true,
            'message' => __('auth.messages.otp_verified'),
            'otp' => $otp,
        ];
    }

    /**
     * Complete user registration after OTP verification.
     *
     * @param string $emailOrPhone
     * @param string $password
     * @param array $profileData
     * @return User|null
     */
    public function completeRegistration(string $emailOrPhone, string $password, array $profileData = []): ?User
    {
        $contactType = $this->determineContactType($emailOrPhone);

        // Prepare user data
        $userData = [
            'password' => $password,
            'is_active' => true,
        ];

        // Add profile data
        if (isset($profileData['first_name'])) {
            $userData['first_name'] = $profileData['first_name'];
        }
        if (isset($profileData['last_name'])) {
            $userData['last_name'] = $profileData['last_name'];
        }

        // Set email or phone
        if ($contactType === 'email') {
            $userData['email'] = $emailOrPhone;
        } else {
            $userData['phone_number'] = $emailOrPhone;
            // Extract country code if provided
            if (isset($profileData['country_code'])) {
                $userData['country_code'] = $profileData['country_code'];
            }
        }

        // Create user via service
        return $this->userService->create($userData);
    }

    /**
     * Authenticate user with email or phone and password.
     *
     * @param string $emailOrPhone
     * @param string $password
     * @return array
     */
    public function login(string $emailOrPhone, string $password): array
    {
        $user = $this->userService->authenticateByEmailOrPhone($emailOrPhone, $password);

        if (!$user) {
            return [
                'success' => false,
                'message' => __('auth.messages.invalid_credentials'),
            ];
        }

        if (!$user->is_active) {
            return [
                'success' => false,
                'message' => __('auth.messages.account_inactive'),
            ];
        }

        return [
            'success' => true,
            'message' => __('auth.messages.login_successful'),
            'user' => $user,
        ];
    }

    /**
     * Perform login action for authenticated user.
     *
     * @param User $user
     * @param bool $remember
     * @return void
     */
    public function performLogin(User $user, bool $remember = false): void
    {
        Auth::guard('web')->login($user, $remember);
        $user->updateLastLogin();
        session()->regenerate();
    }

    /**
     * Initiate forgot password flow.
     *
     * @param string $emailOrPhone
     * @return array
     */
    public function initiateForgotPassword(string $emailOrPhone): array
    {
        $user = $this->findUserByEmailOrPhone($emailOrPhone);

        if (!$user) {
            // For security, don't reveal if user exists
            return [
                'success' => true,
                'message' => __('auth.messages.reset_link_sent'),
                'user_found' => false,
            ];
        }

        $contactType = $this->determineContactType($emailOrPhone);
        $otpType = $contactType === 'email' ? 'email' : 'sms';

        $otp = $this->otpService->create($user, $otpType);

        // TODO: Send OTP via email or SMS
        $this->sendOtp($otp, $otpType, $emailOrPhone);

        return [
            'success' => true,
            'message' => __('auth.messages.reset_link_sent'),
            'otp_id' => $otp->id,
            'type' => $otpType,
            'email_or_phone' => $emailOrPhone,
            'user_id' => $user->id,
            'user_found' => true,
        ];
    }

    /**
     * Verify OTP for password reset.
     *
     * @param string $code
     * @return array
     */
    public function verifyResetOtp(string $code): array
    {
        $result = $this->otpService->verifyOtp($code, false);

        if (!$result['success']) {
            return $result;
        }

        $otp = $result['otp'];

        if ($otp->isExpired()) {
            return [
                'success' => false,
                'message' => __('auth.messages.otp_expired'),
            ];
        }

        if ($otp->is_used) {
            return [
                'success' => false,
                'message' => __('auth.messages.otp_already_used'),
            ];
        }

        if ($otp->hasReachedMaxAttempts()) {
            return [
                'success' => false,
                'message' => __('auth.messages.otp_max_attempts'),
            ];
        }

        if ($otp->code !== $code) {
            $otp->incrementAttempts();
            return [
                'success' => false,
                'message' => __('auth.messages.invalid_otp'),
            ];
        }

        return [
            'success' => true,
            'message' => __('auth.messages.otp_verified'),
            'otp' => $otp,
        ];
    }

    /**
     * Reset user password.
     *
     * @param string $code
     * @param string $newPassword
     * @return array
     */
    public function resetPassword(string $code, string $newPassword): array
    {
        // Get OTP by code
        $otp = $this->otpService->getRepository()->findByCode($code);

        if (!$otp) {
            return [
                'success' => false,
                'message' => __('auth.messages.session_expired'),
            ];
        }

        if ($otp->isExpired() || $otp->is_used) {
            return [
                'success' => false,
                'message' => __('auth.messages.session_expired'),
            ];
        }

        // Get user from OTP
        $user = $otp->user;

        if (!$user) {
            return [
                'success' => false,
                'message' => __('auth.messages.user_not_found'),
            ];
        }

        // Change password
        $this->userService->changePassword($user->id, $newPassword);

        // Mark OTP as used
        $otp->markAsUsed();

        // Logout from other sessions (optional)
        Auth::guard('web')->logout();

        return [
            'success' => true,
            'message' => __('auth.messages.password_reset_successful'),
            'user_id' => $user->id,
        ];
    }

    /**
     * Determine if contact is email or phone.
     *
     * @param string $contact
     * @return string|null
     */
    public function determineContactType(string $contact): ?string
    {
        if (filter_var($contact, FILTER_VALIDATE_EMAIL)) {
            return 'email';
        }

        // Iranian phone number pattern: 09XX XXXXXXX
        if (preg_match('/^(\+?98|0)?9\d{9}$/', $contact)) {
            return 'phone';
        }

        return null;
    }

    /**
     * Find user by email or phone.
     *
     * @param string $emailOrPhone
     * @return User|null
     */
    public function findUserByEmailOrPhone(string $emailOrPhone): ?User
    {
        return User::where('email', $emailOrPhone)
            ->orWhere('phone_number', $emailOrPhone)
            ->first();
    }

    /**
     * Send OTP code via email or SMS.
     *
     * @param Otp $otp
     * @param string $type
     * @param string $destination
     * @return void
     */
    public function sendOtp(Otp $otp, string $type, string $destination): void
    {
        $this->notificationService->send($otp->code, $type, $destination);
    }
}
