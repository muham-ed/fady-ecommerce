<?php

/**
 * موديل الطلبات - منصة فادي التجارية
 * Fady E-commerce Order Model
 *
 * هذا الموديل مسؤول عن إدارة جميع الطلبات التي يقوم بها العملاء،
 * ويتضمن حالة الطلب، بيانات الدفع، والعنوان.
 *
 * @author     Mohamed Alaa <fady@example.com>
 * @version    1.0.0
 * @since      2026-06-19
 */

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Order extends Model
{
    use HasFactory;

    /**
     * الحقول المسموح بتعبئتها مباشرة (Mass Assignment)
     * أنا حددتها عشان أحمي قاعدة البيانات من الإدخالات الضارة.
     */
    protected $fillable = [
        'user_id',
        'order_number',
        'status',
        'payment_status',
        'subtotal',
        'discount',
        'tax',
        'shipping_cost',
        'total',
        'currency',
        'shipping_address_id',
        'billing_address_id',
        'notes',
        'placed_at',
    ];

    /**
     * تحويلات أنواع البيانات
     * عشان أتعامل مع الأسعار كأرقام عشرية والتواريخ ككائنات وقت.
     */
    protected $casts = [
        'subtotal' => 'decimal:2',
        'discount' => 'decimal:2',
        'tax' => 'decimal:2',
        'shipping_cost' => 'decimal:2',
        'total' => 'decimal:2',
        'placed_at' => 'datetime',
    ];

    // ------------------- العلاقات (Relationships) -------------------

    /**
     * العميل صاحب الطلب
     */
    public function user()
    {
        return $this->belongsTo(User::class);
    }

    /**
     * عناوين الشحن والفواتير
     */
    public function shippingAddress()
    {
        return $this->belongsTo(Address::class, 'shipping_address_id');
    }

    public function billingAddress()
    {
        return $this->belongsTo(Address::class, 'billing_address_id');
    }

    /**
     * عناصر الطلب (المنتجات المشتراة)
     */
    public function items()
    {
        return $this->hasMany(OrderItem::class);
    }

    /**
     * عملية الدفع الخاصة بالطلب
     */
    public function payment()
    {
        return $this->hasOne(Payment::class);
    }

    /**
     * بيانات الشحن (التتبع)
     */
    public function shipment()
    {
        return $this->hasOne(Shipment::class);
    }
}