<?php

namespace App\Services;

use App\Models\Cliente;
use Illuminate\Contracts\Pagination\LengthAwarePaginator;
use Illuminate\Database\Eloquent\Collection;

class ClienteServices extends BaseServices
{
    public function __construct(private Cliente $cliente) { }

    public function listar($pesquisa = '', $select = [], $relacionamentos = [], $ordenacao = [], $porPagina = null) : Collection | LengthAwarePaginator
    {
        $query = $this->cliente->query();
        $query->where('nome', 'like', '%'.$pesquisa.'%');

        $this->aplicarSelect($query, $select);
        $this->aplicarRelacionamento($query, $relacionamentos);
        $this->aplicarOrdenacao($query, $ordenacao);

        if (!is_null($porPagina)) {
            return $query->paginate($porPagina);
        }

        return $query->get();
    }

    public function encontrarPorId($id, $select = [], $relacionamentos = []) : Cliente | null
    {
        $query = $this->cliente->query();

        $this->aplicarSelect($query, $select);
        $this->aplicarRelacionamento($query, $relacionamentos);

        return $query->find($id);
    }

    public function cadastrar($dados) : Cliente
    {
        return $this->cliente->create($dados);
    }

    public function atualizar($dados, $id) : Array | Cliente
    {
        $cliente = $this->encontrarPorId($id);
        if(empty($cliente))
            return ['error' => 'Registro não encontrado'];

        $cliente->update($dados);

        return $cliente;
    }
}
