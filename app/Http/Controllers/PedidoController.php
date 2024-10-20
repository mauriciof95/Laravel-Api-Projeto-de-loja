<?php

namespace App\Http\Controllers;

use App\Services\PedidoServices;
use App\Traits\ApiResponser;
use Illuminate\Http\Request;

class PedidoController extends Controller
{
    use ApiResponser;

    public function __construct(
        private PedidoServices $pedido_services
    ) { }

    private $por_pagina = 20;

    public function listar(Request $request)
    {
        $pesquisa = $request->pesquisa ?: '';
        $por_pagina = $request->por_pagina ?: $this->por_pagina;

        $pedidos = $this->pedido_services->listar(
            $pesquisa,
            relacionamentos: ['cupom'],
            porPagina: $por_pagina);

        return $this->success($pedidos);
    }

    public function encontrarPorId($id)
    {
        $pedido = $this->pedido_services->encontrarPorId(
            $id,
            relacionamentos: ['cupom', 'pedido_itens.produto.categoria']
        );

        if($pedido == null)
            return $this->error('Registro não encontrado', 404);

        foreach($pedido->pedido_itens as $item){
            $item->produto->imagem = url(imagemProduto($item->produto->imagem));
        }

        return $this->success($pedido);
    }

    public function cadastrar(Request $request)
    {
        $user = auth()->user();

        $pedido = $this->pedido_services->cadastrar($request->all(), $user->id);

        if(!empty($pedido['errors']))
            return $this->error($pedido, 422);

        return $this->success($pedido);
    }
}
