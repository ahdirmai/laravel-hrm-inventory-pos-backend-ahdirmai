<?php

namespace Database\Seeders;

use App\Models\Leave;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class LeaveSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {

        Leave::create([
            'company_id' => 1,
            'user_id' => 1,
            'leave_type_id' => 1,
            'start_date' => '2024-01-01',
            'end_date' => '2024-01-03',
            'total_days' => 3,
            'is_half_day' => false,
            'status' => 'pending',
            'reason' => 'test',
            'is_paid' => false,
            // 'created_by' => 1,
            // 'updated_by' => 1,
        ]);
    }
}
