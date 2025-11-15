<?php

namespace Database\Seeders;

use App\Models\User;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class DatabaseSeeder extends Seeder
{
    use WithoutModelEvents;

    /**
     * Seed the application's database.
     */
    public function run(): void
    {
        // User::factory(10)->create();

        User::create([
            'name' => 'Admin User',
            'username' => 'adminuser',
            'email' => 'admin@example.com',
            'role' => 'admin',
            'password' => bcrypt('adminuser'), // Change this to a secure password
        ]);

        User::create([
            'name' => 'Regular User',
            'username' => 'regularuser',
            'email' => 'user@example.com',
            'role' => 'user',
            'password' => bcrypt('password'), // Change this to a secure password
            'phone_number' => '08876543210',
            'address' => '123 Main St, Cityville',
        ]);
    }
}