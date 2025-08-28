<?php

namespace Database\Seeders;

use App\Models\User;
use App\Models\Api\Enterprise;

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

        Enterprise::factory()->create([
            'name' => 'Admin',
            'phone' => '1234567890',
        ]);

        User::factory()->create([
            'email' => 'admin@admin.com',
            'password' => bcrypt('adminadmin'),
            'roles' => 'superadmin',
            'enterprise_id' => 1,
        ]);
    }
}
