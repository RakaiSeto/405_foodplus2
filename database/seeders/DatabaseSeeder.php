<?php

namespace Database\Seeders;

use App\Models\User;
// use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     */
    public function run(): void
    {
         User::factory()->create([
            "name" => "admin",
            "email" => "admin@gmail.com",
            "role" => "admin",
            "password" => Hash::make("admin")
        ]);
        User::factory()->create([
            "name" => "test resto",
            "email" => "testresto@gmail.com",
            "role" => "penyedia",
            "password" => Hash::make("password")
        ]);
        User::factory()->create([
            "name" => "test user",
            "email" => "testuser@gmail.com",
            "role" => "penerima",
            "password" => Hash::make("password")
        ]);

    }
}
