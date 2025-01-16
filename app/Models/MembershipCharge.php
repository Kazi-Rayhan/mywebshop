<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;


class MembershipCharge extends Model
{
    protected $guarded = [];
    public const STATUS = ['PENDING', 'PAID', 'FAILED'];
}
