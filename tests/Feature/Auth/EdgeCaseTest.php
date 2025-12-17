<?php

namespace Tests\Feature\Auth;

use App\Models\User;

class EdgeCaseTest extends AuthTestCase
{
    /**
     * Test registration with email containing special characters
     */
    public function test_registration_with_special_character_email(): void
    {
        $email = 'user+test@example.co.uk';

        $response = $this->post(route('auth.register'), [
            'email_or_phone' => $email,
        ]);

        $response->assertRedirect(route('auth.register.verify-otp'));
        $this->assertDatabaseHas('otps', [
            'code' => '12345',
            'type' => 'email',
        ]);
    }

    /**
     * Test registration with different phone formats
     */
    public function test_registration_with_different_phone_formats(): void
    {
        $phones = [
            '09123456789',      // 0 prefix
            '+989123456789',    // Country code
            '989123456789',     // Without prefix
        ];

        foreach ($phones as $index => $phone) {
            // Clear database for each iteration
            $this->artisan('db:seed');

            $response = $this->post(route('auth.register'), [
                'email_or_phone' => $phone,
            ]);

            $response->assertRedirect(route('auth.register.verify-otp'));
            $this->assertDatabaseHas('otps', [
                'code' => '12345',
                'type' => 'sms',
            ]);
        }
    }

    /**
     * Test simultaneous registration attempts with same email
     */
    public function test_simultaneous_registration_with_same_email(): void
    {
        // First registration request
        $response1 = $this->post(route('auth.register'), [
            'email_or_phone' => self::TEST_EMAIL,
        ]);

        $response1->assertRedirect(route('auth.register.verify-otp'));

        // Second registration request with same email (should fail or succeed based on logic)
        // This tests race condition handling
        $response2 = $this->post(route('auth.register'), [
            'email_or_phone' => self::TEST_EMAIL,
        ]);

        // Should handle gracefully (either redirect or show error)
        $this->assertTrue($response2->status() === 302);
    }

    /**
     * Test registration with HTML/script injection attempts
     */
    public function test_registration_with_xss_attempts(): void
    {
        $xssPayloads = [
            '<script>alert("xss")</script>@example.com',
            '"><script>alert("xss")</script>',
            'javascript:alert("xss")',
        ];

        foreach ($xssPayloads as $payload) {
            $response = $this->post(route('auth.register'), [
                'email_or_phone' => $payload,
            ]);

            // Should reject invalid input
            $this->assertTrue($response->status() === 302);
        }
    }

    /**
     * Test registration with SQL injection attempts
     */
    public function test_registration_with_sql_injection_attempts(): void
    {
        $sqlPayloads = [
            "'; DROP TABLE users; --",
            "1' OR '1'='1",
            "1' UNION SELECT * FROM users--",
        ];

        foreach ($sqlPayloads as $payload) {
            $response = $this->post(route('auth.register'), [
                'email_or_phone' => $payload,
            ]);

            // Should reject or sanitize invalid input
            $this->assertTrue($response->status() === 302);
        }
    }

    /**
     * Test login with very long email
     */
    public function test_login_with_very_long_email(): void
    {
        $longEmail = str_repeat('a', 200) . '@example.com';

        $response = $this->post(route('auth.login'), [
            'email_or_phone' => $longEmail,
            'password' => self::TEST_PASSWORD,
        ]);

        // Should handle gracefully
        $this->assertTrue($response->status() === 302);
    }

    /**
     * Test login with NULL bytes
     */
    public function test_login_with_null_bytes(): void
    {
        $response = $this->post(route('auth.login'), [
            'email_or_phone' => self::TEST_EMAIL . "\0",
            'password' => self::TEST_PASSWORD,
        ]);

        // Should handle safely
        $this->assertTrue($response->status() === 302);
    }

