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
            'name' => 'customer',
            'email' => 'customer@example.com',
            'password' => bcrypt('password'),
            'roles' => 'customer',
        ]);

        User::factory()->create([
            'name' => 'administrator',
            'email' => 'admin@admin.com',
            'password' => bcrypt('adminadmin'),
            'roles' => 'admin',
        ]);
    }
}
