<?php

namespace Tests\Feature\Auth;

use App\Models\Otp;
use App\Models\User;

class RegisterTest extends AuthTestCase
{
    /**
     * Test showing registration form
     */
    public function test_can_view_registration_form(): void
    {
        $response = $this->get(route('auth.register'));

        $response->assertStatus(200);
        $response->assertViewIs('auth.register');
    }

    /**
     * Test starting registration with valid email
     */
    public function test_can_start_registration_with_email(): void
    {
        $email = 'newuser@example.com';

        $response = $this->post(route('auth.register'), [
            'email_or_phone' => $email,
        ]);

        $response->assertRedirect(route('auth.register.verify-otp'));
        $this->assertSessionHas('registration.email_or_phone', $email);
        $this->assertSessionHas('registration.type', 'email');

        // Check OTP was created
        $this->assertDatabaseHas('otps', [
            'code' => '12345',
            'type' => 'email',
            'user_id' => null,
        ]);
    }

    /**
     * Test starting registration with valid phone
     */
    public function test_can_start_registration_with_phone(): void
    {
        $phone = '09123456789';

        $response = $this->post(route('auth.register'), [
            'email_or_phone' => $phone,
        ]);

        $response->assertRedirect(route('auth.register.verify-otp'));
        $this->assertSessionHas('registration.email_or_phone', $phone);
        $this->assertSessionHas('registration.type', 'sms');

        // Check OTP was created
        $this->assertDatabaseHas('otps', [
            'code' => '12345',
            'type' => 'sms',
            'user_id' => null,
        ]);
    }

    /**
     * Test registration fails with existing email
     */
    public function test_cannot_register_with_existing_email(): void
    {
        $this->createUserWithEmail();

        $response = $this->post(route('auth.register'), [
            'email_or_phone' => self::TEST_EMAIL,
        ]);

        $response->assertRedirect(route('auth.register'));
        $response->assertSessionHasErrors(['email_or_phone']);
    }

    /**
     * Test registration fails with existing phone
     */
    public function test_cannot_register_with_existing_phone(): void
    {
        $this->createUserWithPhone();

        $response = $this->post(route('auth.register'), [
            'email_or_phone' => self::TEST_PHONE,
        ]);

        $response->assertRedirect(route('auth.register'));
        $response->assertSessionHasErrors(['email_or_phone']);
    }

    /**
     * Test registration fails with invalid email format
     */
    public function test_cannot_register_with_invalid_email_format(): void
    {
        $response = $this->post(route('auth.register'), [
            'email_or_phone' => 'invalid-email',
        ]);

        $response->assertRedirect(route('auth.register'));
        $response->assertSessionHasErrors(['email_or_phone']);
    }

    /**
     * Test registration fails with invalid phone format
     */
    public function test_cannot_register_with_invalid_phone_format(): void
    {
        $response = $this->post(route('auth.register'), [
            'email_or_phone' => '1234567890',
        ]);

        $response->assertRedirect(route('auth.register'));
        $response->assertSessionHasErrors(['email_or_phone']);
    }

    /**
     * Test registration fails with empty input
     */
    public function test_cannot_register_with_empty_input(): void
    {
        $response = $this->post(route('auth.register'), [
            'email_or_phone' => '',
        ]);

        $response->assertRedirect(route('auth.register'));
        $response->assertSessionHasErrors(['email_or_phone']);
    }

    /**
     * Test showing verify OTP form
     */
    public function test_can_view_verify_otp_form(): void
    {
        $result = $this->startEmailRegistration();

        $response = $this->get(route('auth.register.verify-otp'));

        $response->assertStatus(200);
        $response->assertViewIs('auth.verify-otp');
    }

    /**
     * Test verifying OTP with correct code
     */
    public function test_can_verify_registration_otp_with_correct_code(): void
    {
        $result = $this->startEmailRegistration();
        $otp = $result['otp'];

        $response = $this->verifyRegistrationOtp($otp);

        $response->assertRedirect(route('auth.register.complete'));
        $this->assertSessionHas('registration.otp_verified', true);
    }

    /**
     * Test verifying OTP with incorrect code
     */
    public function test_cannot_verify_registration_otp_with_incorrect_code(): void
    {
        $result = $this->startEmailRegistration();
        $otp = $result['otp'];

        $response = $this->verifyRegistrationOtp($otp, self::INVALID_OTP);

        $response->assertRedirect(route('auth.register.verify-otp'));
        $response->assertSessionHasErrors(['code']);

        // Check attempts incremented
        $otp->refresh();
        $this->assertEquals(1, $otp->attempts);
    }

    /**
     * Test verification fails with expired OTP
     */
    public function test_cannot_verify_expired_otp(): void
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
     * Test verification fails with already used OTP
     */
    public function test_cannot_verify_already_used_otp(): void
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
     * Test showing complete registration form
     */
    public function test_can_view_complete_registration_form(): void
    {
        $result = $this->startEmailRegistration();
        $otp = $result['otp'];
        $this->verifyRegistrationOtp($otp);

        $response = $this->get(route('auth.register.complete'));

        $response->assertStatus(200);
        $response->assertViewIs('auth.complete-registration');
    }

