<?php

namespace Database\Seeders;

use App\Models\Settings;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class SettingsSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        Settings::create([
            'key' => 'site_sys_name',
            'value' => 'TMS'
        ]);
        Settings::create([
            'key' => 'site_name',
            'value' => 'Rental System'
        ]);
        Settings::create(
            [
            'key' => 'site_email',
            'value' => 'landlord@landlord.com'
            ]);
        Settings::create(
            [
            'key' => 'site_contact',
            'value' => '097845612'
            ]);
        Settings::create(
            [
            'key' => 'site_address',
            'value' => 'Kampala-uganda'
            ]);
        Settings::create(
            [
            'key' => 'site_description',
            'value' => 'Rental System'
            ]);
        Settings::create(
            [
            'key' => 'site_logo',
            'value' => ''
            ]);
        Settings::create(
            [
            'key' => 'site_logo2',
            'value' => ''
            ],
                                  
        );
    }
}