<?php

/**
 * جدول الشحن - منصة فادي
 * Fady E-commerce Shipments Table
 *
 * أنا بتتبع رحلة الشحن من التجهيز حتى التسليم،
 * مع رقم التتبع لشركات الشحن.
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
        Schema::create('shipments', function (Blueprint $table) {
            $table->id();

            $table->foreignId('order_id')->constrained()->onDelete('cascade');

            // معلومات شركة الشحن
            $table->string('carrier', 100)->nullable(); // مثل: DHL, Aramex
            $table->string('tracking_number', 100)->nullable();
            $table->string('tracking_url', 255)->nullable();

            // التواريخ المهمة
            $table->timestamp('shipped_at')->nullable();
            $table->date('estimated_delivery')->nullable();
            $table->timestamp('delivered_at')->nullable();

            $table->timestamps();

            $table->index('order_id');
            $table->index('tracking_number');
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('shipments');
    }
};