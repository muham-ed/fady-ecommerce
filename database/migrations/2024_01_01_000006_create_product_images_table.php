<?php

/**
 * جدول صور المنتجات - منصة فادي
 * Fady E-commerce Product Images Table
 *
 * أنا بستخدم هذا الجدول لتخزين صور متعددة لكل منتج،
 * مع إمكانية تحديد صورة رئيسية واحدة.
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
        Schema::create('product_images', function (Blueprint $table) {
            $table->id();

            $table->foreignId('product_id')
                ->constrained()
                ->onDelete('cascade'); // لو اتحذف المنتج، اتحذف صوره

            $table->string('image_url', 255);
            $table->string('alt_text', 255)->nullable(); // للنصوص البديلة (SEO)
            $table->boolean('is_primary')->default(false); // الصورة الرئيسية
            $table->integer('sort_order')->unsigned()->default(0); // ترتيب العرض

            $table->timestamps();

            $table->index('product_id');
            $table->index('is_primary');
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('product_images');
    }
};