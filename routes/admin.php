<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Admin\AdminController;
use App\Http\Controllers\Admin\AdminAvatarController;
use App\Http\Controllers\Admin\AdminPasswordController;
use App\Http\Controllers\Admin\ProfileController;
use App\Http\Controllers\Examples\UsersController;

Route::group([
    'prefix' => config('admin.prefix'),
    'as' => config('admin.route_name_prefix') . '.',
    'middleware' => ['auth.admin'],
], function () {
    // Dashboard
    Route::get('/', function () {
        return view('pages.dashboard');
    })->name('dashboard');

    // Settings
    Route::get('/settings', function () {
        return view('pages.settings');
    })->name('settings');

    // Users
    Route::get('/users', [UsersController::class, 'index'])->name('users.index');

    // Examples
    Route::prefix('examples')->name('examples.')->group(function () {
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

    // Admin Management
    Route::prefix('admins')->name('admins.')->group(function () {
        Route::get('/', [AdminController::class, 'index'])->name('index');
        Route::get('/create', [AdminController::class, 'create'])->name('create');
        Route::post('/', [AdminController::class, 'store'])->name('store');
        Route::get('/{id}', [AdminController::class, 'show'])->name('show');
        Route::get('/{id}/edit', [AdminController::class, 'edit'])->name('edit');
        Route::match(['put', 'patch'], '/{id}', [AdminController::class, 'update'])->name('update');
        Route::delete('/{id}', [AdminController::class, 'destroy'])->name('destroy');

        // Avatar
        Route::post('/{id}/avatar', [AdminAvatarController::class, 'upload'])->name('avatar.upload');
        Route::delete('/{id}/avatar', [AdminAvatarController::class, 'delete'])->name('avatar.delete');

        // Password
        Route::get('/{id}/password/edit', [AdminPasswordController::class, 'edit'])->name('password.edit');
        Route::match(['put', 'patch'], '/{id}/password', [AdminPasswordController::class, 'update'])->name('password.update');
    });

    // Profile (Authenticated Admin's Own Profile)
    Route::prefix('profile')->name('profile.')->group(function () {
        Route::get('/', [ProfileController::class, 'show'])->name('show');
        Route::get('/edit', [ProfileController::class, 'edit'])->name('edit');
        Route::match(['put', 'patch'], '/', [ProfileController::class, 'update'])->name('update');

        // Avatar (reuse AdminAvatarController)
        Route::post('/avatar', [AdminAvatarController::class, 'upload'])->name('avatar.upload');
        Route::delete('/avatar', [AdminAvatarController::class, 'delete'])->name('avatar.delete');

        // Password (reuse AdminPasswordController)
        Route::get('/password/edit', [AdminPasswordController::class, 'edit'])->name('password.edit');
        Route::match(['put', 'patch'], '/password', [AdminPasswordController::class, 'update'])->name('password.update');
    });
});

