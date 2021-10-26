<?php

namespace App\Http\Controllers;

use App\Models\Inventory;
use App\Models\Product;
use App\Models\Shop;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class InventoryController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        //$inventories = Inventory::paginate(10);
        $inventories = Inventory::all();
        $products = Product::all();
        $shops = Shop::all();
        return view('inventories.index', [
            'products' => $products,
            'shops' => $shops,
            'inventories' => $inventories,
        ]);


    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        //if (Gate::denies('new'))
        //  return redirect()->back()->with('erro', 'Não Tens Permissão para Cadastrar');

        $products = Product::all();
        $shops = Shop::all();
        return view('inventories.create', [
            'products' => $products,
            'shops' => $shops,
        ]);
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param \Illuminate\Http\Request $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        if (Inventory::create($request->all())) {
            return redirect()->route('inventories.index')->with('sucesso', 'Dados Salvo com sucesso!');
        } else {
            return redirect()->back()->with('erro', 'Erro ao salvar');
        }
    }

    /**
     * Display the specified resource.
     *
     * @param \App\Models\Inventory $inventory
     * @return \Illuminate\Http\Response
     */
    public function show(Inventory $inventory)
    {
        //if (Gate::denies('view'))
        // return redirect()->back()->with('erro', 'Não Tens Permissão para vizualizar este Item');

        $products = Product::all();
        $shops = Shop::all();
        return view('inventories.show', [
            'products' => $products,
            'shops' => $shops,
            'inventory' => $inventory,
        ]);
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param \App\Models\Inventory $inventory
     * @return \Illuminate\Http\Response
     */
    public function edit(Inventory $inventory)
    {
        //if (Gate::denies('update'))
        // return redirect()->back()->with('erro', 'Não Tens Permissão para alterar este Item');

        $products = Product::all();
        $shops = Shop::all();
        return view('inventories.edit', [
            'products' => $products,
            'shops' => $shops,
            'inventory' => $inventory,
        ]);
    }

    /**
     * Update the specified resource in storage.
     *
     * @param \Illuminate\Http\Request $request
     * @param \App\Models\Inventory $inventory
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, Product $product)
    {
        if ($product->update($request->all())) {
            return redirect()->route('inventories.index')->with('sucesso', 'Dados Alterado com sucesso!');
        } else {
            return redirect()->back()->with('erro', 'Erro ao Alterar');
        }
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param \App\Models\Inventory $inventory
     * @return \Illuminate\Http\Response
     */
    public function destroy(Inventory $inventory)
    {
        //if (Gate::denies('delete'))
        // return redirect()->back()->with('erro', 'Não Tens Permissão para eliminar este Item');

        if ($inventory->delete()) {
            return redirect()->route('inventories.index')->with('sucesso', 'Dados Eliminado com sucesso!');
        } else {
            return redirect()->back()->with('erro', 'Erro ao Eliminar');
        }
    }

    public function listar_by_nome(Request $request)
    {
        $produtos = DB::table('inventories')
        ->join('products', 'products.id', 'inventories.products_id')
        ->where('products.produto', 'LIKE', "%$request->produto%")->get();

        echo json_encode($produtos);
    }
}
