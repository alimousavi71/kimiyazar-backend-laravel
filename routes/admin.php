<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Admin\AdminController;
use App\Http\Controllers\Admin\AdminAvatarController;
use App\Http\Controllers\Admin\AdminPasswordController;
use App\Http\Controllers\Admin\ProfileController;
use App\Http\Controllers\Admin\ProfileAvatarController;
use App\Http\Controllers\Admin\ProfilePasswordController;
use App\Http\Controllers\Admin\TwoFactorManagementController;
use App\Http\Controllers\Admin\BannerController;
use App\Http\Controllers\Admin\CategoryController;
use App\Http\Controllers\Admin\ContactController;
use App\Http\Controllers\Admin\ContentController;
use App\Http\Controllers\Admin\FaqController;
use App\Http\Controllers\Admin\PhotoController;
use App\Http\Controllers\Admin\SliderController;
use App\Http\Controllers\Admin\TagController;
use App\Http\Controllers\Admin\UserController;
use App\Http\Controllers\Admin\ModalController;
use App\Http\Controllers\Admin\MorphableController;
use App\Http\Controllers\Admin\ProductController;
use App\Http\Controllers\Admin\ProductPriceController;
use App\Http\Controllers\Admin\SettingController;
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

    // Users Management
    Route::prefix('users')->name('users.')->group(function () {
        Route::get('/', [UserController::class, 'index'])->name('index');
        Route::get('/create', [UserController::class, 'create'])->name('create');
        Route::post('/', [UserController::class, 'store'])->name('store');
        Route::get('/{id}', [UserController::class, 'show'])->name('show');
        Route::get('/{id}/edit', [UserController::class, 'edit'])->name('edit');
        Route::match(['put', 'patch'], '/{id}', [UserController::class, 'update'])->name('update');
        Route::delete('/{id}', [UserController::class, 'destroy'])->name('destroy');

        // Password Management
        Route::get('/{id}/password/edit', [UserController::class, 'editPassword'])->name('edit-password');
        Route::match(['put', 'patch'], '/{id}/password', [UserController::class, 'updatePassword'])->name('update-password');

        // Status Toggle
        Route::post('/{id}/toggle-status', [UserController::class, 'toggleStatus'])->name('toggle-status');
    });

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

        // Avatar (dedicated profile controller - secure)
        Route::post('/avatar', [ProfileAvatarController::class, 'upload'])->name('avatar.upload');
        Route::delete('/avatar', [ProfileAvatarController::class, 'delete'])->name('avatar.delete');

        // Password (dedicated profile controller - secure)
        Route::get('/password/edit', [ProfilePasswordController::class, 'edit'])->name('password.edit');
        Route::match(['put', 'patch'], '/password', [ProfilePasswordController::class, 'update'])->name('password.update');
    });

    // Two-Factor Authentication Management
    Route::prefix('two-factor')->name('two-factor.')->group(function () {
        Route::get('/status', [TwoFactorManagementController::class, 'status'])->name('status');
        Route::get('/enable', [TwoFactorManagementController::class, 'showEnableForm'])->name('enable');
        Route::post('/enable', [TwoFactorManagementController::class, 'enable'])->name('enable.store');
        Route::post('/disable', [TwoFactorManagementController::class, 'disable'])->name('disable');
        Route::post('/recovery-codes/regenerate', [TwoFactorManagementController::class, 'regenerateRecoveryCodes'])->name('recovery-codes.regenerate');
    });

    // Categories Management
    Route::prefix('categories')->name('categories.')->group(function () {
        Route::get('/', [CategoryController::class, 'index'])->name('index');
        Route::get('/create', [CategoryController::class, 'create'])->name('create');
        Route::post('/', [CategoryController::class, 'store'])->name('store');
        Route::get('/{id}', [CategoryController::class, 'show'])->name('show');
        Route::get('/{id}/edit', [CategoryController::class, 'edit'])->name('edit');
        Route::match(['put', 'patch'], '/{id}', [CategoryController::class, 'update'])->name('update');
        Route::delete('/{id}', [CategoryController::class, 'destroy'])->name('destroy');
    });

    // Contacts Management
    Route::prefix('contacts')->name('contacts.')->group(function () {
        Route::get('/', [ContactController::class, 'index'])->name('index');
        Route::get('/{id}', [ContactController::class, 'show'])->name('show');
    });

    // Banners Management
    Route::prefix('banners')->name('banners.')->group(function () {
        Route::get('/', [BannerController::class, 'index'])->name('index');
        Route::get('/create', [BannerController::class, 'create'])->name('create');
        Route::post('/', [BannerController::class, 'store'])->name('store');
        Route::get('/{id}', [BannerController::class, 'show'])->name('show');
        Route::get('/{id}/edit', [BannerController::class, 'edit'])->name('edit');
        Route::match(['put', 'patch'], '/{id}', [BannerController::class, 'update'])->name('update');
        Route::delete('/{id}', [BannerController::class, 'destroy'])->name('destroy');
    });

    // Contents Management
    Route::prefix('contents')->name('contents.')->group(function () {
        Route::get('/', [ContentController::class, 'index'])->name('index');
        Route::get('/create', [ContentController::class, 'create'])->name('create');
        Route::post('/', [ContentController::class, 'store'])->name('store');
        Route::get('/{id}', [ContentController::class, 'show'])->name('show');
        Route::get('/{id}/edit', [ContentController::class, 'edit'])->name('edit');
        Route::match(['put', 'patch'], '/{id}', [ContentController::class, 'update'])->name('update');
        Route::delete('/{id}', [ContentController::class, 'destroy'])->name('destroy');
    });

    // Photos Management (API)
    Route::prefix('photos')->name('photos.')->group(function () {
        Route::get('/', [PhotoController::class, 'index'])->name('index');
        Route::post('/', [PhotoController::class, 'store'])->name('store');
        Route::put('/{id}', [PhotoController::class, 'update'])->name('update');
        Route::delete('/{id}', [PhotoController::class, 'destroy'])->name('destroy');
        Route::post('/reorder', [PhotoController::class, 'reorder'])->name('reorder');
        Route::post('/attach', [PhotoController::class, 'attach'])->name('attach');
    });

    // Tags Management (API)
    Route::prefix('tags')->name('tags.')->group(function () {
        Route::get('/search', [TagController::class, 'search'])->name('search');
        Route::get('/', [TagController::class, 'index'])->name('index');
        Route::post('/', [TagController::class, 'store'])->name('store');
        Route::post('/attach', [TagController::class, 'attach'])->name('attach');
        Route::delete('/{id}/detach', [TagController::class, 'detach'])->name('detach');
        Route::put('/{id}/body', [TagController::class, 'updateBody'])->name('update-body');
    });

    // Sliders Management
    Route::prefix('sliders')->name('sliders.')->group(function () {
        Route::get('/', [SliderController::class, 'index'])->name('index');
        Route::get('/create', [SliderController::class, 'create'])->name('create');
        Route::post('/', [SliderController::class, 'store'])->name('store');
        Route::get('/{id}', [SliderController::class, 'show'])->name('show');
        Route::get('/{id}/edit', [SliderController::class, 'edit'])->name('edit');
        Route::match(['put', 'patch'], '/{id}', [SliderController::class, 'update'])->name('update');
        Route::delete('/{id}', [SliderController::class, 'destroy'])->name('destroy');
    });

    // Modals Management
    Route::prefix('modals')->name('modals.')->group(function () {
        Route::get('/', [ModalController::class, 'index'])->name('index');
        Route::get('/create', [ModalController::class, 'create'])->name('create');
        Route::post('/', [ModalController::class, 'store'])->name('store');
        Route::get('/{id}', [ModalController::class, 'show'])->name('show');
        Route::get('/{id}/edit', [ModalController::class, 'edit'])->name('edit');
        Route::match(['put', 'patch'], '/{id}', [ModalController::class, 'update'])->name('update');
        Route::delete('/{id}', [ModalController::class, 'destroy'])->name('destroy');
    });

    // FAQs Management
    Route::prefix('faqs')->name('faqs.')->group(function () {
        Route::get('/', [FaqController::class, 'index'])->name('index');
        Route::get('/create', [FaqController::class, 'create'])->name('create');
        Route::post('/', [FaqController::class, 'store'])->name('store');
        Route::get('/{id}', [FaqController::class, 'show'])->name('show');
        Route::get('/{id}/edit', [FaqController::class, 'edit'])->name('edit');
        Route::match(['put', 'patch'], '/{id}', [FaqController::class, 'update'])->name('update');
        Route::delete('/{id}', [FaqController::class, 'destroy'])->name('destroy');
    });

    // Morphable relationship search endpoint
    Route::get('/morphable/search', [MorphableController::class, 'search'])->name('morphable.search');

    // Products Management
    Route::prefix('products')->name('products.')->group(function () {
        Route::get('/', [ProductController::class, 'index'])->name('index');
        Route::get('/create', [ProductController::class, 'create'])->name('create');
        Route::post('/', [ProductController::class, 'store'])->name('store');
        Route::get('/{id}', [ProductController::class, 'show'])->name('show');
        Route::get('/{id}/edit', [ProductController::class, 'edit'])->name('edit');
        Route::match(['put', 'patch'], '/{id}', [ProductController::class, 'update'])->name('update');
        Route::delete('/{id}', [ProductController::class, 'destroy'])->name('destroy');
    });

    // Product Prices Management
    Route::prefix('product-prices')->name('product-prices.')->group(function () {
        Route::get('/', [ProductPriceController::class, 'index'])->name('index');
        Route::post('/sync-today', [ProductPriceController::class, 'syncTodayPrices'])->name('sync-today');
        Route::post('/{productId}', [ProductPriceController::class, 'updatePrice'])->name('update');
        Route::post('/bulk-update', [ProductPriceController::class, 'bulkUpdate'])->name('bulk-update');
    });

    // Settings Management
    Route::prefix('settings')->name('settings.')->group(function () {
        Route::get('/edit', [SettingController::class, 'edit'])->name('edit');
        Route::match(['put', 'patch'], '/', [SettingController::class, 'update'])->name('update');
    });
});

