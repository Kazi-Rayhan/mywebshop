<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class ManagerPriceGroup extends Model
{
    use HasFactory;

    protected $fillable = [
        'service_id',
        'manager_id',
        'price_group_id',
    ];
}
