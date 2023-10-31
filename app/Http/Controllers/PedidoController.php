<?php

namespace App\Http\Controllers;

use App\Models\Inventory;
use App\Models\Mesa;
use App\Models\Pedido;
use App\Models\PedidosProduct;
use App\Models\PedidosProductsStatu;
use App\Models\Product;
use App\Models\Statu;
use App\Models\StatusMesa;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Yajra\DataTables\DataTables;

class PedidoController extends Controller
{
    public function index()
    {
        return view('pedidos.index');
    }

    public function abrir()
    {


        $produtos = Inventory::with('products')->with('sizes')
            ->with('colors')->with('categorias')->with('marcas')
            ->where('qtd', '>', 0)
            ->get();

        return view('pedidos.abrir', [
            //'pedidos' => PedidosProduct::all(),
            'mesas' => Mesa::all(),
            'users' => User::all(),
            // 'status' => Statu::all()->whereIn('id', [1, 4]),
        ]);
    }

    public function mesas_consumo(Mesa $mesa)
    {

        $produtos = Inventory::with('products')->with('sizes')
            ->with('colors')->with('categorias')->with('marcas')
            ->where('qtd', '>', 0)
            ->get();

        if (status_mesa($mesa->id) != 'Aberto') {
            return redirect()->route('pedidos.abrir')->with('erro', 'Lamento! Esta Mesa não está aberta');
        }

        return view('pedidos.consumos', [
            'produtos' => $produtos,
            'mesa' => $mesa,
        ]);
    }

    public function abrir_store(Request $request)
    {
        $request->validate([
            'mesas_id' => 'required',
            'produtos_id' => 'required',
            'qtd' => 'required',
        ]);
        if (false) {

        } else {
            //$produto = Product::all()->where('codigo', $request->codigo)->first();
            $inventory = Inventory::all()->find($request->produtos_id);
            $product = Product::all()->find($inventory->products_id);

            /*$pedido = Pedido::create([
                'clientes_id' => null,
                'status_mesas_id' => $request->mesas_id,
                'total' => 0,
                'data' => now()
            ]);*/

            $pedido_product = PedidosProduct::create([
                'status_mesas_id' => $request->mesas_id,
                'inventories_id' => $inventory->id,
                'qtd' => $request->qtd,
                'preco' => $product->preco_venda,
            ]);

            if ($pedido_product) {
                $pedido_status = PedidosProductsStatu::create([
                    'status_mesas_id' => $request->mesas_id,
                    'status_id' => 5,
                    'users_id' => auth()->id(),
                    'data' => now(),
                ]);
                return redirect()->back()->with("sucesso", "Pedido Adicionado com sucesso!");
            }

            return redirect()->back()->with("erro", "Erro ao Adicionar pedido")->withInput();
        }


    }

    public function adicionar_cart(Mesa $mesa, Request $request)
    {
        $this->middleware('VerifyCsrfToken');

        $inventory = Inventory::all()->find($request->inventories_id);
        $status_mesas = StatusMesa::all()->where('mesas_id', $mesa->id)->last();
        $qtd = $request->qtd;
        $id = $inventory->id;
        $desc = 0;
        $parametros = [
            'products_id' => $inventory->products_id,
            'shops_id' => $inventory->shops_id,
            'sizes_id' => $inventory->sizes_id,
            'colors_id' => $inventory->colors_id,
            'marcas_id' => $inventory->marcas_id,
            'categorias_id' => $inventory->categorias_id,
            'validade' => $inventory->validade,
        ];

        $carrinho = session()->get('carrinho_pedidos');

        // se o carrinho estiver vazio, este é o primeiro item
        if (!$carrinho) {


            if (getCurrentStock($parametros) < $qtd) {
                return redirect()->back()->with('erro', 'Lamento! Não temos stock suficiente para este produto');
            }

            $carrinho = [
                $id => [
                    "product" => $inventory->products->product,
                    "mesa" => $mesa->id,
                    "status_mesas_id" => $status_mesas->id,
                    "qtd" => $qtd,
                    "preco" => $inventory->products->preco_venda,
                    'tipo' => $inventory->products->tipo,
                    'desc' => $desc,
                    'cozinha' => $request->cozinha,
                    'obs' => $request->obs
                ]
            ];
            session()->put('carrinho_pedidos', $carrinho);
            // return redirect()->back()->with('sucesso', 'Item adicionado com sucesso!');
            return redirect()->back();
        }

        // se o carrinho não estiver vazio, verifique se este item existe e aumente a quantidade
        if (isset($carrinho[$id])) {

            $carrinho[$id]['qtd'] += $qtd;

            if (getCurrentStock($parametros) < $carrinho[$id]['qtd']) {
                return redirect()->back()->with('erro', 'Lamento! Não temos stock suficiente para este produto');
            }

            session()->put('carrinho_pedidos', $carrinho);
            //return redirect()->back()->with('sucesso', 'Adicionado Item existente com sucesso!');
            return redirect()->back();
        }
        // se o item não existe no carrinho, adicione ao carrinho com quantidade = 1

        if (getCurrentStock($parametros) < $qtd) {
            return redirect()->back()->with('erro', 'Lamento! Não temos stock suficiente para este produto');
        }

        $carrinho[$id] = [
            "product" => $inventory->products->product,
            "mesa" => $mesa->id,
            "status_mesas_id" => $status_mesas->id,
            "qtd" => $qtd,
            "preco" => $inventory->products->preco_venda,
            'tipo' => $inventory->products->tipo,
            'desc' => $desc,
            'cozinha' => $request->cozinha,
            'obs' => $request->obs
        ];
        session()->put('carrinho_pedidos', $carrinho);
        return redirect()->back()->with('sucesso', 'Adicionado outro Item com sucesso!');
    }

