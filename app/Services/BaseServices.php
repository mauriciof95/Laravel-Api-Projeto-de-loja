<?php
namespace App\Services;

class BaseServices
{
    public function aplicar_select($query, $select = [])
    {
        if (!empty($select)) {
            return $query->select($select);
        }

        return $query;
    }

    public function aplicar_relacionamento($query, $relacionamentos = [])
    {
        if (!empty($relacionamentos)) {
            return $query->with($relacionamentos);
        }

        return $query;
    }

    public function aplicar_ordenacao($query, $ordenacao = [])
    {
        if (!empty($ordenacao))
        {
            return $query->orderBy($ordenacao[0], $ordenacao[1] ?? '');
        }

        return $query;
    }
}
