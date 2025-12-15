<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Spatie\Permission\Models\Permission;
use Spatie\Permission\Models\Role;

class RolePermissionSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        // Reset cached roles and permissions
        app()[\Spatie\Permission\PermissionRegistrar::class]->forgetCachedPermissions();

        // Create permissions
        $modules = ['service', 'service_message', 'renewal_plan', 'reports', 'admin'];
        $actions = ['view', 'create', 'update', 'delete'];

        foreach ($modules as $module) {
            foreach ($actions as $action) {
                Permission::create(['name' => "{$module}.{$action}"]);
            }
        }

        // Create roles
        $adminRole = Role::create(['name' => 'admin']);
        $managerRole = Role::create(['name' => 'manager']);
        $marketingRole = Role::create(['name' => 'marketing']);
        $developerRole = Role::create(['name' => 'developer']);

        // Assign all permissions to admin
        $adminRole->givePermissionTo(Permission::all());

        // Assign specific permissions to manager
        $managerRole->givePermissionTo([
            'service.view',
            'service.create',
            'service.update',
            'service_message.view',
            'service_message.create',
            'service_message.update',
            'renewal_plan.view',
            'renewal_plan.create',
            'renewal_plan.update',
            'reports.view',
        ]);

        // Assign specific permissions to marketing
        $marketingRole->givePermissionTo([
            'service.view',
            'service_message.view',
            'service_message.create',
            'service_message.update',
            'renewal_plan.view',
            'reports.view',
        ]);

        // Assign specific permissions to developer
        $developerRole->givePermissionTo([
            'service.view',
            'service_message.view',
            'renewal_plan.view',
            'reports.view',
        ]);
    }
}