    /**
     * Test completing registration with valid password
     */
    public function test_can_complete_registration_with_valid_password(): void
    {
        $result = $this->startEmailRegistration();
        $otp = $result['otp'];
        $this->verifyRegistrationOtp($otp);

        $response = $this->completeRegistration($otp);

        $response->assertRedirect('/');
        $this->assertUserAuthenticated(User::where('email', self::TEST_EMAIL)->first());

        // Check user was created
        $this->assertUserExists([
            'email' => self::TEST_EMAIL,
            'is_active' => true,
        ]);
    }

    /**
     * Test completing registration with password too short
     */
    public function test_cannot_complete_registration_with_short_password(): void
    {
        $result = $this->startEmailRegistration();
        $otp = $result['otp'];
        $this->verifyRegistrationOtp($otp);

        $response = $this->completeRegistration($otp, 'short');

        $response->assertRedirect(route('auth.register.complete'));
        $response->assertSessionHasErrors(['password']);
    }

    /**
     * Test completing registration with mismatched passwords
     */
    public function test_cannot_complete_registration_with_mismatched_passwords(): void
    {
        $result = $this->startEmailRegistration();
        $otp = $result['otp'];
        $this->verifyRegistrationOtp($otp);

        $this->session(['registration' => [
            'email_or_phone' => self::TEST_EMAIL,
            'otp_id' => $otp->id,
            'type' => 'email',
            'otp_verified' => true,
        ]]);

        $response = $this->post(route('auth.register.complete'), [
            'password' => 'SecurePassword123',
            'password_confirmation' => 'DifferentPassword123',
        ]);

        $response->assertRedirect(route('auth.register.complete'));
        $response->assertSessionHasErrors(['password']);
    }

    /**
     * Test complete email registration flow
     */
    public function test_complete_email_registration_flow(): void
    {
        // Step 1: Start registration
        $result = $this->startEmailRegistration();
        $this->assertTrue($result['response']->status() === 302);
        $this->assertNotNull($result['otp']);

        // Step 2: Verify OTP
        $verifyResponse = $this->verifyRegistrationOtp($result['otp']);
        $this->assertTrue($verifyResponse->status() === 302);

        // Step 3: Complete registration
        $completeResponse = $this->completeRegistration($result['otp']);
        $this->assertTrue($completeResponse->status() === 302);

        // Verify user is created and authenticated
        $user = User::where('email', self::TEST_EMAIL)->first();
        $this->assertNotNull($user);
        $this->assertTrue($user->is_active);
        $this->assertUserAuthenticated($user);
    }

    /**
     * Test complete phone registration flow
     */
    public function test_complete_phone_registration_flow(): void
    {
        // Step 1: Start registration
        $result = $this->startPhoneRegistration();
        $this->assertTrue($result['response']->status() === 302);
        $this->assertNotNull($result['otp']);

        // Step 2: Verify OTP
        $this->session(['registration' => [
            'email_or_phone' => self::TEST_PHONE,
            'otp_id' => $result['otp']->id,
            'type' => 'sms',
        ]]);

        $verifyResponse = $this->post(route('auth.register.verify-otp'), [
            'code' => '12345',
        ]);
        $this->assertTrue($verifyResponse->status() === 302);

        // Step 3: Complete registration
        $this->session(['registration' => [
            'email_or_phone' => self::TEST_PHONE,
            'otp_id' => $result['otp']->id,
            'type' => 'sms',
            'otp_verified' => true,
        ]]);

        $completeResponse = $this->post(route('auth.register.complete'), [
            'password' => self::TEST_PASSWORD,
            'password_confirmation' => self::TEST_PASSWORD,
            'first_name' => 'Test',
            'last_name' => 'User',
        ]);
        $this->assertTrue($completeResponse->status() === 302);

        // Verify user is created with phone and authenticated
        $user = User::where('phone_number', self::TEST_PHONE)->first();
        $this->assertNotNull($user);
        $this->assertTrue($user->is_active);
        $this->assertUserAuthenticated($user);
    }

    /**
     * Test guest middleware blocks authenticated users
     */
    public function test_authenticated_user_cannot_access_register_page(): void
    {
        $user = $this->createUserWithEmail();
        $this->actingAs($user);

        $response = $this->get(route('auth.register'));

        $response->assertRedirect('/');
    }

    /**
     * Test clearing registration session on completion
     */
    public function test_registration_session_cleared_on_completion(): void
    {
        $result = $this->startEmailRegistration();
        $otp = $result['otp'];
        $this->verifyRegistrationOtp($otp);
        $this->completeRegistration($otp);

        // After completion, session should be cleared
        $this->assertSessionMissing('registration');
    }
}
