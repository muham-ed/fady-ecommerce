<?php

/**
 * موديل التصنيفات - منصة فادي
 * Fady E-commerce Category Model
 *
 * @author     Mohamed Alaa <fady@example.com>
 */

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Category extends Model
{
    use HasFactory;

    protected $fillable = [
        'parent_id',
        'name',
        'slug',
        'description',
        'image_url',
        'is_active',
    ];

    /**
     * التصنيف الرئيسي (الأب)
     */
    public function parent()
    {
        return $this->belongsTo(Category::class, 'parent_id');
    }

    /**
     * التصنيفات الفرعية (الأبناء)
     */
    public function children()
    {
        return $this->hasMany(Category::class, 'parent_id');
    }

    /**
     * المنتجات التابعة لهذا التصنيف
     */
    public function products()
    {
        return $this->hasMany(Product::class);
    }
}