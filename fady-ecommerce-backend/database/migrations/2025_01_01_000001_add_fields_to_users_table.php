<?php

/**
 * إضافة أعمدة جديدة لجدول المستخدمين - منصة فادي
 * Fady E-commerce Add Fields to Users Table
 *
 * أنا بضيف الحقول المهمة للمستخدمين (رقم الهاتف، الدور، الحالة)
 * عشان أكمل نظام المصادقة والأدوار.
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
        Schema::table('users', function (Blueprint $table) {
            // أنا بحط الأعمدة الجديدة بعد حقل email عشان الترتيب يكون منطقي
            $table->string('phone', 20)->nullable()->after('email');
            $table->enum('role', ['customer', 'admin', 'super_admin'])
                ->default('customer')
                ->after('phone');
            $table->boolean('is_active')->default(true)->after('role');
            $table->timestamp('last_login_at')->nullable()->after('is_active');
        });
    }

    public function down(): void
    {
        Schema::table('users', function (Blueprint $table) {
            $table->dropColumn(['phone', 'role', 'is_active', 'last_login_at']);
        });
    }
};