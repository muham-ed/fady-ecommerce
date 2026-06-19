<?php

/**
 * موديل سجل حركة المخزون - منصة فادي
 * Fady E-commerce Inventory Log Model
 *
 * أنا استخدم هذا الموديل لتتبع كل حركة دخول أو خروج للمنتجات،
 * عشان أقدر أرجع لأي تعديل لو حصل خطأ.
 *
 * @author     Mohamed Alaa <fady@example.com>
 */

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class InventoryLog extends Model
{
    use HasFactory;

    protected $fillable = [
        'product_id',
        'variant_id',
        'old_quantity',
        'new_quantity',
        'change_reason',
        'reference_id',
        'admin_id',
    ];

    public function product()
    {
        return $this->belongsTo(Product::class);
    }

    public function variant()
    {
        return $this->belongsTo(ProductVariant::class);
    }

    public function admin()
    {
        return $this->belongsTo(User::class, 'admin_id');
    }
}