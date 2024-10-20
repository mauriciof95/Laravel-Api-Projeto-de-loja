<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use App\Http\Requests\LoginClienteRequest;
use App\Services\AuthServices;
use App\Traits\ApiResponser;

class AuthClienteController extends Controller
{
    use ApiResponser;

    public function __construct(protected AuthServices $auth_services) { }

    public function login(LoginClienteRequest $request)
    {
        $dados = $request->all();
        $resultado = $this->auth_services->loginComEmailSenha($dados);

        if(!empty($resultado['error']))
            return $this->error($resultado['error'], 422);

        return $this->success($resultado);
    }

    public function logout()
    {
        auth()->user()->tokens()->delete();

        return [
            'message' => 'Deslogado com sucesso.'
        ];
    }
}
