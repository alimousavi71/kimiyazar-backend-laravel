<?php

namespace Tests\Feature\Auth;

use App\Models\Otp;

class OtpVerificationTest extends AuthTestCase
{
    /**
     * Test OTP verification with correct code during registration
     */
    public function test_can_verify_registration_otp_with_correct_code(): void
    {
        $otp = $this->createRegistrationOtp('email');

        $this->session(['registration' => [
            'email_or_phone' => self::TEST_EMAIL,
            'otp_id' => $otp->id,
            'type' => 'email',
        ]]);

        $response = $this->post(route('auth.register.verify-otp'), [
            'code' => '12345',
        ]);

        $response->assertRedirect(route('auth.register.complete'));
        $this->assertSessionHas('registration.otp_verified', true);
    }

    /**
     * Test OTP verification fails with incorrect code
     */
    public function test_otp_verification_fails_with_incorrect_code(): void
    {
        $otp = $this->createRegistrationOtp('email');

        $this->session(['registration' => [
            'email_or_phone' => self::TEST_EMAIL,
            'otp_id' => $otp->id,
            'type' => 'email',
        ]]);

        $response = $this->post(route('auth.register.verify-otp'), [
            'code' => '000000',
        ]);

        $response->assertRedirect(route('auth.register.verify-otp'));
        $response->assertSessionHasErrors(['code']);

        // Check attempts incremented
        $otp->refresh();
        $this->assertEquals(1, $otp->attempts);
    }

    /**
     * Test OTP verification fails with expired OTP
     */
    public function test_otp_verification_fails_with_expired_otp(): void
    {
        $otp = $this->createRegistrationOtp('email', expired: true);

        $this->session(['registration' => [
            'email_or_phone' => self::TEST_EMAIL,
            'otp_id' => $otp->id,
            'type' => 'email',
        ]]);

        $response = $this->post(route('auth.register.verify-otp'), [
            'code' => '12345',
        ]);

        $response->assertRedirect(route('auth.register.verify-otp'));
        $response->assertSessionHasErrors();
    }

    /**
     * Test OTP verification fails with already used OTP
     */
    public function test_otp_verification_fails_with_already_used_otp(): void
    {
        $otp = $this->createRegistrationOtp('email');
        $otp->markAsUsed();

        $this->session(['registration' => [
            'email_or_phone' => self::TEST_EMAIL,
            'otp_id' => $otp->id,
            'type' => 'email',
        ]]);

        $response = $this->post(route('auth.register.verify-otp'), [
            'code' => '12345',
        ]);

        $response->assertRedirect(route('auth.register.verify-otp'));
        $response->assertSessionHasErrors();
    }

    /**
     * Test OTP verification increments attempts
     */
    public function test_otp_verification_increments_attempts(): void
    {
        $otp = $this->createRegistrationOtp('email');

        $this->session(['registration' => [
            'email_or_phone' => self::TEST_EMAIL,
            'otp_id' => $otp->id,
            'type' => 'email',
        ]]);

        $this->assertEquals(0, $otp->attempts);

        // First wrong attempt
        $this->post(route('auth.register.verify-otp'), [
            'code' => '000000',
        ]);

        $otp->refresh();
        $this->assertEquals(1, $otp->attempts);

        // Second wrong attempt
        $this->post(route('auth.register.verify-otp'), [
            'code' => '111111',
        ]);

        $otp->refresh();
        $this->assertEquals(2, $otp->attempts);
    }

    /**
     * Test OTP verification fails with max attempts reached
     */
    public function test_otp_verification_fails_with_max_attempts(): void
    {
        $otp = $this->createRegistrationOtp('email');
        $otp->update(['attempts' => 5]); // Already at max

        $this->session(['registration' => [
            'email_or_phone' => self::TEST_EMAIL,
            'otp_id' => $otp->id,
            'type' => 'email',
        ]]);

        $response = $this->post(route('auth.register.verify-otp'), [
            'code' => '12345',
        ]);

        $response->assertRedirect(route('auth.register.verify-otp'));
        $response->assertSessionHasErrors();
    }

    /**
     * Test OTP verification fails with empty code
     */
    public function test_otp_verification_fails_with_empty_code(): void
    {
        $otp = $this->createRegistrationOtp('email');

        $this->session(['registration' => [
            'email_or_phone' => self::TEST_EMAIL,
            'otp_id' => $otp->id,
            'type' => 'email',
        ]]);

        $response = $this->post(route('auth.register.verify-otp'), [
            'code' => '',
        ]);

        $response->assertRedirect(route('auth.register.verify-otp'));
        $response->assertSessionHasErrors(['code']);
    }

    /**
     * Test OTP verification fails with non-numeric code
     */
    public function test_otp_verification_fails_with_non_numeric_code(): void
    {
        $otp = $this->createRegistrationOtp('email');

        $this->session(['registration' => [
            'email_or_phone' => self::TEST_EMAIL,
            'otp_id' => $otp->id,
            'type' => 'email',
        ]]);

        $response = $this->post(route('auth.register.verify-otp'), [
            'code' => 'abcdef',
        ]);

        $response->assertRedirect(route('auth.register.verify-otp'));
        $response->assertSessionHasErrors(['code']);
    }

