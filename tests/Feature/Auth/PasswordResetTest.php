<?php

namespace Tests\Feature\Auth;

use App\Models\User;

class PasswordResetTest extends AuthTestCase
{
    /**
     * Test showing forgot password form
     */
    public function test_can_view_forgot_password_form(): void
    {
        $response = $this->get(route('auth.password.request'));

        $response->assertStatus(200);
        $response->assertViewIs('auth.forgot-password');
    }

    /**
     * Test starting password reset with valid email
     */
    public function test_can_start_password_reset_with_email(): void
    {
        $user = $this->createUserWithEmail();

        $result = $this->startPasswordResetWithEmail(self::TEST_EMAIL);

        $result['response']->assertRedirect(route('auth.password.verify-otp'));
        $this->assertSessionHas('password_reset.email_or_phone', self::TEST_EMAIL);
        $this->assertNotNull($result['otp']);
    }

    /**
     * Test starting password reset with valid phone
     */
    public function test_can_start_password_reset_with_phone(): void
    {
        $user = $this->createUserWithPhone();

        $result = $this->startPasswordResetWithPhone(self::TEST_PHONE);

        $result['response']->assertRedirect(route('auth.password.verify-otp'));
        $this->assertSessionHas('password_reset.email_or_phone', self::TEST_PHONE);
        $this->assertNotNull($result['otp']);
    }

    /**
     * Test password reset fails with non-existent email
     */
    public function test_cannot_start_password_reset_with_non_existent_email(): void
    {
        $response = $this->post(route('auth.password.email'), [
            'email_or_phone' => 'nonexistent@example.com',
        ]);

        $response->assertRedirect(route('auth.password.request'));
        $response->assertSessionHasErrors();
    }

    /**
     * Test password reset fails with non-existent phone
     */
    public function test_cannot_start_password_reset_with_non_existent_phone(): void
    {
        $response = $this->post(route('auth.password.email'), [
            'email_or_phone' => '09999999999',
        ]);

        $response->assertRedirect(route('auth.password.request'));
        $response->assertSessionHasErrors();
    }

    /**
     * Test showing verify reset OTP form
     */
    public function test_can_view_verify_reset_otp_form(): void
    {
        $user = $this->createUserWithEmail();
        $result = $this->startPasswordResetWithEmail();

        $response = $this->get(route('auth.password.verify-otp'));

        $response->assertStatus(200);
        $response->assertViewIs('auth.verify-reset-otp');
    }

    /**
     * Test verifying reset OTP with correct code
     */
    public function test_can_verify_reset_otp_with_correct_code(): void
    {
        $user = $this->createUserWithEmail();
        $otp = $this->createResetOtp($user, 'email');

        $this->session(['password_reset' => [
            'email_or_phone' => self::TEST_EMAIL,
            'otp_id' => $otp->id,
            'user_id' => $user->id,
        ]]);

        $response = $this->post(route('auth.password.verify-otp'), [
            'code' => '12345',
        ]);

        $response->assertRedirect(route('auth.password.reset'));
        $this->assertSessionHas('password_reset.otp_verified', true);
    }

    /**
     * Test verifying reset OTP with incorrect code
     */
    public function test_cannot_verify_reset_otp_with_incorrect_code(): void
    {
        $user = $this->createUserWithEmail();
        $otp = $this->createResetOtp($user, 'email');

        $this->session(['password_reset' => [
            'email_or_phone' => self::TEST_EMAIL,
            'otp_id' => $otp->id,
            'user_id' => $user->id,
        ]]);

        $response = $this->post(route('auth.password.verify-otp'), [
            'code' => '000000',
        ]);

        $response->assertRedirect(route('auth.password.verify-otp'));
        $response->assertSessionHasErrors(['code']);
    }

    /**
     * Test showing reset password form
     */
    public function test_can_view_reset_password_form(): void
    {
        $user = $this->createUserWithEmail();
        $otp = $this->createResetOtp($user, 'email');

        $this->session(['password_reset' => [
            'email_or_phone' => self::TEST_EMAIL,
            'otp_id' => $otp->id,
            'user_id' => $user->id,
            'otp_verified' => true,
        ]]);

        $response = $this->get(route('auth.password.reset'));

        $response->assertStatus(200);
        $response->assertViewIs('auth.reset-password');
    }

