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
            'name' => 'Empresa Exemplo',
            'email' => 'empresa@exemplo.com',
            'password' => bcrypt('password'),
            'roles' => 'admin',
        ]);

        User::factory()->create([
            'name' => 'Super Admin',
            'email' => 'admin@admin.com',
            'password' => bcrypt('adminadmin'),
            'roles' => 'superadmin',
        ]);
    }
}
