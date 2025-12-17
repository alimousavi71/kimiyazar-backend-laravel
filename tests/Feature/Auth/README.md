# Authentication Test Suite

Comprehensive test suite for the Laravel authentication system supporting email/phone registration, login, OTP verification, and password reset flows.

## Test Files

### 1. **AuthTestCase.php** (Base Test Class)
Provides helper methods and utilities for all authentication tests.

**Key Methods:**
- `createUserWithEmail()` - Create a test user with email
- `createUserWithPhone()` - Create a test user with phone
- `createRegistrationOtp()` - Create a registration OTP
- `createResetOtp()` - Create a password reset OTP
- `startEmailRegistration()` - Initiate email registration
- `startPhoneRegistration()` - Initiate phone registration
- `verifyRegistrationOtp()` - Verify OTP during registration
- `completeRegistration()` - Complete registration and set password
- `loginWithEmail()` - Login with email/password
- `loginWithPhone()` - Login with phone/password
- `startPasswordResetWithEmail()` - Request password reset via email
- `startPasswordResetWithPhone()` - Request password reset via phone
- `verifyResetOtp()` - Verify OTP during password reset
- `resetPassword()` - Reset password with new password
- `logout()` - Logout user

**Assertion Methods:**
- `assertUserAuthenticated()` - Assert user is logged in
- `assertUserNotAuthenticated()` - Assert user is not logged in
- `assertUserExists()` - Assert user exists in database
- `assertOtpExists()` - Assert OTP exists in database

### 2. **RegisterTest.php** (Registration Flow)
Tests for user registration with email or phone.

**Test Coverage:**
- ✅ View registration form
- ✅ Register with valid email
- ✅ Register with valid phone
- ✅ Reject registration with existing email
- ✅ Reject registration with existing phone
- ✅ Validate email format
- ✅ Validate phone format
- ✅ View verify OTP form
- ✅ Verify OTP with correct code
- ✅ Reject OTP with incorrect code
- ✅ Reject expired OTP
- ✅ Reject already used OTP
- ✅ View complete registration form
- ✅ Complete registration with valid password
- ✅ Validate password length
- ✅ Validate password confirmation
- ✅ Complete email registration flow (end-to-end)
- ✅ Complete phone registration flow (end-to-end)
- ✅ Block authenticated users from registration
- ✅ Clear session after completion

**Total Tests: 20**

### 3. **LoginTest.php** (Login Flow)
Tests for user login with email or phone.

**Test Coverage:**
- ✅ View login form
- ✅ Login with valid email
- ✅ Login with valid phone
- ✅ Reject login with non-existent email
- ✅ Reject login with non-existent phone
- ✅ Reject login with incorrect password
- ✅ Validate email is required
- ✅ Validate password is required
- ✅ Persist input on validation error
- ✅ Reject login with inactive user
- ✅ Support remember me functionality
- ✅ Logout functionality
- ✅ Update last login timestamp
- ✅ Block authenticated users from login page
- ✅ Case-insensitive email login
- ✅ Session regeneration on login
- ✅ Handle multiple failed attempts
- ✅ JSON API responses
- ✅ CSRF protection

**Total Tests: 28**

### 4. **OtpVerificationTest.php** (OTP Verification)
Tests for OTP verification in registration and password reset flows.

**Test Coverage:**
- ✅ Verify OTP with correct code
- ✅ Reject OTP with incorrect code
- ✅ Reject expired OTP
- ✅ Reject already used OTP
- ✅ Track failed verification attempts
- ✅ Block OTP after max attempts (5)
- ✅ Validate OTP code format (numeric, 6 digits)
- ✅ Mark OTP as used after successful verification
- ✅ Support SMS OTP verification
- ✅ Support password reset OTP verification
- ✅ Require session data for verification
- ✅ Track attempt count incrementally
- ✅ Validate multiple attempts leading to lockout

**Total Tests: 20**

### 5. **PasswordResetTest.php** (Password Reset Flow)
Tests for password reset with OTP verification.

**Test Coverage:**
- ✅ View forgot password form
- ✅ Request password reset with email
- ✅ Request password reset with phone
- ✅ Reject request with non-existent email
- ✅ Reject request with non-existent phone
- ✅ View verify reset OTP form
- ✅ Verify reset OTP with correct code
- ✅ Reject reset OTP with incorrect code
- ✅ View reset password form
- ✅ Reset password with valid new password
- ✅ Validate password confirmation matches
- ✅ Validate password length
- ✅ Login with new password after reset
- ✅ Reject login with old password after reset
- ✅ Clear session after completion
- ✅ Complete password reset flow (end-to-end) with email
- ✅ Complete password reset flow (end-to-end) with phone
- ✅ Block authenticated users from password reset
- ✅ Require OTP verification before password reset

**Total Tests: 19**

### 6. **OtpResendTest.php** (OTP Resend)
Tests for resending OTP codes in registration and password reset.

**Test Coverage:**
- ✅ Resend OTP during registration
- ✅ Resend OTP resets attempts count
- ✅ Resend OTP extends expiration time
- ✅ Resend returns success message
- ✅ Resend SMS OTP type
- ✅ Resend OTP during password reset
- ✅ Require session data for resend
- ✅ Require OTP ID in session for resend
- ✅ Create multiple OTP records on multiple resends
- ✅ Use newly resent OTP for verification
- ✅ Old OTP not invalidated on resend
- ✅ Resend when max attempts reached
- ✅ New OTP is valid after resend
- ✅ Resend expired OTP

**Total Tests: 14**

### 7. **EdgeCaseTest.php** (Edge Cases & Error Scenarios)
Tests for edge cases, error handling, and security scenarios.

