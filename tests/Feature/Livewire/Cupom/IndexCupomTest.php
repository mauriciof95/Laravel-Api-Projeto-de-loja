<?php

namespace Tests\Feature\Livewire\Cupom;

use App\Livewire\Cupom\IndexCupom;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Livewire\Livewire;
use Tests\TestCase;

class IndexCupomTest extends TestCase
{
    /** @test */
    public function renders_successfully()
    {
        Livewire::test(IndexCupom::class)
            ->assertStatus(200);
    }
}
