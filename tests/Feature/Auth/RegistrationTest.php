<?php

namespace Tests\Feature\Auth;

use App\Models\Otp;
use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Support\Facades\Auth;
use Tests\TestCase;

class RegistrationTest extends TestCase
{
    use RefreshDatabase;

    /**
     * Test: Show registration form page
     */
    public function test_show_registration_form(): void
    {
        $response = $this->get(route('auth.register'));

        $response->assertStatus(200);
        $response->assertViewIs('auth.register');
    }

    /**
     * Test: Cannot access registration if already authenticated
     */
    public function test_cannot_access_registration_if_authenticated(): void
    {
        $user = User::factory()->create();

        $this->actingAs($user);

        $response = $this->get(route('auth.register'));

        $response->assertRedirect();
    }

    /**
     * Test: Successful registration initiation with valid email
     */
    public function test_successful_registration_initiation_with_email(): void
    {
        $response = $this->post(route('auth.register'), [
            'email_or_phone' => 'newuser@example.com',
        ]);

        $response->assertRedirect(route('auth.register.verify-otp'));
        $response->assertSessionHas('registration.email_or_phone', 'newuser@example.com');
        $response->assertSessionHas('registration.otp_id');
        $this->assertTrue(session()->has('registration.type'));
    }

    /**
     * Test: Successful registration initiation with valid phone
     */
    public function test_successful_registration_initiation_with_phone(): void
    {
        $response = $this->post(route('auth.register'), [
            'email_or_phone' => '09123456789',
        ]);

        $response->assertRedirect(route('auth.register.verify-otp'));
        $response->assertSessionHas('registration.email_or_phone', '09123456789');
        $response->assertSessionHas('registration.otp_id');
    }

    /**
     * Test: Registration validation - missing email/phone
     */
    public function test_registration_validation_missing_email_or_phone(): void
    {
        $response = $this->post(route('auth.register'), []);

        $response->assertSessionHasErrors('email_or_phone');
    }

    /**
     * Test: Registration validation - invalid email format
     */
    public function test_registration_validation_invalid_email(): void
    {
        $response = $this->post(route('auth.register'), [
            'email_or_phone' => 'invalid-email',
        ]);

        $response->assertSessionHasErrors('email_or_phone');
    }

    /**
     * Test: Registration validation - invalid phone format
     */
    public function test_registration_validation_invalid_phone(): void
    {
        $response = $this->post(route('auth.register'), [
            'email_or_phone' => '1234567890',
        ]);

        $response->assertSessionHasErrors('email_or_phone');
    }

    /**
     * Test: Registration fails with already existing email
     */
    public function test_registration_fails_with_existing_email(): void
    {
        User::factory()->create([
            'email' => 'existing@example.com',
        ]);

        $response = $this->post(route('auth.register'), [
            'email_or_phone' => 'existing@example.com',
        ]);

        $response->assertSessionHasErrors('email_or_phone');
    }

    /**
     * Test: Registration fails with already existing phone
     */
    public function test_registration_fails_with_existing_phone(): void
    {
        User::factory()->create([
            'phone_number' => '09123456789',
        ]);

        $response = $this->post(route('auth.register'), [
            'email_or_phone' => '09123456789',
        ]);

        $response->assertSessionHasErrors('email_or_phone');
    }

    /**
     * Test: Show OTP verification form
     */
    public function test_show_otp_verification_form(): void
    {
        $this->post(route('auth.register'), [
            'email_or_phone' => 'newuser@example.com',
        ]);

        $response = $this->get(route('auth.register.verify-otp'));

        $response->assertStatus(200);
        $response->assertViewIs('auth.verify-otp');
        $response->assertViewHas('email_or_phone', 'newuser@example.com');
    }

    /**
     * Test: Cannot show OTP verification form without registration session
     */
    public function test_cannot_show_otp_form_without_session(): void
    {
        $response = $this->get(route('auth.register.verify-otp'));

        $response->assertRedirect(route('auth.register'));
        $response->assertSessionHas('error');
    }

    /**
     * Test: Verify OTP with correct code
     */
    public function test_verify_otp_with_correct_code(): void
    {
        // Initiate registration
        $this->post(route('auth.register'), [
            'email_or_phone' => 'newuser@example.com',
        ]);

        // Get the OTP code (in local environment it's always '12345')
        $otp = Otp::latest()->first();

        $response = $this->post(route('auth.register.verify-otp'), [
            'code' => $otp->code,
        ]);

        $response->assertRedirect(route('auth.register.complete'));
        $response->assertSessionHas('registration.otp_verified', true);
    }

    /**
     * Test: Verify OTP with incorrect code
     */
    public function test_verify_otp_with_incorrect_code(): void
    {
        // Initiate registration
        $this->post(route('auth.register'), [
            'email_or_phone' => 'newuser@example.com',
        ]);

        $response = $this->post(route('auth.register.verify-otp'), [
            'code' => 'wrongcode',
        ]);

        $response->assertRedirect();
        $response->assertSessionHas('error');
    }

