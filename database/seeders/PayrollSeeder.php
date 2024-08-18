<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use App\Models\Payroll;
use Carbon\Carbon;


class PayrollSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {

        $payrollData = [
            [
                'company_id' => 1,
                'user_id' => 3,
                'month' => 7,
                'year' => 2024,
                'basic_salary' => 6000000,
                'net_salary' => 6500000,
                'total_days' => 31,
                'total_working_days' => 22,
                'total_present_days' => 19,
                'total_office_time' => '02:30:00',
                'total_worked_time' => '02:20:00',
                'half_days' => 2,
                'late_days' => 3,
                'paid_leave' => 1,
                'unpaid_leave' => 2,
                'holiday_count' => 8,
                'payment_date' => Carbon::now(),
                'status' => 'generated',
            ],
            [
                'company_id' => 1,
                'user_id' => 4,
                'month' => 7,
                'year' => 2024,
                'basic_salary' => 5500000,
                'net_salary' => 6000000,
                'total_days' => 31,
                'total_working_days' => 22,
                'total_present_days' => 20,
                'total_office_time' => '02:30:00',
                'total_worked_time' => '02:25:00',
                'half_days' => 1,
                'late_days' => 2,
                'paid_leave' => 1,
                'unpaid_leave' => 1,
                'holiday_count' => 8,
                'payment_date' => Carbon::now(),
                'status' => 'generated',
            ],
            [
                'company_id' => 1,
                'user_id' => 5,
                'month' => 7,
                'year' => 2024,
                'basic_salary' => 7000000,
                'net_salary' => 7500000,
                'total_days' => 31,
                'total_working_days' => 22,
                'total_present_days' => 21,
                'total_office_time' => '02:30:00',
                'total_worked_time' => '02:28:00',
                'half_days' => 0,
                'late_days' => 1,
                'paid_leave' => 1,
                'unpaid_leave' => 0,
                'holiday_count' => 8,
                'payment_date' => Carbon::now(),
                'status' => 'generated',
            ],
        ];

        foreach ($payrollData as $data) {
            Payroll::create($data);
        }
    }
}
