<?php

use App\Http\Controllers\EnderecoController;
use App\Http\Controllers\HomeController;
use App\Http\Controllers\ProdutoController;
use App\Http\Controllers\UsuarioController;
use App\Models\Produto;
use Illuminate\Support\Facades\Route;


// FEITO PARA SER O OFICIAL
Route::get('/', [HomeController::class, 'index'])->name('home');

Route::resource('produtos', ProdutoController::class);
// Route::get('/produtos', [ProdutoController::class, 'index'])->name('produtos.index');
// Route::get('/produtos/create', [ProdutoController::class, 'create'])->name('produtos.create');
// Route::post('/produtos', [ProdutoController::class, 'store'])->name('produtos.store');
// Route::get('/produtos/{produto}', [ProdutoController::class, 'show'])->name('produtos.show');
// Route::get('/produtos/{produto}/edit', [ProdutoController::class, 'edit'])->name('produtos.edit');
// Route::put('/produtos/{produto}', [ProdutoController::class, 'update'])->name('produtos.update');
// Route::delete('/produtos/{produto}', [ProdutoController::class, 'destroy'])->name('produtos.destroy');




// VER DEPOIS
// Route::get('/', function () {
//     return redirect()->route('login');
// });

// Route::get('/', function () {
//     return view('welcome');
// });

// TESTE ROUTE COM CONTROLLER
// Route::resource('produtos', ProdutoController::class);
// Route::resource('enderecos', EnderecoController::class);

Route::get('/dashboard', function () {
    return view('dashboard');
})->middleware(['auth', 'verified'])->name('dashboard');

// Route::middleware('auth')->group(function () {
//     Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
//     Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
//     Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');
// });

require __DIR__.'/auth.php';