<?php

namespace App\Services;

use App\Models\Categoria;

class CategoriaServices extends BaseServices
{
    public function __construct(private Categoria $categoria) { }

    public function cadastrar($dados)
    {
        $this->categoria->create($dados);
    }
}
