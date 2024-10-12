<?php

namespace Tests\Feature\Livewire\Categoria;

use App\Livewire\Categoria\CadastrarCategoria;
use App\Models\Categoria;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Livewire\Livewire;
use PHPUnit\Framework\Attributes\Test;
use Tests\TestCase;

class CadastrarCategoriaTest extends TestCase
{
    use RefreshDatabase;

    #[Test]
    public function deve_cadastrar_uma_categoria_valida()
    {
        Livewire::test(CadastrarCategoria::class)
            ->set('nome', 'Teste Categoria')
            ->call('cadastrar')
            ->assertHasNoErrors();

        $this->assertDatabaseCount(Categoria::class, 1);
    }

    #[Test]
    public function deve_retornar_erro_validacao_required_ao_cadastrar()
    {
        Livewire::test(CadastrarCategoria::class)
            ->set('nome', '')
            ->call('cadastrar')
            ->assertHasErrors(['nome' => 'required']);
    }

    #[Test]
    public function deve_retornar_erro_validacao_min_ao_cadastrar()
    {
        Livewire::test(CadastrarCategoria::class)
            ->set('nome', 'te')
            ->call('cadastrar')
            ->assertHasErrors(['nome' => 'min']);
    }

    #[Test]
    public function deve_retornar_erro_validacao_unique_ao_cadastrar()
    {
        $categoria = Categoria::factory()->create();

        Livewire::test(CadastrarCategoria::class)
            ->set('nome', $categoria->nome)
            ->call('cadastrar')
            ->assertHasErrors(['nome' => 'unique']);
    }
}
