<?php
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\ClienteController;

// Route::get('cliente',[ClienteController::class, 'index']);
Route::post('clienteCadastro',[ClienteController::class, 'clienteCadastro']);
Route::get('cliente',[ClienteController::class, 'buscarClientes']);
Route::get('cliente/{id}',[ClienteController::class, 'buscarClientesById']);
Route::put('cliente/{id}',[ClienteController::class, 'atualizarCliente']);
Route::delete('cliente/{id}',[ClienteController::class, 'excluirCliente']);
Route::get('consulta/final-placa/{numero}',[ClienteController::class, 'buscarFinalPlacaCliente']);








