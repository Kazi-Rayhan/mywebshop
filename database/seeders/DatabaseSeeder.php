<?php

namespace Database\Seeders;

// use Illuminate\Database\Console\Seeds\WithoutModelEvents;

use App\Models\Category;
use App\Models\Order;
use App\Models\Product;
use App\Models\Shop;
use App\Models\UserProduct;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;
use TCG\Voyager\Models\Role;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     *
     * @return void
     */
    public function run()
    {

        $this->call([
            RolesTableSeeder::class,
            ShopsTableSeeder::class,
            UsersTableSeeder::class,
            LanguageSeeder::class,
            ProductSeeder::class,
            PersonalTrainerSeeder::class,
            // UsersProductTableSeeder::class,
        ]);

        $orders = Order::factory(100)->create();
        foreach ($orders as $order) {

            $products = $order->shop->products;
            $prods = $products->shuffle()->take(rand(1, 4));
            $data = [];
            foreach ($prods as $prod) {
                $data[$prod->id] = ['price' => $prod->price, 'quantity' => 1];
            }
            $order->products()->sync($data);

            $order->createMetas([
                'first_name' => fake()->firstName(),
                'last_name' => fake()->lastName(),
                'email' => fake()->email(),
                'address' => fake()->address(),
                'city' => fake()->city(),
                'post_code' => fake()->postcode(),
                'phone' => fake()->phoneNumber(),
                'state' => fake()->city(),
                'details' => fake()->paragraph(),
                'company_country_prefix' => 'NO',
                'company_name' => fake()->company(),
                'company_id' => fake()->swiftBicNumber()
            ]);
        }




        // \App\Models\User::factory()->create([
        //     'name' => 'Test User',
        //     'email' => 'test@example.com',
        // ]);
    }
}
