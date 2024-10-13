<?php

namespace App\Services;

use App\Models\Categoria;
use Illuminate\Contracts\Pagination\LengthAwarePaginator;
use Illuminate\Database\Eloquent\Collection;

class CategoriaServices extends BaseServices
{
    public function __construct(private Categoria $categoria) { }

    public function listar($pesquisa = '', $select = [], $relacionamentos = [], $ordenacao = [], $porPagina = null) : Collection | LengthAwarePaginator
    {
        $query = $this->categoria->query();
        $query->where('nome', 'like', '%'.$pesquisa.'%');

        $this->aplicarSelect($query, $select);
        $this->aplicarRelacionamento($query, $relacionamentos);
        $this->aplicarOrdenacao($query, $ordenacao);

        if (!is_null($porPagina)) {
            return $query->paginate($porPagina);
        }

        return $query->get();
    }

    public function encontrarPorId($id, $select = [], $relacionamentos = []) : Categoria
    {
        $query = $this->categoria->query();

        $this->aplicarSelect($query, $select);
        $this->aplicarRelacionamento($query, $relacionamentos);

        return $query->find($id);
    }

    public function cadastrar($dados) : Categoria
    {
        return $this->categoria->create($dados);
    }

    public function atualizar($dados, $id) : Array | Categoria
    {
        $categoria = $this->encontrarPorId($id);
        if(empty($categoria))
            return ['error' => 'Registro não encontrado'];

        $categoria->update($dados);

        return $categoria;
    }

    public function deletar($id) : Array | bool
    {
        $categoria = $this->encontrarPorId($id);
        if(empty($categoria))
            return ['error' => 'Registro não encontrado'];

        $resultado = $this->transaction(
            function() use ($categoria){
                $categoria->delete();
            }
        );

        if(!$resultado)
            return ['error' => 'Não foi possivel deletar o registro, verifique se este não possui registros dependentes.'];

        return true;
    }
}
