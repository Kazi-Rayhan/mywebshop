<?php

namespace Database\Seeders;

use App\Models\Category;
use App\Models\Product;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class ProductSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $products = Product::factory(100)->create();
        Category::factory(20)->create();
        Category::factory(20)->isChildren()->create();
        $categories = Category::all();
        foreach ($products as $product) {
            $categories = $product->shop->categories;
            $categoryIds = $categories->pluck('id')->shuffle()->take(rand(1, 4))->toArray();
            $product->categories()->sync($categoryIds);
        }

        $products = Product::factory(5)->create(['shop_id' => 2]);
    }
}