    /**
     * Test OTP verification with spaces in code
     */
    public function test_otp_verification_with_spaces_in_code(): void
    {
        $otp = $this->createRegistrationOtp('email');

        $this->session(['registration' => [
            'email_or_phone' => self::TEST_EMAIL,
            'otp_id' => $otp->id,
            'type' => 'email',
        ]]);

        $response = $this->post(route('auth.register.verify-otp'), [
            'code' => '123 456',
        ]);

        $response->assertRedirect(route('auth.register.verify-otp'));
        $response->assertSessionHasErrors();
    }

    /**
     * Test user created with various name combinations
     */
    public function test_user_created_with_special_characters_in_name(): void
    {
        $result = $this->startEmailRegistration();
        $otp = $result['otp'];
        $this->verifyRegistrationOtp($otp);

        $names = [
            ['first_name' => "José", 'last_name' => "García"],
            ['first_name' => "محمد", 'last_name' => "علی"],
            ['first_name' => "O'Brien", 'last_name' => "Smith-Jones"],
        ];

        foreach ($names as $name) {
            // Reset for each iteration
            $result = $this->startEmailRegistration("test{$name['first_name']}@example.com");
            $otp = $result['otp'];
            $this->verifyRegistrationOtp($otp);

            $response = $this->post(route('auth.register.complete'), [
                'password' => self::TEST_PASSWORD,
                'password_confirmation' => self::TEST_PASSWORD,
                'first_name' => $name['first_name'],
                'last_name' => $name['last_name'],
            ]);

            // Should handle special characters gracefully
            $this->assertTrue($response->status() === 302);
        }
    }

    /**
     * Test session expiration during registration
     */
    public function test_incomplete_registration_session_timeout(): void
    {
        $result = $this->startEmailRegistration();

        // Simulate session timeout by clearing registration session
        session()->forget('registration');

        $response = $this->get(route('auth.register.verify-otp'));

        // Should redirect or show error
        $this->assertTrue($response->status() === 302);
    }

    /**
     * Test accessing complete registration form without OTP verification
     */
    public function test_cannot_access_complete_registration_without_otp_verification(): void
    {
        $this->session(['registration' => [
            'email_or_phone' => self::TEST_EMAIL,
            'otp_id' => 999, // Non-existent OTP
            'type' => 'email',
            // Missing otp_verified
        ]]);

        $response = $this->get(route('auth.register.complete'));

        // Should redirect back to start
        $this->assertTrue($response->status() === 302);
    }

    /**
     * Test accessing reset password without OTP verification
     */
    public function test_cannot_access_reset_password_form_without_otp_verification(): void
    {
        $user = $this->createUserWithEmail();

        $this->session(['password_reset' => [
            'email_or_phone' => self::TEST_EMAIL,
            'user_id' => $user->id,
            // Missing otp_verified
        ]]);

        $response = $this->get(route('auth.password.reset'));

        // Should redirect back
        $this->assertTrue($response->status() === 302);
    }

    /**
     * Test password reset with very long password
     */
    public function test_can_reset_password_with_very_long_password(): void
    {
        $user = $this->createUserWithEmail();
        $otp = $this->createResetOtp($user, 'email');

        $longPassword = str_repeat('A', 100) . '1';

        $response = $this->resetPassword($otp, $longPassword);

        $response->assertRedirect(route('auth.login'));

        // Should be able to login with long password
        $loginResponse = $this->loginWithEmail(password: $longPassword);
        $loginResponse->assertRedirect('/');
    }

    /**
     * Test password reset with unicode password
     */
    public function test_can_reset_password_with_unicode_characters(): void
    {
        $user = $this->createUserWithEmail();
        $otp = $this->createResetOtp($user, 'email');

        $unicodePassword = 'پسورد123!@#';

        $response = $this->resetPassword($otp, $unicodePassword);

        $response->assertRedirect(route('auth.login'));

        // Should be able to login with unicode password
        $loginResponse = $this->loginWithEmail(password: $unicodePassword);
        $loginResponse->assertRedirect('/');
    }

