<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Stripe\StripeClient;
use App\Models\Order;
use App\Models\Product;

class PaymentController extends Controller
{
    public function createCheckoutSession(Request $request)
    {
        $data = $request->validate([
            'items' => 'required|array|min:1',
            'items.*.product_id' => 'required|exists:products,id',
            'items.*.quantity' => 'required|integer|min:1',
        ]);

        $stripe = new StripeClient(env('STRIPE_SECRET'));

        $line_items = [];
        foreach ($data['items'] as $it) {
            $product = Product::findOrFail($it['product_id']);
            $line_items[] = [
                'price_data' => [
                    'currency' => env('APP_CURRENCY', 'usd'),
                    'product_data' => [
                        'name' => $product->name,
                    ],
                    'unit_amount' => intval($product->price * 100),
                ],
                'quantity' => $it['quantity'],
            ];
        }

        $session = $stripe->checkout->sessions->create([
            'payment_method_types' => ['card'],
            'line_items' => $line_items,
            'mode' => 'payment',
            'success_url' => env('APP_URL') . '/?success=1',
            'cancel_url' => env('APP_URL') . '/?canceled=1',
        ]);

        return response()->json(['id' => $session->id, 'url' => $session->url]);
    }
}