    public function remover_all()
    {
        $carrinho = session()->get('carrinho_pedidos');
        foreach ($carrinho as $key => $value) {
            if (isset($carrinho[$key])) {
                unset($carrinho[$key]);
                session()->put('carrinho_pedidos', $carrinho);
            }
        }
        return redirect()->back()->with('sucesso', 'Itens Removido com sucessso!');
    }

    public function remover(Request $request)
    {
        if ($request->id) {
            $carrinho = session()->get('carrinho_pedidos');
            if (isset($carrinho[$request->id])) {
                unset($carrinho[$request->id]);
                session()->put('carrinho_pedidos', $carrinho);
                return redirect()->back()->with('sucesso', 'Item Removido com sucessso!');
            }
            return redirect()->back()->with('erro', 'Item não encontrado!');
        }
    }

    public function mesas_detalhes(Mesa $mesa)
    {
        $produtos = DB::table('inventories')
            ->get();

        $pedidos = DB::table('pedidos_products')
            ->join('inventories', 'inventories.id', 'pedidos_products.inventories_id')
            ->join('products', 'products.id', 'inventories.products_id')
            ->join('status_mesas', 'status_mesas.id', 'pedidos_products.status_mesas_id')
            ->join('mesas', 'mesas.id', 'status_mesas.mesas_id')
            ->leftJoin('pedidos_products_status', 'pedidos_products_status.pedidos_products_id', 'pedidos_products.id')
            ->leftJoin('status', 'status.id', 'pedidos_products_status.status_id')
            ->where('mesas.id', $mesa->id)
            ->where('status', 1)
            //->where('historico_mesas.status_mesas_id', 2)
            ->get([
                '*',
                'pedidos_products.qtd as qtd',
                'pedidos_products.preco as preco',
                'status.statu as statu'
            ]);

        $total = 0;
        foreach ($pedidos as $pedido) {
            $total += $pedido->preco * $pedido->qtd;
        }
        return view('pedidos.detalhe_mesa', [
            'mesa' => $mesa,
            'produtos' => $produtos,
            'pedidos' => $pedidos,
            'pedido' => $pedidos->last(),
            'users' => User::all(),
            'total' => formatar_moeda($total),
            'total2' => $total
        ]);
    }

    public function fechar()
    {

    }

    public function historico()
    {

    }

    public function create()
    {
        //
    }

    public function store()
    {

        $carts = session('carrinho_pedidos');
        $count = 0;
        foreach ($carts as $key => $cart) {

            $inventory = Inventory::all()->find($key);
            $product = Product::all()->find($inventory->products_id);

            $pedido_product = PedidosProduct::create([
                'status_mesas_id' => $cart['status_mesas_id'],
                'inventories_id' => $inventory->id,
                'qtd' => $cart['qtd'],
                //'preco' => $product->preco_venda,
                'preco' => $cart['preco'],
                'cozinha' => $cart['cozinha'],
                'obs' => $cart['obs']
            ]);

            if ($pedido_product) {
                if ($cart['cozinha'] == 1) {
                    $pedido_status = PedidosProductsStatu::create([
                        'pedidos_products_id' => $pedido_product->id,
                        'status_id' => 5,
                        'users_id' => auth()->id(),
                        'data' => now(),
                    ]);
                }
            }

            //Remover do carrinho
            if (isset($carts[$key])) {
                unset($carts[$key]);
                session()->put('carrinho_pedidos', $carts);
            }
        }


        return redirect()->back()->with("sucesso", "Pedido Registado com sucesso!");


    }

    public function finalizar(Request $request)
    {
        $request->validate([
            'troco'=>'required',
            'dinheiro'=>'required',
            'tpa'=>'required_if:dinheiro,null',
        ]);
    }

    public function show(Pedido $pedido)
    {
        //
    }

    public function edit(Pedido $pedido)
    {
        //
    }

    public function update(Request $request, Pedido $pedido)
    {
        //
    }

    public function destroy(Pedido $pedido)
    {
        //
    }

    public function listar()
    {
        $pedidos = DB::table('pedidos')->get();

        $dados = [];
        foreach ($pedidos as $pedido) {
            $pedidos_products_status = PedidosProductsStatu::with('users')->with('status')->where('pedidos_id', $pedido->id)
                ->get()->last();
            $dados[] = [
                'id' => $pedido->id,
                'pedido' => $pedido->pedido,
                'statu' => $pedidos_products_status ? $pedidos_products_status->status->statu : '',
                'username' => $pedidos_products_status ? $pedidos_products_status->users->username : '',
                'data' => $pedidos_products_status ? data_formatada($pedidos_products_status->data) : '',
            ];
        }

        return DataTables::of($dados)
            ->make(true);
    }

}
