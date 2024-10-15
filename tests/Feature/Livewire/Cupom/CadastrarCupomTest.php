<?php

namespace Tests\Feature\Livewire\Cupom;

use App\Livewire\Cupom\CadastrarCupom;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Livewire\Livewire;
use Tests\TestCase;

class CadastrarCupomTest extends TestCase
{
    /** @test */
    public function renders_successfully()
    {
        Livewire::test(CadastrarCupom::class)
            ->assertStatus(200);
    }
}
