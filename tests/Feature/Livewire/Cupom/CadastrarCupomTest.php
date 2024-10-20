<?php

namespace Tests\Feature\Livewire\Cupom;

use App\Livewire\Cupom\CadastrarCupom;
use App\Models\Cupom;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Livewire\Livewire;
use PHPUnit\Framework\Attributes\Test;
use Tests\TestCase;

class CadastrarCupomTest extends TestCase
{
    use RefreshDatabase;

    #[Test]
    public function deve_cadastrar_um_cupom_valido()
    {
        Livewire::test(CadastrarCupom::class)
            ->set('identificacao', 'PROMO20')
            ->set('valor_desconto', '20.0')
            ->set('data_validade', '2030-01-01')
            ->call('cadastrar')
            ->assertHasNoErrors();

        $this->assertDatabaseCount(Cupom::class, 1);
    }

    #[Test]
    public function deve_retornar_error_validacao_unique()
    {
        $cupom = Cupom::factory()->create();

        Livewire::test(CadastrarCupom::class)
            ->set('identificacao', $cupom->identificacao)
            ->set('valor_desconto', '20.0')
            ->set('data_validade', '2030-01-01')
            ->call('cadastrar')
            ->assertHasErrors(['identificacao' => 'unique']);

        $this->assertDatabaseCount(Cupom::class, 1);
    }
}
