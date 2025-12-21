<?php

use App\Http\Controllers\Admin\Auth\AdminAuthController;
use App\Http\Controllers\Admin\Auth\AdminPasswordResetController;
use App\Http\Controllers\Admin\Auth\TwoFactorController;
use App\Http\Controllers\Auth\ForgotPasswordController;
use App\Http\Controllers\Auth\LoginController;
use App\Http\Controllers\Auth\RegisterController;
use App\Http\Controllers\Examples\ApiExampleController;
use App\Http\Controllers\Examples\FormExampleController;
use Illuminate\Support\Facades\Route;

Route::get('/', [\App\Http\Controllers\HomeController::class, 'index'])->name('home');

// Contact Routes
Route::get('/contact', [\App\Http\Controllers\ContactController::class, 'index'])->name('contact.index');
Route::post('/contact', [\App\Http\Controllers\ContactController::class, 'store'])->name('contact.store');

// Admin Authentication Routes
Route::prefix('admin')->name('admin.')->group(function () {
    Route::middleware('guest:admin')->group(function () {
        Route::get('/login', [AdminAuthController::class, 'showLoginForm'])->name('login');
        Route::post('/login', [AdminAuthController::class, 'login'])->name('login');

        Route::get('/forgot-password', [AdminPasswordResetController::class, 'showLinkRequestForm'])->name('password.request');
        Route::post('/forgot-password', [AdminPasswordResetController::class, 'sendResetLinkEmail'])->name('password.email');

        Route::get('/reset-password/{token}', [AdminPasswordResetController::class, 'showResetForm'])->name('password.reset');
        Route::post('/reset-password', [AdminPasswordResetController::class, 'reset'])->name('password.update');

        // Two-Factor Authentication Routes
        Route::get('/two-factor-challenge', [TwoFactorController::class, 'showChallenge'])->name('two-factor.login');
        Route::post('/two-factor-challenge', [TwoFactorController::class, 'verify'])->name('two-factor.verify');
    });

    Route::middleware('auth:admin')->group(function () {
        Route::post('/logout', [AdminAuthController::class, 'logout'])->name('logout');
    });
});

// User Authentication Routes
Route::prefix('auth')->name('auth.')->group(function () {
    Route::middleware('guest:web')->group(function () {
        // Registration Routes
        Route::get('/register', [RegisterController::class, 'showRegistrationForm'])->name('register');
        Route::post('/register', [RegisterController::class, 'register'])->name('register');

        Route::get('/register/verify-otp', [RegisterController::class, 'showVerifyOtpForm'])->name('register.verify-otp');
        Route::post('/register/verify-otp', [RegisterController::class, 'verifyOtp'])->name('register.verify-otp');

        Route::get('/register/complete', [RegisterController::class, 'showCompleteRegistrationForm'])->name('register.complete');
        Route::post('/register/complete', [RegisterController::class, 'completeRegistration'])->name('register.complete');

        Route::post('/register/resend-otp', [RegisterController::class, 'resendOtp'])->name('register.resend-otp');

        // Login Routes
        Route::get('/login', [LoginController::class, 'showLoginForm'])->name('login');
        Route::post('/login', [LoginController::class, 'login'])->name('login');

        // Forgot Password Routes
        Route::get('/forgot-password', [ForgotPasswordController::class, 'showForgotPasswordForm'])->name('password.request');
        Route::post('/forgot-password', [ForgotPasswordController::class, 'sendResetOtp'])->name('password.email');

        Route::get('/forgot-password/verify-otp', [ForgotPasswordController::class, 'showVerifyResetOtpForm'])->name('password.verify-otp');
        Route::post('/forgot-password/verify-otp', [ForgotPasswordController::class, 'verifyResetOtp'])->name('password.verify-otp');

        Route::get('/reset-password', [ForgotPasswordController::class, 'showResetPasswordForm'])->name('password.reset');
        Route::post('/reset-password', [ForgotPasswordController::class, 'resetPassword'])->name('password.update');

        Route::post('/forgot-password/resend-otp', [ForgotPasswordController::class, 'resendResetOtp'])->name('password.resend-otp');
    });

    Route::middleware('auth:web')->group(function () {
        Route::post('/logout', [LoginController::class, 'logout'])->name('logout');
    });
});

// API Routes
Route::prefix('api')->name('api.')->group(function () {
    Route::get('/example', [ApiExampleController::class, 'index'])->name('example.index');
    Route::post('/example', [ApiExampleController::class, 'store'])->name('example.store');
    Route::get('/example/test-error', [ApiExampleController::class, 'testError'])->name('example.test-error');

    // Form Example Routes
    Route::post('/form-example/submit', [FormExampleController::class, 'submit'])->name('form-example.submit');
    Route::get('/users/search', [FormExampleController::class, 'searchUsers'])->name('users.search');
});

// Legacy route names for compatibility
Route::get('/dashboard', function () {
    return redirect()->route('admin.dashboard');
})->name('dashboard');

Route::get('/users', function () {
    return redirect()->route('admin.users.index');
})->name('users.index');

Route::get('/settings', function () {
    return redirect()->route('admin.settings');
})->name('settings');
