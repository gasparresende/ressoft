<?php

namespace App\Http\Controllers;

use App\Models\Inventory;
use App\Models\Product;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use function Composer\Autoload\includeFile;

class CarrinhoController extends Controller
{
    public function adicionar(Request $request)
    {

        $this->middleware('VerifyCsrfToken');
        #$id = Auth::id();

        $qtd = $request->qtd;

        $pro = Product::all()->where('codigo', $request->codigo);
        if ($pro->isEmpty()) {
            return back()->with('alerta', 'Produto não encontrado, Por favor tenta novamente!');
        }

        $id = $pro->first()->id;
        $desc = $request->desc;

        //$inventories = Inventory::all()->find($id);
        $inventories = DB::table('inventories')
            ->join('products', 'products.id', 'inventories.products_id')->get(['*', 'inventories.id as inventories_id'])
            ->where('products_id', $id)
            ->first();

        if ($inventories->qtd <= $qtd) {
            return back()->with('alerta', "Quantidade não disponível em stock! Dispoem de $inventories->qtd");
        }

        $carrinho = session()->get('carrinho');

        // se o carrinho estiver vazio, este é o primeiro item
        if (!$carrinho) {
            $carrinho = [
                $id => [
                    "produto" => $inventories->produto,
                    "qtd" => $qtd,
                    "preco_venda" => $inventories->preco_venda,
                    "preco_compra" => $inventories->preco_compra,
                    'tipo' => $inventories->tipo,
                    'codigo' => $inventories->codigo,
                    'validade' => $inventories->validade,
                    'istock' => $inventories->isstock,
                    'shops_id' => $inventories->codigo,
                    'inventories_id' => $inventories->inventories_id,
                    'qtd_stock' => $inventories->qtd,
                    'desc' => $desc,
                ]
            ];
            session()->put('carrinho', $carrinho);
            return redirect()->back()->with('sucesso', 'Item adicionado com sucesso!');
        }

        // se o carrinho não estiver vazio, verifique se este item existe e aumente a quantidade
        if (isset($carrinho[$id])) {
            $carrinho[$id]['qtd'] += $qtd;
            session()->put('carrinho', $carrinho);
            return redirect()->back()->with('sucesso', 'Adicionado Item existente com sucesso!');
        }
        // se o item não existe no carrinho, adicione ao carrinho com quantidade = 1
        $carrinho[$id] = [
            "produto" => $inventories->produto,
            "qtd" => $qtd,
            "preco_venda" => $inventories->preco_venda,
            "preco_compra" => $inventories->preco_compra,
            'tipo' => $inventories->tipo,
            'codigo' => $inventories->codigo,
            'validade' => $inventories->validade,
            'istock' => $inventories->isstock,
            'shops_id' => $inventories->codigo,
            'inventories_id' => $inventories->inventories_id,
            'qtd_stock' => $inventories->qtd,
            'desc' => $desc,
        ];
        session()->put('carrinho', $carrinho);
        return redirect()->back()->with('sucesso', 'Adicionado outro Item com sucesso!');

    }

    public function remover(Request $request)
    {
        if ($request->id) {
            $carrinho = session()->get('carrinho');
            if (isset($carrinho[$request->id])) {
                unset($carrinho[$request->id]);
                session()->put('carrinho', $carrinho);
            }
            return redirect()->back()->with('sucesso', 'Item Removido com sucessso!');
        }
    }

    public function recuperar(Request $request)
    {

        $this->middleware('VerifyCsrfToken');
        $id = $request->id;


        if (true) {
            return redirect()->back()->with('sucesso', 'Cotação recuperada com sucesso!');
        } else
            return redirect()->back()->with('erro', 'Carrinho não está vazio, Elimine os Itens antes de continuar');
    }

    public function remover_todos()
    {
        $carrinho = session()->get('carrinho');
        foreach ($carrinho as $key => $value) {
            if (isset($carrinho[$key])) {
                unset($carrinho[$key]);
                session()->put('carrinho', $carrinho);
            }
        }
        return redirect()->back()->with('sucesso', 'Itens Removido com sucessso!');
    }
}

