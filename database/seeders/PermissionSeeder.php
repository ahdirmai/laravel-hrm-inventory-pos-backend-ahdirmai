<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

use App\Models\Permission;

class PermissionSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {

        $permissions = [
            [
                'name' => 'view_dashboard',
                'display_name' => 'View Dashboard',
                'description' => 'Can view the dashboard',
                'module_name' => 'Dashboard',
            ],
            [
                'name' => 'manage_users',
                'display_name' => 'Manage Users',
                'description' => 'Can manage users',
                'module_name' => 'User Management',
            ],
            [
                'name' => 'manage_roles',
                'display_name' => 'Manage Roles',
                'description' => 'Can manage roles',
                'module_name' => 'Role Management',
            ],
            [
                'name' => 'manage_permissions',
                'display_name' => 'Manage Permissions',
                'description' => 'Can manage permissions',
                'module_name' => 'Permission Management',
            ],
        ];

        foreach ($permissions as $permission) {
            Permission::create($permission);
        }
    }
}
