<?php

namespace Database\Factories;

use App\Models\Package;
use App\Models\Shop;
use App\Models\User;
use Illuminate\Database\Eloquent\Factories\Factory;
use Illuminate\Support\Carbon;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\Booking>
 */
class BookingFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition()
    {
        $package = Package::select('id')
            ->inRandomOrder()
            ->first();
        $minutes = Shop::first()->defaultoption->minutes;
        $start = fake()->dateTimeBetween('-1 years');
        $end = Carbon::parse($start)->addMinutes($minutes);
        return [
            'manager_id' => User::manager()->select('id')
                ->inRandomOrder()
                ->first()
                ->id,
            'user_id' => User::customer()->select('id')
                ->inRandomOrder()
                ->first()
                ->id,
            'shop_id' => 1,
            'service_id' => Package::select('id')
                ->inRandomOrder()
                ->first()
                ->id,
            'service_type' => 1,
            'status' => rand(0, 3),
            'payment_status' => 1,
            'start_at' => $start,
            'end_at' => $end,
        ];
    }
}