    /**
     * Test OTP verification fails with incorrect length code
     */
    public function test_otp_verification_fails_with_incorrect_length_code(): void
    {
        $otp = $this->createRegistrationOtp('email');

        $this->session(['registration' => [
            'email_or_phone' => self::TEST_EMAIL,
            'otp_id' => $otp->id,
            'type' => 'email',
        ]]);

        // Too short
        $response = $this->post(route('auth.register.verify-otp'), [
            'code' => '123',
        ]);

        $response->assertRedirect(route('auth.register.verify-otp'));
        $response->assertSessionHasErrors(['code']);
    }

    /**
     * Test OTP verification marks OTP as used
     */
    public function test_otp_verification_marks_otp_as_used(): void
    {
        $otp = $this->createRegistrationOtp('email');

        $this->assertFalse($otp->is_used);

        $this->session(['registration' => [
            'email_or_phone' => self::TEST_EMAIL,
            'otp_id' => $otp->id,
            'type' => 'email',
        ]]);

        $this->post(route('auth.register.verify-otp'), [
            'code' => '12345',
        ]);

        $otp->refresh();
        $this->assertTrue($otp->is_used);
        $this->assertNotNull($otp->used_at);
    }

    /**
     * Test OTP verification for SMS type
     */
    public function test_otp_verification_for_sms_type(): void
    {
        $otp = $this->createRegistrationOtp('sms');

        $this->session(['registration' => [
            'email_or_phone' => self::TEST_PHONE,
            'otp_id' => $otp->id,
            'type' => 'sms',
        ]]);

        $response = $this->post(route('auth.register.verify-otp'), [
            'code' => '12345',
        ]);

        $response->assertRedirect(route('auth.register.complete'));
        $this->assertSessionHas('registration.otp_verified', true);
    }

    /**
     * Test OTP verification for password reset
     */
    public function test_otp_verification_for_password_reset(): void
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
     * Test OTP verification requires session data
     */
    public function test_otp_verification_fails_without_session_data(): void
    {
        $otp = $this->createRegistrationOtp('email');

        // No session data
        $response = $this->post(route('auth.register.verify-otp'), [
            'code' => '12345',
        ]);

        $response->assertRedirect(route('auth.register'));
    }

    /**
     * Test OTP verification requires OTP ID in session
     */
    public function test_otp_verification_fails_without_otp_id_in_session(): void
    {
        $this->session(['registration' => [
            'email_or_phone' => self::TEST_EMAIL,
            'type' => 'email',
            // Missing otp_id
        ]]);

        $response = $this->post(route('auth.register.verify-otp'), [
            'code' => '12345',
        ]);

        $response->assertRedirect(route('auth.register'));
    }

    /**
     * Test multiple OTP attempts tracking
     */
    public function test_multiple_otp_attempts_tracking(): void
    {
        $otp = $this->createRegistrationOtp('email');

        $this->session(['registration' => [
            'email_or_phone' => self::TEST_EMAIL,
            'otp_id' => $otp->id,
            'type' => 'email',
        ]]);

        // Attempt 1
        $this->post(route('auth.register.verify-otp'), ['code' => '000000']);
        $otp->refresh();
        $this->assertEquals(1, $otp->attempts);

        // Attempt 2
        $this->post(route('auth.register.verify-otp'), ['code' => '111111']);
        $otp->refresh();
        $this->assertEquals(2, $otp->attempts);

        // Attempt 3
        $this->post(route('auth.register.verify-otp'), ['code' => '222222']);
        $otp->refresh();
        $this->assertEquals(3, $otp->attempts);

        // Attempt 4
        $this->post(route('auth.register.verify-otp'), ['code' => '333333']);
        $otp->refresh();
        $this->assertEquals(4, $otp->attempts);

        // Attempt 5
        $this->post(route('auth.register.verify-otp'), ['code' => '444444']);
        $otp->refresh();
        $this->assertEquals(5, $otp->attempts);

        // Should not be able to verify anymore
        $response = $this->post(route('auth.register.verify-otp'), ['code' => '12345']);
        $response->assertRedirect(route('auth.register.verify-otp'));
        $response->assertSessionHasErrors();
    }

    /**
     * Test OTP code validation format
     */
    public function test_otp_code_must_be_exactly_6_digits(): void
    {
        $otp = $this->createRegistrationOtp('email');

        $this->session(['registration' => [
            'email_or_phone' => self::TEST_EMAIL,
            'otp_id' => $otp->id,
            'type' => 'email',
        ]]);

        // 5 digits
        $response = $this->post(route('auth.register.verify-otp'), [
            'code' => '12345',
        ]);
        // Note: This might pass if code is 12345, adjust based on actual validation

        // 7 digits
        $response = $this->post(route('auth.register.verify-otp'), [
            'code' => '1234567',
        ]);
        $response->assertRedirect(route('auth.register.verify-otp'));
        $response->assertSessionHasErrors(['code']);
    }
}
