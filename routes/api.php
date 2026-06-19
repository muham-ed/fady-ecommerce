<?php

/**
 * ملف Routes الخاص بـ API - منصة فادي
 * Fady E-commerce API Routes
 *
 * أنا نظمت المسارات حسب الأدوار (عميل / أدمن)
 * ووضعت كل مسارات المصادقة في مكان واحد.
 *
 * @author     Mohamed Alaa <fady@example.com>
 * @version    1.0.0
 */

use App\Http\Controllers\Api\Auth\LoginController;
use App\Http\Controllers\Api\Auth\RegisterController;
use App\Http\Controllers\Api\Customer\CartController;
use App\Http\Controllers\Api\Customer\ProductController;
use App\Http\Controllers\Api\Admin\DashboardController;
use App\Http\Controllers\Api\Admin\ProductManagementController;
use App\Http\Controllers\Api\Admin\OrderManagementController;

// ------------------- مسارات المصادقة (العامة) -------------------
Route::post('/register', [RegisterController::class, 'register']);
Route::post('/login', [LoginController::class, 'login']);

// ------------------- مسارات العميل (محمية) -------------------
Route::middleware('auth:sanctum')->group(function () {
    // تسجيل الخروج
    Route::post('/logout', [LoginController::class, 'logout']);

    // السلة
    Route::get('/cart', [CartController::class, 'index']);
    Route::post('/cart/add', [CartController::class, 'add']);
    Route::delete('/cart/remove/{id}', [CartController::class, 'remove']);
    Route::put('/cart/update/{id}', [CartController::class, 'update']);

    // (هنا هضيف باقي مسارات الطلبات في التحديث الجاي)
});

// ------------------- مسارات المنتجات (عامة للجميع) -------------------
Route::get('/products', [ProductController::class, 'index']);
Route::get('/products/{slug}', [ProductController::class, 'show']);

// ------------------- مسارات الأدمن (محمية بصلاحية خاصة) -------------------
// استخدمت فحص صلاحية مبسّط داخل المسارات بدل تسجيل middleware جديد في Kernel
Route::middleware(['auth:sanctum','admin'])->prefix('admin')->group(function () {
    Route::apiResource('products', ProductManagementController::class);
    // Route::get('/dashboard', [DashboardController::class, 'index']);
});