<?php

use App\Http\Controllers\Admin\Auth\AdminAuthController;
use App\Http\Controllers\Admin\Auth\AdminPasswordResetController;
use App\Http\Controllers\Examples\ApiExampleController;
use App\Http\Controllers\Examples\FormExampleController;
use Illuminate\Support\Facades\Route;

Route::get('/', function () {
    return view('welcome');
});

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
        Route::get('/two-factor-challenge', function () {
            return view('auth.two-factor-challenge');
        })->name('two-factor.login');

        Route::post('/two-factor-challenge', function () {
            // TODO: Implement 2FA verification logic
            return redirect()->route('admin.dashboard');
        })->name('two-factor.verify');
    });

    Route::middleware('auth:admin')->group(function () {
        Route::post('/logout', [AdminAuthController::class, 'logout'])->name('logout');
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
