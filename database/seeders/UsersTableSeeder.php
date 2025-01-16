<?php

namespace Database\Seeders;

use App\Models\User;
use Illuminate\Database\Seeder;
use Illuminate\Support\Str;
use TCG\Voyager\Models\Role;


class UsersTableSeeder extends Seeder
{
    /**
     * Auto generated seed file.
     *
     * @return void
     */
    public function run()
    {
        // if (User::count() == 0) {
        //     $role = Role::where('name', 'admin')->firstOrFail();

        //     User::create([
        //         'name'           => 'Admin',
        //         'email'          => 'admin@admin.com',
        //         'password'       => bcrypt('password'),
        //         'remember_token' => Str::random(60),
        //         'role_id'        => $role->id,
        //     ]);
        // }
        // User::factory(100)->create();
        User::factory(5)->isManager()->create();
        User::factory(10)->create();
    }
}
