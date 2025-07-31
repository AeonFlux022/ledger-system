<?php

namespace Database\Seeders;

use App\Models\User;
// use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     */
    public function run(): void
    {
        // User::factory(10)->create();

        User::factory()->create([
            'username' => 'admin',
            'email' => 'admin@mail.com',
            'password' => bcrypt('admin'),
            'role' => 'admin', // Default role
        ]);

        User::factory()->create([
            'username' => 'superadmin',
            'email' => 'superadmin@mail.com',
            'password' => bcrypt('superadmin'),
            'role' => 'super_admin', // Default role
        ]);
    }
}
