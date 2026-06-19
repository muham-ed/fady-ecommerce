<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Order;

class WebhookController extends Controller
{
    public function handlePaymob(Request $request)
    {
        $payload = $request->all();

        // TODO: Verify signature according to PayMob documentation

        if (!empty($payload['order_id'])) {
            $order = Order::where('order_number', $payload['order_id'])->first();
            if ($order) {
                // Simplified mapping - adapt according to actual PayMob payload
                if (!empty($payload['success'])) {
                    $order->update(['status' => 'paid']);
                } else {
                    $order->update(['status' => 'failed']);
                }
            }
        }

        return response()->json(['ok' => true]);
    }

    public function handleStripe(Request $request)
    {
        // For Stripe, use the official Stripe SDK and webhook signature verification
        $event = $request->all();

        // Example processing - adapt to your webhook event structure
        if (!empty($event['data']['object']['metadata']['order_id'])) {
            $orderId = $event['data']['object']['metadata']['order_id'];
            $order = Order::where('order_number', $orderId)->first();
            if ($order) {
                $order->update(['status' => 'paid']);
            }
        }

        return response()->json(['ok' => true]);
    }
}
