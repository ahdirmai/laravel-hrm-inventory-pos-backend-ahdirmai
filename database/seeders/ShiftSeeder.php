<?php

namespace Database\Seeders;

use App\Models\Shift;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class ShiftSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        Shift::create([
            'company_id' => 1,
            'name' => 'Morning',
            'clock_in_time' => '09:00',
            'clock_out_time' => '17:00',
        ]);


        // afternoon
        Shift::create([
            'company_id' => 1,
            'name' => 'Afternoon',
            'clock_in_time' => '13:00',
            'clock_out_time' => '21:00',
        ]);
    }
}
