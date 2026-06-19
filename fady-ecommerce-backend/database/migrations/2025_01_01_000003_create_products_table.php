<?php

/**
 * جدول المنتجات - منصة فادي التجارية
 * Fady E-commerce Products Table
 *
 * هذا الجدول هو قلب المنصة، يحتوي على جميع بيانات المنتجات
 * بما في ذلك الأسعار، المخزون، والمواصفات.
 *
 * @author     Mohamed Alaa <fady@example.com>
 * @version    1.0.0
 * @since      2026-06-19
 */

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        Schema::create('products', function (Blueprint $table) {
            $table->id();

            // العلاقة مع التصنيف (كل منتج يتبع تصنيف واحد)
            $table->foreignId('category_id')
                ->nullable()
                ->constrained()
                ->nullOnDelete(); // عند حذف التصنيف، تُفرّغ العلاقة بدل منع الحذف

            // المعلومات الأساسية للمنتج
            $table->string('name', 200);
            $table->string('slug', 220)->unique(); // رابط SEO صديق
            $table->string('short_description', 500)->nullable();
            $table->text('description')->nullable();

            // معلومات الأسعار (أنا بحطها بدقة عالية للتعامل المالي)
            $table->decimal('price', 12, 2); // السعر الأساسي
            $table->decimal('compare_price', 12, 2)->nullable(); // السعر قبل الخصم
            $table->decimal('cost', 12, 2)->nullable(); // تكلفة الشراء (للأدمن فقط)

            // معلومات المخزون والتعقب
            $table->string('sku', 100)->unique()->nullable(); // رقم المنتج الفريد
            $table->string('barcode', 100)->nullable(); // الباركود
            $table->integer('stock_quantity')->unsigned()->default(0);
            $table->integer('low_stock_threshold')->unsigned()->default(5); // حد التنبيه

            // الأبعاد (للشحن)
            $table->decimal('weight', 8, 2)->nullable();
            $table->decimal('length', 8, 2)->nullable();
            $table->decimal('width', 8, 2)->nullable();
            $table->decimal('height', 8, 2)->nullable();

            // حالات المنتج
            $table->boolean('is_active')->default(true);
            $table->boolean('is_featured')->default(false);

            // إحصائيات
            $table->bigInteger('views_count')->unsigned()->default(0);

            $table->timestamps();

            // أنا بضيف فهارس عشان سرعة البحث
            $table->index('slug');
            $table->index('sku');
            $table->index('is_active');
            $table->index('category_id');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('products');
    }
};