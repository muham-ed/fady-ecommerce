<?php

/**
 * جدول تقييمات المنتجات - منصة فادي
 * Fady E-commerce Reviews Table
 *
 * أنا بسمح للعملاء بتقييم المنتجات فقط بعد الشراء،
 * عن طريق ربط التقييم بـ order_id (ضمان الجودة).
 *
 * @author     Mohamed Alaa <fady@example.com>
 * @version    1.0.0
 */

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('reviews', function (Blueprint $table) {
            $table->id();

            $table->foreignId('product_id')->constrained()->onDelete('cascade');
            $table->foreignId('user_id')->constrained()->onDelete('cascade');
            $table->foreignId('order_id')->nullable()->constrained()->nullOnDelete();

            // التقييم من 1 إلى 5 نجوم
            $table->tinyInteger('rating')->unsigned()->check('rating BETWEEN 1 AND 5');

            $table->text('comment')->nullable();

            // موافقة الأدمن قبل النشر
            $table->boolean('is_approved')->default(false);

            $table->timestamps();

            // منع تكرار التقييم لنفس المنتج من نفس المستخدم
            $table->unique(['product_id', 'user_id']);

            $table->index('product_id');
            $table->index('user_id');
            $table->index('is_approved');
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('reviews');
    }
};