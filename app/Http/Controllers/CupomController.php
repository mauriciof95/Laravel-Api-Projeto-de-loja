<?php

namespace App\Http\Controllers;

use App\Services\CupomServices;
use App\Traits\ApiResponser;

class CupomController extends Controller
{
    use ApiResponser;

    public function __construct(protected CupomServices $cupom_services) { }

    public function encontrarPorIdentificacao($identificacao)
    {
        $cupom = $this->cupom_services->encontrarPorIdentificacao($identificacao);
        return $this->success($cupom);
    }
}
