<?php

namespace Tests\Feature\Auth;

use App\Models\Otp;

class OtpResendTest extends AuthTestCase
{
    /**
     * Test resending OTP during registration
     */
    public function test_can_resend_otp_during_registration(): void
    {
        $firstOtp = $this->createRegistrationOtp('email');

        $this->session(['registration' => [
            'email_or_phone' => self::TEST_EMAIL,
            'otp_id' => $firstOtp->id,
            'type' => 'email',
        ]]);

        $response = $this->post(route('auth.register.resend-otp'));

        $response->assertStatus(200);
        $response->assertJsonStructure(['message', 'data']);

        // Check new OTP was created
        $newOtp = Otp::where('code', '12345')
            ->where('type', 'email')
            ->latest()
            ->first();

        $this->assertNotNull($newOtp);
        $this->assertNotEquals($firstOtp->id, $newOtp->id);
    }

    /**
     * Test resending OTP resets attempts count
     */
    public function test_resending_otp_resets_attempts(): void
    {
        $otp = $this->createRegistrationOtp('email');
        $otp->update(['attempts' => 3]);

        $this->session(['registration' => [
            'email_or_phone' => self::TEST_EMAIL,
            'otp_id' => $otp->id,
            'type' => 'email',
        ]]);

        $response = $this->post(route('auth.register.resend-otp'));

        $response->assertStatus(200);

        // Old OTP should still have 3 attempts
        $otp->refresh();
        $this->assertEquals(3, $otp->attempts);

        // New OTP should have 0 attempts
        $newOtp = Otp::where('code', '12345')
            ->latest()
            ->first();
        $this->assertEquals(0, $newOtp->attempts);
    }

    /**
     * Test resending OTP extends expiration time
     */
    public function test_resending_otp_extends_expiration(): void
    {
        $otp = $this->createRegistrationOtp('email');
        $oldExpiredAt = $otp->expired_at;

        $this->session(['registration' => [
            'email_or_phone' => self::TEST_EMAIL,
            'otp_id' => $otp->id,
            'type' => 'email',
        ]]);

        $response = $this->post(route('auth.register.resend-otp'));

        $response->assertStatus(200);

        // New OTP should have later expiration
        $newOtp = Otp::where('code', '12345')
            ->latest()
            ->first();

        $this->assertTrue($newOtp->expired_at->isAfter($oldExpiredAt));
    }

    /**
     * Test resending OTP returns success message
     */
    public function test_resending_otp_returns_success_message(): void
    {
        $otp = $this->createRegistrationOtp('email');

        $this->session(['registration' => [
            'email_or_phone' => self::TEST_EMAIL,
            'otp_id' => $otp->id,
            'type' => 'email',
        ]]);

        $response = $this->postJson(route('auth.register.resend-otp'));

        $response->assertStatus(200);
        $response->assertJsonStructure(['message']);
        $response->assertJson(['message' => true]);
    }

    /**
     * Test resending OTP for SMS type
     */
    public function test_can_resend_sms_otp(): void
    {
        $otp = $this->createRegistrationOtp('sms');

        $this->session(['registration' => [
            'email_or_phone' => self::TEST_PHONE,
            'otp_id' => $otp->id,
            'type' => 'sms',
        ]]);

        $response = $this->post(route('auth.register.resend-otp'));

        $response->assertStatus(200);

        // New OTP should be SMS type
        $newOtp = Otp::where('code', '12345')
            ->latest()
            ->first();

        $this->assertEquals('sms', $newOtp->type);
    }

    /**
     * Test resending OTP during password reset
     */
    public function test_can_resend_otp_during_password_reset(): void
    {
        $user = $this->createUserWithEmail();
        $otp = $this->createResetOtp($user, 'email');

        $this->session(['password_reset' => [
            'email_or_phone' => self::TEST_EMAIL,
            'otp_id' => $otp->id,
            'user_id' => $user->id,
        ]]);

        $response = $this->post(route('auth.password.resend-otp'));

        $response->assertStatus(200);

        // New OTP should exist
        $newOtp = Otp::where('code', '12345')
            ->where('user_id', $user->id)
            ->latest()
            ->first();

        $this->assertNotNull($newOtp);
    }

    /**
     * Test resending OTP fails without session data
     */
    public function test_cannot_resend_otp_without_session_data(): void
    {
        // No session data
        $response = $this->post(route('auth.register.resend-otp'));

        $response->assertStatus(401);
        $response->assertJson(['error' => true]);
    }

    /**
     * Test resending OTP requires OTP ID in session
     */
    public function test_cannot_resend_otp_without_otp_id_in_session(): void
    {
        $this->session(['registration' => [
            'email_or_phone' => self::TEST_EMAIL,
            'type' => 'email',
            // Missing otp_id
        ]]);

        $response = $this->post(route('auth.register.resend-otp'));

        $response->assertStatus(401);
        $response->assertJson(['error' => true]);
    }

