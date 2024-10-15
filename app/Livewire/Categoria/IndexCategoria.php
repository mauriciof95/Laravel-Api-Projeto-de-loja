<?php

namespace App\Livewire\Categoria;

use App\Services\CategoriaServices;
use Livewire\Component;
use Livewire\WithPagination;
use Masmerise\Toaster\Toaster;

class IndexCategoria extends Component
{
    use WithPagination;

    protected CategoriaServices $categoria_services;

    public int $porPagina = 10;
    public string $pesquisa = '';
    public function boot(CategoriaServices $categoria_services)
    {
        $this->categoria_services = $categoria_services;
    }

    public function updating()
    {
        $this->resetPage();
    }

    public function deletar($id){
        $resultado = $this->categoria_services->deletar($id);

        if(!empty($resultado['error']))
        {
            Toaster::error($resultado['error']);
            return;
        }


        Toaster::success('Registro deletado com sucesso.');
    }

    public function render()
    {
        $categorias = $this->categoria_services->listar(
            pesquisa:  $this->pesquisa,
            porPagina: $this->porPagina);

        return view('livewire.categoria.index-categoria', compact('categorias'));
    }
}
