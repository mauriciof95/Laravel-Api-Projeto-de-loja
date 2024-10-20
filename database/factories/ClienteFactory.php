<?php

namespace Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Str;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\Cliente>
 */
class ClienteFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        $parte1 = fake()->unique()->numberBetween(100, 999);
        $parte2 = fake()->unique()->numberBetween(100, 999);
        $parte3 = fake()->unique()->numberBetween(100, 999);
        $parte4 = fake()->unique()->numberBetween(10, 99);

        return [
            'nome' => fake()->name(),
            'email' => fake()->unique()->safeEmail(),
            'c_cpf' => $parte1.'.'.$parte2.'.'.$parte3.'-'.$parte4,
            'telefone' => '(88) 9'.fake()->numberBetween(1000, 9999).'-'.fake()->numberBetween(1000, 9999),
            'email_verified_at' => now(),
            'password' => Hash::make('12345678'),
            'remember_token' => Str::random(10),
        ];
    }
}
