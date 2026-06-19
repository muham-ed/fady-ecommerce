<?php

/**
 * جدول الطلبات - منصة فادي
 * Fady E-commerce Orders Table
 *
 * هذا الجدول هو سجل كل طلب يتم في المنصة،
 * ويحتوي على كل التفاصيل المالية والعناوين.
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
        Schema::create('orders', function (Blueprint $table) {
            $table->id();

            $table->foreignId('user_id')->constrained()->restrictOnDelete();

            // رقم الطلب الفريد (للعميل)
            $table->string('order_number', 50)->unique();

            // حالات الطلب
            $table->enum('status', [
                'pending', 'processing', 'shipped',
                'delivered', 'canceled', 'refunded'
            ])->default('pending');

            $table->enum('payment_status', [
                'unpaid', 'paid', 'failed', 'refunded'
            ])->default('unpaid');

            // المعلومات المالية (أنا بحسبها بدقة)
            $table->decimal('subtotal', 12, 2);
            $table->decimal('discount', 12, 2)->default(0.00);
            $table->decimal('tax', 12, 2)->default(0.00);
            $table->decimal('shipping_cost', 12, 2)->default(0.00);
            $table->decimal('total', 12, 2);
            $table->string('currency', 3)->default('EGP');

            // العناوين (شحن وفواتير)
            $table->foreignId('shipping_address_id')->constrained('addresses');
            $table->foreignId('billing_address_id')->nullable()->constrained('addresses');

            // ملاحظات
            $table->text('notes')->nullable();

            // توقيت الطلب
            $table->timestamp('placed_at')->useCurrent();

            $table->timestamps();

            // فهارس للبحث السريع
            $table->index('user_id');
            $table->index('order_number');
            $table->index('status');
            $table->index('payment_status');
            $table->index('placed_at');
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('orders');
    }
};