<?php

namespace App\Http\Controllers\Api\Customer;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

class CartController extends Controller
{
    // Simple session-based cart for demo purposes
    public function index(Request $request)
    {
        $cart = $request->session()->get('cart', []);
        return response()->json(['items' => $cart]);
    }

    public function add(Request $request)
    {
        $request->validate([
            'product_id' => 'required|integer',
            'quantity' => 'sometimes|integer|min:1'
        ]);

        $cart = $request->session()->get('cart', []);
        $id = $request->product_id;
        $qty = $request->input('quantity', 1);

        if (isset($cart[$id])) {
            $cart[$id]['quantity'] += $qty;
        } else {
            $cart[$id] = ['product_id' => $id, 'quantity' => $qty];
        }

        $request->session()->put('cart', $cart);

        return response()->json(['cart' => $cart]);
    }

    public function remove(Request $request, $id)
    {
        $cart = $request->session()->get('cart', []);
        if (isset($cart[$id])) {
            unset($cart[$id]);
            $request->session()->put('cart', $cart);
        }
        return response()->json(['cart' => $cart]);
    }

    public function update(Request $request, $id)
    {
        $request->validate(['quantity' => 'required|integer|min:1']);
        $cart = $request->session()->get('cart', []);
        if (isset($cart[$id])) {
            $cart[$id]['quantity'] = $request->quantity;
            $request->session()->put('cart', $cart);
        }
        return response()->json(['cart' => $cart]);
    }
}
