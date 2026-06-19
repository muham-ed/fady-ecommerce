<?php

/**
 * جدول التصنيفات - منصة فادي
 * Fady E-commerce Categories Table
 *
 * أنا بستخدم هذا الجدول لتصنيف المنتجات بشكل هرمي،
 * مع دعم التصنيفات الفرعية.
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
        Schema::create('categories', function (Blueprint $table) {
            $table->id();

            // التصنيف الأب (للدعم الهرمي)
            $table->foreignId('parent_id')->nullable()->constrained('categories')->onDelete('cascade');

            // معلومات التصنيف
            $table->string('name', 100);
            $table->string('slug', 120)->unique();
            $table->text('description')->nullable();

            // الصورة
            $table->string('image_url', 255)->nullable();

            // الترتيب والعرض
            $table->integer('sort_order')->unsigned()->default(0);
            $table->boolean('is_active')->default(true);
            $table->boolean('is_featured')->default(false);

            $table->timestamps();

            $table->index('parent_id');
            $table->index('slug');
            $table->index('is_active');
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('categories');
    }
};
