<?php

namespace Database\Factories;

use App\Models\User;
use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\UserProduct>
 */
class UserProductFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition()
    {
        return [
            'user_id' => User::factory()->isVendor()->create(),
            'shop_id' => 1,
            'product_id'=>rand(1, 30),
            "qr"=> 'qrcode/7e3aa19d-187b-4b8d-9a0c-cc341764bb44.png',
        ];
    }
}
