<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\User;
use Illuminate\Support\Facades\Hash;

class UserSeeder extends Seeder
{
    public function run(): void
    {
        // Admin
        User::updateOrCreate(
            ['email' => 'admin@example.com'],
            [
                'name' => 'Admin Demo',
                'phone' => '081234567890',
                'email' => 'admin@example.com',
                'password' => Hash::make('@Password123'),
                'role' => 'admin'
            ]
        );

        // Customer
        User::updateOrCreate(
            ['email' => 'customer@example.com'],
            [
                'name' => 'Customer Demo',
                'phone' => '085177778888',
                'email' => 'customer@example.com',
                'password' => Hash::make('@Password123'),
                'role' => 'customer'
            ]
        );
    }
}
