<?php

namespace Tests\Feature\Livewire\Produto;

use App\Livewire\Produto\CadastrarProduto;
use App\Models\Categoria;
use App\Models\Produto;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Livewire\Livewire;
use PHPUnit\Framework\Attributes\Test;
use Tests\TestCase;

class CadastrarProdutoTest extends TestCase
{
    use RefreshDatabase;

    #[Test]
    public function deve_cadastrar_um_produto_valido()
    {
        $categoria = Categoria::factory()->create();

        Livewire::test(CadastrarProduto::class)
            ->set('nome', 'Teste Produto')
            ->set('descricao', 'Lorem ipsum dolor sit amet, consectetur adipisicing elit. Id minus quae velit deserunt, earum est quaerat omnis reiciendis suscipit quibusdam! Mollitia minus doloremque neque, deleniti reiciendis reprehenderit architecto tempore veritatis.')
            ->set('valor_compra', 10.0)
            ->set('valor_venda', 20.0)
            ->set('quantidade_estoque', 5)
            ->set('categoria_id', $categoria->id)
            ->call('cadastrar')
            ->assertHasNoErrors();

        $this->assertDatabaseCount(Produto::class, 1);
    }

    #[Test]
    public function deve_retornar_erro_validacao_exists_ao_cadastrar_com_categoria_inexistente()
    {

        Livewire::test(CadastrarProduto::class)
            ->set('nome', 'Teste Produto Falha')
            ->set('descricao', 'Lorem ipsum dolor sit amet, consectetur adipisicing elit. Id minus quae velit deserunt, earum est quaerat omnis reiciendis suscipit quibusdam! Mollitia minus doloremque neque, deleniti reiciendis reprehenderit architecto tempore veritatis.')
            ->set('valor_compra', 10.0)
            ->set('valor_venda', 20.0)
            ->set('quantidade_estoque', 5)
            ->set('categoria_id', 999)
            ->call('cadastrar')
            ->assertHasErrors(['categoria_id' => 'exists']);

            $this->assertDatabaseMissing('produtos', ['nome' => 'Teste Produto Falha']);
    }

    #[Test]
    public function deve_retornar_erro_validacao_unique_ao_cadastrar()
    {
        $categoria = Categoria::factory()->create();
        $produto = Produto::factory()->make();
        $produto->categoria_id = $categoria->id;
        $produto->save();

        Livewire::test(CadastrarProduto::class)
            ->set('nome', $produto->nome)
            ->set('descricao', 'Lorem ipsum dolor sit amet, consectetur adipisicing elit. Id minus quae velit deserunt, earum est quaerat omnis reiciendis suscipit quibusdam! Mollitia minus doloremque neque, deleniti reiciendis reprehenderit architecto tempore veritatis.')
            ->set('valor_compra', 10.0)
            ->set('valor_venda', 20.0)
            ->set('quantidade_estoque', 5)
            ->set('categoria_id', $categoria->id)
            ->call('cadastrar')
            ->assertHasErrors(['nome' => 'unique']);

        $this->assertDatabaseCount(Produto::class, 1);
    }
}
