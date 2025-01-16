<?php

namespace Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\Product>
 */
class ProductFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition()
    {
        return [
            "shop_id"       => 1,
            "name"          => fake()->words(3, true),
            "slug"          => fake()->unique()->slug(),
            "ean"           => rand(1000, 3000),
            "price"         => rand(300, 500),
            "retailerprice"         => rand(300, 500),
            "saleprice"     => rand(300, 500),
            "tax"           => rand(5, 15),
            "sku"           => 'prod' . '-' . uniqid(),
            "quantity"      => rand(100, 200),
            "description"   => fake()->paragraph,
            "details"       => fake()->paragraph,
            "image"         => 'defaults/product.jpg',
            "images"      => ['defaults/product.jpg', 'defaults/product2.jpg', 'defaults/product3.jpg'],
            "status"        => true,
            "featured"        =>  rand(0, 1),
            "areas" => json_encode(["Barishal" => ["price" => rand(300, 500), "saleprice" => rand(100, 300), 'quantity' => 10, "retailerprice" => rand(200, 450)], "Dhaka" => ["price" => rand(300, 500), "saleprice" => rand(100, 300), 'quantity' => 10, "retailerprice" => rand(200, 450)]]),
        ];
    }
}
