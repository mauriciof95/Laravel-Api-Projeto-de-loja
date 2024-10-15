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
            porPagina: $por_pagina);

        foreach($produtos as $item)
        {
            if($item->imagem == null){
                $item->imagem = imagemProduto($item->imagem);
            }
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

        if($produto->imagem == null){
            $produto->imagem = imagemProduto($produto->imagem);
        }

        return $this->success($produto);
    }
}
