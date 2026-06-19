<?php

use App\Http\Controllers\Api\Auth\LoginController;
use App\Http\Controllers\Api\Auth\RegisterController;
use App\Http\Controllers\Api\Admin\ProductManagementController;
use Illuminate\Support\Facades\Route;

Route::post('/register', [RegisterController::class, 'register']);
Route::post('/login', [LoginController::class, 'login']);

Route::middleware('auth:sanctum')->group(function () {
    Route::post('/logout', [LoginController::class, 'logout']);
});

use App\Http\Controllers\Api\PaymentController;

// Payment routes
Route::post('/payment/intent', [PaymentController::class, 'createIntent']);
Route::post('/payment/webhook', [PaymentController::class, 'webhook']);

use App\Http\Controllers\Api\Customer\ProductController as CustomerProductController;
use App\Http\Controllers\Api\Customer\CartController as CustomerCartController;

// Storefront API
Route::get('/products', [CustomerProductController::class, 'index']);
Route::get('/products/{slug}', [CustomerProductController::class, 'show']);

Route::get('/cart', [CustomerCartController::class, 'index']);
Route::post('/cart/add', [CustomerCartController::class, 'add']);
Route::delete('/cart/remove/{id}', [CustomerCartController::class, 'remove']);
Route::put('/cart/update/{id}', [CustomerCartController::class, 'update']);

Route::middleware(['auth:sanctum','admin'])->prefix('admin')->group(function () {
    Route::apiResource('products', ProductManagementController::class);
});
