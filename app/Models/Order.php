<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Relations\{BelongsTo, HasOne, HasMany};



class Order extends Model
{
    use HasFactory;

    protected $fillable = [
        'user_id', 'service_package_id', 'branch_id',
        'service_type', 'weight', 'price',
        'approximate_price', 'branch_admin_id',
        'pickup_address', 'pickup_time', 'status', 'snap_token',
        'order_id', 'payment_option', 'payment_status', 'promo_code', 'booking_fee'
    ];

    public function user(): BelongsTo
    {
        return $this->belongsTo(User::class);
    }

    public function servicePackage(): BelongsTo
    {
        return $this->belongsTo(ServicePackage::class);
    }

    public function branchAdmin() : BelongsTo
    {
        return $this->belongsTo(User::class, 'branch_admin_id');
    }


    public function payments(): HasMany
    {
        return $this->hasMany(Payment::class);
    }

    public function reviews(): HasMany
    {
        return $this->hasMany(Review::class);
    }

    public function promo(): BelongsTo
    {
        return $this->belongsTo(Promo::class, 'promo_code', 'code');
    }

    public function getDiscountPercentageAttribute()
    {
        return $this->promo ? $this->promo->discount_percentage : 0;
    }
}
