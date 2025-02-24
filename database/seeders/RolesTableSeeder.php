<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use TCG\Voyager\Models\Role;

class RolesTableSeeder extends Seeder
{
    /**
     * Auto generated seed file.
     */
    public function run()
    {
        $role = Role::firstOrNew(['name' => 'admin']);
        if (!$role->exists) {
            $role->fill([
                'display_name' => __('voyager::seeders.roles.admin'),
            ])->save();
        }

        $role = Role::firstOrNew(['name' => 'user']);
        if (!$role->exists) {
            $role->fill([
                'display_name' => __('voyager::seeders.roles.user'),
            ])->save();
        }
        $role = Role::firstOrNew(['name' => 'vendor']);
        if (!$role->exists) {
            $role->fill([
                'display_name' => __('voyager::seeders.roles.vendor'),
            ])->save();
        }
        $role = Role::firstOrNew(['name' => 'manager']);
        if (!$role->exists) {
            $role->fill([
                'display_name' => __('voyager::seeders.roles.manager'),
            ])->save();
        }
        $role = Role::firstOrNew(['name' => 'retailer']);
        if (!$role->exists) {
            $role->fill([
                'display_name' => __('voyager::seeders.roles.retailer'),
            ])->save();
        }
        

    }
}
