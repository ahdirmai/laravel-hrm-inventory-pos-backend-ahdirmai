<?php

namespace Database\Seeders;

use App\Models\Department;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class DepartmentSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        // it and Hr
        Department::create([
            'name' => 'IT',
            'company_id' => 1,
            'created_by' => 1,
            'description' => 'IT Department',
        ]);

        Department::create([
            'name' => 'HR',
            'company_id' => 1,
            'created_by' => 1,
            'description' => 'HR Department',
        ]);
    }
}
