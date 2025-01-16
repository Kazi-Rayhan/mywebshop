<?php

namespace Database\Factories;

use App\Models\User;
use Illuminate\Support\Str;
use Illuminate\Database\Eloquent\Factories\Factory;
use Illuminate\Support\Facades\Hash;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\Shop>
 */
class ShopFactory extends Factory
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
            'user_name' => Str::slug(fake()->unique()->company),
            'tax' => 10,
            'status' => true,
            'establishment' => true,
            'service_establishment' => true,
            'establishment_cost' => rand(500, 1000),
            'service_establishment_cost' => rand(300, 600),
            'service_monthly_fee' => rand(200, 400),
            'monthly_cost' => rand(200, 400),
            'can_provide_service' => true,
            'per_user_fee' => rand(100, 150),
            'area' => ["Barishal", "Dhaka"][rand(0, 1)],
            'paid_at' => now(),

        ];
    }

    public function customUser($data)
    {
        return $this->state(fn (array $attributes) => [
            'user_id' => User::factory()->isVendor()->create($data)
        ]);
    }
}
