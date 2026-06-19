<?php

use App\Http\Controllers\Api\Auth\LoginController;
use App\Http\Controllers\Api\Auth\RegisterController;
use App\Http\Controllers\Api\Admin\ProductManagementController;
use App\Http\Controllers\Api\PaymentController;
use App\Http\Controllers\Api\Customer\ProductController as CustomerProductController;
use App\Http\Controllers\Api\Customer\CartController as CustomerCartController;
use Illuminate\Session\Middleware\StartSession;
use Illuminate\Support\Facades\Route;

// ------------------- Auth -------------------
Route::post('/register', [RegisterController::class, 'register']);
Route::post('/login', [LoginController::class, 'login']);

Route::middleware('auth:sanctum')->group(function () {
    Route::post('/logout', [LoginController::class, 'logout']);
});

// ------------------- Storefront products (public) -------------------
Route::get('/products', [CustomerProductController::class, 'index']);
Route::get('/products/{slug}', [CustomerProductController::class, 'show']);

// ------------------- Cart (guests via session or logged-in users) -------------------
Route::middleware(StartSession::class)->group(function () {
    Route::get('/cart', [CustomerCartController::class, 'index']);
    Route::post('/cart/add', [CustomerCartController::class, 'add']);
    Route::delete('/cart/remove/{id}', [CustomerCartController::class, 'remove']);
    Route::put('/cart/update/{id}', [CustomerCartController::class, 'update']);
});

// ------------------- Payment -------------------
Route::post('/payment/intent', [PaymentController::class, 'createIntent']);
Route::post('/payment/webhook', [PaymentController::class, 'webhook']);

// ------------------- Admin (auth + admin role) -------------------
Route::middleware(['auth:sanctum', 'admin'])->prefix('admin')->group(function () {
    Route::apiResource('products', ProductManagementController::class);
});
