<?php

namespace Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\PackageOption>
 */
class PackageOptionFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition()
    {
        return [
            'shop_id' => 1,
            'title' => fake()->sentence(4),
            'details' => fake()->sentence(10),
            'minutes' => rand(30, 60),
            'buffer' => rand(10, 15)
        ];
    }
}
