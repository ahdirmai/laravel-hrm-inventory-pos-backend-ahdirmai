<?php

namespace Database\Seeders;

use App\Models\User;
// use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     */
    public function run(): void
    {
        // User::factory(10)->create();



        $this->call([
            UserSeeder::class,
            CompanySeeder::class,
            RoleSeeder::class,
            PermissionSeeder::class,
            RoleHasPermissionSeeder::class,
            DepartmentSeeder::class,
            DesignationSeeder::class,
            ShiftSeeder::class,
            BasicSalarySeeder::class,
            UserHasRoleSeeder::class,
            HolidaySeeder::class,
            LeaveTypeSeeder::class,
            LeaveSeeder::class,
            AttendanceSeeder::class,
            PayrollSeeder::class,
        ]);
    }
}
