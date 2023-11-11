<?php

use App\Http\Controllers\AlunosController;
use App\Http\Controllers\BalanceteController;
use App\Http\Controllers\CaixaController;
use App\Http\Controllers\CaixaCpController;
use App\Http\Controllers\CarrinhoController;
use App\Http\Controllers\CarrinhoMeioPagamentoController;
use App\Http\Controllers\CategoryController;
use App\Http\Controllers\CompanyController;
use App\Http\Controllers\ContaController;
use App\Http\Controllers\DespesaController;
use App\Http\Controllers\EmpresaController;
use App\Http\Controllers\FacturaController;
use App\Http\Controllers\IndividualController;
use App\Http\Controllers\InpuProductController;
use App\Http\Controllers\InventoryController;
use App\Http\Controllers\MesaController;
use App\Http\Controllers\PedidoController;
use App\Http\Controllers\PermissionController;
use App\Http\Controllers\PermissionsRoleController;
use App\Http\Controllers\PermissionsUserController;
use App\Http\Controllers\PrecosController;
use App\Http\Controllers\ProductsController;
use App\Http\Controllers\RelatorioController;
use App\Http\Controllers\RoleController;
use App\Http\Controllers\RolesUserController;
use App\Http\Controllers\SeleController;
use App\Http\Controllers\ShopController;
use App\Http\Controllers\UrlController;
use App\Http\Controllers\UserController;
use App\Http\Controllers\UsersController;
use App\Http\Controllers\UsersShopController;
use App\Models\Balancete;
use App\Models\Product;
use Illuminate\Foundation\Application;
use Illuminate\Support\Facades\Route;
use Inertia\Inertia;
use Rawilk\Printing\Facades\Printing;

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


//ACesso Livre
Route::get('relatorios/cardapio', [RelatorioController::class, 'cardapio'])->name('relatorios.cardapio');


