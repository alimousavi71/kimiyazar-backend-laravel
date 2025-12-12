<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Admin\AdminController;
use App\Http\Controllers\Admin\AdminAvatarController;
use App\Http\Controllers\Admin\AdminPasswordController;
use App\Http\Controllers\Admin\ProfileController;
use App\Http\Controllers\Admin\ProfileAvatarController;
use App\Http\Controllers\Admin\ProfilePasswordController;
use App\Http\Controllers\Examples\UsersController;

// TODO: Temporarily disabled auth middleware for admin routes
// To enable: add ->middleware('auth:admin') to the route group below
Route::group([
    'prefix' => config('admin.prefix'),
    'as' => config('admin.route_name_prefix') . '.',
    // 'middleware' => ['auth:admin'], // Temporarily disabled
], function () {
    Route::get('/dashboard', function () {
        return view('pages.dashboard');
    })->name('dashboard');

    Route::get('/settings', function () {
        return view('pages.settings');
    })->name('settings');

    // Users Routes
    Route::get('/users', [UsersController::class, 'index'])->name('users.index');

    // Example Routes Group
    Route::group(['prefix' => 'examples', 'as' => 'examples.'], function () {
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

    // Admin Management Routes Group
    Route::group(['prefix' => 'admins', 'as' => 'admins.'], function () {
        Route::get('/', [AdminController::class, 'index'])->name('index');
        Route::get('/create', [AdminController::class, 'create'])->name('create');
        Route::post('/', [AdminController::class, 'store'])->name('store');
        Route::get('/{id}', [AdminController::class, 'show'])->name('show');
        Route::get('/{id}/edit', [AdminController::class, 'edit'])->name('edit');
        Route::put('/{id}', [AdminController::class, 'update'])->name('update');
        Route::patch('/{id}', [AdminController::class, 'update'])->name('update');
        Route::delete('/{id}', [AdminController::class, 'destroy'])->name('destroy');

        // Avatar Routes
        Route::post('/{id}/avatar', [AdminAvatarController::class, 'upload'])->name('avatar.upload');
        Route::delete('/{id}/avatar', [AdminAvatarController::class, 'delete'])->name('avatar.delete');

        // Password Routes
        Route::get('/{id}/password/edit', [AdminPasswordController::class, 'edit'])->name('password.edit');
        Route::put('/{id}/password', [AdminPasswordController::class, 'update'])->name('password.update');
        Route::patch('/{id}/password', [AdminPasswordController::class, 'update'])->name('password.update');
    });

    // Profile Routes (Authenticated Admin's Own Profile)
    Route::group(['prefix' => 'profile', 'as' => 'profile.'], function () {
        Route::get('/', [ProfileController::class, 'show'])->name('show');
        Route::get('/edit', [ProfileController::class, 'edit'])->name('edit');
        Route::put('/', [ProfileController::class, 'update'])->name('update');
        Route::patch('/', [ProfileController::class, 'update'])->name('update');

        // Profile Avatar Routes
        Route::post('/avatar', [ProfileAvatarController::class, 'upload'])->name('avatar.upload');
        Route::delete('/avatar', [ProfileAvatarController::class, 'delete'])->name('avatar.delete');

        // Profile Password Routes
        Route::get('/password/edit', [ProfilePasswordController::class, 'edit'])->name('password.edit');
        Route::put('/password', [ProfilePasswordController::class, 'update'])->name('password.update');
        Route::patch('/password', [ProfilePasswordController::class, 'update'])->name('password.update');
    });
});

