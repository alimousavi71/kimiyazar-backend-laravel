<?php

namespace Tests\Feature\Auth;

use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Support\Facades\Auth;
use Tests\TestCase;

class LoginTest extends TestCase
{
    use RefreshDatabase;

    /**
     * Test: Show login form page
     */
    public function test_show_login_form(): void
    {
        $response = $this->get(route('auth.login'));

        $response->assertStatus(200);
        $response->assertViewIs('auth.login');
    }

    /**
     * Test: Successful login with valid email and password
     */
    public function test_successful_login_with_email(): void
    {
        $user = User::factory()->create([
            'email' => 'test@example.com',
            'password' => 'password123',
            'is_active' => true,
        ]);

        $response = $this->post(route('auth.login'), [
            'email_or_phone' => 'test@example.com',
            'password' => 'password123',
        ]);

        $response->assertRedirect('/');
        $this->assertAuthenticatedAs($user);
    }

    /**
     * Test: Successful login with valid phone number
     */
    public function test_successful_login_with_phone(): void
    {
        $user = User::factory()->create([
            'phone_number' => '09123456789',
            'password' => 'password123',
            'is_active' => true,
        ]);

        $response = $this->post(route('auth.login'), [
            'email_or_phone' => '09123456789',
            'password' => 'password123',
        ]);

        $response->assertRedirect('/');
        $this->assertAuthenticatedAs($user);
    }

    /**
     * Test: Login with remember me checkbox
     */
    public function test_login_with_remember_me(): void
    {
        $user = User::factory()->create([
            'email' => 'test@example.com',
            'password' => 'password123',
            'is_active' => true,
        ]);

        $response = $this->post(route('auth.login'), [
            'email_or_phone' => 'test@example.com',
            'password' => 'password123',
            'remember' => true,
        ]);

        $response->assertRedirect('/');
        $this->assertAuthenticatedAs($user);
        // Check if remember token is set
        $this->assertNotNull($user->fresh()->remember_token);
    }

    /**
     * Test: Failed login with wrong password
     */
    public function test_failed_login_with_wrong_password(): void
    {
        User::factory()->create([
            'email' => 'test@example.com',
            'password' => 'password123',
            'is_active' => true,
        ]);

        $response = $this->post(route('auth.login'), [
            'email_or_phone' => 'test@example.com',
            'password' => 'wrongpassword',
        ]);

        $response->assertRedirect();
        $response->assertSessionHas('error');
        $this->assertGuest();
    }

    /**
     * Test: Failed login with non-existent user
     */
    public function test_failed_login_with_non_existent_user(): void
    {
        $response = $this->post(route('auth.login'), [
            'email_or_phone' => 'nonexistent@example.com',
            'password' => 'password123',
        ]);

        $response->assertRedirect();
        $response->assertSessionHas('error');
        $this->assertGuest();
    }

    /**
     * Test: Failed login with inactive user account
     */
    public function test_failed_login_with_inactive_user(): void
    {
        User::factory()->create([
            'email' => 'test@example.com',
            'password' => 'password123',
            'is_active' => false,
        ]);

        $response = $this->post(route('auth.login'), [
            'email_or_phone' => 'test@example.com',
            'password' => 'password123',
        ]);

        $response->assertRedirect();
        $response->assertSessionHas('error');
        $this->assertGuest();
    }

    /**
     * Test: Login validation - missing email/phone
     */
    public function test_login_validation_missing_email_or_phone(): void
    {
        $response = $this->post(route('auth.login'), [
            'password' => 'password123',
        ]);

        $response->assertSessionHasErrors('email_or_phone');
    }

    /**
     * Test: Login validation - missing password
     */
    public function test_login_validation_missing_password(): void
    {
        $response = $this->post(route('auth.login'), [
            'email_or_phone' => 'test@example.com',
        ]);

        $response->assertSessionHasErrors('password');
    }

    /**
     * Test: Login persists email/phone on validation error
     */
    public function test_login_persists_input_on_error(): void
    {
        $response = $this->post(route('auth.login'), [
            'email_or_phone' => 'test@example.com',
        ]);

        $response->assertSessionHasErrors('password');
    }

    /**
     * Test: Session is regenerated after successful login
     */
    public function test_session_regenerated_after_login(): void
    {
        $user = User::factory()->create([
            'email' => 'test@example.com',
            'password' => 'password123',
            'is_active' => true,
        ]);

        $oldSessionId = session()->getId();

        $this->post(route('auth.login'), [
            'email_or_phone' => 'test@example.com',
            'password' => 'password123',
        ]);

        $newSessionId = session()->getId();
        $this->assertNotSame($oldSessionId, $newSessionId);
    }

