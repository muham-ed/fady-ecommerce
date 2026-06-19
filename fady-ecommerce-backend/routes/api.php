<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;

Route::prefix('v1')->group(function () {
    Route::apiResource('products', App\Http\Controllers\Api\ProductController::class);
    Route::apiResource('categories', App\Http\Controllers\Api\CategoryController::class);
    Route::apiResource('orders', App\Http\Controllers\Api\OrderController::class)->only(['index','show','store']);

    // Auth routes (register/login) — token based for SPA (Sanctum)
    Route::post('register', [App\Http\Controllers\Auth\RegisteredUserController::class, 'store']);
    Route::post('login', [App\Http\Controllers\Auth\AuthenticatedSessionController::class, 'store']);
    Route::post('logout', [App\Http\Controllers\Auth\AuthenticatedSessionController::class, 'destroy'])->middleware('auth:sanctum');

    // Payments
    Route::post('payments/checkout', [App\Http\Controllers\Api\PaymentController::class, 'createCheckoutSession']);
});
