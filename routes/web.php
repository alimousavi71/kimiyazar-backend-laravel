<?php

use Illuminate\Support\Facades\Route;

Route::get('/', function () {
    return view('welcome');
});

// Authentication Routes
Route::middleware('guest')->group(function () {
    Route::get('/login', function () {
        return view('auth.login');
    })->name('login');

    Route::get('/forgot-password', function () {
        return view('auth.forgot-password');
    })->name('password.request');

    Route::post('/forgot-password', function () {
        // TODO: Implement password reset email sending logic
        // This is a placeholder - connect to Laravel's password reset system
        return back()->with('status', 'If an account exists with that email, we have sent password reset instructions.');
    })->name('password.email');
});

// Two-Factor Authentication Routes
Route::get('/two-factor-challenge', function () {
    return view('auth.two-factor-challenge');
})->name('two-factor.login');

Route::post('/two-factor-challenge', function () {
    // TODO: Implement 2FA verification logic
    return redirect()->route('admin.dashboard');
})->name('two-factor.verify');


// API Routes
Route::prefix('api')->name('api.')->group(function () {
    Route::get('/example', [App\Http\Controllers\Examples\ApiExampleController::class, 'index'])->name('example.index');
    Route::post('/example', [App\Http\Controllers\Examples\ApiExampleController::class, 'store'])->name('example.store');
    Route::get('/example/test-error', [App\Http\Controllers\Examples\ApiExampleController::class, 'testError'])->name('example.test-error');

    // Form Example Routes
    Route::post('/form-example/submit', [App\Http\Controllers\Examples\FormExampleController::class, 'submit'])->name('form-example.submit');
    Route::get('/users/search', [App\Http\Controllers\Examples\FormExampleController::class, 'searchUsers'])->name('users.search');
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