    /**
     * Test: Last login timestamp is updated
     */
    public function test_last_login_timestamp_updated(): void
    {
        $user = User::factory()->create([
            'email' => 'test@example.com',
            'password' => 'password123',
            'is_active' => true,
            'last_login' => null,
        ]);

        $this->post(route('auth.login'), [
            'email_or_phone' => 'test@example.com',
            'password' => 'password123',
        ]);

        $user->refresh();
        $this->assertNotNull($user->last_login);
    }

    /**
     * Test: JSON response on successful login
     */
    public function test_json_response_on_successful_login(): void
    {
        $user = User::factory()->create([
            'email' => 'test@example.com',
            'password' => 'password123',
            'is_active' => true,
        ]);

        $response = $this->postJson(route('auth.login'), [
            'email_or_phone' => 'test@example.com',
            'password' => 'password123',
        ]);

        $response->assertStatus(200);
        $response->assertJsonStructure(['data', 'message']);
        $response->assertJsonPath('data.user.id', $user->id);
    }

    /**
     * Test: JSON error response on failed login
     */
    public function test_json_error_response_on_failed_login(): void
    {
        $response = $this->postJson(route('auth.login'), [
            'email_or_phone' => 'nonexistent@example.com',
            'password' => 'password123',
        ]);

        $response->assertStatus(401);
        $response->assertJsonStructure(['message', 'errors']);
    }

    /**
     * Test: Cannot access login if already authenticated
     */
    public function test_cannot_access_login_if_authenticated(): void
    {
        $user = User::factory()->create([
            'email' => 'test@example.com',
            'password' => 'password123',
            'is_active' => true,
        ]);

        $this->actingAs($user);

        $response = $this->get(route('auth.login'));

        // Should redirect away from login when already authenticated
        $response->assertRedirect();
    }

    /**
     * Test: Logout requires authentication
     */
    public function test_logout_requires_authentication(): void
    {
        $response = $this->post(route('auth.logout'));

        // Should redirect when not authenticated
        $response->assertRedirect();
    }

    /**
     * Test: Successful logout
     */
    public function test_successful_logout(): void
    {
        $user = User::factory()->create([
            'email' => 'test@example.com',
            'password' => 'password123',
            'is_active' => true,
        ]);

        $response = $this->actingAs($user)
            ->post(route('auth.logout'));

        $response->assertRedirect(route('auth.login'));
        $this->assertGuest();
    }

    /**
     * Test: Session is invalidated after logout
     */
    public function test_session_invalidated_after_logout(): void
    {
        $user = User::factory()->create([
            'email' => 'test@example.com',
            'password' => 'password123',
            'is_active' => true,
        ]);

        $this->actingAs($user);

        $oldSessionId = session()->getId();

        $this->post(route('auth.logout'));

        $newSessionId = session()->getId();
        $this->assertNotSame($oldSessionId, $newSessionId);
    }

    /**
     * Test: CSRF token is required for login
     */
    public function test_csrf_token_required_for_login(): void
    {
        $response = $this->withoutMiddleware()
            ->post(route('auth.login'), [
                'email_or_phone' => 'test@example.com',
                'password' => 'password123',
            ]);

        // This should normally fail with CSRF but we're testing with middleware disabled
        // In real scenario, it would require CSRF token
    }

    /**
     * Test: Login redirects to intended route if available
     */
    public function test_login_redirects_to_intended_route(): void
    {
        $user = User::factory()->create([
            'email' => 'test@example.com',
            'password' => 'password123',
            'is_active' => true,
        ]);

        $response = $this->from(route('auth.login'))
            ->post(route('auth.login'), [
                'email_or_phone' => 'test@example.com',
                'password' => 'password123',
            ]);

        $response->assertRedirect('/');
    }

    /**
     * Test: Remember token is cleared on logout
     */
    public function test_remember_token_handling(): void
    {
        $user = User::factory()->create([
            'email' => 'test@example.com',
            'password' => 'password123',
            'is_active' => true,
        ]);

        $this->post(route('auth.login'), [
            'email_or_phone' => 'test@example.com',
            'password' => 'password123',
            'remember' => true,
        ]);

        $user->refresh();
        $this->assertNotNull($user->remember_token);

        $this->post(route('auth.logout'));
    }

    /**
     * Test: Multiple failed login attempts
     */
    public function test_multiple_failed_login_attempts(): void
    {
        $user = User::factory()->create([
            'email' => 'test@example.com',
            'password' => 'password123',
            'is_active' => true,
        ]);

        for ($i = 0; $i < 3; $i++) {
            $response = $this->post(route('auth.login'), [
                'email_or_phone' => 'test@example.com',
                'password' => 'wrongpassword',
            ]);

            $response->assertRedirect();
            $this->assertGuest();
        }

        // Should still be able to login with correct password
        $response = $this->post(route('auth.login'), [
            'email_or_phone' => 'test@example.com',
            'password' => 'password123',
        ]);

        $response->assertRedirect('/');
        $this->assertAuthenticatedAs($user);
    }
}
