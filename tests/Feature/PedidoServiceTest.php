<?php

namespace Tests\Feature;

use App\Models\Pedido;
use App\Models\Produto;
use App\Services\CupomServices;
use App\Services\PedidoServices;
use App\Services\ProdutoServices;
use Tests\TestCase;
use Mockery;

class PedidoServiceTest extends TestCase
{
    protected $pedidoService;
    protected $cupomServicesMock;
    protected $produtoServicesMock;
    protected $pedidoMock;

    protected function setUp(): void
    {
        parent::setUp();

        $this->cupomServicesMock = Mockery::mock(CupomServices::class);
        $this->produtoServicesMock = Mockery::mock(ProdutoServices::class);
        $this->pedidoMock = Mockery::mock(Pedido::class);

        $this->pedidoService = new PedidoServices(
            $this->pedidoMock,
            $this->cupomServicesMock,
            $this->produtoServicesMock
        );
    }

    public function deve_retornar_error_cupom_invalido()
    {
        $dados = [
            'cliente_nome' => 'Fulano',
            'cliente_cpf' => '123.456.789-10',
            'cliente_telefone' => '99999-9999',
            'cliente_email' => 'fulano@email.com',
            'identificacao_cupom' => 'CUPOMINVALIDO',
            'produtos_adicionados' => [],
            'data_venda' => '2024-10-14'
        ];

        $this->cupomServicesMock->shouldReceive('encontrarPorIdenticacao')
            ->with('CUPOMINVALIDO')
            ->andReturn(null);

        $result = $this->pedidoService->cadastrar($dados);

        $this->assertArrayHasKey('errors', $result);
        $this->assertEquals('Esse cupom é inválido', $result['errors']['cupom']['mensagem']);
    }

    public function deve_retornar_error_produto_nao_encontrado()
    {
        $dados = [
            'cliente_nome' => 'Fulano',
            'cliente_cpf' => '123.456.789-10',
            'cliente_telefone' => '99999-9999',
            'cliente_email' => 'fulano@email.com',
            'identificacao_cupom' => null,
            'produtos_adicionados' => [
                ['id' => 1, 'quantidade' => 2]
            ],
            'data_venda' => '2024-10-14'
        ];

        $this->produtoServicesMock->shouldReceive('encontrarPorId')
            ->with(1)
            ->andReturn(null);

        $result = $this->pedidoService->cadastrar($dados);

        $this->assertArrayHasKey('errors', $result);
        $this->assertEquals('Produto não encontrado.', $result['errors']['produto']['mensagem']);
    }

    public function deve_retornar_error_de_quantidade_invalida()
    {
        $dados = [
            'cliente_nome' => 'Fulano',
            'cliente_cpf' => '123.456.789-10',
            'cliente_telefone' => '99999-9999',
            'cliente_email' => 'fulano@email.com',
            'identificacao_cupom' => null,
            'produtos_adicionados' => [
                ['id' => 1, 'quantidade' => 5]
            ],
            'data_venda' => '2024-10-14'
        ];

        $produtoMock = Mockery::mock(Produto::class);
        $produtoMock->quantidade_estoque = 3;
        $produtoMock->id = 1;

        $this->produtoServicesMock->shouldReceive('encontrarPorId')
            ->with(1)
            ->andReturn($produtoMock);

        $result = $this->pedidoService->cadastrar($dados);

        $this->assertArrayHasKey('errors', $result);
        $this->assertEquals('Quantidade insuficiente para o pedido desse produto.', $result['errors']['produto']['mensagem']);
    }

    public function deve_cadastrar_um_pedido()
    {
        $dados = [
            'cliente_nome' => 'Fulano',
            'cliente_cpf' => '123.456.789-10',
            'cliente_telefone' => '99999-9999',
            'cliente_email' => 'fulano@email.com',
            'identificacao_cupom' => null,
            'produtos_adicionados' => [
                ['id' => 1, 'quantidade' => 2]
            ],
            'data_venda' => '2024-10-14'
        ];

        // Mockar o produto encontrado
        $produtoMock = Mockery::mock(Produto::class);
        $produtoMock->quantidade_estoque = 10;
        $produtoMock->valor_venda = 50.00;
        $produtoMock->id = 1;

        // Mockar o serviço de produto para retornar o produto
        $this->produtoServicesMock->shouldReceive('encontrarPorId')
            ->with(1)
            ->andReturn($produtoMock);

        // Mockar a atualização do produto
        $this->produtoServicesMock->shouldReceive('atualizar')
            ->with(Mockery::type('array'), 1)
            ->andReturn(true);

        // Mockar a criação do pedido
        $this->pedidoMock->shouldReceive('create')
            ->andReturn($this->pedidoMock);
        $this->pedidoMock->shouldReceive('pedido_itens')
            ->andReturnSelf();
        $this->pedidoMock->shouldReceive('createMany')
            ->andReturn(true);

        // Executar a função 'cadastrar'
        $result = $this->pedidoService->cadastrar($dados);

        // Não deve haver erros
        $this->assertInstanceOf(Pedido::class, $result);
        $this->assertEquals($dados['cliente_nome'], $result->cliente_nome);
        $this->assertEquals($dados['valor_total'], $result->valor_total);
    }

    protected function tearDown(): void
    {
        parent::tearDown();
        Mockery::close();
    }
}