    /**
     * Test resending OTP multiple times creates multiple OTP records
     */
    public function test_resending_otp_multiple_times_creates_multiple_records(): void
    {
        $otp = $this->createRegistrationOtp('email');
        $otpIds = [$otp->id];

        $this->session(['registration' => [
            'email_or_phone' => self::TEST_EMAIL,
            'otp_id' => $otp->id,
            'type' => 'email',
        ]]);

        // First resend
        $this->post(route('auth.register.resend-otp'));
        $newOtp1 = Otp::where('code', '12345')
            ->latest()
            ->first();
        $otpIds[] = $newOtp1->id;

        $this->session(['registration' => [
            'email_or_phone' => self::TEST_EMAIL,
            'otp_id' => $newOtp1->id,
            'type' => 'email',
        ]]);

        // Second resend
        $this->post(route('auth.register.resend-otp'));
        $newOtp2 = Otp::where('code', '12345')
            ->latest()
            ->first();
        $otpIds[] = $newOtp2->id;

        // All OTPs should exist
        foreach ($otpIds as $id) {
            $this->assertDatabaseHas('otps', ['id' => $id]);
        }

        // All should be unique
        $this->assertEquals(3, count(array_unique($otpIds)));
    }

    /**
     * Test can use newly resent OTP
     */
    public function test_can_use_newly_resent_otp(): void
    {
        $otp = $this->createRegistrationOtp('email');

        $this->session(['registration' => [
            'email_or_phone' => self::TEST_EMAIL,
            'otp_id' => $otp->id,
            'type' => 'email',
        ]]);

        // First: Fail with wrong code
        $this->post(route('auth.register.verify-otp'), [
            'code' => '000000',
        ]);

        // Second: Resend OTP
        $this->post(route('auth.register.resend-otp'));

        // Third: Get new OTP
        $newOtp = Otp::where('code', '12345')
            ->latest()
            ->first();

        // Fourth: Update session with new OTP ID
        $this->session(['registration' => [
            'email_or_phone' => self::TEST_EMAIL,
            'otp_id' => $newOtp->id,
            'type' => 'email',
        ]]);

        // Fifth: Verify with new OTP
        $response = $this->post(route('auth.register.verify-otp'), [
            'code' => '12345',
        ]);

        $response->assertRedirect(route('auth.register.complete'));
    }

    /**
     * Test old OTP becomes invalid when new one is sent
     */
    public function test_old_otp_not_invalidated_on_resend(): void
    {
        $otp = $this->createRegistrationOtp('email');

        $this->session(['registration' => [
            'email_or_phone' => self::TEST_EMAIL,
            'otp_id' => $otp->id,
            'type' => 'email',
        ]]);

        // Resend new OTP
        $this->post(route('auth.register.resend-otp'));

        // Old OTP should still exist
        $otp->refresh();
        $this->assertFalse($otp->is_used);
        $this->assertEquals(0, $otp->attempts);
    }

    /**
     * Test resend OTP for user that reached max attempts
     */
    public function test_can_resend_otp_when_max_attempts_reached(): void
    {
        $otp = $this->createRegistrationOtp('email');
        $otp->update(['attempts' => 5]);

        $this->session(['registration' => [
            'email_or_phone' => self::TEST_EMAIL,
            'otp_id' => $otp->id,
            'type' => 'email',
        ]]);

        $response = $this->post(route('auth.register.resend-otp'));

        $response->assertStatus(200);

        // New OTP should have 0 attempts
        $newOtp = Otp::where('code', '12345')
            ->latest()
            ->first();
        $this->assertEquals(0, $newOtp->attempts);
    }

    /**
     * Test resending OTP creates valid OTP
     */
    public function test_resent_otp_is_valid(): void
    {
        $otp = $this->createRegistrationOtp('email');

        $this->session(['registration' => [
            'email_or_phone' => self::TEST_EMAIL,
            'otp_id' => $otp->id,
            'type' => 'email',
        ]]);

        $this->post(route('auth.register.resend-otp'));

        $newOtp = Otp::where('code', '12345')
            ->latest()
            ->first();

        $this->assertTrue($newOtp->isValid());
        $this->assertFalse($newOtp->isExpired());
        $this->assertFalse($newOtp->hasReachedMaxAttempts());
    }

    /**
     * Test resending expired OTP
     */
    public function test_can_resend_when_current_otp_is_expired(): void
    {
        $otp = $this->createRegistrationOtp('email', expired: true);

        $this->session(['registration' => [
            'email_or_phone' => self::TEST_EMAIL,
            'otp_id' => $otp->id,
            'type' => 'email',
        ]]);

        $response = $this->post(route('auth.register.resend-otp'));

        $response->assertStatus(200);

        // New OTP should not be expired
        $newOtp = Otp::where('code', '12345')
            ->latest()
            ->first();

        $this->assertFalse($newOtp->isExpired());
    }
}
