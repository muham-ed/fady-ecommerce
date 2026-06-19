<?php

/**
 * جدول العناوين - منصة فادي
 * Fady E-commerce Addresses Table
 *
 * أنا بستخدم هذا الجدول لتخزين عناوين العملاء،
 * ويدعم عناوين متعددة لكل عميل مع إمكانية تحديد عنوان افتراضي.
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
        Schema::create('addresses', function (Blueprint $table) {
            $table->id();

            $table->foreignId('user_id')->constrained()->onDelete('cascade');

            // معلومات العنوان
            $table->string('label', 50)->default('Home'); // Home, Work, etc.
            $table->string('recipient_name', 100);
            $table->string('phone', 20);

            // تفاصيل العنوان
            $table->string('address_line1', 255);
            $table->string('address_line2', 255)->nullable();
            $table->string('city', 100);
            $table->string('state', 100)->nullable();
            $table->string('postal_code', 20)->nullable();
            $table->string('country', 100)->default('Egypt');

            // عنوان افتراضي
            $table->boolean('is_default')->default(false);

            $table->timestamps();

            $table->index('user_id');
            $table->index('is_default');
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('addresses');
    }
};