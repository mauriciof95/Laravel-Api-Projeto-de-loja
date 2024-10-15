<?php

namespace Tests\Feature\Livewire\Cupom;

use App\Livewire\Cupom\EditarCupom;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Livewire\Livewire;
use Tests\TestCase;

class EditarCupomTest extends TestCase
{
    /** @test */
    public function renders_successfully()
    {
        Livewire::test(EditarCupom::class)
            ->assertStatus(200);
    }
}
