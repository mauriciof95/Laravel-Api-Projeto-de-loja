<?php

namespace App\Http\Controllers;

use App\Services\CategoriaServices;
use App\Traits\ApiResponser;
use Illuminate\Http\Request;

class CategoriaController extends Controller
{
    use ApiResponser;

    public function __construct(
        private CategoriaServices $categoria_services
    ) { }

    private $por_pagina = 20;

    public function listar(Request $request)
    {
        $pesquisa = $request->pesquisa ?: '';
        $por_pagina = $request->por_pagina ?: $this->por_pagina;

        $categorias = $this->categoria_services->listar(
            $pesquisa,
            porPagina: $por_pagina);

        return $this->success($categorias);
    }

    public function encontrarPorId($id)
    {
        if($id == null){
            return $this->error('Categoria não encontrada', 404);
        }

        $categoria = $this->categoria_services->encontrarPorId($id);
        return $this->success($categoria);
    }
}