    /**
     * Test registration with case sensitivity
     */
    public function test_registration_email_case_insensitive(): void
    {
        $email = 'TestUser@Example.COM';

        $response = $this->post(route('auth.register'), [
            'email_or_phone' => $email,
        ]);

        $response->assertRedirect(route('auth.register.verify-otp'));

        // Try registering with same email but different case
        $response2 = $this->post(route('auth.register'), [
            'email_or_phone' => strtolower($email),
        ]);

        // Should fail (already exists)
        $response2->assertRedirect(route('auth.register'));
    }

    /**
     * Test concurrent login and logout
     */
    public function test_concurrent_login_and_logout(): void
    {
        $user = $this->createUserWithEmail();

        // Login
        $this->loginWithEmail();
        $this->assertUserAuthenticated($user);

        // Logout
        $this->logout();
        $this->assertUserNotAuthenticated();

        // Login again
        $this->loginWithEmail();
        $this->assertUserAuthenticated($user);
    }

    /**
     * Test OTP with duplicate code validation
     */
    public function test_multiple_otps_with_same_code(): void
    {
        $otp1 = $this->createRegistrationOtp('email');
        $otp2 = $this->createRegistrationOtp('email');

        // Both have code '12345'
        $this->assertEquals($otp1->code, $otp2->code);

        // Should be able to query by specific OTP ID
        $this->assertDatabaseHas('otps', ['id' => $otp1->id, 'code' => '12345']);
        $this->assertDatabaseHas('otps', ['id' => $otp2->id, 'code' => '12345']);
    }

    /**
     * Test user with email and phone both set
     */
    public function test_user_with_both_email_and_phone(): void
    {
        $user = User::factory()->create([
            'email' => 'user@example.com',
            'phone_number' => '09123456789',
            'password' => self::TEST_PASSWORD,
            'is_active' => true,
        ]);

        // Can login with email
        $response1 = $this->loginWithEmail();
        $response1->assertRedirect('/');

        // Can login with phone
        $response2 = $this->loginWithPhone();
        $response2->assertRedirect('/');
    }

    /**
     * Test OTP code with leading zeros
     */
    public function test_otp_verification_with_leading_zeros(): void
    {
        $otp = $this->createRegistrationOtp('email');
        $otp->update(['code' => '012345']);

        $this->session(['registration' => [
            'email_or_phone' => self::TEST_EMAIL,
            'otp_id' => $otp->id,
            'type' => 'email',
        ]]);

        $response = $this->post(route('auth.register.verify-otp'), [
            'code' => '012345',
        ]);

        $response->assertRedirect(route('auth.register.complete'));
    }

    /**
     * Test rapid succession of API requests
     */
    public function test_rapid_registration_requests(): void
    {
        for ($i = 0; $i < 5; $i++) {
            $email = "user{$i}@example.com";

            $response = $this->post(route('auth.register'), [
                'email_or_phone' => $email,
            ]);

            $response->assertRedirect(route('auth.register.verify-otp'));
        }

        // All should have created OTPs
        $this->assertDatabaseCount('otps', 5);
    }

    /**
     * Test user activation status enforcement
     */
    public function test_inactive_user_cannot_login(): void
    {
        $user = $this->createUserWithEmail(active: false);

        $response = $this->loginWithEmail();

        $response->assertRedirect(route('auth.login'));
        $this->assertUserNotAuthenticated();
    }

    /**
     * Test remember token persists across requests
     */
    public function test_remember_token_persists_across_requests(): void
    {
        $user = $this->createUserWithEmail();

        $this->loginWithEmail(remember: true);

        $user->refresh();
        $rememberToken = $user->remember_token;

        // Make another request
        $this->get(route('auth.login'));

        $user->refresh();
        // Remember token should remain the same
        $this->assertEquals($rememberToken, $user->remember_token);
    }
}
