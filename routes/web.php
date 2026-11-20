<?php

use App\Http\Controllers\Admin\PedidoAdminController;
use App\Http\Controllers\AuthController;
use App\Http\Controllers\CartController;
use App\Http\Controllers\CategoriaController;
use App\Http\Controllers\CheckoutController;
use App\Http\Controllers\HomeController;
use App\Http\Controllers\PedidoController;
use App\Http\Controllers\ProdutoController;
use App\Http\Controllers\UserController;
use Illuminate\Support\Facades\Route;

// HOME (publica)
Route::get('/', [HomeController::class, 'index'])->name('home');

// APAGADO E REFEITO EM BAIXO COM O AUTH INSERIDO
//CATEGORIAS
// Route::get('categorias/create', [CategoriaController::class, 'create'])->name('categorias.create');
// Route::post('/categorias', [CategoriaController::class, 'store'])->name('categorias.store');

// // PRODUTOS
// Route::resource('produtos', ProdutoController::class);
// // Route::get('/produtos', [ProdutoController::class, 'index'])->name('produtos.index');
// // Route::get('/produtos/create', [ProdutoController::class, 'create'])->name('produtos.create');
// // Route::post('/produtos', [ProdutoController::class, 'store'])->name('produtos.store');
// // Route::get('/produtos/{produto}', [ProdutoController::class, 'show'])->name('produtos.show');
// // Route::get('/produtos/{produto}/edit', [ProdutoController::class, 'edit'])->name('produtos.edit');
// // Route::put('/produtos/{produto}', [ProdutoController::class, 'update'])->name('produtos.update');
// // Route::delete('/produtos/{produto}', [ProdutoController::class, 'destroy'])->name('produtos.destroy');

// CADASTRO E LOGIN (publicos)
Route::get('/users/create', [UserController::class, 'create'])->name('users.create');
Route::post('/users', [UserController::class, 'store'])->name('users.store');

Route::get('/login', [AuthController::class, 'create'])->name('login');
Route::post('/login', [AuthController::class, 'store'])->name('login.store');
Route::post('/logout', [AuthController::class, 'destroy'])->name('logout');

// ADMINISTRADOR (restrito ao user admin)
Route::middleware(['auth', 'admin'])->group(function () {
    // PRODUTOS: tudo menos o show
    Route::resource('produtos', ProdutoController::class)->except(['show']);

    // CATEGORIAS
    Route::get('/categorias/create', [CategoriaController::class, 'create'])->name('categorias.create');
    Route::post('/categorias', [CategoriaController::class, 'store'])->name('categorias.store');
});

// ADMINISTRADOR: ENTREGA
Route::middleware(['auth', 'admin'])->prefix('admin')->name('admin.')->group(function () {
    Route::get('/pedidos', [PedidoAdminController::class, 'index'])->name('pedidos.index');
    Route::patch('/pedidos/{pedido}/saiu', [PedidoAdminController::class, 'saiu'])->name('pedidos.saiu');
});


// SHOW PRODUTOS (publico)
Route::get('/produtos/{produto}', [ProdutoController::class, 'show'])->name('produtos.show');

// CARRINHO
Route::post('/cart/add', [CartController::class, 'add_to_cart'])->name('cart.add');
Route::get('/cart', [CartController::class, 'index'])->name('cart.index');
Route::put('/cart/update', [CartController::class, 'update_cart'])->name('cart.update');
Route::delete('/cart/remove/{rowId}', [CartController::class, 'remove_from_cart'])->name('cart.remove');
Route::delete('/cart/remove', [CartController::class, 'clear_cart'])->name('cart.clear');

// PAGAMENTO
Route::middleware('auth')->group(function () {
    Route::get('/checkout', [CheckoutController::class, 'index'])->name('checkout.index');
    Route::post('/checkout', [CheckoutController::class, 'escolher'])->name('checkout.escolher');
    Route::get('/checkout/pagamento', [CheckoutController::class, 'pagamento'])->name('checkout.pagamento');
    Route::post('/checkout/confirmar', [CheckoutController::class, 'confirmar'])->name('checkout.confirmar');
    Route::get('/checkout/sucesso', [CheckoutController::class, 'sucesso'])->name('checkout.sucesso');

    // ENTREGA
    Route::get('/pedidos', [PedidoController::class, 'index'])->name('pedidos.index');
    Route::get('/pedidos/{pedido}', [PedidoController::class, 'show'])->name('pedidos.show');
    Route::patch('/pedidos/{pedido}/entregue', [PedidoController::class, 'entregue'])->name('pedidos.entregue');
});



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

// Route::get('/dashboard', function () {
//     return view('dashboard');
// })->middleware(['auth', 'verified'])->name('dashboard');

// Route::middleware('auth')->group(function () {
//     Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
//     Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
//     Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');
// });

// require __DIR__.'/auth.php';