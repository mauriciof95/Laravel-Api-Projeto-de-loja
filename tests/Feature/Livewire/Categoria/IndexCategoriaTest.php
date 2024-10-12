<?php

namespace Tests\Feature\Livewire\Categoria;

use App\Livewire\Categoria\IndexCategoria;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Livewire\Livewire;
use PHPUnit\Framework\Attributes\Test;
use Tests\TestCase;

class IndexCategoriaTest extends TestCase
{
    #[Test]
    public function renders_successfully()
    {
        Livewire::test(IndexCategoria::class)
            ->assertStatus(200);
    }
}
