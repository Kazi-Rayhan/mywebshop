<?php

namespace App\Models\Traits;

use App\Models\Charge;

trait HasCharges
{
    public function charges()
    {
        return $this->morphMany(Charge::class, 'chargeable');
    }
}
