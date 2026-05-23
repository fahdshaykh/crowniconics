<?php

namespace Database\Seeders;

use App\Enums\RolesEnum;
use Illuminate\Database\Seeder;
use Spatie\Permission\Models\Role;
use Spatie\Permission\Models\Permission;

class PermissionSeeder extends Seeder
{
    public function run(): void
    {
        $this->command->info('⏳ Seeding roles and permissions...');

        $modules = [
            'Users' => ['list users', 'create user', 'edit user', 'delete user', 'view user'],
            'Properties' => ['list properties', 'create property', 'edit property', 'delete property', 'view property', 'manage property'],
            'Categories' => ['list categories', 'create category', 'edit category', 'delete category', 'view category'],
            'Users' => ['list users', 'create user', 'edit user', 'delete user', 'view user'],
            'Roles' => ['list roles', 'create role', 'edit role', 'delete role', 'view role'],
            'services' => ['list services', 'create services', 'edit services', 'delete services', 'view services'],
        ];

        foreach ($modules as $module => $permissions) {
            foreach ($permissions as $perm) {
                Permission::firstOrCreate([
                    'name' => $perm,
                    'module' => $module
                ]);
            }
        }

        // Create roles
        $admin = Role::firstOrCreate(['name' => RolesEnum::ADMIN]);
        $agent = Role::firstOrCreate(['name' => RolesEnum::AGENT]);
        // $user = Role::firstOrCreate(['name' => RolesEnum::USER]);
        $professional = Role::firstOrCreate(['name' => RolesEnum::PROFESSIONAL]);

        // Assign module-based permissions
        $admin->syncPermissions(Permission::pluck('name')->toArray());
        $agent->syncPermissions([
            'list properties',
            'create property',
            'edit property',
            'delete property',
            'view property',
            'manage property',
        ]);
        // $professional->syncPermissions([
        //     'list properties',
        //     'create property',
        //     'edit property',
        //     'delete property',
        //     'view property',
        //     'manage property',
        // ]);
        
        $this->command->info('Roles and Permissions seeding completed successfully!');
    }
}
