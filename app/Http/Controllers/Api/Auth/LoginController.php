<?php

/**
 * نظام تسجيل الدخول - منصة فادي
 * Fady E-commerce Login System
 *
 * هذا الكلاس مسؤول عن مصادقة المستخدمين (العملاء والإداريين)
 * وإرجاع توكن API خاص بيهم عشان يستخدموا باقي الخدمات.
 *
 * @author     Mohamed Alaa <fady@example.com>
 * @version    1.0.0
 */

namespace App\Http\Controllers\Api\Auth;

use App\Http\Controllers\Controller;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use Illuminate\Validation\ValidationException;

class LoginController extends Controller
{
    /**
     * تسجيل دخول المستخدم
     *
     * أنا بستقبل الإيميل والباسورد، وبتحقق من صحتهم.
     * لو صح، بحدث وقت آخر دخول وبعمل توكن جديد.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\JsonResponse
     */
    public function login(Request $request)
    {
        // الخطوة 1: التحقق من صحة البيانات الواردة
        $request->validate([
            'email' => 'required|email',
            'password' => 'required|string',
        ]);

        // الخطوة 2: البحث عن المستخدم في قاعدة البيانات
        $user = User::where('email', $request->email)->first();

        // الخطوة 3: التأكد من وجود المستخدم وتطابق كلمة المرور
        if (!$user || !Hash::check($request->password, $user->password)) {
            throw ValidationException::withMessages([
                'email' => ['بيانات الدخول غير صحيحة.'],
            ]);
        }

        // الخطوة 4: التأكد من أن الحساب نشط (مش موقف)
        if (!$user->is_active) {
            return response()->json([
                'message' => 'الحساب موقف مؤقتاً، راجع فريق الدعم.',
            ], 403);
        }

        // الخطوة 5: تحديث وقت آخر دخول (عشان analytics)
        $user->last_login_at = now();
        $user->save();

        // الخطوة 6: حذف أي توكنات قديمة (اختياري، عشان الأمان)
        $user->tokens()->delete();

        // الخطوة 7: إنشاء توكن جديد
        $token = $user->createToken('auth_token')->plainTextToken;

        // الخطوة 8: إرجاع الرد
        return response()->json([
            'message' => 'تم تسجيل الدخول بنجاح! أهلاً بك في منصة فادي 🎉',
            'user' => $user,
            'token' => $token,
        ], 200);
    }

    /**
     * تسجيل الخروج (Logout)
     * أنا بحذف التوكن الحالي عشان ينهي الجلسة.
     */
    public function logout(Request $request)
    {
        // حذف التوكن اللي المستخدم بيستخدمه حالياً
        $request->user()->currentAccessToken()->delete();

        return response()->json([
            'message' => 'تم تسجيل الخروج بنجاح. نراك قريباً! 👋',
        ], 200);
    }
}