    /**
     * Test resetting password with valid new password
     */
    public function test_can_reset_password_with_valid_password(): void
    {
        $user = $this->createUserWithEmail();
        $otp = $this->createResetOtp($user, 'email');
        $oldPassword = $user->password;

        $response = $this->resetPassword($otp, 'NewPassword123');

        $response->assertRedirect(route('auth.login'));

        // Verify password changed
        $user->refresh();
        $this->assertNotEquals($oldPassword, $user->password);
    }

    /**
     * Test resetting password with mismatched passwords
     */
    public function test_cannot_reset_password_with_mismatched_passwords(): void
    {
        $user = $this->createUserWithEmail();
        $otp = $this->createResetOtp($user, 'email');

        $this->session(['password_reset' => [
            'email_or_phone' => self::TEST_EMAIL,
            'otp_id' => $otp->id,
            'user_id' => $user->id,
            'otp_verified' => true,
        ]]);

        $response = $this->post(route('auth.password.update'), [
            'password' => 'NewPassword123',
            'password_confirmation' => 'DifferentPassword123',
        ]);

        $response->assertRedirect(route('auth.password.reset'));
        $response->assertSessionHasErrors(['password']);
    }

    /**
     * Test resetting password with password too short
     */
    public function test_cannot_reset_password_with_short_password(): void
    {
        $user = $this->createUserWithEmail();
        $otp = $this->createResetOtp($user, 'email');

        $this->session(['password_reset' => [
            'email_or_phone' => self::TEST_EMAIL,
            'otp_id' => $otp->id,
            'user_id' => $user->id,
            'otp_verified' => true,
        ]]);

        $response = $this->post(route('auth.password.update'), [
            'password' => 'short',
            'password_confirmation' => 'short',
        ]);

        $response->assertRedirect(route('auth.password.reset'));
        $response->assertSessionHasErrors(['password']);
    }

    /**
     * Test can login with new password after reset
     */
    public function test_can_login_with_new_password_after_reset(): void
    {
        $user = $this->createUserWithEmail();
        $otp = $this->createResetOtp($user, 'email');
        $newPassword = 'NewPassword123';

        $this->resetPassword($otp, $newPassword);

        // Try logging in with new password
        $response = $this->loginWithEmail(password: $newPassword);

        $response->assertRedirect('/');
        $this->assertUserAuthenticated(User::where('email', self::TEST_EMAIL)->first());
    }

    /**
     * Test cannot login with old password after reset
     */
    public function test_cannot_login_with_old_password_after_reset(): void
    {
        $user = $this->createUserWithEmail();
        $otp = $this->createResetOtp($user, 'email');

        $this->resetPassword($otp, 'NewPassword123');

        // Try logging in with old password
        $response = $this->loginWithEmail(password: self::TEST_PASSWORD);

        $response->assertRedirect(route('auth.login'));
        $response->assertSessionHasErrors();
    }

    /**
     * Test password reset session is cleared after completion
     */
    public function test_password_reset_session_cleared_on_completion(): void
    {
        $user = $this->createUserWithEmail();
        $otp = $this->createResetOtp($user, 'email');

        $this->resetPassword($otp);

        // After completion, session should be cleared
        $this->assertSessionMissing('password_reset');
    }

    /**
     * Test complete password reset flow with email
     */
    public function test_complete_password_reset_flow_with_email(): void
    {
        $user = $this->createUserWithEmail();

        // Step 1: Request password reset
        $result = $this->startPasswordResetWithEmail();
        $this->assertTrue($result['response']->status() === 302);
        $this->assertNotNull($result['otp']);

        // Step 2: Verify OTP
        $verifyResponse = $this->verifyResetOtp($result['otp']);
        $this->assertTrue($verifyResponse->status() === 302);

        // Step 3: Reset password
        $resetResponse = $this->resetPassword($result['otp'], 'NewPassword456');
        $this->assertTrue($resetResponse->status() === 302);

        // Verify can login with new password
        $loginResponse = $this->loginWithEmail(password: 'NewPassword456');
        $loginResponse->assertRedirect('/');
        $this->assertUserAuthenticated($user);
    }

