<?php

use App\Livewire\Categoria\CadastrarCategoria;
use App\Livewire\Categoria\EditarCategoria;
use App\Livewire\Categoria\IndexCategoria;
use App\Livewire\Cupom\CadastrarCupom;
use App\Livewire\Cupom\EditarCupom;
use App\Livewire\Cupom\IndexCupom;
use App\Livewire\Pedido\CadastrarPedido;
use App\Livewire\Pedido\DetalhesPedido;
use App\Livewire\Pedido\IndexPedido;
use App\Livewire\Produto\CadastrarProduto;
use App\Livewire\Produto\EditarProduto;
use App\Livewire\Produto\IndexProduto;
use Illuminate\Support\Facades\Route;



Route::middleware(['auth'])->group(function(){
    Route::view('/', 'home');

    Route::view('home', 'home')->name('home');
    Route::view('profile', 'profile')->name('profile');


    Route::get('/categoria', IndexCategoria::class)->name('index_categoria');
    Route::get('/categoria/cadastrar', CadastrarCategoria::class)->name('cadastrar_categoria');
    Route::get('/categoria/editar/{id}', EditarCategoria::class)->name('editar_categoria');

    Route::get('/produto', IndexProduto::class)->name('index_produto');
    Route::get('/produto/cadastrar', CadastrarProduto::class)->name('cadastrar_produto');
    Route::get('/produto/editar/{id}', EditarProduto::class)->name('editar_produto');

    Route::get('/cupom', IndexCupom::class)->name('index_cupom');
    Route::get('/cupom/cadastrar', CadastrarCupom::class)->name('cadastrar_cupom');
    Route::get('/cupom/editar/{id}', EditarCupom::class)->name('editar_cupom');

    Route::get('/pedido', IndexPedido::class)->name('index_pedido');
    Route::get('/pedido/detalhes/{id}', DetalhesPedido::class)->name('detalhes_pedido');
});

require __DIR__.'/auth.php';
