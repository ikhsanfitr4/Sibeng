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
            'name' => 'Ikhsan Fitrah Al Mubarak',
            'email' => 'owner@bengkel.com',
            'password' => Hash::make('password123'),
            'role' => 'owner',
        ]);

        // Admin account
        User::create([
            'name' => 'Admin Bengkel',
            'email' => 'admin@bengkel.com',
            'password' => Hash::make('password123'),
            'role' => 'admin',
        ]);
    }
}