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

// Admin Panel Routes
Route::prefix('admin')->name('admin.')->group(function () {
    Route::get('/dashboard', function () {
        return view('pages.dashboard');
    })->name('dashboard');

    Route::get('/users', function () {
        // Example pagination data - Replace with your actual model query
        $perPage = request()->get('per_page', 10);
        $currentPage = request()->get('page', 1);

        // Example data collection (replace with your actual query)
        $items = collect([
            ['id' => 1, 'name' => 'John Doe', 'email' => 'john.doe@example.com', 'role' => 'admin', 'status' => 'active', 'created' => '2024-01-15'],
            ['id' => 2, 'name' => 'Jane Smith', 'email' => 'jane.smith@example.com', 'role' => 'user', 'status' => 'active', 'created' => '2024-01-20'],
            ['id' => 3, 'name' => 'Alice Brown', 'email' => 'alice.brown@example.com', 'role' => 'user', 'status' => 'pending', 'created' => '2024-02-01'],
            ['id' => 4, 'name' => 'Bob Wilson', 'email' => 'bob.wilson@example.com', 'role' => 'moderator', 'status' => 'active', 'created' => '2024-02-05'],
            ['id' => 5, 'name' => 'Charlie Davis', 'email' => 'charlie.davis@example.com', 'role' => 'user', 'status' => 'inactive', 'created' => '2024-02-10'],
            ['id' => 6, 'name' => 'Diana Prince', 'email' => 'diana.prince@example.com', 'role' => 'admin', 'status' => 'active', 'created' => '2024-02-15'],
            ['id' => 7, 'name' => 'Eve Johnson', 'email' => 'eve.johnson@example.com', 'role' => 'user', 'status' => 'active', 'created' => '2024-02-20'],
            ['id' => 8, 'name' => 'Frank Miller', 'email' => 'frank.miller@example.com', 'role' => 'moderator', 'status' => 'active', 'created' => '2024-02-25'],
            ['id' => 9, 'name' => 'Grace Lee', 'email' => 'grace.lee@example.com', 'role' => 'user', 'status' => 'pending', 'created' => '2024-03-01'],
            ['id' => 10, 'name' => 'Henry Taylor', 'email' => 'henry.taylor@example.com', 'role' => 'user', 'status' => 'active', 'created' => '2024-03-05'],
            ['id' => 11, 'name' => 'Ivy Chen', 'email' => 'ivy.chen@example.com', 'role' => 'admin', 'status' => 'active', 'created' => '2024-03-10'],
            ['id' => 12, 'name' => 'Jack White', 'email' => 'jack.white@example.com', 'role' => 'user', 'status' => 'inactive', 'created' => '2024-03-15'],
        ]);

        $total = $items->count();
        $offset = ($currentPage - 1) * $perPage;
        $itemsForCurrentPage = $items->slice($offset, $perPage)->values();

        $paginator = new \Illuminate\Pagination\LengthAwarePaginator(
            $itemsForCurrentPage,
            $total,
            $perPage,
            $currentPage,
            [
                'path' => request()->url(),
                'pageName' => 'page',
            ]
        );

        $paginator->appends(request()->except('page'));

        return view('pages.users', ['paginator' => $paginator, 'users' => $itemsForCurrentPage]);
    })->name('users.index');

    Route::get('/settings', function () {
        return view('pages.settings');
    })->name('settings');

    Route::get('/imask-test', function () {
        return view('pages.imask-test');
    })->name('imask-test');

    Route::get('/validation-example', function () {
        return view('pages.validation-example');
    })->name('validation-example');

    Route::get('/toast-example', function () {
        return view('pages.toast-example');
    })->name('toast-example');

    Route::get('/axios-example', function () {
        return view('pages.axios-example');
    })->name('axios-example');

    Route::get('/form-example', function () {
        return view('pages.form-example');
    })->name('form-example');

    Route::get('/modal-example', function () {
        return view('pages.modal-example');
    })->name('modal-example');
});

// API Routes
Route::prefix('api')->name('api.')->group(function () {
    Route::get('/example', [App\Http\Controllers\ApiExampleController::class, 'index'])->name('example.index');
    Route::post('/example', [App\Http\Controllers\ApiExampleController::class, 'store'])->name('example.store');
    Route::get('/example/test-error', [App\Http\Controllers\ApiExampleController::class, 'testError'])->name('example.test-error');

    // Form Example Routes
    Route::post('/form-example/submit', [App\Http\Controllers\FormExampleController::class, 'submit'])->name('form-example.submit');
    Route::get('/users/search', [App\Http\Controllers\FormExampleController::class, 'searchUsers'])->name('users.search');
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
