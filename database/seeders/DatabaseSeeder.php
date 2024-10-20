<?php

namespace Database\Seeders;

use App\Models\Categoria;
use App\Models\Cliente;
use App\Models\Cupom;
use App\Models\Produto;
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
            'name' => 'Admin User',
            'email' => 'admin@admin.com',
            'password' => Hash::make('admin')
        ]);

        // Cliente::factory()
        //     ->create();

        // Categoria::factory()
        //     ->count(50)
        //     ->create();

        // Produto::factory()
        //     ->count(10)
        //     ->create();

        // Cupom::factory()
        //     ->count(10)
        //     ->create();
    }
}
