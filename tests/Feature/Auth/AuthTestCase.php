<?php

namespace Tests\Feature\Auth;

use App\Models\Otp;
use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

abstract class AuthTestCase extends TestCase
{
    use RefreshDatabase;

    /**
     * Valid test email
     */
    protected const TEST_EMAIL = 'user@example.com';

    /**
     * Valid test phone
     */
    protected const TEST_PHONE = '09123456789';

    /**
     * Valid test password
     */
    protected const TEST_PASSWORD = 'SecurePassword123';

    /**
     * Invalid OTP code
     */
    protected const INVALID_OTP = '000000';

    /**
     * Create a user with email
     */
    protected function createUserWithEmail(
        string $email = self::TEST_EMAIL,
        string $password = self::TEST_PASSWORD,
        bool $active = true
    ): User {
        return User::factory()->create([
            'email' => $email,
            'password' => $password,
            'is_active' => $active,
        ]);
    }

    /**
     * Create a user with phone number
     */
    protected function createUserWithPhone(
        string $phone = self::TEST_PHONE,
        string $password = self::TEST_PASSWORD,
        bool $active = true
    ): User {
        return User::factory()->create([
            'phone_number' => $phone,
            'password' => $password,
            'is_active' => $active,
        ]);
    }

    /**
     * Create an OTP for registration
     */
    protected function createRegistrationOtp(
        string $type = 'email',
        bool $expired = false
    ): Otp {
        $expiresAt = $expired
            ? now()->subMinutes(5)
            : now()->addMinutes(10);

        return Otp::factory()->create([
            'code' => '12345',
            'type' => $type,
            'user_id' => null,
            'is_used' => false,
            'attempts' => 0,
            'expired_at' => $expiresAt,
        ]);
    }

    /**
     * Create an OTP for password reset
     */
    protected function createResetOtp(
        User $user,
        string $type = 'email',
        bool $expired = false,
        bool $used = false
    ): Otp {
        $expiresAt = $expired
            ? now()->subMinutes(5)
            : now()->addMinutes(10);

        return Otp::factory()->create([
            'code' => '12345',
            'type' => $type,
            'user_id' => $user->id,
            'is_used' => $used,
            'attempts' => 0,
            'expired_at' => $expiresAt,
        ]);
    }

    /**
     * Start registration with email
     */
    protected function startEmailRegistration(string $email = self::TEST_EMAIL): array
    {
        $response = $this->post(route('auth.register'), [
            'email_or_phone' => $email,
        ]);

        return [
            'response' => $response,
            'otp' => Otp::where('code', '12345')
                ->where('type', 'email')
                ->latest()
                ->first(),
        ];
    }

    /**
     * Start registration with phone
     */
    protected function startPhoneRegistration(string $phone = self::TEST_PHONE): array
    {
        $response = $this->post(route('auth.register'), [
            'email_or_phone' => $phone,
        ]);

        return [
            'response' => $response,
            'otp' => Otp::where('code', '12345')
                ->where('type', 'sms')
                ->latest()
                ->first(),
        ];
    }

    /**
     * Verify OTP during registration
     */
    protected function verifyRegistrationOtp(
        Otp $otp,
        string $code = '12345',
        string $contactType = 'email'
    ) {
        $this->session(['registration' => [
            'email_or_phone' => $contactType === 'email' ? self::TEST_EMAIL : self::TEST_PHONE,
            'otp_id' => $otp->id,
            'type' => $contactType,
        ]]);

        return $this->post(route('auth.register.verify-otp'), [
            'code' => $code,
        ]);
    }

    /**
     * Complete registration (set password)
     */
    protected function completeRegistration(
        Otp $otp,
        string $password = self::TEST_PASSWORD,
        ?string $firstName = 'Test',
        ?string $lastName = 'User'
    ) {
        $this->session(['registration' => [
            'email_or_phone' => self::TEST_EMAIL,
            'otp_id' => $otp->id,
            'type' => 'email',
            'otp_verified' => true,
        ]]);

        return $this->post(route('auth.register.complete'), [
            'password' => $password,
            'password_confirmation' => $password,
            'first_name' => $firstName,
            'last_name' => $lastName,
        ]);
    }

