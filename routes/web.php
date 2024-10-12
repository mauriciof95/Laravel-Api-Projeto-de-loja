<?php

use App\Livewire\Categoria\CadastrarCategoria;
use App\Livewire\Categoria\EditarCategoria;
use App\Livewire\Categoria\IndexCategoria;
use Illuminate\Support\Facades\Route;

Route::view('/', 'welcome');

Route::middleware(['auth'])->group(function(){
    Route::view('dashboard', 'dashboard')->middleware('verified')->name('dashboard');
    Route::view('profile', 'profile')->name('profile');


    Route::get('/categoria', IndexCategoria::class)->name('index_categoria');
    Route::get('/categoria/cadastrar', CadastrarCategoria::class)->name('cadastrar_categoria');
    Route::get('/categoria/editar/{id}', EditarCategoria::class)->name('editar_categoria');


});


require __DIR__.'/auth.php';
