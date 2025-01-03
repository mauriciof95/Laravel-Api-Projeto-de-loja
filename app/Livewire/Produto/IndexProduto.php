<?php

namespace App\Livewire\Produto;

use App\Services\ProdutoServices;
use Livewire\Component;
use Livewire\WithPagination;
use Masmerise\Toaster\Toaster;

class IndexProduto extends Component
{
    use WithPagination;

    protected ProdutoServices $produto_services;

    public int $porPagina = 10;
    public string $pesquisa = '';
    public function boot(
        ProdutoServices $produto_services
    )
    {
        $this->produto_services = $produto_services;
    }

    public function updating()
    {
        $this->resetPage();
    }

    public function deletar($id){
        $resultado = $this->produto_services->deletar($id);

        if(!empty($resultado['error']))
        {
            Toaster::error($resultado['error']);
            return;
        }


        Toaster::success('Registro deletado com sucesso.');
    }

    public function render()
    {
        $produtos = $this->produto_services->listar(
            pesquisa:  $this->pesquisa,
            relacionamentos: ['categoria'],
            porPagina: $this->porPagina);

        return view('livewire.produto.index-produto', compact('produtos'));
    }
}
