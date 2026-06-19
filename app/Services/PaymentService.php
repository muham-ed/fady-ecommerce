<?php

/**
 * خدمة الدفع الإلكتروني - منصة فادي
 * Fady E-commerce Payment Service
 *
 * أنا أتعامل مع بوابة PayMob أو Stripe لإتمام المدفوعات.
 *
 * @author     Mohamed Alaa <fady@example.com>
 * @version    1.0.0
 */

namespace App\Services;

use Illuminate\Support\Facades\Http;

class PaymentService
{
    protected $apiKey;
    protected $integrationId;
    protected $baseUrl;

    public function __construct()
    {
        $this->apiKey = config('services.paymob.api_key');
        $this->integrationId = config('services.paymob.integration_id');
        $this->baseUrl = config('services.paymob.base_url');
    }

    /**
     * إنشاء طلب دفع جديد
     */
    public function initiatePayment($order, $total)
    {
        // أنا بجيب توكن المصادقة
        $authToken = $this->getAuthToken();

        // إنشاء سجل الدفع
        $response = Http::post($this->baseUrl . '/api/ecommerce/orders', [
            'auth_token' => $authToken,
            'delivery_needed' => 'false',
            'amount_cents' => $total * 100, // بالقرش
            'currency' => 'EGP',
            'order_id' => $order->order_number,
            'items' => [],
        ]);

        // إرجاع رابط الدفع للعميل
        return $response->json();
    }

    protected function getAuthToken()
    {
        $response = Http::post($this->baseUrl . '/api/auth/tokens', [
            'api_key' => $this->apiKey,
        ]);
        return $response->json('token');
    }
}
