<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class RetailerMeta extends Model
{
    use HasFactory;
    use HasFactory;

    protected $guarded = [];

    public function retailerType()
    {
        return $this->belongsTo(RetailerType::class, 'type');
    }

    public function parent()
    {
        return $this->belongsTo(User::class, 'parent_id');
    }

    public function user()
    {
        return $this->belongsTo(User::class);
    }


    protected static function booted(): void
    {
        static::updated(function (RetailerMeta $retailerMeta) {
            if ($retailerMeta->isDirty('status')) {
                if ($retailerMeta->status == false) {
                    $retailerMeta->user->retailerShops()->update(['previous_retailer_suspended_at' => now()]);
                } else {
                    $retailerMeta->user->retailerShops()->update(['previous_retailer_suspended_at' => null]);
                }
            }
        });
    }
}
