<?php

namespace Tests\Feature\Livewire\Cupom;

use App\Livewire\Cupom\EditarCupom;
use App\Models\Cupom;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Livewire\Livewire;
use PHPUnit\Framework\Attributes\Test;
use Tests\TestCase;

class EditarCupomTest extends TestCase
{
    use RefreshDatabase;

    #[Test]
    public function renders_successfully()
    {
        $cupom = Cupom::factory()
                ->create();

        Livewire::test(EditarCupom::class, ['id' => $cupom->id])
            ->assertStatus(200);
    }
}
