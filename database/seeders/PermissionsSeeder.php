<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Spatie\Permission\Models\Permission;
use Spatie\Permission\Models\Role;

class PermissionsSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $permissionsByCategory =
            [
                'view_roles', 'create_roles', 'edit_roles', 'delete_roles',
                'view_engineer','create_engineer','edit_engineer','delete_engineer','engineer_account','engineer_tasks',
                'view_tasks', 'create_tasks', 'edit_tasks', 'delete_tasks',
                'view_orders', 'create_orders', 'edit_orders', 'delete_orders',
                'view_clients', 'create_clients', 'edit_clients', 'delete_clients',
                'view_purchase', 'create_purchase', 'edit_purchase', 'delete_purchase',
                'view_products', 'create_products', 'edit_products', 'delete_products','product_transaction',
                'view_suppliers', 'create_suppliers', 'edit_suppliers', 'delete_suppliers',
                'view_settings',
                'reports',
                ];

        foreach ($permissionsByCategory as $category => $permissions)
        {
            collect($permissions)->each(function ($name)
            {
                Permission::firstOrCreate(['name' => $name, 'guard_name' => 'admin']);
            });
        }
        $role = Role::firstOrCreate(['name' => 'super_admin', 'guard_name' => 'admin']);
        $allPermissions = collect($permissionsByCategory)->flatten();
        $role->syncPermissions($allPermissions);
    }
}
