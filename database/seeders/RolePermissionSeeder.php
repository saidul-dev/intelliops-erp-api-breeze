<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Spatie\Permission\Models\Role;
use Spatie\Permission\Models\Permission;
use Spatie\Permission\PermissionRegistrar;

class RolePermissionSeeder extends Seeder
{
    public function run(): void
    {
        app()[PermissionRegistrar::class]->forgetCachedPermissions();

        // Permissions
        $permissions = [
            'view_dashboard',
            'manage_users',
            'manage_projects',
            'manage_settings',
            'view_reports',
        ];

        foreach ($permissions as $permission) {
            Permission::firstOrCreate([
                'name' => $permission,
                'guard_name' => 'web',
            ]);
        }

        // Roles
        $admin = Role::firstOrCreate(['name' => 'admin', 'guard_name' => 'web']);
        $hr    = Role::firstOrCreate(['name' => 'hr', 'guard_name' => 'web']);
        $staff = Role::firstOrCreate(['name' => 'staff', 'guard_name' => 'web']);

        // Assign permissions
        $admin->syncPermissions($permissions);

        $hr->syncPermissions([
            'view_dashboard',
            'view_reports',
        ]);

        $staff->syncPermissions([
            'view_dashboard',
        ]);
    }
}