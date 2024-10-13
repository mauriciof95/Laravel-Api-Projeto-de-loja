<?php

namespace Tests\Feature\Livewire\Produto;

use App\Livewire\Produto\EditarProduto;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Livewire\Livewire;
use Tests\TestCase;

class EditarProdutoTest extends TestCase
{
    /** @test */
    public function renders_successfully()
    {
        Livewire::test(EditarProduto::class)
            ->assertStatus(200);
    }
}
