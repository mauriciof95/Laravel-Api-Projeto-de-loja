<?php

namespace Tests\Feature\Livewire\Categoria;

use App\Livewire\Categoria\EditarCategoria;
use App\Models\Categoria;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Livewire\Livewire;
use PHPUnit\Framework\Attributes\Test;
use Tests\TestCase;

class EditarCategoriaTest extends TestCase
{
    #[Test]
    public function renders_successfully()
    {
        $categoria = Categoria::factory()->create();

        Livewire::test(EditarCategoria::class, ['id' => $categoria->id])
            ->assertStatus(200);
    }
}
