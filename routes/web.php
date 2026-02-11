<?php

use App\Http\Controllers\AdminAuthController;
use App\Http\Controllers\AdminBlogPostController;
use App\Http\Controllers\BlogController;
use App\Http\Controllers\PaymentController;
use App\Http\Controllers\SubscriptionController;
use Illuminate\Support\Facades\Route;

Route::get('/', [BlogController::class, 'index'])->name('home');
Route::get('/article/{blog_post:slug}', [BlogController::class, 'show'])->name('blog.show');
Route::get('/article/{blog_post:slug}/payment', [PaymentController::class, 'create'])->name('blog.payment.form');

Route::middleware(['auth'])->group(function () {
    Route::post('/article/{blog_post:slug}/payment', [PaymentController::class, 'store'])->name('blog.payment');

    Route::get('/subscription', [SubscriptionController::class, 'index'])->name('subscription.dashboard');
    Route::post('/subscription/subscribe', [SubscriptionController::class, 'store'])->name('subscription.subscribe');
    Route::post('/subscription/cancel', [SubscriptionController::class, 'cancel'])->name('subscription.cancel');
});

Route::middleware(['guest'])->group(function () {
    Route::get('/login', [AdminAuthController::class, 'showLogin'])->name('login');
    Route::post('/login', [AdminAuthController::class, 'login']);
    Route::get('/admin/login', [AdminAuthController::class, 'showLogin'])->name('admin.login');
    Route::post('/admin/login', [AdminAuthController::class, 'login']);
});

Route::middleware(['auth', 'admin'])->group(function () {
    Route::post('/admin/logout', [AdminAuthController::class, 'logout'])->name('admin.logout');
    Route::get('/admin/posts/create', [AdminBlogPostController::class, 'create'])->name('admin.posts.create');
    Route::post('/admin/posts', [AdminBlogPostController::class, 'store'])->name('admin.posts.store');
});
