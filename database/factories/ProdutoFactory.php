<?php

namespace Database\Factories;

use App\Models\Categoria;
use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\Produto>
 */
class ProdutoFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        return [
            'nome' => fake()->unique()->words(3, true),
            'descricao' => fake()->paragraphs(2, true),
            'valor_compra' => fake()->randomFloat(2, 2, 200),
            'valor_venda' => fake()->randomFloat(2, 2, 200),
            'quantidade_estoque' => fake()->numberBetween(0, 20),
            'categoria_id' => Categoria::inRandomOrder()->first()->id
        ];
    }
}
