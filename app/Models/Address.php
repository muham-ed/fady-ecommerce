<?php

/**
 * موديل العناوين - منصة فادي
 * Fady E-commerce Address Model
 *
 * @author     Mohamed Alaa <fady@example.com>
 */

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Address extends Model
{
    use HasFactory;

    /**
     * الحقول المسموح بتعبئتها
     */
    protected $fillable = [
        'user_id',
        'label',
        'recipient_name',
        'phone',
        'address_line1',
        'address_line2',
        'city',
        'state',
        'postal_code',
        'country',
        'is_default',
    ];

    /**
     * العلاقات
     */
    public function user()
    {
        return $this->belongsTo(User::class);
    }
}