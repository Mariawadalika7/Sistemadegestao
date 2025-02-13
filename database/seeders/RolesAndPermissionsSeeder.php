<?php
// database/seeders/RolesAndPermissionsSeeder.php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Spatie\Permission\Models\Role;
use Spatie\Permission\Models\Permission;

class RolesAndPermissionsSeeder extends Seeder
{
    public function run()
    {
        // Reset cached roles and permissions
        app()[\Spatie\Permission\PermissionRegistrar::class]->forgetCachedPermissions();

        // Create permissions
        $permissions = [
            // Clientes
            'view clients',
            'create clients',
            'edit clients',
            'delete clients',

            // Faturas
            'view invoices',
            'create invoices',
            'edit invoices',
            'delete invoices',
            'process payments',

            // Consumo
            'view consumption',
            'register readings',
            'edit readings',
            'delete readings',

            // Relatórios
            'view reports',
            'export data',

            // Configurações
            'manage settings',
            'manage roles',
            'manage users'
        ];

        foreach ($permissions as $permission) {
            Permission::create(['name' => $permission]);
        }

        // Create roles and assign permissions
        $role = Role::create(['name' => 'admin']);
        $role->givePermissionTo(Permission::all());

        $role = Role::create(['name' => 'manager']);
        $role->givePermissionTo([
            'view clients', 'create clients', 'edit clients',
            'view invoices', 'create invoices', 'edit invoices', 'process payments',
            'view consumption', 'register readings', 'edit readings',
            'view reports', 'export data',
            'manage settings'
        ]);

        $role = Role::create(['name' => 'operator']);
        $role->givePermissionTo([
            'view clients',
            'view invoices', 'create invoices',
            'view consumption', 'register readings',
            'view reports'
        ]);

        $role = Role::create(['name' => 'reader']);
        $role->givePermissionTo([
            'view consumption', 'register readings'
        ]);
    }
}
