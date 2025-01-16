<?php

namespace App\Models;

use App\Models\Traits\HasCharges;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\Http;

class Enterprise extends Model
{
    use HasFactory;

    const PERMISSIONS = [
        'category' => [
            'create' => true,
            'edit' => true,
            'browse' => true,
        ],
        'product' => [
            'create' => true,
            'edit' => true,
            'browse' => true,
        ],
        'subscription_product' => [
            'create' => true,
            'edit' => true,
            'browse' => true,
        ],
        'store' => [
            'create' => true,
            'edit' => true,
            'browse' => true,
        ],
        'manager' => [
            'create' => true,
            'edit' => true,
            'browse' => true,
        ],
        'slider' => [
            'create' => true,
            'edit' => true,
            'browse' => true,
        ],
        'shipping' => [
            'create' => true,
            'edit' => true,
            'browse' => true,
        ],

        'coupon' => [
            'create' => true,
            'edit' => true,
            'browse' => true,
        ],
        'booking' => [
            'create' => true,
            'edit' => true,
            'browse' => true,
        ],
        'personal_trainee' => [
            'create' => true,
            'edit' => true,
            'browse' => true,
        ],
        'kiosk' => [
            'active' => true
        ]
    ];

    protected $guarded = [];

    public function subscriptionFee()
    {
        return 29;
    }

    public function details()
    {
        return json_decode(Http::get($this->domain . '/api/enterprise/' . $this->unqid . '/details'));
    }

    public function fee()
    {
        return $this->details()->total_fee;
    }

    public function getPermissionsAttribute()
    {
        $enterprise_permissions = json_decode($this->attributes['permissions'] ?? '');

        $original_permissions = $this::PERMISSIONS;
        if ($enterprise_permissions) {
            foreach ($enterprise_permissions as $key => $value) {

                if (array_key_exists($key, $original_permissions)) {
                    $original_permissions[$key] = (array) $value;
                }
            }
        }

        return (array)$original_permissions;
    }

    public function subscription()
    {
        return $this->morphOne(Subscription::class, 'subscribable');
    }
}
