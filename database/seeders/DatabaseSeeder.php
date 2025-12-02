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

        User::factory()->create([
            'name' => 'admin',
            'role' => 'admin',
            'password' => bcrypt('password'),
            'email' => 'admin@gmail.com',
        ]);

        User::factory()->create([
            'name' => 'user3',
            'role' => 'customer',
            'password' => bcrypt('12345678'),
            'email' => 'user3@gmail.com',
        ]);

        User::factory()->create([
            'name' => 'badmin',
            'role' => 'branch_admin',
            'password' => bcrypt('password'),
            'email' => 'badmin@gmail.com',
        ]);
    }
}