    /**
     * Login with email
     */
    protected function loginWithEmail(
        string $email = self::TEST_EMAIL,
        string $password = self::TEST_PASSWORD,
        bool $remember = false
    ) {
        return $this->post(route('auth.login'), [
            'email_or_phone' => $email,
            'password' => $password,
            'remember' => $remember ? 'on' : null,
        ]);
    }

    /**
     * Login with phone
     */
    protected function loginWithPhone(
        string $phone = self::TEST_PHONE,
        string $password = self::TEST_PASSWORD,
        bool $remember = false
    ) {
        return $this->post(route('auth.login'), [
            'email_or_phone' => $phone,
            'password' => $password,
            'remember' => $remember ? 'on' : null,
        ]);
    }

    /**
     * Start password reset with email
     */
    protected function startPasswordResetWithEmail(string $email = self::TEST_EMAIL): array
    {
        $response = $this->post(route('auth.password.email'), [
            'email_or_phone' => $email,
        ]);

        $user = User::where('email', $email)->first();

        return [
            'response' => $response,
            'user' => $user,
            'otp' => Otp::where('code', '12345')
                ->where('type', 'email')
                ->where('user_id', $user?->id)
                ->latest()
                ->first(),
        ];
    }

    /**
     * Start password reset with phone
     */
    protected function startPasswordResetWithPhone(string $phone = self::TEST_PHONE): array
    {
        $response = $this->post(route('auth.password.email'), [
            'email_or_phone' => $phone,
        ]);

        $user = User::where('phone_number', $phone)->first();

        return [
            'response' => $response,
            'user' => $user,
            'otp' => Otp::where('code', '12345')
                ->where('type', 'sms')
                ->where('user_id', $user?->id)
                ->latest()
                ->first(),
        ];
    }

    /**
     * Verify OTP during password reset
     */
    protected function verifyResetOtp(Otp $otp, string $code = '12345') {
        $this->session(['password_reset' => [
            'email_or_phone' => self::TEST_EMAIL,
            'otp_id' => $otp->id,
            'user_id' => $otp->user_id,
        ]]);

        return $this->post(route('auth.password.verify-otp'), [
            'code' => $code,
        ]);
    }

    /**
     * Reset password
     */
    protected function resetPassword(
        Otp $otp,
        string $newPassword = self::TEST_PASSWORD
    ) {
        $this->session(['password_reset' => [
            'email_or_phone' => self::TEST_EMAIL,
            'otp_id' => $otp->id,
            'user_id' => $otp->user_id,
            'otp_verified' => true,
        ]]);

        return $this->post(route('auth.password.update'), [
            'password' => $newPassword,
            'password_confirmation' => $newPassword,
        ]);
    }

    /**
     * Logout
     */
    protected function logout() {
        return $this->post(route('auth.logout'));
    }

    /**
     * Assert user is authenticated
     */
    protected function assertUserAuthenticated(User $user): void
    {
        $this->assertAuthenticated();
        $this->assertEquals($user->id, auth()->id());
    }

    /**
     * Assert user is not authenticated
     */
    protected function assertUserNotAuthenticated(): void
    {
        $this->assertGuest();
    }

    /**
     * Assert user exists in database
     */
    protected function assertUserExists(array $attributes): void
    {
        $this->assertDatabaseHas('users', $attributes);
    }

    /**
     * Assert user does not exist in database
     */
    protected function assertUserDoesNotExist(array $attributes): void
    {
        $this->assertDatabaseMissing('users', $attributes);
    }

    /**
     * Assert OTP exists in database
     */
    protected function assertOtpExists(array $attributes): void
    {
        $this->assertDatabaseHas('otps', $attributes);
    }

    /**
     * Get error message from response
     */
    protected function getErrorMessage($response): ?string
    {
        $errors = $response->viewData('errors');
        if ($errors && $errors->count() > 0) {
            return $errors->first();
        }
        return null;
    }
}
