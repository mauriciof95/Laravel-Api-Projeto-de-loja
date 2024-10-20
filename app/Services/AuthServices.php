<?php

namespace App\Services;

use App\Models\Cliente;

class AuthServices extends BaseServices
{
    /**
     * @param array $credenciais
     *
     * @var $credenciais[email] string, required
     * @var $credenciais[password] string, required
     *
     * @return array ['token', 'user_nome', 'user_email'] ou ['error'] em caso de falha na autenticação
     */
    public function loginComEmailSenha($credenciais) : array
    {
        if (!auth()->guard('api')->attempt($credenciais)) {
            return ['error' => 'Email ou senha incorretos.'];
        }

        $user = auth()->guard('api')->user();

        $token = $user->createToken('Cliente API Token');

        return [
            'token' => $token->plainTextToken,
            'user_nome' => $user->nome,
            'user_email' => $user->email,
        ];
    }

    /**
     * @return array ['token', 'user_nome', 'user_email']
     */
    public function loginComModelCliente(Cliente $cliente) : array
    {
        auth()->guard('api')->login($cliente);

        $user = auth()->guard('api')->user();

        $token = $user->createToken('Cliente API Token');

        return [
            'token' => $token->plainTextToken,
            'user_nome' => $user->nome,
            'user_email' => $user->email,
        ];
    }
}
