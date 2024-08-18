<?php

namespace Database\Seeders;

use App\Models\Role;
use App\Models\Roles;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class RoleSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        Role::create([
            'name' => 'admin',
            'display_name' => 'Admin',
            'description' => 'Admin',
            'company_id' => 1,
        ]);

        // staff
        Role::create([
            'name' => 'staff',
            'display_name' => 'Staff',
            'description' => 'Staff',
            'company_id' => 1,
        ]);
    }
}
