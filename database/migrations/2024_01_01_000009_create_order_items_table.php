<?php

/**
 * جدول عناصر الطلب - منصة فادي
 * Fady E-commerce Order Items Table
 *
 * أنا بسجل كل منتج تم شراؤه في الطلب مع سعره وقت الشراء،
 * عشان لو تغير سعر المنتج بعدين، يفضل الطلب كما هو.
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
        Schema::create('order_items', function (Blueprint $table) {
            $table->id();

            $table->foreignId('order_id')->constrained()->onDelete('cascade');

            $table->foreignId('product_id')->constrained()->restrictOnDelete();
            $table->foreignId('variant_id')->nullable()->constrained('product_variants')->nullOnDelete();

            // أنا بخزن نسخة من اسم المنتج و SKU وقت الشراء
            $table->string('product_name', 200);
            $table->string('sku', 100)->nullable();

            // الكميات والأسعار
            $table->integer('quantity')->unsigned();
            $table->decimal('unit_price', 12, 2);
            $table->decimal('total_price', 12, 2);

            $table->timestamps();

            $table->index('order_id');
            $table->index('product_id');
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('order_items');
    }
};