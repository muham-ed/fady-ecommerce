<?php

/**
 * موديل سلة التسوق - منصة فادي
 * Fady E-commerce Cart Model
 *
 * أنا استخدم هذا الموديل لتتبع المنتجات التي يضيفها العميل قبل الشراء،
 * ويدعم المستخدمين المسجلين والزوار عبر `session_id`.
 *
 * @author     Mohamed Alaa <fady@example.com>
 * @version    1.0.0
 */

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Cart extends Model
{
    use HasFactory;

    protected $fillable = [
        'user_id',
        'session_id',
        'product_id',
        'variant_id',
        'quantity',
        'added_at',
    ];

    // أنا بتعامل مع الوقت كـ Carbon object
    protected $casts = [
        'added_at' => 'datetime',
    ];

    public function user()
    {
        return $this->belongsTo(User::class);
    }

    public function product()
    {
        return $this->belongsTo(Product::class);
    }

    public function variant()
    {
        return $this->belongsTo(ProductVariant::class);
    }
}