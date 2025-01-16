<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\MorphTo;
use App\Models\Traits\HasMeta;
use Illuminate\Database\Eloquent\Casts\Attribute;

class Booking extends Model
{

    const STATUS_PENDING  = 0;
    const STATUS_COMPLETED = 1;
    const STATUS_CANCELED = 3;

    const PAYMENT_STATUS_PAID = 1;

    use HasFactory, HasMeta;
    protected $guarded = [];
    protected $meta_attributes = [
        'note',
        'log',

    ];

    protected $casts = [
        'end_at'    => 'datetime',
        'start_at'  => 'datetime',
    ];

    protected $types = [
        'demo_credits' => 'Demo free Sessions',
        'manager_credits' => 'Manager free sessions',
        'admin_credits' => 'Admin free sessions',
        'subscription_credits' => 'Subscription sessions',
        'session_credits' => 'Paid sessions'
    ];
    public function getStatusAttribute($value)
    {
        if ($value === static::STATUS_PENDING && $this->start_at->isPast()) {
            $value = 2;
        }

        $status = [
            0 => 'Pending',
            1 => 'Completed',
            2 => 'Expired',
            3 => 'Cancelled',
        ];

        return $status[$value] ?? $status[0];
    }
    public function getPaymentStatusAttribute($value)
    {
        $status = [
            0 => 'Unpaid',
            1 => 'Paid',

        ];

        return $status[$value] ?? $status[0];
    }

    public function customer()
    {
        return $this->belongsTo(User::class, 'user_id')->withDefault();
    }

    public function manager()
    {
        return $this->belongsTo(User::class, 'manager_id')->withDefault();
    }

    public function shop()
    {
        return $this->belongsTo(Shop::class, 'shop_id')->withDefault();
    }

    public function store_service()
    {
        return $this->belongsTo(Service::class, 'service_id')->withDefault();
    }
    public function trainer_service()
    {
        return $this->belongsTo(Packageoption::class, 'service_id')->withDefault();
    }

    public function getServiceAttribute()
    {
        if ($this->service_type == 1) {

            return $this->trainer_service;
        } else {
            return $this->store_service;
        }
    }
    public function commissionType():Attribute
    {
        return Attribute::make(get:fn($value)=> $this->types[$value]);
    }
}
