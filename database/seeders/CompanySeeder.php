<?php

namespace Database\Seeders;

use App\Models\Company;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class CompanySeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        Company::create([
            'name' => 'Default Company',
            'email' => 'info@defaultcompany.com',
            'phone' => '+1234567890',
            'website' => 'https://www.defaultcompany.com',
            'logo' => 'default_logo.png',
            'address' => '123 Default Street, Default City, 12345',
            'status' => 'active',
            'total_users' => 1,
            'clock_in_time' => '09:30:00',
            'clock_out_time' => '18:00:00',
            'early_clock_in_time' => 15, // 30 minutes before clock_in_time
            'allow_clock_out_till' => 15, // 60 minutes after clock_out_time
            'self_clocking' => true,
        ]);
    }
}
