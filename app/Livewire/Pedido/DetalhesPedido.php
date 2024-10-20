<?php

namespace App\Livewire\Pedido;

use App\Services\PedidoServices;
use Livewire\Component;
use Masmerise\Toaster\Toaster;

class DetalhesPedido extends Component
{
    protected PedidoServices $pedido_services;

    public int $id = 0;
    public $pedido;
    public $status;

    public function boot(PedidoServices $pedido_services)
    {
        $this->pedido_services = $pedido_services;
    }

    public function mount($id)
    {
        $pedido = $this->pedido_services->encontrarPorId(
            $id, relacionamentos: ['cliente', 'cupom', 'pedido_itens.produto.categoria']
        );

        if(is_null($pedido))
        {
            Toaster::warning('Registro não encontrado');
            return redirect()->route('index_pedido');
        }

        $this->id = $pedido->id;
        $this->pedido = $pedido;
        $this->status = $pedido->status;
    }

    public function rules() : array
    {
        return [
            'status' => ['required'],
        ];
    }

    public function atualizarStatus()
    {
        $dados = $this->validate();
        $resultado = $this->pedido_services->atualizarStatus($dados, $this->id);

        if(!empty($resultado['error']))
        {
            return Toaster::warning($resultado['error']);
        }

        Toaster::success('Registro atualizado com sucesso!');
    }

    public function render()
    {
        return view('livewire.pedido.detalhes-pedido');
    }
}
