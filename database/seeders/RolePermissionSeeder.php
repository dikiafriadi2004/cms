<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Spatie\Permission\Models\Permission;
use Spatie\Permission\Models\Role;

class RolePermissionSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        //Role Admin
        // Permission : admin-blogs, admin-pages, admin-users
        Role::create(['name' => 'admin']);

        Permission::create(['name' => 'Admin Posts']);
        Permission::create(['name' => 'Admin Categories']);
        Permission::create(['name' => 'Admin Pages']);
        Permission::create(['name' => 'Admin Users']);

        $roleAdmin = Role::findByName('admin');
        $roleAdmin->givePermissionTo('Admin Posts');
        $roleAdmin->givePermissionTo('Admin Categories');
        $roleAdmin->givePermissionTo('Admin Pages');
        $roleAdmin->givePermissionTo('Admin Users');
    }
}
