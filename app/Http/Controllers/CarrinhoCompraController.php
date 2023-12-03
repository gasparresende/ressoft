<?php

namespace App\Http\Controllers;

use App\Models\Inventory;
use App\Models\Factura;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use function Composer\Autoload\includeFile;
use function PHPUnit\Framework\isEmpty;

class CarrinhoCompraController extends Controller
{

    public $cart = 0;
    public $total = 0;

    public function adicionar(Request $request)
    {

        $this->middleware('VerifyCsrfToken');
        #$id = Auth::id();

        $qtd = $request->qtd;
        $id = $request->id;
        $desc = $request->desc;

        $inventory = Inventory::all()->where('id', $id)->first();

        $carrinho = session()->get('carrinho_factura');

        // se o carrinho estiver vazio, este é o primeiro item
        if (!$carrinho) {
            $carrinho = [
                $id => [
                    "product" => $inventory->products->product,
                    "qtd" => $qtd,
                    "valor" => $inventory->products->preco_venda,
                    'tipo' => $inventory->products->tipo,
                    'desc' => $desc,
                ]
            ];
            session()->put('carrinho_factura', $carrinho);
            return redirect()->back()->with('sucesso', 'Item adicionado com sucesso!');
        }

        // se o carrinho não estiver vazio, verifique se este item existe e aumente a quantidade
        if (isset($carrinho[$id])) {
            $carrinho[$id]['qtd'] += $qtd;
            session()->put('carrinho_factura', $carrinho);
            return redirect()->back()->with('sucesso', 'Adicionado Item existente com sucesso!');
        }
        // se o item não existe no carrinho, adicione ao carrinho com quantidade = 1
        $carrinho[$id] = [
            "product" => $inventory->products->product,
            "qtd" => $qtd,
            "valor" => $inventory->products->preco_venda,
            'tipo' => $inventory->products->tipo,
            'desc' => $desc,
        ];
        session()->put('carrinho_factura', $carrinho);
        return redirect()->back()->with('sucesso', 'Adicionado outro Item com sucesso!');
    }

    public function update(Request $request)
    {
        if ($request->id and $request->quantity) {
            $carrinho = session()->get('carrinho_factura');
            $carrinho[$request->id]["quantity"] = $request->quantity;
            session()->put('carrinho_factura', $carrinho);
            session()->flash('success', 'carrinho updated successfully');
        }
    }

    public function remover(Request $request)
    {
        if ($request->id) {
            $carrinho = session()->get('carrinho_factura');
            if (isset($carrinho[$request->id])) {
                unset($carrinho[$request->id]);
                session()->put('carrinho_factura', $carrinho);
            }
            return redirect()->back()->with('sucesso', 'Item Removido com sucessso!');
        }
    }

    public function remover_todos()
    {
        $carrinho = session()->get('carrinho_factura');
        foreach ($carrinho as $key => $value) {
            if (isset($carrinho[$key])) {
                unset($carrinho[$key]);
                session()->put('carrinho_factura', $carrinho);
            }
        }
        return redirect()->back()->with('sucesso', 'Itens Removido com sucessso!');
    }


}
