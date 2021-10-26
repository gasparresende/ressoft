<?php

namespace App\Http\Controllers;

use App\DataTables\CaixaDataTable;
use App\Http\Requests\ProductRequest;
use App\Models\Category;
use App\Models\Product;
use App\Models\Unity;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Yajra\DataTables\DataTables;

class ProductsController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(CaixaDataTable $dataTable)
    {
        return $dataTable->render('products.index');
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

        $units = Unity::all();
        $categories = Category::all();
        return view('products.create', [
            'units' => $units,
            'categories' => $categories,
        ]);
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param \Illuminate\Http\Request $request
     * @return \Illuminate\Http\Response
     */
    public function store(ProductRequest $request)
    {
        if (Product::create($request->all())) {
            return redirect()->route('products.index')->with('sucesso', 'Dados Salvo com sucesso!');
        } else {
            //return redirect()->back()->with('erro', 'Erro ao salvar');
        }
    }

    /**
     * Display the specified resource.
     *
     * @param \App\Models\Product $produtos
     * @return \Illuminate\Http\Response
     */
    public function show(Product $product)
    {
        //if (Gate::denies('view'))
           // return redirect()->back()->with('erro', 'Não Tens Permissão para vizualizar este Item');

        $units = Unity::all();
        $categories = Category::all();
        return view('products.show', [
            'units' => $units,
            'categories' => $categories,
            'product' => $product,
        ]);
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param \App\Models\Product $produtos
     * @return \Illuminate\Http\Response
     */
    public function edit(Product $product)
    {
        //if (Gate::denies('update'))
           // return redirect()->back()->with('erro', 'Não Tens Permissão para alterar este Item');

        $units = Unity::all();
        $categories = Category::all();
        return view('products.edit', [
            'units' => $units,
            'categories' => $categories,
            'product' => $product,
        ]);
    }

    /**
     * Update the specified resource in storage.
     *
     * @param \Illuminate\Http\Request $request
     * @param \App\Models\Product $produtos
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, Product $product)
    {
        if ($product->update($request->all())) {
            return redirect()->route('products.index')->with('sucesso', 'Dados Alterado com sucesso!');
        } else {
            return redirect()->back()->with('erro', 'Erro ao Alterar');
        }
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param \App\Models\Product $produtos
     * @return \Illuminate\Http\Response
     */
    public function destroy(Product $product)
    {
        //if (Gate::denies('delete'))
           // return redirect()->back()->with('erro', 'Não Tens Permissão para eliminar este Item');

        if ($product->delete()) {
            return redirect()->route('products.index')->with('sucesso', 'Dados Eliminado com sucesso!');
        } else {
            return redirect()->back()->with('erro', 'Erro ao Eliminar');
        }
    }

    public function listar()
    {
        $products = DB::table('products')->select(['*']);

        return DataTables::of($products)
            ->make(true);
    }

}
