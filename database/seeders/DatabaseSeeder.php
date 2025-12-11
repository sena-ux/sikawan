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

        User::create([
            'email' => 'admin@sikawan.sma',
            'username' => 'administrator',
            'password' => bcrypt('admin@sikawan.sma'),
            'role' => 'admin',
        ]);
    }
}