    /**
     * Test: Cannot verify OTP without registration session
     */
    public function test_cannot_verify_otp_without_session(): void
    {
        $response = $this->post(route('auth.register.verify-otp'), [
            'code' => '12345',
        ]);

        $response->assertSessionHasErrors();
    }

    /**
     * Test: Show registration completion form
     */
    public function test_show_registration_completion_form(): void
    {
        // Initiate and verify OTP
        $this->post(route('auth.register'), [
            'email_or_phone' => 'newuser@example.com',
        ]);

        $otp = Otp::latest()->first();

        $this->post(route('auth.register.verify-otp'), [
            'code' => $otp->code,
        ]);

        $response = $this->get(route('auth.register.complete'));

        $response->assertStatus(200);
        $response->assertViewIs('auth.complete-registration');
        $response->assertViewHas('email_or_phone', 'newuser@example.com');
    }

    /**
     * Test: Cannot show completion form without OTP verification
     */
    public function test_cannot_show_completion_form_without_otp_verification(): void
    {
        $this->post(route('auth.register'), [
            'email_or_phone' => 'newuser@example.com',
        ]);

        $response = $this->get(route('auth.register.complete'));

        $response->assertRedirect(route('auth.register'));
        $response->assertSessionHas('error');
    }

    /**
     * Test: Complete registration with valid password
     */
    public function test_complete_registration_with_valid_password(): void
    {
        // Initiate and verify OTP
        $this->post(route('auth.register'), [
            'email_or_phone' => 'newuser@example.com',
        ]);

        $otp = Otp::latest()->first();

        $this->post(route('auth.register.verify-otp'), [
            'code' => $otp->code,
        ]);

        $response = $this->post(route('auth.register.complete'), [
            'first_name' => 'John',
            'last_name' => 'Doe',
            'password' => 'SecurePassword123',
            'password_confirmation' => 'SecurePassword123',
        ]);

        $response->assertRedirect('/');

        // Verify user was created
        $user = User::where('email', 'newuser@example.com')->first();
        $this->assertNotNull($user);
        $this->assertEquals('John', $user->first_name);
        $this->assertEquals('Doe', $user->last_name);

        // Verify user is authenticated
        $this->assertAuthenticatedAs($user);
    }

    /**
     * Test: Complete registration - password too short
     */
    public function test_complete_registration_password_too_short(): void
    {
        // Initiate and verify OTP
        $this->post(route('auth.register'), [
            'email_or_phone' => 'newuser@example.com',
        ]);

        $otp = Otp::latest()->first();

        $this->post(route('auth.register.verify-otp'), [
            'code' => $otp->code,
        ]);

        $response = $this->post(route('auth.register.complete'), [
            'first_name' => 'John',
            'last_name' => 'Doe',
            'password' => 'short',
            'password_confirmation' => 'short',
        ]);

        $response->assertSessionHasErrors('password');
        $this->assertGuest();
    }

    /**
     * Test: Complete registration - password confirmation mismatch
     */
    public function test_complete_registration_password_mismatch(): void
    {
        // Initiate and verify OTP
        $this->post(route('auth.register'), [
            'email_or_phone' => 'newuser@example.com',
        ]);

        $otp = Otp::latest()->first();

        $this->post(route('auth.register.verify-otp'), [
            'code' => $otp->code,
        ]);

        $response = $this->post(route('auth.register.complete'), [
            'first_name' => 'John',
            'last_name' => 'Doe',
            'password' => 'SecurePassword123',
            'password_confirmation' => 'DifferentPassword',
        ]);

        $response->assertSessionHasErrors('password');
        $this->assertGuest();
    }

    /**
     * Test: Cannot complete registration without OTP verification
     */
    public function test_cannot_complete_registration_without_otp_verification(): void
    {
        $this->post(route('auth.register'), [
            'email_or_phone' => 'newuser@example.com',
        ]);

        $response = $this->post(route('auth.register.complete'), [
            'first_name' => 'John',
            'last_name' => 'Doe',
            'password' => 'SecurePassword123',
            'password_confirmation' => 'SecurePassword123',
        ]);

        $response->assertSessionHasErrors();
    }

    /**
     * Test: User is auto-logged in after successful registration
     */
    public function test_user_auto_login_after_registration(): void
    {
        // Initiate and verify OTP
        $this->post(route('auth.register'), [
            'email_or_phone' => 'newuser@example.com',
        ]);

        $otp = Otp::latest()->first();

        $this->post(route('auth.register.verify-otp'), [
            'code' => $otp->code,
        ]);

        $this->post(route('auth.register.complete'), [
            'password' => 'SecurePassword123',
            'password_confirmation' => 'SecurePassword123',
        ]);

        // Check if user is authenticated
        $this->assertTrue(Auth::check());
    }

