<?php

namespace Tests\Feature\Livewire\Produto;

use App\Livewire\Produto\IndexProduto;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Livewire\Livewire;
use Tests\TestCase;

class IndexProdutoTest extends TestCase
{
    /** @test */
    public function renders_successfully()
    {
        Livewire::test(IndexProduto::class)
            ->assertStatus(200);
    }
}
