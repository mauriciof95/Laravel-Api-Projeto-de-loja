<?php

namespace Tests\Feature;

use App\Models\Categoria;
use App\Models\Cliente;
use App\Models\Cupom;
use App\Models\Pedido;
use App\Models\PedidoItem;
use App\Models\Produto;
use App\Services\CupomServices;
use App\Services\PedidoServices;
use App\Services\ProdutoServices;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;
use Mockery;
use PHPUnit\Framework\Attributes\Test;

class PedidoServiceTest extends TestCase
{
    use RefreshDatabase;

    protected $pedido_service;
    protected $cupom_services_mock;
    protected $produto_services_mock;
    protected $pedidoMock;
    protected $pedidoItensMock;

    protected function setUp(): void
    {
        parent::setUp();

        $this->cupom_services_mock = Mockery::mock(CupomServices::class);
        $this->produto_services_mock = Mockery::mock(ProdutoServices::class);
        $this->pedidoMock = Mockery::mock(Pedido::class);
        $this->pedidoItensMock = Mockery::mock(PedidoItem::class);

        $this->pedido_service = new PedidoServices(
            $this->pedidoMock,
            $this->cupom_services_mock,
            $this->produto_services_mock
        );
    }

    #[Test]
    public function deve_retornar_error_cupom_invalido()
    {
        $dados = [
            'identificacao_cupom' => 'CUPOMINVALIDO',
            'itens' => [],
            'data_venda' => '2024-10-14'
        ];

        $cliente_mock = Mockery::mock(Cliente::class);
        $cliente_mock->shouldReceive('getAttribute')->with('id')->andReturn(1);

        $this->cupom_services_mock->shouldReceive('encontrarPorIdentificacao')
            ->with('CUPOMINVALIDO')
            ->andReturn(null);

        $result = $this->pedido_service->cadastrar($dados, $cliente_mock->id);

        $this->assertArrayHasKey('errors', $result);
        $this->assertEquals('Esse cupom é inválido', $result['errors']['cupom']['mensagem']);
    }

    #[Test]
    public function deve_retornar_error_produto_nao_encontrado()
    {
        $dados = [
            'identificacao_cupom' => null,
            'itens' => [
                ['produto_id' => 1, 'quantidade' => 2]
            ],
            'data_venda' => '2024-10-14'
        ];

        $cliente_mock = Mockery::mock(Cliente::class);
        $cliente_mock->shouldReceive('getAttribute')->with('id')->andReturn(1);

        $this->produto_services_mock->shouldReceive('encontrarPorId')
            ->with(1)
            ->andReturn(null);

        $result = $this->pedido_service->cadastrar($dados, $cliente_mock->id);

        $this->assertArrayHasKey('errors', $result);
        $this->assertEquals('Produto não encontrado.', $result['errors']['produto']['mensagem']);
    }

    #[Test]
    public function deve_retornar_error_de_quantidade_invalida()
    {
        $dados = [
            'identificacao_cupom' => null,
            'itens' => [
                ['produto_id' => 1, 'quantidade' => 5]
            ],
            'data_venda' => '2024-10-14'
        ];

        $cliente_mock = Mockery::mock(Cliente::class);
        $cliente_mock->shouldReceive('getAttribute')->with('id')->andReturn(1);

        $produtoMock = Mockery::mock(Produto::class);
        $produtoMock->shouldReceive('getAttribute')->with('quantidade_estoque')->andReturn(3);
        $produtoMock->shouldReceive('getAttribute')->with('id')->andReturn(1);

        $this->produto_services_mock->shouldReceive('encontrarPorId')
            ->with(1)
            ->andReturn($produtoMock);

        $result = $this->pedido_service->cadastrar($dados, $cliente_mock->id);

        $this->assertArrayHasKey('errors', $result);
        $this->assertEquals('Quantidade insuficiente para o pedido desse produto.', $result['errors']['produto']['mensagem']);
    }

    #[Test]
    public function deve_cadastrar_um_pedido()
    {
        $pedido_service = new PedidoServices(
            new Pedido(),
            new CupomServices(new Cupom()),
            new ProdutoServices(new Produto())
        );

        $dados = [
            'identificacao_cupom' => null,
            'itens' => [
                ['produto_id' => 1, 'quantidade' => 2]
            ],
            'data_venda' => '2024-10-14'
        ];

        $cliente = Cliente::factory()->make();
        $cliente->id = 1;
        $cliente->save();

        $categoria = Categoria::factory()->make();
        $categoria->id = 1;
        $categoria->save();

        $produto = Produto::factory()->make();
        $produto->categoria_id = $categoria->id;
        $produto->quantidade_estoque = 10;
        $produto->valor_venda = 50.00;
        $produto->id = 1;
        $produto->save();

        $result = $pedido_service->cadastrar($dados, $cliente->id);

        $this->assertInstanceOf(Pedido::class, $result);
        $this->assertEquals(100, $result->valor_total);
    }

    protected function tearDown(): void
    {
        parent::tearDown();
        Mockery::close();
    }
}
