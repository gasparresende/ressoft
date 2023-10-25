<?php

namespace App\Http\Controllers;

use App\DataTables\CaixaDataTable;
use App\Http\Requests\ProductRequest;
use App\Models\Category;
use App\Models\Product;
use App\Models\Regime;
use App\Models\Unidade;
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
    private $produto;

    public function __construct()
    {
        $p = new Product();
        $this->produto = $p;
    }

    public function index()
    {

        return view('products.index');
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
        return view('products.create', $this->produto->dependencias());

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
            return redirect()->back()->with('erro', 'Erro ao salvar')->withInput();
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
        $dependencias = $this->produto->dependencias();
        $dependencias['product']=$product;
        return view('products.show', $dependencias);

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

        $dependencias = $this->produto->dependencias();
        $dependencias['product']=$product;
        return view('products.edit', $dependencias);
    }

    /**
     * Update the specified resource in storage.
     *
     * @param \Illuminate\Http\Request $request
     * @param \App\Models\Product $produtos
     * @return \Illuminate\Http\Response
     */
    public function update(ProductRequest $request, Product $product)
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
