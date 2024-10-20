<?php

namespace App\Http\Controllers;

use App\Services\ProdutoServices;
use App\Traits\ApiResponser;
use Illuminate\Http\Request;

class ProdutoController extends Controller
{
    use ApiResponser;

    public function __construct(
        private ProdutoServices $produto_services
    ) { }

    private $por_pagina = 20;

    public function listar(Request $request)
    {
        $pesquisa = $request->pesquisa ?: '';
        $por_pagina = $request->por_pagina ?: $this->por_pagina;

        $produtos = $this->produto_services->listar(
            $pesquisa,
            relacionamentos: ['categoria'],
            porPagina: $por_pagina,
            ordenacao: [['quantidade_estoque', 'desc'], ['id', 'asc']]
        );

        foreach($produtos as $item)
        {
            $item->imagem = url(imagemProduto($item->imagem));
        }

        return $this->success($produtos);
    }

    public function encontrarPorId($id)
    {
        if($id == null){
            return $this->error('Produto não encontrado', 404);
        }

        $produto = $this->produto_services->encontrarPorId(
            $id,
            relacionamentos: ['categoria']
        );

        $produto->imagem = url(imagemProduto($produto->imagem));

        return $this->success($produto);
    }
}
