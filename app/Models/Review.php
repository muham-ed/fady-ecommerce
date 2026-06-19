<?php

/**
 * موديل تقييمات المنتجات - منصة فادي
 * Fady E-commerce Review Model
 *
 * أنا سمحت للعملاء بتقييم المنتجات فقط بعد الشراء (عن طريق ربطه بـ `order_id`).
 *
 * @author     Mohamed Alaa <fady@example.com>
 * @version    1.0.0
 */

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Review extends Model
{
    use HasFactory;

    protected $fillable = [
        'product_id',
        'user_id',
        'order_id',
        'rating',
        'comment',
        'is_approved',
    ];

    public function product()
    {
        return $this->belongsTo(Product::class);
    }

    public function user()
    {
        return $this->belongsTo(User::class);
    }

    public function order()
    {
        return $this->belongsTo(Order::class);
    }
}