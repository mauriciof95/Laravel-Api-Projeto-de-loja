<?php

namespace App\Livewire\Cupom;

use App\Services\CupomServices;
use Livewire\Component;
use Masmerise\Toaster\Toaster;

class EditarCupom extends Component
{
    protected CupomServices $cupom_services;

    public int $id = 0;
    public string $identificacao = '';
    public $data_validade;
    public float $valor_desconto = 0.0;
    public bool $aplicado = false;

    public function boot(CupomServices $cupom_services)
    {
        $this->cupom_services = $cupom_services;
    }

    public function mount($id)
    {
        $cupom = $this->cupom_services->encontrarPorId($id);

        if(is_null($cupom))
        {
            Toaster::warning('Registro não encontrado');
            return redirect()->route('index_cupom');
        }

        $this->id = $cupom->id;
        $this->identificacao = $cupom->identificacao;
        $this->data_validade = $cupom->data_validade;
        $this->valor_desconto = $cupom->valor_desconto;
        $this->aplicado = $cupom->aplicado;
    }

    public function rules() : array
    {
        return [
            'identificacao' => ['required', 'string', 'min:3', 'unique:cupons,identificacao,'.$this->id],
            'data_validade' => ['required', 'date'],
            'valor_desconto' => ['required', 'numeric', 'min:1', 'max:100'],
            'aplicado' => ['required']
        ];
    }

    public function atualizar()
    {
        $dados = $this->validate();
        $resultado = $this->cupom_services->atualizar($dados, $this->id);

        if(!empty($resultado['error']))
        {
            return Toaster::warning($resultado['error']);
        }

        Toaster::success('Registro atualizado com sucesso!');
    }

    public function render()
    {
        return view('livewire.cupom.editar-cupom');
    }
}
