<?php

namespace App\Http\Controllers;

use App\Models\Categorias;
use App\Models\Precos;
use App\Models\Product;
use App\Models\Unidades;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Gate;

class PrecosController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $precos = Precos::paginate(100);
        #$precos = Precos::all();
        return view('precos.index', [
            'precos' => $precos
        ]);
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        if (Gate::denies('new'))
            return redirect()->back()->with('erro', 'Não Tens Permissão para Cadastrar');

        $pro = Product::all();
        $un = Unidades::all();
        $cat = Categorias::all();
        return view('precos.create', [
            'pro' => $pro,
            'un' => $un,
            'cat' => $cat,
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
        if (Precos::create($request->all())) {
            return redirect()->route('precos.index')->with('sucesso', 'Dados Salvo com sucesso!');
        } else {
            return redirect()->back()->with('erro', 'Erro ao salvar');
        }
    }

    /**
     * Display the specified resource.
     *
     * @param \App\Models\Precos $precos
     * @return \Illuminate\Http\Response
     */
    public function show(Precos $preco)
    {
        if (Gate::denies('view'))
            return redirect()->back()->with('erro', 'Não Tens Permissão para vizualizar este Item');

        $un = Unidades::all();
        $cat = Categorias::all();
        return view('precos.show', [
            'un' => $un,
            'cat' => $cat,
            'preco' => $preco,
        ]);
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param \App\Models\Precos $precos
     * @return \Illuminate\Http\Response
     */
    public function edit(Precos $preco)
    {
        if (Gate::denies('update'))
            return redirect()->back()->with('erro', 'Não Tens Permissão para alterar este Item');

        $un = Unidades::all();
        $cat = Categorias::all();
        return view('precos.edit', [
            'un' => $un,
            'cat' => $cat,
            'preco' => $preco,
        ]);
    }

    /**
     * Update the specified resource in storage.
     *
     * @param \Illuminate\Http\Request $request
     * @param \App\Models\Precos $precos
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, Precos $preco)
    {
        if ($preco->update($request->all())) {
            return redirect()->route('precos.index')->with('sucesso', 'Dados Alterado com sucesso!');
        } else {
            return redirect()->back()->with('erro', 'Erro ao Alterar');
        }
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param \App\Models\Precos $precos
     * @return \Illuminate\Http\Response
     */
    public function destroy(Precos $preco)
    {
        if (Gate::denies('delete'))
            return redirect()->back()->with('erro', 'Não Tens Permissão para eliminar este Item');

        if ($preco->delete()) {
            return redirect()->route('precos.index')->with('sucesso', 'Dados Eliminado com sucesso!');
        } else {
            return redirect()->back()->with('erro', 'Erro ao Eliminar');
        }
    }
}
