<?php

use App\Http\Controllers\Admin\Auth\AdminAuthController;
use App\Http\Controllers\Admin\Auth\AdminPasswordResetController;
use App\Http\Controllers\Admin\Auth\TwoFactorController;
use App\Http\Controllers\AboutController;
use App\Http\Controllers\ArticleController;
use App\Http\Controllers\Auth\ForgotPasswordController;
use App\Http\Controllers\Auth\LoginController;
use App\Http\Controllers\Auth\RegisterController;
use App\Http\Controllers\ContactController;
use App\Http\Controllers\Api\ProductPriceController as ApiProductPriceController;
use App\Http\Controllers\Examples\ApiExampleController;
use App\Http\Controllers\Examples\FormExampleController;
use App\Http\Controllers\HomeController;
use App\Http\Controllers\NewsController;
use App\Http\Controllers\ProductController;
use App\Http\Controllers\FaqController;
use App\Http\Controllers\TagController;
use App\Http\Controllers\ProfileController;
use App\Http\Controllers\ProfilePasswordController;
use App\Http\Controllers\ProfileEmailController;
use App\Http\Controllers\ProfilePhoneController;
use App\Http\Controllers\ProfilePriceInquiryController;
use App\Http\Controllers\PriceInquiryController;
use App\Http\Controllers\OrderFormController;
use App\Http\Controllers\PageController;
use Illuminate\Support\Facades\Route;

Route::get('/', [HomeController::class, 'index'])->name('home');

// Contact Routes
Route::get('/contact', [ContactController::class, 'index'])->name('contact.index');
Route::post('/contact', [ContactController::class, 'store'])->name('contact.store');

// CAPTCHA Routes
Route::get('/captcha/refresh', function () {
    return response()->json(['captcha' => captcha_img('default')]);
})->name('captcha.refresh');

// About Route
Route::get('/about', [AboutController::class, 'index'])->name('about.index');

// News Routes
Route::get('/news', [NewsController::class, 'index'])->name('news.index');
Route::get('/news/{slug}', [NewsController::class, 'show'])->name('news.show');

// Articles Routes
Route::get('/articles', [ArticleController::class, 'index'])->name('articles.index');
Route::get('/articles/{slug}', [ArticleController::class, 'show'])->name('articles.show');

// Products Routes
Route::get('/products', [ProductController::class, 'index'])->name('products.index');
Route::get('/products/{slug}', [ProductController::class, 'show'])->name('products.show');

// Tags Routes
Route::get('/tags/{slug}', [TagController::class, 'index'])->name('tags.index');

// FAQ Routes
Route::get('/faq', [FaqController::class, 'index'])->name('faq.index');

// Page Routes
Route::get('/page/{slug}', [PageController::class, 'show'])->name('page.show');

// Price Inquiry Routes
Route::get('/price-inquiry', [PriceInquiryController::class, 'create'])->name('price-inquiry.create');
Route::post('/price-inquiry', [PriceInquiryController::class, 'store'])->name('price-inquiry.store');

// Order Form Routes (Public)
Route::prefix('orders')->name('orders.')->group(function () {
    Route::get('/create/real/{productSlug}', [OrderFormController::class, 'createReal'])->name('create.real');
    Route::post('/create/real/{productSlug}', [OrderFormController::class, 'storeReal'])->name('store.real');

    Route::get('/create/legal/{productSlug}', [OrderFormController::class, 'createLegal'])->name('create.legal');
    Route::post('/create/legal/{productSlug}', [OrderFormController::class, 'storeLegal'])->name('store.legal');

    Route::get('/confirmation/{orderId}', [OrderFormController::class, 'confirmation'])->name('confirmation');
});

// Admin Authentication Routes
Route::prefix(config('admin.prefix'))->name(config('admin.route_name_prefix') . '.')->group(function () {
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

// User Profile Routes (Authenticated Users)
Route::middleware('auth:web')->prefix('profile')->name('user.profile.')->group(function () {
    Route::get('/', [ProfileController::class, 'show'])->name('show');
    Route::get('/edit', [ProfileController::class, 'edit'])->name('edit');
    Route::match(['put', 'patch'], '/', [ProfileController::class, 'update'])->name('update');

    // Password Management
    Route::get('/password/edit', [ProfilePasswordController::class, 'edit'])->name('password.edit');
    Route::match(['put', 'patch'], '/password', [ProfilePasswordController::class, 'update'])->name('password.update');

    // Email Management (with OTP verification)
    Route::prefix('email')->name('email.')->group(function () {
        Route::get('/edit', [ProfileEmailController::class, 'edit'])->name('edit');
        Route::post('/send-otp', [ProfileEmailController::class, 'sendOtp'])->name('send-otp');
        Route::get('/verify', [ProfileEmailController::class, 'showVerifyForm'])->name('verify');
        Route::post('/verify', [ProfileEmailController::class, 'verify'])->name('verify');
        Route::post('/resend-otp', [ProfileEmailController::class, 'resendOtp'])->name('resend-otp');
    });

    // Phone Management (with OTP verification)
    Route::prefix('phone')->name('phone.')->group(function () {
        Route::get('/edit', [ProfilePhoneController::class, 'edit'])->name('edit');
        Route::post('/send-otp', [ProfilePhoneController::class, 'sendOtp'])->name('send-otp');
        Route::get('/verify', [ProfilePhoneController::class, 'showVerifyForm'])->name('verify');
        Route::post('/verify', [ProfilePhoneController::class, 'verify'])->name('verify');
        Route::post('/resend-otp', [ProfilePhoneController::class, 'resendOtp'])->name('resend-otp');
    });

    // Price Inquiries Management
    Route::prefix('price-inquiries')->name('price-inquiries.')->group(function () {
        Route::get('/', [ProfilePriceInquiryController::class, 'index'])->name('index');
        Route::get('/{id}', [ProfilePriceInquiryController::class, 'show'])->name('show');
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

    // Product Price Routes
    Route::get('/products/{productId}/price-history', [ApiProductPriceController::class, 'getPriceHistory'])->name('products.price-history');

    // Product Search Route (for Select2)
    Route::get('/products/search', [\App\Http\Controllers\Api\ProductController::class, 'search'])->name('products.search');

    // Country & State Search Routes (for Order Forms)
    Route::get('/countries/search', [\App\Http\Controllers\Api\CountryController::class, 'search'])->name('countries.search');
    Route::get('/states/search', [\App\Http\Controllers\Api\StateController::class, 'search'])->name('states.search');
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
