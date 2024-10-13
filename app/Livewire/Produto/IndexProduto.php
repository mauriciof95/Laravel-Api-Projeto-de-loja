<?php

namespace App\Livewire\Produto;

use App\Services\ProdutoServices;
use Livewire\Component;
use Livewire\WithPagination;
use Masmerise\Toaster\Toaster;

class IndexProduto extends Component
{
    use WithPagination;

    protected ProdutoServices $produtoServices;

    public int $porPagina = 10;
    public string $pesquisa = '';
    public function boot(
        ProdutoServices $produtoServices
    )
    {
        $this->produtoServices = $produtoServices;
    }

    public function updating()
    {
        $this->resetPage();
    }

    public function deletar($id){
        $resultado = $this->produtoServices->deletar($id);

        if(!empty($resultado['error']))
        {
            Toaster::error($resultado['error']);
            return;
        }


        Toaster::success('Registro deletado com sucesso.');
    }

    public function render()
    {
        $produtos = $this->produtoServices->listar(
            pesquisa:  $this->pesquisa,
            relacionamentos: ['categoria'],
            porPagina: $this->porPagina);

        return view('livewire.produto.index-produto', compact('produtos'));
    }
}
