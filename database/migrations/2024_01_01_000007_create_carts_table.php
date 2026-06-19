<?php

/**
 * جدول سلة التسوق - منصة فادي
 * Fady E-commerce Cart Table
 *
 * أنا دعمت نوعين من المستخدمين في السلة:
 * 1- المستخدم المسجل (user_id)
 * 2- الزائر (session_id)
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
        Schema::create('carts', function (Blueprint $table) {
            $table->id();

            // إما مستخدم مسجل أو زائر
            $table->foreignId('user_id')->nullable()->constrained()->onDelete('cascade');
            $table->string('session_id', 100)->nullable();

            // المنتج والمتغير
            $table->foreignId('product_id')->constrained()->onDelete('cascade');
            $table->foreignId('variant_id')->nullable()->constrained('product_variants')->onDelete('cascade');

            // الكمية
            $table->integer('quantity')->unsigned()->default(1);

            // توقيت الإضافة
            $table->timestamp('added_at')->useCurrent();

            $table->timestamps();

            // أنا بحط فهارس عشان البحث السريع
            $table->index('user_id');
            $table->index('session_id');
            $table->index('product_id');

            // أنا بمنع تكرار نفس المنتج لنفس المستخدم في السلة
            $table->unique(['user_id', 'product_id', 'variant_id']);
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('carts');
    }
};