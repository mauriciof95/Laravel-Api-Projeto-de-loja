<?php

use App\Http\Controllers\Auth\AuthClienteController;
use Illuminate\Support\Facades\Route;

Route::post('/cliente/login', [AuthClienteController::class, 'login']);
Route::post('/cliente/cadastrar', [App\Http\Controllers\ClienteController::class, 'cadastrar']);

Route::group(['middleware' => ['auth:sanctum']], function () {
    Route::post('/cliente/logout', [AuthClienteController::class, 'logout']);

    Route::controller(App\Http\Controllers\PedidoController::class)->prefix('/pedido')->group(function(){
        Route::get('/', 'listar');
        Route::post('/', 'cadastrar');
        Route::get('/detalhes/{id}', 'encontrarPorId');
    });
});

Route::controller(App\Http\Controllers\ProdutoController::class)->prefix('/produto')->group(function(){
    Route::get('/', 'listar');
    Route::get('/{id}', 'encontrarPorId');
});

Route::controller(App\Http\Controllers\CupomController::class)->prefix('/cupom')->group(function(){
    Route::get('/{identificacao}', 'encontrarPorIdentificacao');
});



