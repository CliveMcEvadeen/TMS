<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Spatie\Permission\Models\Role;
use Spatie\Permission\Models\Permission;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;

class RoleSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        Permission::create(['name' => 'edit']);
        Permission::create(['name' => 'delete']);
        Permission::create(['name' => 'create']);
        Permission::create(['name' => 'view']);
        
        $role = Role::create(['name' => 'rental-admin']);
        $role1 = Role::create(['name' => 'rental-manager']);
        $role2 = Role::create(['name' => 'rental-staff']);

        $role->givePermissionTo(['edit','delete','create','view']);
        $role1->givePermissionTo(['create','view']);
        $role2->givePermissionTo(['create','view']);
    }
}