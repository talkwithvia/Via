<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Spatie\Permission\Models\Role;
use Spatie\Permission\Models\Permission;
use Spatie\Permission\PermissionRegistrar;

class RolesAndPermissionsSeeder extends Seeder
{
    public function run()
    {
        // Reset cached roles & permissions
        app()[PermissionRegistrar::class]->forgetCachedPermissions();

        // 🔑 CREATE PERMISSIONS
        $permissions = [

            // Users
            'view users',
            'view user',
            'create user',
            'edit user',
            'delete user',
            'toggle user status',
            'assign user roles',
            'reset user password',
            'impersonate user',

            // Roles
            'view roles',
            'view role',
            'create role',
            'edit role',
            'delete role',
            'assign permissions to role',

            // Permissions
            'view permissions',
            'view permission',
            'create permission',
            'edit permission',
            'delete permission',

            // Activity Logs
            'view activity logs',
            'view activity log',
            'delete activity log',
            'clear activity logs',

            // Profile
            'view profile',
            'edit profile',
            'update profile',
            'change password',
            'upload avatar',
            'delete account',

            // Optional
            'view dashboard',
            'access admin panel',
            'manage settings',

            // products and categories
            'view products',
            'view product',
            'create product',
            'edit product',
            'delete product',
            'view categories',
            'view category',
            'create category',
            'edit category',
            'delete category',
            'manage subscriptions',
            'create subscription',
            'edit subscription',
            'delete subscription',


            // activity logs
            'export activity logs',
            'view activity logs',

        ];

        foreach ($permissions as $permission) {
            Permission::firstOrCreate(['name' => $permission]);
        }

        // 👥 CREATE ROLES
        $superAdmin = Role::firstOrCreate(['name' => 'super-admin']);
        $admin      = Role::firstOrCreate(['name' => 'admin']);
        $staff      = Role::firstOrCreate(['name' => 'staff']);
        $user       = Role::firstOrCreate(['name' => 'user']);

        // 👑 ASSIGN ALL PERMISSIONS TO SUPER ADMIN
        $superAdmin->syncPermissions(Permission::all());

        // 🛠 OPTIONAL: Assign limited permissions to other roles

        $admin->syncPermissions([
            'view users',
            'view user',
            'create user',
            'edit user',
            'toggle user status',
            'assign user roles',
            'view roles',
            'view permissions',
            'view activity logs',
            'view dashboard',
        ]);

        $staff->syncPermissions([
            'view users',
            'view user',
            'edit user',
            'view profile',
            'update profile',
        ]);

        $user->syncPermissions([
            'view profile',
            'update profile',
            'change password',
        ]);
    }
}
