<?php

/**
 * موديل المستخدمين - منصة فادي التجارية
 * Fady E-commerce User Model
 *
 * هذا الموديل مسؤول عن إدارة بيانات المستخدمين (العملاء والإداريين)
 * ويحتوي على العلاقات مع الطلبات والعناوين.
 *
 * @author     Mohamed Alaa <fady@example.com>
 * @version    1.0.0
 * @since      2026-06-19
 */

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;
use Laravel\Sanctum\HasApiTokens;

class User extends Authenticatable
{
    use HasApiTokens, HasFactory, Notifiable;

    /**
     * الحقول المسموح بتعبئتها مباشرة (Mass Assignment)
     * أنا حددتها عشان أحمي قاعدة البيانات من الإدخالات الضارة.
     *
     * @var array<int, string>
     */
    protected $fillable = [
        'name',
        'email',
        'password',
        'phone',
        'role',
        'is_active',
        'last_login_at',
    ];

    /**
     * الحقول المخفية عند إرجاع البيانات (زي التوكنات وكلمة المرور)
     *
     * @var array<int, string>
     */
    protected $hidden = [
        'password',
        'remember_token',
    ];

    /**
     * تحويلات أنواع البيانات (Casts)
     * عشان أتأكد إن التاريخ ييجي بصيغة صحيحة والصلاحية تبقى بوليفان
     *
     * @var array<string, string>
     */
    protected $casts = [
        'email_verified_at' => 'datetime',
        'last_login_at' => 'datetime',
        'is_active' => 'boolean',
        'password' => 'hashed',
    ];

    // ------------------- العلاقات (Relationships) -------------------

    /**
     * علاقة المستخدم بالعناوين: المستخدم عنده عدة عناوين
     * أنا كاتبه عشان لما أجيب المستخدم، أقدر أجيب عناوينه بسهولة.
     */
    public function addresses()
    {
        return $this->hasMany(Address::class);
    }

    /**
     * علاقة المستخدم بالطلبات: المستخدم عنده عدة طلبات
     */
    public function orders()
    {
        return $this->hasMany(Order::class);
    }

    /**
     * دالة مساعدة للتحقق من أن المستخدم أدمن
     * هاستخدمها في الـ Middleware عشان أحمي لوحة التحكم
     */
    public function isAdmin()
    {
        return in_array($this->role, ['admin', 'super_admin']);
    }
}