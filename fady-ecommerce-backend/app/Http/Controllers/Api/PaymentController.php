<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
# تشغيل الخادم الخلفي
php artisan serve

# Vite (إذا لم يكن يعمل)
npm run dev

# لتطبيق التغييرات على DB (تم تنفيذها بالفعل في جلسة العمل)
php artisan migrate --force
php artisan db:seed --class=DatabaseSeeder --force
class PaymentController extends Controller
{
    /**
     * Create a payment intent (uses Stripe if installed and configured)
     */
    public function createIntent(Request $request)
    {
        $stripeKey = config('services.stripe.key') ?? env('STRIPE_KEY');
        $stripeSecret = config('services.stripe.secret') ?? env('STRIPE_SECRET');

        if (! $stripeKey || ! $stripeSecret) {
            return response()->json(['message' => 'Payment gateway not configured'], 500);
        }

        // If stripe/stripe-php is installed, create real payment intent. Otherwise return placeholder.
        if (class_exists('\Stripe\Stripe')) {
            \Stripe\Stripe::setApiKey($stripeSecret);
            $amount = intval($request->input('amount', 1000));
            $intent = \Stripe\PaymentIntent::create([
                'amount' => $amount,
                'currency' => $request->input('currency', 'usd'),
            ]);
            return response()->json(['client_secret' => $intent->client_secret]);
        }

        return response()->json(['client_secret' => 'test_client_secret_placeholder']);
    }

    public function webhook(Request $request)
    {
        // Placeholder webhook handler. Implement signature verification when using Stripe.
        $payload = $request->all();
        // log or handle events
        return response()->json(['received' => true]);
    }
}
