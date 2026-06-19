<?php

/**
 * موديل المنتجات - منصة فادي
 * Fady E-commerce Product Model
 *
 * @author     Mohamed Alaa <fady@example.com>
 */

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Product extends Model
{
    use HasFactory;

    protected $fillable = [
        'category_id',
        'name',
        'slug',
        'short_description',
        'description',
        'price',
        'compare_price',
        'cost',
        'sku',
        'barcode',
        'stock_quantity',
        'low_stock_threshold',
        'weight',
        'length',
        'width',
        'height',
        'is_active',
        'is_featured',
        'views_count',
    ];

    /**
     * العلاقة بالتصنيف
     */
    public function category()
    {
        return $this->belongsTo(Category::class);
    }

    /**
     * صور المنتج
     */
    public function images()
    {
        return $this->hasMany(ProductImage::class);
    }

    /**
     * المتغيرات (مقاسات، ألوان)
     */
    public function variants()
    {
        return $this->hasMany(ProductVariant::class);
    }
}