<?php

use App\Http\Controllers\AlunosController;
use App\Http\Controllers\CaixaCpController;
use App\Http\Controllers\CarrinhoController;
use App\Http\Controllers\CarrinhoMeioPagamentoController;
use App\Http\Controllers\CategoryController;
use App\Http\Controllers\CompanyController;
use App\Http\Controllers\DespesaController;
use App\Http\Controllers\IndividualController;
use App\Http\Controllers\InpuProductController;
use App\Http\Controllers\InventoryController;
use App\Http\Controllers\PrecosController;
use App\Http\Controllers\ProductsController;
use App\Http\Controllers\SeleController;
use App\Http\Controllers\ShopController;
use App\Http\Controllers\UsersController;
use App\Http\Controllers\UsersShopController;
use App\Models\Product;
use Illuminate\Foundation\Application;
use Illuminate\Support\Facades\Route;
use Inertia\Inertia;

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| contains the "web" middleware group. Now create something great!
|
*/

/*Route::get('/', function () {
    return Inertia::render('Welcome', [
        'canLogin' => Route::has('login'),
        'canRegister' => Route::has('register'),
        'laravelVersion' => Application::VERSION,
        'phpVersion' => PHP_VERSION,
    ]);
});*/


/*
Route::middleware(['auth:sanctum', 'verified'])->get('/dashboard', function () {
    return Inertia::render('Dashboard');
})->name('dashboard');*/


Route::get('/', function () {
    return view('auth.login');
})->name('inicio');

Route::post('/login', [UsersController::class, 'login'])->name('login');
Route::post('/logout', [UsersController::class, 'logout'])->name('logout');

Route::middleware(['auth'])->group(function () {
    Route::get('/home', [UsersController::class, 'home'])->name('home');

    //Individual
    Route::get('/lucros', [IndividualController::class, 'lucros'])->name('lucros.index');

    //URL
    Route::get('/url/produtos/by-nome', [InventoryController::class, 'listar_by_nome'])->name('url.produtos_by_nome');

    //Carrinho de Produtos
    Route::post('/carrinho/adicionar', [CarrinhoController::class, 'adicionar'])->name('carrinho.adicionar');
    Route::get('/carrinho/{id}/remover', [CarrinhoController::class, 'remover'])->name('carrinho.remover');
    Route::get('/carrinho/remover-todos', [CarrinhoController::class, 'remover_todos'])->name('carrinho.remover.todos');
    Route::post('/carrinho/recuperar', [CarrinhoController::class, 'recuperar'])->name('carrinho.recuperar');

    //Carrinho Meio de Pagamentos
    Route::post('/carrinho-meio-pagamentos/adicionar', [CarrinhoMeioPagamentoController::class, 'adicionar'])->name('carrinho_meio_pagamentos.adicionar');
    Route::get('/carrinho-meio-pagamentos/{id}/remover', [CarrinhoMeioPagamentoController::class, 'remover'])->name('carrinho_meio_pagamentos.remover');
    Route::get('/carrinho-meio-pagamentos/remover-todos', [CarrinhoMeioPagamentoController::class, 'remover_todos'])->name('carrinho_meio_pagamentos.remover.todos');

    Route::resource('/categories', CategoryController::class);
    Route::resource('/inventories', InventoryController::class);
    Route::resource('/input_products', InpuProductController::class);
    Route::resource('/companies', CompanyController::class);
    Route::resource('/shops', ShopController::class);
    #Route::resource('/caixas', CaixaController::class)->parameters(['caixas'=>'cash'])->names(['edit'=>'caixas.editar']);
    Route::resource('/users_shops', UsersShopController::class);


    //Caixas
    Route::get('caixas/fechar', [CaixaCpController::class, 'fechar'])->name('caixas.fechar');
    Route::get('productscaixas/listar', [CaixaCpController::class, 'listar'])->name('caixas.listar');


    //Despesas
    Route::get('despesas/listar', [DespesaController::class, 'listar'])->name('despesas.listar');
    Route::resource('/despesas', DespesaController::class);


    //Users
    Route::get('users/by/shop', [UsersController::class, 'listar'])->name('users.by.shop');

    //Produtos
    Route::get('products/listar', [ProductsController::class, 'listar'])->name('products.listar');
    Route::resource('/products', ProductsController::class);


    //Seles
    Route::get('seles/listar', [SeleController::class, 'listar'])->name('seles.listar');
    Route::get('/seles/next', [SeleController::class, 'next'])->name('seles.next');
    Route::get('/seles/next2', [SeleController::class, 'next2'])->name('seles.next2');
    Route::resource('/seles', SeleController::class);
});

Route::resource('caixas', CaixaCpController::class)->middleware('auth:sanctum');



Route::get('teste', function () {
    $res = \Illuminate\Support\Facades\DB::table('precos')->get();
    foreach ($res as $re) {
        \Illuminate\Support\Facades\DB::table('products')->where('id', $re->produtos_id)->update(
            [
                'preco_venda' => $re->venda,
                'preco_compra' => $re->compra,
            ]
        );
    }
    echo "ok";
});


Route::fallback(function () {
    echo "Página não encontrada";
});
