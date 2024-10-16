<?php

namespace Tests\Feature\Livewire\Produto;

use App\Livewire\Produto\EditarProduto;
use App\Models\Categoria;
use App\Models\Produto;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Livewire\Livewire;
use PHPUnit\Framework\Attributes\Test;
use Tests\TestCase;

class EditarProdutoTest extends TestCase
{
    use RefreshDatabase;

    #[Test]
    public function renders_successfully()
    {
        $categoria = Categoria::factory()->create();
        $produto = Produto::factory()->make();
        $produto->categoria_id = $categoria->id;
        $produto->save();

        Livewire::test(EditarProduto::class, ['id' => $produto->id])
            ->assertStatus(200);
    }
}
