<?php

namespace Database\Seeders;

use App\Models\Holiday;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class HolidaySeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        // create 10 holidays
        $holidays = [
            [
                'name' => 'New Year',
                'date' => '2024-01-01',
                'type' => 'national',
                'is_weekend' => true,
                'company_id' => 1,
                'created_by' => 1,
            ],
            [
                'name' => 'Independence Day',
                'date' => '2024-08-15',
                'type' => 'national',
                'is_weekend' => false,
                'company_id' => 1,
                'created_by' => 1,
            ],
        ];

        foreach ($holidays as $holiday) {
            Holiday::create($holiday);
        }
    }
}
