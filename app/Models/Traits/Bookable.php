<?php

namespace App\Models\Traits;

use App\Models\Booking;

trait Bookable
{
    public function bookings()
    {
        return $this->morphMany(Booking::class, 'serviceable');
    }
}
