<?php

use Illuminate\Support\Facades\Route;

Route::controller(App\Http\Controllers\CategoriaController::class)->prefix('/categoria')->group(function(){
    Route::get('/', 'listar');
    Route::get('/{id}', 'encontrarPorId');
});

Route::controller(App\Http\Controllers\ProdutoController::class)->prefix('/produto')->group(function(){
    Route::get('/', 'listar');
    Route::get('/{id}', 'encontrarPorId');
});

Route::controller(App\Http\Controllers\PedidoController::class)->prefix('/pedido')->group(function(){
    Route::post('/', 'cadastrar');
});

