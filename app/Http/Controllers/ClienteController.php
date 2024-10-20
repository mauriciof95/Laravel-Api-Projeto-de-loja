<?php

namespace App\Http\Controllers;

use App\Http\Requests\CadastrarClienteRequest;
use App\Services\AuthServices;
use App\Services\ClienteServices;
use App\Traits\ApiResponser;

class ClienteController extends Controller
{
    use ApiResponser;

    public function __construct(
        protected ClienteServices $cliente_services,
        protected AuthServices $auth_services
    ) { }

    public function cadastrar(CadastrarClienteRequest $request){
        $dados = $request->all();
        $cliente = $this->cliente_services->cadastrar($dados);
        $token = $this->auth_services->loginComModelCliente($cliente);
        return $this->success($token);
    }
}
