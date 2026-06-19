<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;

Route::prefix('v1')->group(function () {
    // Public routes
    Route::get('products', [App\Http\Controllers\Api\ProductController::class, 'index']);
    Route::get('products/{product}', [App\Http\Controllers\Api\ProductController::class, 'show']);
    Route::get('categories', [App\Http\Controllers\Api\CategoryController::class, 'index']);
    Route::get('categories/{category}', [App\Http\Controllers\Api\CategoryController::class, 'show']);

    // Auth routes (register/login) — token based for SPA (Sanctum)
    Route::post('register', [App\Http\Controllers\Auth\RegisteredUserController::class, 'store']);
    Route::post('login', [App\Http\Controllers\Auth\AuthenticatedSessionController::class, 'store']);
    Route::post('logout', [App\Http\Controllers\Auth\AuthenticatedSessionController::class, 'destroy'])->middleware('auth:sanctum');

    // Orders & cart
    Route::get('orders', [App\Http\Controllers\Api\OrderController::class, 'index'])->middleware('auth:sanctum');
    Route::get('orders/{order}', [App\Http\Controllers\Api\OrderController::class, 'show'])->middleware('auth:sanctum');
    Route::post('orders', [App\Http\Controllers\Api\OrderController::class, 'store'])->middleware('auth:sanctum');

    // Payments
    Route::post('payments/checkout', [App\Http\Controllers\Api\PaymentController::class, 'createCheckoutSession'])->middleware('auth:sanctum');

    // File upload (products images) - admin
    Route::post('upload', [App\Http\Controllers\Api\UploadController::class, 'upload'])->middleware(['auth:sanctum','admin']);

    // Admin product management - protected by admin middleware
    Route::middleware(['auth:sanctum','admin'])->group(function(){
        Route::apiResource('admin/products', App\Http\Controllers\Api\Admin\ProductController::class);
        Route::apiResource('admin/categories', App\Http\Controllers\Api\Admin\CategoryController::class);
    });

    // Endpoint to get current authenticated user
    Route::middleware('auth:sanctum')->get('/user', function (Request $request) {
        return $request->user();
    });

    // Webhooks
    Route::post('webhooks/paymob', [App\Http\Controllers\Api\WebhookController::class, 'handlePaymob']);
    Route::post('webhooks/stripe', [App\Http\Controllers\Api\WebhookController::class, 'handleStripe']);
});
