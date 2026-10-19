<?php

namespace Database\Seeders;

use App\Models\User;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;

class UserSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        // Owner account
        User::create([
            'name' => 'Owner Bengkel',
            'email' => '@example.com',
            'password' => Hash::make('pass'),
            'role' => 'owner',
        ]);

        // Admin account
        User::create([
            'name' => 'Admin Bengkel',
            'email' => '@example.com',
            'password' => Hash::make('pass'),
            'role' => 'admin',
        ]);
    }
}