    /**
     * Test: Registration session is cleared after completion
     */
    public function test_registration_session_cleared_after_completion(): void
    {
        // Initiate and verify OTP
        $this->post(route('auth.register'), [
            'email_or_phone' => 'newuser@example.com',
        ]);

        $otp = Otp::latest()->first();

        $this->post(route('auth.register.verify-otp'), [
            'code' => $otp->code,
        ]);

        $this->post(route('auth.register.complete'), [
            'password' => 'SecurePassword123',
            'password_confirmation' => 'SecurePassword123',
        ]);

        // Session should be cleared
        $this->assertFalse(session()->has('registration.email_or_phone'));
        $this->assertFalse(session()->has('registration.otp_id'));
    }

    /**
     * Test: Resend OTP
     */
    public function test_resend_otp(): void
    {
        // Initiate registration
        $response = $this->post(route('auth.register'), [
            'email_or_phone' => 'newuser@example.com',
        ]);

        $otpId = session('registration.otp_id');

        // Resend OTP
        $response = $this->postJson(route('auth.register.resend-otp'), [
            'otp_id' => $otpId,
        ]);

        $response->assertStatus(200);
        $response->assertJsonStructure(['data', 'message']);
    }

    /**
     * Test: Resend OTP with invalid OTP ID
     */
    public function test_resend_otp_with_invalid_id(): void
    {
        $response = $this->postJson(route('auth.register.resend-otp'), [
            'otp_id' => 99999,
        ]);

        $response->assertStatus(404);
    }

    /**
     * Test: JSON response on successful registration initiation
     */
    public function test_json_response_on_successful_registration(): void
    {
        $response = $this->postJson(route('auth.register'), [
            'email_or_phone' => 'newuser@example.com',
        ]);

        $response->assertStatus(200);
        $response->assertJsonStructure(['data', 'message']);
        $this->assertTrue($response->json('data.success'));
    }

    /**
     * Test: JSON error response on invalid email
     */
    public function test_json_error_response_on_invalid_email(): void
    {
        $response = $this->postJson(route('auth.register'), [
            'email_or_phone' => 'invalid-email',
        ]);

        $response->assertStatus(422);
        $response->assertJsonStructure(['message', 'errors']);
    }

    /**
     * Test: Complete registration with phone number
     */
    public function test_complete_registration_with_phone(): void
    {
        // Initiate and verify OTP with phone
        $this->post(route('auth.register'), [
            'email_or_phone' => '09123456789',
        ]);

        $otp = Otp::latest()->first();

        $this->post(route('auth.register.verify-otp'), [
            'code' => $otp->code,
        ]);

        $response = $this->post(route('auth.register.complete'), [
            'first_name' => 'John',
            'last_name' => 'Doe',
            'country_code' => '+98',
            'password' => 'SecurePassword123',
            'password_confirmation' => 'SecurePassword123',
        ]);

        $response->assertRedirect('/');

        // Verify user was created with phone
        $user = User::where('phone_number', '09123456789')->first();
        $this->assertNotNull($user);
        $this->assertEquals('John', $user->first_name);
    }

    /**
     * Test: Registration with optional fields (first_name, last_name)
     */
    public function test_registration_with_optional_fields(): void
    {
        // Initiate and verify OTP
        $this->post(route('auth.register'), [
            'email_or_phone' => 'user3@example.com',
        ]);

        $otp = Otp::latest()->first();

        $this->post(route('auth.register.verify-otp'), [
            'code' => $otp->code,
        ]);

        // Complete without optional fields
        $response = $this->post(route('auth.register.complete'), [
            'password' => 'SecurePassword123',
            'password_confirmation' => 'SecurePassword123',
        ]);

        $response->assertRedirect('/');

        $user = User::where('email', 'user3@example.com')->first();
        $this->assertNotNull($user);
    }

    /**
     * Test: OTP code validation
     */
    public function test_otp_verification_with_wrong_code(): void
    {
        // Initiate registration
        $this->post(route('auth.register'), [
            'email_or_phone' => 'user4@example.com',
        ]);

        // Try wrong code - should show error
        $response = $this->post(route('auth.register.verify-otp'), [
            'code' => 'wrong123',
        ]);

        $response->assertRedirect();
        $response->assertSessionHas('error');
    }

    /**
     * Test: Successfully register multiple different users in separate flows
     */
    public function test_register_second_user_after_first(): void
    {
        // First user completes registration
        $this->post(route('auth.register'), [
            'email_or_phone' => 'firstuser@example.com',
        ]);

        $otp1 = Otp::latest()->first();

        $this->post(route('auth.register.verify-otp'), [
            'code' => $otp1->code,
        ]);

        $this->post(route('auth.register.complete'), [
            'password' => 'SecurePassword123',
            'password_confirmation' => 'SecurePassword123',
        ]);

        // Verify first user exists
        $this->assertTrue(User::where('email', 'firstuser@example.com')->exists());
    }

}
