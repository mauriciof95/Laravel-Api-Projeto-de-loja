<?php

namespace App\Services;

use App\Models\Cupom;
use Illuminate\Contracts\Pagination\LengthAwarePaginator;
use Illuminate\Database\Eloquent\Collection;

class CupomServices extends BaseServices
{
    public function __construct(private Cupom $cupom) { }

    public function listar($pesquisa = '', $select = [], $relacionamentos = [], $ordenacao = [], $porPagina = null) : Collection | LengthAwarePaginator
    {
        $query = $this->cupom->query();
        $query->where('identificacao', 'like', '%'.$pesquisa.'%');

        $this->aplicarSelect($query, $select);
        $this->aplicarRelacionamento($query, $relacionamentos);
        $this->aplicarOrdenacao($query, $ordenacao);

        if (!is_null($porPagina)) {
            return $query->paginate($porPagina);
        }

        return $query->get();
    }

    public function encontrarPorId($id, $select = [], $relacionamentos = []) : Cupom
    {
        $query = $this->cupom->query();

        $this->aplicarSelect($query, $select);
        $this->aplicarRelacionamento($query, $relacionamentos);

        return $query->find($id);
    }

    public function encontrarPorIdenticacao(string $identificacao) : Cupom
    {
        return $this->cupom->valido()->where('identificacao', $identificacao)->first();
    }

    public function cadastrar($dados) : Cupom
    {
        return $this->cupom->create($dados);
    }

    public function atualizar($dados, $id) : Array | Cupom
    {
        $cupom = $this->encontrarPorId($id);
        if(empty($cupom))
            return ['error' => 'Registro não encontrado'];

        $cupom->update($dados);

        return $cupom;
    }

    public function deletar($id) : Array | bool
    {
        $cupom = $this->encontrarPorId($id);
        if(empty($cupom))
            return ['error' => 'Registro não encontrado'];

        $resultado = $this->transaction(
            function() use ($cupom){
                $cupom->delete();
            }
        );

        if(!$resultado)
            return ['error' => 'Não foi possivel deletar o registro, verifique se este não possui registros dependentes.'];

        return true;
    }
}
