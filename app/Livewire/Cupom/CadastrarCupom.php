<?php

namespace App\Livewire\Cupom;

use App\Services\CupomServices;
use Livewire\Component;
use Masmerise\Toaster\Toaster;

class CadastrarCupom extends Component
{
    protected CupomServices $cupom_services;

    public string $identificacao = '';
    public $data_validade;
    public float $valor_desconto = 0.0;


    public function boot(CupomServices $cupom_services)
    {
        $this->cupom_services = $cupom_services;
    }

    public function rules() : array
    {
        return [
            'identificacao' => ['required', 'string', 'min:3', 'unique:cupons,identificacao'],
            'data_validade' => ['required', 'date'],
            'valor_desconto' => ['required', 'numeric', 'min:1', 'max:100'],
        ];
    }

    public function cadastrar()
    {
        $dados = $this->validate();
        $this->cupom_services->cadastrar($dados);
        Toaster::success('Registro cadastrado com sucesso!');
        $this->reset();
    }

    public function render()
    {
        return view('livewire.cupom.cadastrar-cupom');
    }
}
