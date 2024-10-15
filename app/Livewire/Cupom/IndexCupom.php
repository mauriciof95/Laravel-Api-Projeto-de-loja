<?php

namespace App\Livewire\Cupom;

use App\Services\CupomServices;
use Livewire\Component;
use Livewire\WithPagination;
use Masmerise\Toaster\Toaster;

class IndexCupom extends Component
{
    use WithPagination;

    protected CupomServices $cupom_services;

    public int $porPagina = 10;
    public string $pesquisa = '';
    public function boot(CupomServices $cupom_services)
    {
        $this->cupom_services = $cupom_services;
    }

    public function updating()
    {
        $this->resetPage();
    }

    public function deletar($id){
        $resultado = $this->cupom_services->deletar($id);

        if(!empty($resultado['error']))
        {
            Toaster::error($resultado['error']);
            return;
        }


        Toaster::success('Registro deletado com sucesso.');
    }

    public function render()
    {
        $cupons = $this->cupom_services->listar(
            pesquisa:  $this->pesquisa,
            porPagina: $this->porPagina);

        return view('livewire.cupom.index-cupom', compact('cupons'));
    }
}
