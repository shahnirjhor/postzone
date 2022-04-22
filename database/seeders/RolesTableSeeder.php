<?php

namespace Database\Seeders;

use App\Models\User;
use Illuminate\Database\Seeder;
use Spatie\Permission\Models\Role;
use Spatie\Permission\Models\Permission;

class RolesTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $role = Role::create([
            'name' => 'Super Admin',
            'guard_name' => 'web',
            'price' => '1',
            'validity' => '1825',
            'is_default' => '1',
        ]);
        $permissions = Permission::select('id')->get()->pluck('id');
        $role->syncPermissions($permissions);

        $admin = User::create([
            'name' => 'Super Admin',
            'email' => 'admin@gmail.com',
            'password' => bcrypt('12345678'),
            'phone' => '01712340889',
            'address' => 'Dhaka, BD',
            'status' => '1',
        ]);
        $adminRole = Role::where('name', 'Super Admin')->first();
        $admin->assignRole([$adminRole->id]);
    }
}
