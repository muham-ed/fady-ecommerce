<?php

/**
 * موديل متغيرات المنتج (مقاسات، ألوان) - منصة فادي
 * Fady E-commerce Product Variant Model
 *
 * @author     Mohamed Alaa <fady@example.com>
 */

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class ProductVariant extends Model
{
    use HasFactory;

    protected $fillable = [
        'product_id',
        'attribute_name',
        'attribute_value',
        'sku',
        'additional_price',
        'stock_quantity',
    ];

    protected $casts = [
        'additional_price' => 'decimal:2',
    ];

    public function product()
    {
        return $this->belongsTo(Product::class);
    }
}