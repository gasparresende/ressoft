<?php

namespace App\Http\Controllers;

use App\Models\Inventory;
use App\Models\Product;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use function Composer\Autoload\includeFile;

class CarrinhoMeioPagamentoController extends Controller
{
    public function adicionar(Request $request)
    {

        $this->middleware('VerifyCsrfToken');

        $id = $request->id;

        $meio = DB::table('meio_pagamentos')->find($id);

        $carrinho = session()->get('carrinho_meio_pagamento');

        // se o carrinho estiver vazio, este é o primeiro item
        if (!$carrinho) {
            $carrinho = [
                $id => [
                    "meio" => $meio->meio,
                    "valor" => str_replace(',', '.', str_replace('.', '', $request->valor)),
                ]
            ];
            session()->put('carrinho_meio_pagamento', $carrinho);
            return redirect()->back()->with('sucesso', 'Item adicionado com sucesso!');
        }

        // se o carrinho não estiver vazio, verifique se este item existe e aumente a quantidade
        if (isset($carrinho[$id])) {
            $carrinho[$id]['valor'] += str_replace(',', '.', str_replace('.', '', $request->valor));
            session()->put('carrinho_meio_pagamento', $carrinho);
            return redirect()->back()->with('sucesso', 'Adicionado Item existente com sucesso!');
        }
        // se o item não existe no carrinho, adicione ao carrinho com quantidade = 1
        $carrinho[$id] = [
            "meio" => $meio->meio,
            "valor" => str_replace(',', '.', str_replace('.', '', $request->valor)),
        ];
        session()->put('carrinho_meio_pagamento', $carrinho);
        return redirect()->back()->with('sucesso', 'Adicionado outro Item com sucesso!');

    }

    public function remover(Request $request)
    {
        if ($request->id) {
            $carrinho = session()->get('carrinho_meio_pagamento');
            if (isset($carrinho[$request->id])) {
                unset($carrinho[$request->id]);
                session()->put('carrinho_meio_pagamento', $carrinho);
            }
            return redirect()->back()->with('sucesso', 'Item Removido com sucessso!');
        }
    }


    public function remover_todos()
    {
        $carrinho = session()->get('carrinho_meio_pagamento');
        foreach ($carrinho as $key => $value) {
            if (isset($carrinho[$key])) {
                unset($carrinho[$key]);
                session()->put('carrinho_meio_pagamento', $carrinho);
            }
        }
        return redirect()->back()->with('sucesso', 'Itens Removido com sucessso!');
    }
}

