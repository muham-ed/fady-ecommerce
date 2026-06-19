<?php

/**
 * منتجات العميل - منصة فادي
 * Fady E-commerce Customer Product Controller
 *
 * أنا مسؤول عن عرض المنتجات للعملاء (القائمة، التفاصيل، والفلترة).
 *
 * @author     Mohamed Alaa <fady@example.com>
 * @version    1.0.0
 */

namespace App\Http\Controllers\Api\Customer;

use App\Http\Controllers\Controller;
use App\Models\Product;
use Illuminate\Http\Request;

class ProductController extends Controller
{
    /**
     * عرض قائمة المنتجات (مع إمكانية البحث والفلترة)
     * أنا بدعم pagination عشان السرعة.
     */
    public function index(Request $request)
    {
        $query = Product::where('is_active', true)
            ->with(['category', 'images']);

        // فلترة حسب التصنيف
        if ($request->has('category_id')) {
            $query->where('category_id', $request->category_id);
        }

        // فلترة حسب السعر
        if ($request->has('min_price')) {
            $query->where('price', '>=', $request->min_price);
        }
        if ($request->has('max_price')) {
            $query->where('price', '<=', $request->max_price);
        }

        // البحث بالاسم
        if ($request->has('search')) {
            $query->where('name', 'LIKE', '%' . $request->search . '%');
        }

        $products = $query->paginate(20);

        return response()->json($products);
    }

    /**
     * عرض تفاصيل منتج معين
     * أنا بزيد عدد المشاهدات في كل مرة.
     */
    public function show($slug)
    {
        $product = Product::where('slug', $slug)
            ->where('is_active', true)
            ->with(['category', 'images', 'variants'])
            ->firstOrFail();

        // زيادة عدد المشاهدات (أنا بسجل الإحصاءات)
        $product->increment('views_count');

        return response()->json($product);
    }
}