Route::middleware(['auth'])->group(function () {
    Route::get('/home', [UsersController::class, 'home'])->name('home');

    //Listar
    Route::get('seles/listar', [SeleController::class, 'listar'])->name('seles.listar');


    //Individual
    Route::get('/lucros', [IndividualController::class, 'lucros'])->name('lucros.index');

    //URL
    Route::get('/url/produtos/by-nome', [InventoryController::class, 'listar_by_nome'])->name('url.produtos_by_nome');
    Route::get('/stocks/actual', [UrlController::class, 'stock_actual'])->name('stock.actual');


    Route::post('/lojas/store', [UrlController::class, 'store_loja'])->name('lojas.store');
    Route::post('/products/store2', [UrlController::class, 'store_produtos'])->name('products.store2');
    Route::post('/fornecedors/store', [UrlController::class, 'store_fornecedors'])->name('fornecedors.store');
    Route::get('lojas/listar', [UrlController::class, 'listar'])->name('lojas.listar');
    Route::get('fornecedors/listar', [UrlController::class, 'listar'])->name('fornecedors.listar');


    //Exportar
    Route::post('/inventories/exportar', [InventoryController::class, 'exportar'])->name('inventories.export');



    //Carrinho de Produtos
    Route::post('/carrinho/adicionar', [CarrinhoController::class, 'adicionar'])->name('carrinho.adicionar');
    Route::get('/carrinho/{id}/remover', [CarrinhoController::class, 'remover'])->name('carrinho.remover');
    Route::get('/carrinho/remover-todos', [CarrinhoController::class, 'remover_todos'])->name('carrinho.remover.todos');
    Route::post('/carrinho/recuperar', [CarrinhoController::class, 'recuperar'])->name('carrinho.recuperar');

    //Carrinho Meio de Pagamentos
    Route::post('/carrinho-meio-pagamentos/adicionar', [CarrinhoMeioPagamentoController::class, 'adicionar'])->name('carrinho_meio_pagamentos.adicionar');
    Route::get('/carrinho-meio-pagamentos/{id}/remover', [CarrinhoMeioPagamentoController::class, 'remover'])->name('carrinho_meio_pagamentos.remover');
    Route::get('/carrinho-meio-pagamentos/remover-todos', [CarrinhoMeioPagamentoController::class, 'remover_todos'])->name('carrinho_meio_pagamentos.remover.todos');

    Route::get('inventories/entradas', [InventoryController::class, 'entradas'])->name('inventories.entradas');
    Route::get('inventories/saidas', [InventoryController::class, 'saidas'])->name('inventories.saidas');
    Route::get('inventories/transferencias', [InventoryController::class, 'transferencias'])->name('inventories.transferencias');



    Route::resource('/categories', CategoryController::class);
    Route::resource('/inventories', InventoryController::class);
    Route::resource('/input_products', InpuProductController::class);
    Route::resource('/companies', CompanyController::class);
    Route::resource('/shops', ShopController::class);
    Route::resource('/users_shops', UsersShopController::class);




    //Despesas
    Route::get('despesas/listar', [DespesaController::class, 'listar'])->name('despesas.listar');
    Route::resource('/despesas', DespesaController::class);


    //Users
    Route::get('users/by/shop', [UsersController::class, 'listar'])->name('users.by.shop');

    //Produtos
    Route::get('products/listar', [ProductsController::class, 'listar'])->name('products.listar');
    Route::resource('/products', ProductsController::class);

//Mesas
    Route::get('mesas/historico', [MesaController::class, 'historico'])->name('mesas.historico');
    Route::post('mesas/fechar', [MesaController::class, 'abrir'])->name('mesas.abrir');
    Route::post('mesas/abrir/store', [MesaController::class, 'abrir_store'])->name('mesas.abrir.store');
    Route::get('mesas/abrir', [MesaController::class, 'abrir'])->name('mesas.abrir');
    Route::get('mesas/listar', [MesaController::class, 'listar'])->name('mesas.listar');
    Route::resource('/mesas', MesaController::class);

    //Relatorios
    Route::resource('/relatorios', RelatorioController::class);

    Route::resource('/contas', ContaController::class);
    Route::resource('/movimentos', ContaController::class);
    Route::resource('/balancetes', BalanceteController::class);

    Route::resource('/users', UserController::class);
    Route::resource('/roles', RoleController::class);
    Route::resource('/permissions', PermissionController::class);
    Route::resource('/permissions_roles', PermissionsRoleController::class);
    Route::resource('/permissions_users', PermissionsUserController::class);
    Route::resource('/roles_users', RolesUserController::class);

    Route::resource('/empresas', EmpresaController::class);

    //Route::get('/pedidos/adicionar/{mesa}/{inventory}/cart', [PedidoController::class, 'adicionar_cart'])->name('pedidos.adicionar.cart');
    Route::post('/pedidos/adicionar/{mesa}/cart', [PedidoController::class, 'adicionar_cart'])->name('pedidos.adicionar.cart');
    Route::get('/pedidos/cart/remover-all', [PedidoController::class, 'remover_all'])->name('pedidos.cart.remover.all');
    Route::get('/pedidos/cart/remover', [PedidoController::class, 'remover'])->name('pedidos.cart.remover');
    Route::get('/pedidos/mesas/{mesa}/consumo', [PedidoController::class, 'mesas_consumo'])->name('pedidos.mesas.consumo');
    Route::get('/pedidos/mesas/{mesa}/detalhe', [PedidoController::class, 'mesas_detalhes'])->name('pedidos.mesas.detalhe');
    Route::get('pedidos/historico', [PedidoController::class, 'historico'])->name('pedidos.historico');
    Route::post('pedidos/fechar', [PedidoController::class, 'abrir'])->name('pedidos.abrir');
    Route::post('pedidos/abrir/store', [PedidoController::class, 'abrir_store'])->name('pedidos.abrir.store');
    Route::get('pedidos/abrir', [PedidoController::class, 'abrir'])->name('pedidos.abrir');
    Route::get('pedidos/listar', [PedidoController::class, 'listar'])->name('pedidos.listar');
    Route::post('/pedidos/finalizar/{mesa}/{total}', [PedidoController::class, 'finalizar'])->name('pedidos.finalizar');
    Route::resource('/pedidos', PedidoController::class);

    Route::get('/factura/{id}/qrcode/', [FacturaController::class, 'factura_hash'])->name('factura.qrcode');
    Route::get('/report/{id}/facturas/preview', [FacturaController::class, 'preview_facturas'])->name('report.facturas.preview');
    Route::get('/report/{id}/facturas/termica', [FacturaController::class, 'preview_termica'])->name('report.facturas.termica');
    Route::get('/facturas/listar/', [FacturaController::class, 'listar'])->name('facturas.listar');
    Route::resource('/facturas', FacturaController::class);

    //Caixas
    Route::get('/caixas/fechar', [CaixaController::class, 'fechar'])->name('caixas.fechar');
    Route::get('/caixas/listar', [CaixaController::class, 'listar'])->name('caixas.listar');
    Route::resource('/caixas', CaixaController::class);

    //Seles
    Route::get('/seles/next', [SeleController::class, 'next'])->name('seles.next');
    Route::get('/seles/next2', [SeleController::class, 'next2'])->name('seles.next2');
    Route::resource('/seles', SeleController::class);
});


Route::get('/impressora', function () {

    $printers = Printing::printers();

    foreach ($printers as $printer) {
        echo $printer->name()."<br>";
    }

})->name('impressora');


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
