<?php

namespace Database\Seeders;

use App\Models\BasicSalary;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class BasicSalarySeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        BasicSalary::create([
            'user_id' => 1,
            'company_id' => 1,
            'amount' => 10000,
        ]);
    }
}
