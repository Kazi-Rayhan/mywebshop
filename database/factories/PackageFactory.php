<?php

namespace Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\Package>
 */
class PackageFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition()
    {
        return [
            'title'=>fake()->sentence(4),
            'shop_id'=>1,
            'sessions'=>rand(30,60),
            'price'=>rand(3000,6000),
            'tax'=>rand(300,600),
            'details'=>fake()->sentence(12),
        ];
    }
}
