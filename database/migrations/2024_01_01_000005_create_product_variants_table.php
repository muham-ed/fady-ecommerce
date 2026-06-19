<?php

/**
 * جدول متغيرات المنتج - منصة فادي
 * Fady E-commerce Product Variants Table
 *
 * أنا بستخدم هذا الجدول للمنتجات التي لها مقاسات أو ألوان مختلفة،
 * مثل: (اللون: أحمر، المقاس: L) مع سعر ومخزون منفصل.
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
        Schema::create('product_variants', function (Blueprint $table) {
            $table->id();

            $table->foreignId('product_id')
                ->constrained()
                ->onDelete('cascade');

            // خصائص المتغير
            $table->string('attribute_name', 50); // مثل: size, color
            $table->string('attribute_value', 100); // مثل: Large, Red

            // معلومات خاصة بالمتغير
            $table->string('sku', 100)->unique()->nullable();
            $table->decimal('additional_price', 10, 2)->default(0.00); // سعر إضافي
            $table->integer('stock_quantity')->unsigned()->default(0);

            $table->timestamps();

            // أنا بضمن عدم تكرار نفس المتغير لنفس المنتج
            $table->unique(['product_id', 'attribute_name', 'attribute_value']);

            $table->index('product_id');
            $table->index('sku');
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('product_variants');
    }
};