    /**
     * Test complete password reset flow with phone
     */
    public function test_complete_password_reset_flow_with_phone(): void
    {
        $user = $this->createUserWithPhone();

        // Step 1: Request password reset
        $result = $this->startPasswordResetWithPhone();
        $this->assertTrue($result['response']->status() === 302);
        $this->assertNotNull($result['otp']);

        // Step 2: Verify OTP
        $this->session(['password_reset' => [
            'email_or_phone' => self::TEST_PHONE,
            'otp_id' => $result['otp']->id,
            'user_id' => $user->id,
        ]]);

        $verifyResponse = $this->post(route('auth.password.verify-otp'), [
            'code' => '12345',
        ]);
        $this->assertTrue($verifyResponse->status() === 302);

        // Step 3: Reset password
        $this->session(['password_reset' => [
            'email_or_phone' => self::TEST_PHONE,
            'otp_id' => $result['otp']->id,
            'user_id' => $user->id,
            'otp_verified' => true,
        ]]);

        $resetResponse = $this->post(route('auth.password.update'), [
            'password' => 'NewPassword456',
            'password_confirmation' => 'NewPassword456',
        ]);
        $this->assertTrue($resetResponse->status() === 302);

        // Verify can login with new password
        $loginResponse = $this->loginWithPhone(password: 'NewPassword456');
        $loginResponse->assertRedirect('/');
        $this->assertUserAuthenticated($user);
    }

    /**
     * Test guest middleware blocks authenticated users from password reset
     */
    public function test_authenticated_user_cannot_request_password_reset(): void
    {
        $user = $this->createUserWithEmail();
        $this->actingAs($user);

        $response = $this->get(route('auth.password.request'));

        $response->assertRedirect('/');
    }

    /**
     * Test password reset fails without OTP verification
     */
    public function test_cannot_reset_password_without_otp_verification(): void
    {
        $user = $this->createUserWithEmail();
        $otp = $this->createResetOtp($user, 'email');

        $this->session(['password_reset' => [
            'email_or_phone' => self::TEST_EMAIL,
            'otp_id' => $otp->id,
            'user_id' => $user->id,
            // Missing otp_verified
        ]]);

        $response = $this->post(route('auth.password.update'), [
            'password' => 'NewPassword123',
            'password_confirmation' => 'NewPassword123',
        ]);

        $response->assertRedirect(route('auth.password.request'));
    }

    /**
     * Test password reset with empty password
     */
    public function test_cannot_reset_password_with_empty_password(): void
    {
        $user = $this->createUserWithEmail();
        $otp = $this->createResetOtp($user, 'email');

        $this->session(['password_reset' => [
            'email_or_phone' => self::TEST_EMAIL,
            'otp_id' => $otp->id,
            'user_id' => $user->id,
            'otp_verified' => true,
        ]]);

        $response = $this->post(route('auth.password.update'), [
            'password' => '',
            'password_confirmation' => '',
        ]);

        $response->assertRedirect(route('auth.password.reset'));
        $response->assertSessionHasErrors(['password']);
    }

    /**
     * Test multiple password reset attempts
     */
    public function test_multiple_password_reset_attempts(): void
    {
        $user = $this->createUserWithEmail();

        // First attempt
        $result1 = $this->startPasswordResetWithEmail();
        $this->resetPassword($result1['otp'], 'Password1');

        // Second attempt (request new reset)
        $result2 = $this->startPasswordResetWithEmail();
        $this->resetPassword($result2['otp'], 'Password2');

        // Should be able to login with latest password
        $loginResponse = $this->loginWithEmail(password: 'Password2');
        $loginResponse->assertRedirect('/');
        $this->assertUserAuthenticated($user);
    }
}
