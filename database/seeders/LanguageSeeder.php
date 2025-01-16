<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class LanguageSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $languages = json_decode(file_get_contents('database/jsons/languages.json'), true);
        $settings = json_decode(file_get_contents('database/jsons/settings.json'), true);
        
        DB::table('languages')->insert($languages);
        DB::table('settings')->insert($settings);
    }
}