**Test Coverage:**
- ✅ Registration with special characters in email
- ✅ Registration with various phone formats
- ✅ Simultaneous registration attempts with same email
- ✅ XSS attack prevention (HTML/script injection)
- ✅ SQL injection prevention
- ✅ Login with very long email
- ✅ Login with NULL bytes
- ✅ OTP verification with spaces
- ✅ User creation with Unicode names
- ✅ Session timeout during registration
- ✅ Access protection for incomplete flows
- ✅ Password reset with very long passwords
- ✅ Password reset with Unicode characters
- ✅ Email case sensitivity handling
- ✅ Concurrent login/logout operations
- ✅ Multiple OTPs with same code
- ✅ User with both email and phone
- ✅ OTP verification with leading zeros
- ✅ Rapid succession of requests
- ✅ Inactive user enforcement
- ✅ Remember token persistence

**Total Tests: 21**

## Running Tests

### Run All Tests
```bash
php artisan test tests/Feature/Auth
```

### Run Specific Test File
```bash
php artisan test tests/Feature/Auth/RegisterTest.php
php artisan test tests/Feature/Auth/LoginTest.php
php artisan test tests/Feature/Auth/OtpVerificationTest.php
php artisan test tests/Feature/Auth/PasswordResetTest.php
php artisan test tests/Feature/Auth/OtpResendTest.php
php artisan test tests/Feature/Auth/EdgeCaseTest.php
```

### Run Specific Test
```bash
php artisan test tests/Feature/Auth/RegisterTest.php --filter test_can_view_registration_form
```

### Run Tests with Coverage Report
```bash
php artisan test tests/Feature/Auth --coverage
```

### Run Tests with Verbose Output
```bash
php artisan test tests/Feature/Auth --verbose
```

## Test Statistics

| Test File | Test Count | Coverage |
|-----------|-----------|----------|
| RegisterTest | 20 | Registration flow |
| LoginTest | 28 | Login & logout |
| OtpVerificationTest | 20 | OTP validation |
| PasswordResetTest | 19 | Password reset flow |
| OtpResendTest | 14 | OTP resend |
| EdgeCaseTest | 21 | Edge cases & security |
| **TOTAL** | **122** | **Complete auth system** |

## Test Scenarios Covered

### Registration Flows
- Email registration (3 steps: email → OTP → password)
- Phone registration (3 steps: phone → OTP → password)
- Input validation (format, required fields, uniqueness)
- OTP verification and management
- Session state management

### Login Flows
- Email login with password
- Phone login with password
- Remember me functionality
- Last login tracking
- Inactive user prevention
- Multiple failed attempt handling

### Password Reset Flows
- Email-based password reset
- Phone-based password reset (SMS)
- OTP verification for security
- Password validation
- Session management

### OTP Management
- OTP generation and delivery (email/SMS)
- Expiration handling
- Attempt tracking (max 5)
- Code validation (6 digits, numeric)
- OTP resend with attempt reset
- OTP reuse prevention

### Security Features
- CSRF protection
- XSS prevention
- SQL injection prevention
- Session regeneration
- Inactive user blocking
- Brute force protection (attempt tracking)
- Password hashing validation

### Edge Cases
- Special characters handling
- Unicode character support
- Very long input handling
- Concurrent operations
- Rapid request handling
- Null byte handling
- Session timeout scenarios

## Database State

All tests use `RefreshDatabase` trait to ensure:
- Clean database before each test
- Isolated test execution
- No test interdependencies
- Predictable test behavior

## Environment Configuration

Tests run in the `testing` environment which:
- Uses in-memory SQLite database (faster)
- Disables throttling for testing
- Uses fake mail/SMS drivers (local environment)
- Disables some middleware for specific tests

## Common Test Patterns

### Testing a Complete Flow
```php
// Step 1: Start process
$result = $this->startEmailRegistration();

// Step 2: Verify intermediate step
$response = $this->verifyRegistrationOtp($result['otp']);

// Step 3: Complete process
$completeResponse = $this->completeRegistration($result['otp']);

// Step 4: Verify final state
$this->assertUserAuthenticated($user);
```

### Testing Error Cases
```php
$response = $this->post(route('auth.login'), [
    'email_or_phone' => 'invalid@example.com',
    'password' => 'wrong',
]);

$response->assertRedirect(route('auth.login'));
$response->assertSessionHasErrors();
$this->assertUserNotAuthenticated();
```

### Testing Database State
```php
$user = $this->createUserWithEmail();

$response = $this->loginWithEmail();

$user->refresh();
$this->assertNotNull($user->last_login);
```

## Notes

- All tests use fixtures with constants: `TEST_EMAIL`, `TEST_PHONE`, `TEST_PASSWORD`
- OTP code in local environment is always `12345` for easy testing
- Session keys follow pattern: `{flow}.{key}` (e.g., `registration.otp_verified`)
- Tests validate both success and failure paths
- Edge case tests ensure security and robustness

## Troubleshooting

### Database Locked Error
```bash
# Clear test database
rm -f database/testing.sqlite
php artisan test
```

### Timeout in Tests
```bash
# Increase timeout
php artisan test tests/Feature/Auth --timeout=60
```

### Missing Dependencies
```bash
composer install
php artisan cache:clear
```

## Future Enhancements

- [ ] Rate limiting tests
- [ ] Account lockout after multiple failed attempts
- [ ] Two-factor authentication tests
- [ ] Email verification tests
- [ ] Social login integration tests
- [ ] Performance/load tests
- [ ] API endpoint tests (JSON responses)
