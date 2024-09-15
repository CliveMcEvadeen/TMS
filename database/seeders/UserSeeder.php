<?php

namespace Database\Seeders;

use App\Models\User;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;

class UserSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $admin = User::create([
            'name' => 'Admin',
            'email' => 'admin@admin.com',
            'email_verified_at' => now(),
            'password' => Hash::make('admin'),
        ])->assignRole('rental-admin');

        $landlord = User::create([
            'name' => 'Landlord',
            'email' => 'landlord@landlord.com',
            'email_verified_at' => now(),
            'password' => Hash::make('landlord'),
        ])->assignRole('rental-admin');

        $tenant = User::create([
            'name' => 'Tenant',
            'email' => 'tenant@tenant.com',
            'email_verified_at' => now(),
            'password' => Hash::make('tenant'),
        ])->assignRole('rental-staff');
    }
}