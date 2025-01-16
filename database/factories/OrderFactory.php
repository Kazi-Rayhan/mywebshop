<?php

namespace Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\Order>
 */
class OrderFactory extends Factory
{
    /**
     * Define the model's default s tate.
     *
     * @return array<string, mixed>
     */
    public function definition()
    {
        $subtotal =  rand(1000, 2000);
        $tax = $subtotal * (rand(5, 10) / 100);
        $total =  $subtotal + $tax;
        return [
            'shop_id' => 1,
            'user_id' => rand(1, 18),
            'subtotal' => $subtotal,
            'tax' => $tax,
            'shipping_method' => 0,
            'total' => $total,
            'payment_method' =>'quickpay',
            'status' => rand(0, 4),
            'payment_status' => rand(0, 1),
            'type' => 1,
            'created_at'=>fake()->dateTimeBetween('-1 years')

        ];
    }
}
