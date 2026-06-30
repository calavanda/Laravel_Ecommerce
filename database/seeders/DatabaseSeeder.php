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
        // Crear usuario de pruebas por defecto
        User::create([
            'name' => 'Admin User',
            'email' => 'admin@ecommerce.com',
            'password' => bcrypt('password'),
            'is_admin' => true,
        ]);

        // Sembrar el ecommerce
        $this->call(EcommerceSeeder::class);
    }
}
