<?php

namespace Tests\Feature\Livewire\Categoria;

use App\Livewire\Categoria\DeletarCategoria;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Livewire\Livewire;
use PHPUnit\Framework\Attributes\Test;
use Tests\TestCase;

class DeletarCategoriaTest extends TestCase
{
    #[Test]
    public function renders_successfully()
    {
        Livewire::test(DeletarCategoria::class)
            ->assertStatus(200);
    }
}
