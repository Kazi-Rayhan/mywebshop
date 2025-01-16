<?php

namespace Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\Category>
 */
class CategoryFactory extends Factory
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
            'name' => fake()->word,
            'slug' => fake()->unique()->slug,

        ];
    }

    public function isChildren()
    {
        return $this->state(fn (array $attributes) => [
            'parent_id' => rand(1, 20)
        ]);
    }
}
