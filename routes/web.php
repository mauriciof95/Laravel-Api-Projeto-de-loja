<?php

use App\Livewire\Categoria\CadastrarCategoria;
use App\Livewire\Categoria\EditarCategoria;
use Illuminate\Support\Facades\Route;

Route::view('/', 'welcome');

Route::view('dashboard', 'dashboard')
    ->middleware(['auth', 'verified'])
    ->name('dashboard');

Route::view('profile', 'profile')
    ->middleware(['auth'])
    ->name('profile');

Route::get('/categoria/cadastrar', CadastrarCategoria::class)
    ->middleware(['auth'])
    ->name('cadastrar_categoria');

Route::get('/categoria/editar', EditarCategoria::class)
    ->middleware(['auth'])
    ->name('editar_categoria');

require __DIR__.'/auth.php';
