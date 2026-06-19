<?php

/**
 * موديل المدفوعات - منصة فادي
 * Fady E-commerce Payment Model
 *
 * أنا استخدم هذا الموديل لتسجيل جميع عمليات الدفع،
 * ودعم طرق الدفع المتعددة (كارت، تحويل، كاش).
 *
 * @author     Mohamed Alaa <fady@example.com>
 * @version    1.0.0
 */

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Payment extends Model
{
    use HasFactory;

    protected $fillable = [
        'order_id',
        'payment_method',
        'amount',
        'transaction_id',
        'status',
        'payment_date',
        'gateway_response',
    ];

    protected $casts = [
        'amount' => 'decimal:2',
        'payment_date' => 'datetime',
    ];

    public function order()
    {
        return $this->belongsTo(Order::class);
    }
}