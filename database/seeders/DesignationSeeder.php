<?php

namespace Database\Seeders;

use App\Models\Designation;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class DesignationSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        // software engineer and HR Manager
        Designation::create([
            'name' => 'Software Engineer',
            'description' => 'Software Engineer',
            'company_id' => 1,
            'created_by' => 1
        ]);
        Designation::create([
            'name' => 'HR Manager',
            'description' => 'HR Manager',
            'company_id' => 1,
            'created_by' => 1
        ]);
    }
}
