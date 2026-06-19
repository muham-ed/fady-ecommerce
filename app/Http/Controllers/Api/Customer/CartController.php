<?php

/**
 * سلة التسوق - منصة فادي
 * Fady E-commerce Cart Controller
 *
 * أنا أتحكم في إضافة وحذف وتحديث منتجات السلة،
 * وربطها إما بالمستخدم المسجل أو بالـ session_id للزوار.
 *
 * @author     Mohamed Alaa <fady@example.com>
 */

namespace App\Http\Controllers\Api\Customer;

use App\Http\Controllers\Controller;
use App\Models\Cart;
use App\Models\Product;
use Illuminate\Http\Request;

class CartController extends Controller
{
    /**
     * عرض محتويات السلة
     */
    public function index(Request $request)
    {
        $userId = $request->user()?->id;
        $sessionId = $request->session()->getId();

        $cartItems = Cart::where('user_id', $userId)
            ->orWhere('session_id', $sessionId)
            ->with(['product', 'variant'])
            ->get();

        // أنا بحسب الإجمالي بنفسي عشان أريح الـ Frontend
        $total = $cartItems->sum(function ($item) {
            $price = $item->product->price + ($item->variant?->additional_price ?? 0);
            return $price * $item->quantity;
        });

        return response()->json([
            'items' => $cartItems,
            'total' => $total,
            'count' => $cartItems->sum('quantity'),
        ]);
    }

    /**
     * إضافة منتج للسلة
     */
    public function add(Request $request)
    {
        $request->validate([
            'product_id' => 'required|exists:products,id',
            'variant_id' => 'nullable|exists:product_variants,id',
            'quantity' => 'required|integer|min:1',
        ]);

        $userId = $request->user()?->id;
        $sessionId = $request->session()->getId();

        // أنا بتأكد لو المنتج موجود بالفعل في السلة، أزود الكمية بدل ما أعمل مدخل جديد
        $cartItem = Cart::where('product_id', $request->product_id)
            ->where('variant_id', $request->variant_id)
            ->where(function ($query) use ($userId, $sessionId) {
                $query->where('user_id', $userId)
                    ->orWhere('session_id', $sessionId);
            })
            ->first();

        if ($cartItem) {
            $cartItem->increment('quantity', $request->quantity);
        } else {
            Cart::create([
                'user_id' => $userId,
                'session_id' => $sessionId,
                'product_id' => $request->product_id,
                'variant_id' => $request->variant_id,
                'quantity' => $request->quantity,
            ]);
        }

        return response()->json(['message' => 'تم إضافة المنتج للسلة بنجاح ✅'], 201);
    }

    /**
     * حذف منتج من السلة
     */
    public function remove($id)
    {
        $cartItem = Cart::findOrFail($id);
        $cartItem->delete();

        return response()->json(['message' => 'تم حذف المنتج من السلة 🗑️']);
    }

    /**
     * تحديث كمية منتج في السلة
     */
    public function update(Request $request, $id)
    {
        $request->validate(['quantity' => 'required|integer|min:0']);

        $cartItem = Cart::findOrFail($id);

        if ($request->quantity <= 0) {
            $cartItem->delete();
            return response()->json(['message' => 'تم حذف المنتج 🗑️']);
        }

        $cartItem->update(['quantity' => $request->quantity]);

        return response()->json(['message' => 'تم تحديث الكمية ✅']);
    }
}