<?php

use App\Enums\Database\ContentType;
use App\Models\Content;
use Illuminate\Support\Facades\Route;

// SEO Support Routes - Legacy URL redirects for better SEO

// Products Routes - Redirect capitalized version to lowercase
Route::get('/Products', function () {
    return redirect()->to('/products' . (request()->getQueryString() ? '?' . request()->getQueryString() : ''), 301);
});

// Products Routes - Redirect legacy product show route
Route::get('/Product/{id}/{slug}', function ($id, $slug) {
    $queryString = request()->getQueryString();
    return redirect()->to('/products/' . $slug . ($queryString ? '?' . $queryString : ''), 301);
});

// Contact Routes - Redirect capitalized version to lowercase
Route::get('/ContactUs', function () {
    return redirect()->to('/contact' . (request()->getQueryString() ? '?' . request()->getQueryString() : ''), 301);
});

// About Routes - Redirect capitalized version to lowercase
Route::get('/About', function () {
    return redirect()->to('/about' . (request()->getQueryString() ? '?' . request()->getQueryString() : ''), 301);
});

// News Routes - Redirect capitalized version to lowercase
Route::get('/News', function () {
    return redirect()->to('/news' . (request()->getQueryString() ? '?' . request()->getQueryString() : ''), 301);
});

// News Routes - Redirect legacy news show route
Route::get('/n/{id}/{slug}', function ($id, $slug) {
    $queryString = request()->getQueryString();
    return redirect()->to('/news/' . $slug . ($queryString ? '?' . $queryString : ''), 301);
});

// Articles Routes - Redirect capitalized version to lowercase
Route::get('/Article', function () {
    return redirect()->to('/articles' . (request()->getQueryString() ? '?' . request()->getQueryString() : ''), 301);
});

// Articles Routes - Redirect legacy article show route
Route::get('/a/{id}/{slug}', function ($id, $slug) {
    $queryString = request()->getQueryString();
    return redirect()->to('/articles/' . $slug . ($queryString ? '?' . $queryString : ''), 301);
});

// FAQ Routes - Redirect capitalized version to lowercase
Route::get('/Faq', function () {
    return redirect()->to('/faq' . (request()->getQueryString() ? '?' . request()->getQueryString() : ''), 301);
});

// Price Inquiry Routes - Redirect legacy price inquiry route
Route::get('/InquiryPrice', function () {
    return redirect()->to('/price-inquiry' . (request()->getQueryString() ? '?' . request()->getQueryString() : ''), 301);
});

// Page Routes - Redirect legacy page route by ID to slug
Route::get('/p/{id}', function ($id) {
    $content = Content::where('id', $id)
        ->where('type', ContentType::PAGE->value)
        ->where('is_active', true)
        ->first();

    if ($content) {
        $queryString = request()->getQueryString();
        return redirect()->to('/page/' . $content->slug . ($queryString ? '?' . $queryString : ''), 301);
    }

    // If content not found, redirect to home
    return redirect()->to('/' . (request()->getQueryString() ? '?' . request()->getQueryString() : ''), 301);
});

// Tag Routes - Redirect legacy tag show route
Route::get('/t/{id}/{slug}', function ($id, $slug) {
    $queryString = request()->getQueryString();
    return redirect()->to('/tags/' . $slug . ($queryString ? '?' . $queryString : ''), 301);
});

// Auth Routes - Redirect legacy authentication routes
Route::get('/Auth/LoginPage', function () {
    return redirect()->to('/auth/login' . (request()->getQueryString() ? '?' . request()->getQueryString() : ''), 301);
});

Route::get('/Auth/RegisterPage', function () {
    return redirect()->to('/auth/register' . (request()->getQueryString() ? '?' . request()->getQueryString() : ''), 301);
});

Route::get('/Auth/Forget', function () {
    return redirect()->to('/auth/forgot-password' . (request()->getQueryString() ? '?' . request()->getQueryString() : ''), 301);
});

