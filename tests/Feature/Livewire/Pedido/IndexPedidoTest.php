<?php

namespace Tests\Feature\Livewire\Pedido;

use App\Livewire\Pedido\IndexPedido;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Livewire\Livewire;
use Tests\TestCase;

class IndexPedidoTest extends TestCase
{
    /** @test */
    public function renders_successfully()
    {
        Livewire::test(IndexPedido::class)
            ->assertStatus(200);
    }
}
