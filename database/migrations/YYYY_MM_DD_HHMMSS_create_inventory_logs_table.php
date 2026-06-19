<?php

/**
 * جدول سجل حركة المخزون - منصة فادي
 * Fady E-commerce Inventory Logs Table
 *
 * أنا بتتبع كل حركة في المخزون (بيع، شراء، تعديل، مرتجع)
 * عشان أقدر أرجع لأي تغيير لو حصل خطأ،
 * وده مهم جداً لإدارة المخزون الاحترافية.
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
        Schema::create('inventory_logs', function (Blueprint $table) {
            $table->id();

            $table->foreignId('product_id')->constrained()->onDelete('cascade');
            $table->foreignId('variant_id')->nullable()->constrained('product_variants')->onDelete('cascade');

            // الكميات القديمة والجديدة
            $table->integer('old_quantity');
            $table->integer('new_quantity');

            // سبب التغيير
            $table->enum('change_reason', [
                'purchase', 'sale', 'return', 'adjustment', 'restock'
            ]);

            // مرجع للتغيير (مثل order_id أو purchase_order_id)
            $table->bigInteger('reference_id')->unsigned()->nullable();

            // الأدمن الذي قام بالتعديل
            $table->foreignId('admin_id')->nullable()->constrained('users')->nullOnDelete();

            $table->timestamps();

            $table->index('product_id');
            $table->index('variant_id');
            $table->index('change_reason');
            $table->index('reference_id');
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('inventory_logs');
    }
};