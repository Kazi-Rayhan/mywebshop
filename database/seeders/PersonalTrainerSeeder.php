<?php

namespace Database\Seeders;

use App\Models\Booking;
use App\Models\Level;
use App\Models\Package;
use App\Models\Packageoption;
use App\Models\Shop;
use App\Models\User;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class PersonalTrainerSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        define('LEVELS', ['Novice' => 10, 'Master' => 20, 'Grand Master' => 30]);

        foreach (LEVELS as $level => $commission) {
            Level::create([
                'title' => $level,
                'commission' => $commission,
                'shop_id' => 1
            ]);
        }

        $managers =  User::manager()->get();

        foreach ($managers as $manager) {
            $manager->createMetas([
                'trainee' => true,
                'level' => rand(1, 3)
            ]);
            foreach (config('app.days') as $day) {
                $manager->schedules()->updateOrCreate(
                    ['day' => $day],
                    [
                        "day" => $day,
                        "from_time" => "10:00:00",
                        "is_open" => true,
                        "to_time" => "22:00:00",
                    ]
                );
            }
        }

        Packageoption::factory(5)->create();

        Shop::where('id', 1)->first()->createMetas([
            'default_package_option' => 1
        ]);

        Package::factory(5)->create();

        foreach (Package::all() as $package) {
            foreach (Level::all() as $level) {
                $package->levels()->attach($level, ['price' => rand(100, 200)]);
            }
        }
        Booking::factory(100)->create();
    }
}
