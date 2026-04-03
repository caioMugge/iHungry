<?php

use App\Http\Controllers\UsuarioController;
use Illuminate\Support\Facades\Route;

// Rota para exibir o formulário (o arquivo que você criou na pasta usuarios)
Route::get('/', [UsuarioController::class, 'index'])->name('user.index');
Route::get('/create-usuario', [UsuarioController::class, 'create'])->name('user.create');
Route::post('/store-usuario', [UsuarioController::class, 'store'])->name('user.store');