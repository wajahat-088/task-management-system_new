<?php

namespace Database\Seeders;

use App\Models\User;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;

class UserSeeder extends Seeder
{
    public function run(): void
    {
        // 3 specific users banao
        User::create([
            'name'     => 'Admin User',
            'email'    => 'admin@test.com',
            'password' => Hash::make('password'),
        ]);

        User::create([
            'name'     => 'John Doe',
            'email'    => 'john@test.com',
            'password' => Hash::make('password'),
        ]);

        User::create([
            'name'     => 'Jane Smith',
            'email'    => 'jane@test.com',
            'password' => Hash::make('password'),
        ]);
    }
}