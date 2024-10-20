<?php

namespace App\Services;

use App\Enums\PedidoEnum;
use App\Jobs\EnviarEmailPedidoJob;
use App\Models\Pedido;
use Illuminate\Database\Eloquent\Collection;
use Illuminate\Pagination\LengthAwarePaginator;
use Illuminate\Support\Facades\DB;

class PedidoServices extends BaseServices
{
    public function __construct(
        protected Pedido $pedido,
        protected CupomServices $cupom_services,
        protected ProdutoServices $produto_services
    ) { }

    public function listar($pesquisa = '', $select = [], $relacionamentos = [], $ordenacao = [], $porPagina = null) : Collection | LengthAwarePaginator
    {
        $query = $this->pedido->query();
        $query = $query->whereHas('cliente', function($query) use ($pesquisa){
            $query->where('nome', 'ilike', '%'.$pesquisa.'%')
                  ->orWhere('c_cpf', 'like', '%'.$pesquisa.'%');
        });

        $this->aplicarSelect($query, $select);
        $this->aplicarRelacionamento($query, $relacionamentos);
        $this->aplicarOrdenacao($query, $ordenacao);

        if (!is_null($porPagina)) {
            return $query->paginate($porPagina);
        }

        return $query->get();
    }

    public function encontrarPorId($id, $select = [], $relacionamentos = []) : Pedido
    {
        $query = $this->pedido->query();

        $this->aplicarSelect($query, $select);
        $this->aplicarRelacionamento($query, $relacionamentos);

        return $query->find($id);
    }

    public function cadastrar($dados, $cliente_id)
    {
        try{
            DB::beginTransaction();

            $cupom = null;
            if($dados['identificacao_cupom'] != null)
            {
                $cupom = $this->cupom_services->encontrarPorIdentificacao($dados['identificacao_cupom']);
            }

            if($cupom == null && $dados['identificacao_cupom'] != null){
                return [
                    'errors' => [
                        'cupom' => [
                            'mensagem' => 'Esse cupom é inválido'
                        ]
                    ]
                ];
            }

            $produtos_adicionados = $dados['itens'];
            $atualizar_produtos = [];
            $produtos_pedido = [];
            foreach($produtos_adicionados as $item)
            {
                $produto = $this->produto_services->encontrarPorId($item['produto_id']);
                if($produto == null)
                    return ['errors' => ['produto' => ['id' => $item['produto_id'], 'mensagem' => 'Produto não encontrado.']]];

                if($item['quantidade'] <= 0 || $produto->quantidade_estoque <= 0)
                    return ['errors' => ['produto' => ['id' => $item['produto_id'], 'mensagem' => 'Quantidade insuficiente para o pedido desse produto.']]];

                if($produto->quantidade_estoque < $item['quantidade'])
                    return ['errors' => ['produto' => ['id' => $item['produto_id'], 'mensagem' => 'Quantidade insuficiente para o pedido desse produto.']]];

                $produto->quantidade_estoque -= $item['quantidade'];
                array_push($atualizar_produtos, $produto);
                array_push($produtos_pedido, [
                    'quantidade' =>  $item['quantidade'],
                    'valor_unitario' => $produto->valor_venda,
                    'produto_id' => $produto->id
                ]);
            }

            foreach($atualizar_produtos as $item)
            {
                $this->produto_services->atualizar([
                    'quantidade_estoque' => $item->quantidade_estoque
                ], $item->id);
            }

            $valor_total = collect($produtos_pedido)->sum(fn($p) => $p['valor_unitario'] * $p['quantidade']);
            $cupom_id = null;
            if($cupom != null){
                $cupom_id = $cupom->id;
                $valor_desconto = $cupom->valor_desconto;
                $desconto_total = ($valor_desconto / 100) * $valor_total;
                $valor_total -= $desconto_total;

                if($valor_total < 0)
                    $valor_total = 0;

                $this->cupom_services->atualizar([
                    'aplicado' => true
                ] ,$cupom_id);
            }

            $dados['valor_total'] = $valor_total;
            $dados['data_venda'] = date('Y-m-d H:i:s');
            $dados['cupom_id'] = $cupom_id;
            $dados['cliente_id'] = $cliente_id;
            $dados['status'] = PedidoEnum::RECEBIDO;

            $pedido = $this->pedido->create($dados);
            $pedido->pedido_itens()->createMany($produtos_pedido);

            DB::commit();

            EnviarEmailPedidoJob::dispatch($pedido);
            return $pedido;
        }catch(\Exception $e){
            DB::rollBack();
            throw $e;
        }
    }

    public function atualizarStatus($dados, $pedido_id){
        $pedido = $this->encontrarPorId($pedido_id);

        if($pedido == null)
            return ['error' => 'Registro não encontrado'];

        $pedido->update(['status' => $dados['status']]);

        EnviarEmailPedidoJob::dispatch($pedido);
        return $pedido;
    }
}
