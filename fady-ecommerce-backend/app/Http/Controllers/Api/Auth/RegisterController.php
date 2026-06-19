<?php

/**
 * نظام التسجيل في منصة فادي التجارية
 * Fady E-commerce Registration System
 *
 * @author     Mohamed Alaa <fady@example.com>  <--- حط هنا إيميلك أو اسمك الكامل
 * @version    1.0.0
 * @since      2026-06-19
 * @license    MIT (or Proprietary)
 * @copyright  2026 Mohamed Alaa. All Rights Reserved.
 */

namespace App\Http\Controllers\Api\Auth;

use App\Http\Controllers\Controller;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use Illuminate\Validation\Rules\Password;

class RegisterController extends Controller
{
    /**
     * تسجيل مستخدم جديد في النظام
     * 
     * هذه الدالة مسؤولة عن استقبال بيانات العميل،
     * التحقق من صحتها، إنشاء الحساب، وإرجاع توكن المصادقة.
     *
     * @author Mohamed Alaa
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\JsonResponse
     */
    public function register(Request $request)
    {
        // الخطوة 1: التأكد من أن البيانات صحيحة وكاملة (كتبتها أنا)
        $request->validate([
            'name' => 'required|string|max:255',
            'email' => 'required|string|email|max:255|unique:users',
            'password' => ['required', 'confirmed', Password::defaults()],
        ]);

        // الخطوة 2: إنشاء المستخدم الجديد وتشفير كلمة المرور (تنفيذي)
        $user = User::create([
            'name'     => $request->name,
            'email'    => $request->email,
            'password' => Hash::make($request->password),
        ]);

        // الخطوة 3: توليد توكن API عشان المستخدم يفضل مسجل (أمان)
        $token = $user->createToken('auth_token')->plainTextToken;

        // الخطوة 4: إرجاع البيانات للمطور الأمامي (Frontend Developer)
        return response()->json([
            'message' => 'تم تسجيل الحساب بنجاح! شكراً لانضمامك لمنصة فادي 🚀',
            'user'    => $user,
            'token'   => $token,
        ], 201);
    }
}