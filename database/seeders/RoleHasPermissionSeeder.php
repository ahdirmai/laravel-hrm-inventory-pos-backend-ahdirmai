<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\Permission;
use App\Models\Role;

class RoleHasPermissionSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $permissions = Permission::all();
        $roles = Role::all();

        foreach ($roles as $role) {
            $role->permissions()->attach($permissions);
        }
    }
}
