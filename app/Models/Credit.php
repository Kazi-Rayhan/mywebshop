<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Casts\Attribute;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Credit extends Model
{
    use HasFactory;

    protected $guarded = [];
    protected $casts = ['session_credits_expire_at' => 'datetime', 'subscription_credits_expire_at' => 'datetime'];
    public function user()
    {
        return $this->belongsTo(User::class);
    }


    public function shop()
    {
        return $this->belongsTo(Shop::class);
    }
    public function histories()
    {
        return $this->hasMany(CreditHistory::class, 'credit_id');
    }

    public function package()
    {
        return $this->user->myPackage;
    }

    public function trainer()
    {
        return $this->belongsTo(User::class, 'trainer_id');
    }

    public function subscription()
    {
        return $this->morphOne(Subscription::class, 'subscribable');
    }
    public function subscribed(): bool
    {
        if ($this->subscription) {
            return $this->subscription->status == 1 ? true : false;
        }
        return false;
    }
    public function scopeHasCredits($query)
    {
        return $query->where(function ($query) {
            $query->where('admin_credits', '>', 0)
                ->orWhere('manager_credits', '>', 0)
                ->orWhere('demo_credits', '>', 0)
                ->orWhere('session_credits', '>', 0)
                ->orWhere('subscription_credits', '>', 0);
        });
    }

    public function scopeHasFreeCredits($query)
    {
        return $query->where(function ($query) {
            $query->where('admin_credits', '>', 0)
                ->orWhere('manager_credits', '>', 0)
                ->orWhere('demo_credits', '>', 0);
        });
    }
}
