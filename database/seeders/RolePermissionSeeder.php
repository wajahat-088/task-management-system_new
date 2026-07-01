<?php

namespace Database\Seeders;

// use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Spatie\Permission\Models\Role;
use Spatie\Permission\Models\Permission;

class RolePermissionSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $permissions = [
            // Task permissions
            'view-task', 'create-task', 'edit-task', 'delete-task',

            // Product permissions
            'view-product', 'create-product', 'edit-product', 'delete-product',

            // Category permissions
            'view-category', 'create-category', 'edit-category', 'delete-category',

            // Activity logs
            'view-activity-logs',
        ];

        foreach ($permissions as $permission) {
            Permission::firstOrCreate(['name' => $permission]);
        }

        // Admin Role — acess to all permissions
        $admin = Role::firstOrCreate(['name' => 'admin']);
        $admin->syncPermissions($permissions); // saari permissions de do

        // Manager Role — only view aur edit tasks, products, categories, aur activity logs not have permissions to delete
        $manager = Role::firstOrCreate(['name' => 'manager']);
        $manager->syncPermissions([
            'view-task', 'create-task', 'edit-task',
            'view-product', 'create-product', 'edit-product',
            'view-category',
            'view-activity-logs',
        ]);

        // User Role — only view aur create tasks, products, categories, aur activity logs not have permissions to edit or delete
        $user = Role::firstOrCreate(['name' => 'user']);
        $user->syncPermissions([
            'view-task', 'create-task',
            'view-product',
            'view-category',
        ]);
    }
    }

