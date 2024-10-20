<?php

namespace App\Livewire\Pedido;

use App\Services\PedidoServices;
use Livewire\Component;
use Livewire\WithPagination;
use Masmerise\Toaster\Toaster;

class IndexPedido extends Component
{
    use WithPagination;

    protected PedidoServices $pedido_services;

    public int $porPagina = 10;
    public string $pesquisa = '';
    public function boot(PedidoServices $pedido_services)
    {
        $this->pedido_services = $pedido_services;
    }

    public function updating()
    {
        $this->resetPage();
    }

    public function render()
    {
        $pedidos = $this->pedido_services->listar(
            pesquisa:  $this->pesquisa,
            relacionamentos: ['cupom', 'cliente'],
            porPagina: $this->porPagina);

        return view('livewire.pedido.index-pedido', compact('pedidos'));
    }
}
