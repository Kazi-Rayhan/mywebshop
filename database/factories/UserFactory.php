<?php

namespace Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;
use Illuminate\Support\Str;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\User>
 */
class UserFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition()
    {
        return [
            'name' => fake()->firstName(),
            'last_name' => fake()->lastName(),
            'phone' => fake()->unique()->phoneNumber(),
            'email' => fake()->unique()->safeEmail(),
            'email_verified_at' => now(),
            'role_id' => 2,
            'password' => '$2y$10$92IXUNpkjO0rOQ5byMi.Ye4oKoEa3Ro9llC/.og/at2.uheWG/igi', // password
            'remember_token' => Str::random(10),
        ];
    }

    /**
     * Indicate that the model's email address should be unverified.
     *
     * @return static
     */
    public function unverified()
    {
        return $this->state(fn (array $attributes) => [
            'email_verified_at' => null,
        ]);
    }
    public function isAdmin()
    {
        return $this->state(fn (array $attributes) => [
            'role_id' => 1,
        ]);
    }
    public function isVendor()
    {
        return $this->state(fn (array $attributes) => [
            'role_id' => 3,
        ]);
    }
    public function isManager($shop = 1)
    {
        return $this->state(fn (array $attributes) => [
            'role_id' => 4,
            'shop_id' => $shop
        ]);
    }
    public function isRetailer()
    {
        return $this->state(fn (array $attributes) => [
            'role_id' => 5,
        ]);
    }
}
