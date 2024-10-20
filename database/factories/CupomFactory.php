<?php

namespace Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\Cupom>
 */
class CupomFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        return [
            'identificacao' => 'CUPOM'.fake()->numberBetween(10, 9999),
            'data_validade' => '2024-12-30',
            'valor_desconto' => fake()->numberBetween(10, 50),
            'aplicado' => fake()->numberBetween(1, 3) == 1 ? true : false,
        ];
    }
}
