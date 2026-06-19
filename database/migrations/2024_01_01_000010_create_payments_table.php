<?php

/**
 * جدول المدفوعات - منصة فادي
 * Fady E-commerce Payments Table
 *
 * أنا بسجل كل عملية دفع مرتبطة بالطلبات،
 * وبدعم طرق دفع متعددة مثل (كارت، تحويل، كاش عند الاستلام).
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
        Schema::create('payments', function (Blueprint $table) {
            $table->id();

            $table->foreignId('order_id')->constrained()->onDelete('cascade');

            // طريقة الدفع
            $table->enum('payment_method', [
                'credit_card', 'bank_transfer', 'cod', 'paypal', 'stripe'
            ]);

            $table->decimal('amount', 12, 2);

            // معرف المعاملة من البوابة
            $table->string('transaction_id', 100)->nullable();

            // حالة الدفع
            $table->enum('status', [
                'pending', 'completed', 'failed', 'refunded'
            ])->default('pending');

            $table->timestamp('payment_date')->nullable();

            // أنا بخزن استجابة البوابة (مشفرة) للأرشفة
            $table->text('gateway_response')->nullable();

            $table->timestamps();

            $table->index('order_id');
            $table->index('transaction_id');
            $table->index('status');
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('payments');
    }
};