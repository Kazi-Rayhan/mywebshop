<?php

namespace App\Models;

use App\Models\Traits\HasMeta;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class RetailerWithdrawal extends Model
{
    use HasFactory, HasMeta;
    protected $guarded = [];

    protected $meta_attributes = [
        'trnx_id',
        'date'
    ];
    public function getAmountAttribute($value)
    {
        return $value / 100;
    }
    public function setAmountAttribute($value)
    {
        return $this->attributes['amount']  = $value * 100;
    }

    public function status()
    {
        switch ($this->status) {
            case 0:
                return 'Pending';
                break;
            case 1:
                return 'Completed';
                break;
            case 2:
                return 'Canceled';
                break;
            default:
                # code...
                break;
        }
    }
    public function user()
    {
        return $this->belongsTo(user::class);
    }
}
