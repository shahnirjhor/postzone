<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Spatie\Permission\Models\Permission;


class PermissionTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        Permission::firstOrCreate(['name' => 'profile-read','display_name' => 'Profile']);
        Permission::firstOrCreate(['name' => 'profile-update','display_name' => 'Profile']);
        Permission::firstOrCreate(['name' => 'role-read','display_name' => 'Role']);
        Permission::firstOrCreate(['name' => 'role-create','display_name' => 'Role']);
        Permission::firstOrCreate(['name' => 'role-update','display_name' => 'Role']);
        Permission::firstOrCreate(['name' => 'role-delete','display_name' => 'Role']);
        Permission::firstOrCreate(['name' => 'role-export','display_name' => 'Role']);
        Permission::firstOrCreate(['name' => 'user-read','display_name' => 'User']);
        Permission::firstOrCreate(['name' => 'user-create','display_name' => 'User']);
        Permission::firstOrCreate(['name' => 'user-update','display_name' => 'User']);
        Permission::firstOrCreate(['name' => 'user-delete','display_name' => 'User']);
        Permission::firstOrCreate(['name' => 'user-export','display_name' => 'User']);
    }
}
