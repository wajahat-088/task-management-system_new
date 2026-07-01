<?php

namespace Database\Seeders;

use App\Models\User;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;

class UserSeeder extends Seeder
{
    public function run(): void
    {
        // 3 specific users 
          $admin = User::firstOrCreate(
            ['email' => 'admin@test.com'],
            [
                'name'     => 'Admin User',
                'password' => Hash::make('password'),
            ]
        );
        $admin->syncRoles('admin');

        $manager = User::firstOrCreate(
            ['email' => 'john@test.com'],
            [
                'name'     => 'John Doe',
                'password' => Hash::make('password'),
            ]
        );
        $manager->syncRoles('manager');

        $user = User::firstOrCreate(
            ['email' => 'jane@test.com'],
            [
                'name'     => 'Jane Smith',
                'password' => Hash::make('password'),
            ]
        );
        $user->syncRoles('user');
    }
    }
