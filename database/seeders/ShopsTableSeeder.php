<?php

namespace Database\Seeders;

use App\Models\Shop;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;

class ShopsTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $shop = Shop::factory()->customUser([
            'name' => 'Sohoj',
            'email' => 'info@sohoj.com',
            'password' => Hash::make('password')
        ])->create([
            'user_name' => 'sohoj',
            'terms' => fake()->paragraphs(5, true),
            'tax' => 5,
            'status' => true,
        ]);

        $data = [
            "name" => "Sohoj",
            "company_name" => "Sohoj IT & Freelancing Care",
            "logo" => "defaults/shop_default_logo.png",
            "cover" => "defaults/shop_default_cover.jpg",
            "contact_email" => fake()->companyEmail(),
            "contact_phone" => fake()->phoneNumber(),
            "company_registration" => fake()->swiftBicNumber,
            "city" => fake()->city(),
            "street" => fake()->streetAddress,
            "post_code" => fake()->postcode(),
            "shop_color" => "#D61355",
            "header_color" => "#30E3DF",
            "menu_color" => "#D61355",
            "top_menu_hover_color" => "#30E3DF",
            "menu_hover_color" => "#FFDD83",
            "top_header_color" => "#FFDD83",
            "self_checkout" => true,
            "self_checkout_pin" => 1234,
            "sell_digital_product" => false,
            "quickpay_api_key" => setting('payment.api_key'),
            "quickpay_secret_key" => "3560c4c4d19d1bb6cdf91000329747ff88ba471d97469f3ff871d159db6b5ec1",
        ];

        $shop->createMetas($data);
        Shop::factory()->create();
        
    }
}
