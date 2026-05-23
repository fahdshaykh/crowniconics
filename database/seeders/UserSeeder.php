<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\User;
use Illuminate\Support\Facades\Hash;
use Spatie\Permission\Models\Role;

class UserSeeder extends Seeder
{
    public function run(): void
    {
        $roles = ['admin', 'agent', 'customer', 'professional'];
        foreach ($roles as $role) {
            Role::firstOrCreate(['name' => $role]);
        }

        // Admin user
        $admin = User::updateOrCreate(
            ['email' => 'admin@example.com'],
            [
                'name' => 'Admin',
                'first_name' => 'Admin',
                'last_name' => 'User',
                'phone' => '+1234567890',
                'password' => Hash::make('password'),
                'country_id' => 1,
                'city_id' => 1,
                'state_id' => 1,
                'zip_code' => '10001',
                'address' => '123 Admin Street, New York, NY 10001',
                'status' => 1,
                'role' => 'admin',
                'email_verified_at' => now(),
            ]
        );
        $admin->assignRole('admin');

        $agent = User::updateOrCreate(
            ['email' => 'agent@example.com'],
            [
                'name' => 'john Doe',
                'first_name' => 'john',
                'last_name' => 'Doe',
                'phone' => '+1234567890',
                'password' => Hash::make('password'),
                'country_id' => 1,
                'city_id' => 1,
                'state_id' => 1,
                'zip_code' => '10001',
                'address' => '123 Admin Street, New York, NY 10001',
                'status' => 1,
                'role' => 'agent',
                'email_verified_at' => now(),
            ]
        );
        $agent->assignRole('agent');

        $professional = User::updateOrCreate(
            ['email' => 'professional@example.com'],
            [
                'name' => 'professional',
                'first_name' => 'john',
                'last_name' => 'Doe',
                'phone' => '+1234567890',
                'password' => Hash::make('password'),
                'country_id' => 1,
                'city_id' => 1,
                'state_id' => 1,
                'zip_code' => '10001',
                'address' => '123 Admin Street, New York, NY 10001',
                'status' => 1,
                'role' => 'professional',
                'email_verified_at' => now(),
            ]
        );
        $professional->assignRole('professional');

    }
}
