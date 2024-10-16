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

    public function cadastrar(Request $request)
    {
        $result = $this->pedido_services->cadastrar($request->all());

        dd($result);
        return $this->success($result);
    }
}
