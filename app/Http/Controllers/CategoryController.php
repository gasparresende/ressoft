<?php

namespace App\Http\Controllers;

use App\Models\Category;
use Illuminate\Http\Request;

class CategoryController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $categories = Category::all();
        // $categories = Category::all()->sortByDesc('id');
        return view('categories.index', [
            'categories' => $categories
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

        return view('categories.create');
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param \Illuminate\Http\Request $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        if (Category::create($request->all())) {
            return redirect()->route('categories.index')->with('sucesso', 'Dados Salvo com sucesso!');
        } else {
            return redirect()->back()->with('erro', 'Erro ao salvar');
        }
    }

    /**
     * Display the specified resource.
     *
     * @param \App\Models\Category $produtos
     * @return \Illuminate\Http\Response
     */
    public function show(Category $category)
    {
        //if (Gate::denies('view'))
        // return redirect()->back()->with('erro', 'Não Tens Permissão para vizualizar este Item');

        return view('categories.show', [
            'category' => $category
        ]);
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param \App\Models\Category $produtos
     * @return \Illuminate\Http\Response
     */
    public function edit(Category $category)
    {
        //if (Gate::denies('update'))
        // return redirect()->back()->with('erro', 'Não Tens Permissão para alterar este Item');

        return view('categories.edit', [
            'category' => $category
        ]);
    }

    /**
     * Update the specified resource in storage.
     *
     * @param \Illuminate\Http\Request $request
     * @param \App\Models\Category $produtos
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, Category $category)
    {
        if ($category->update($request->all())) {
            return redirect()->route('categories.index')->with('sucesso', 'Dados Alterado com sucesso!');
        } else {
            return redirect()->back()->with('erro', 'Erro ao Alterar');
        }
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param \App\Models\Category $produtos
     * @return \Illuminate\Http\Response
     */
    public function destroy(Category $category)
    {
        //if (Gate::denies('delete'))
        // return redirect()->back()->with('erro', 'Não Tens Permissão para eliminar este Item');

        if ($category->delete()) {
            return redirect()->route('categories.index')->with('sucesso', 'Dados Eliminado com sucesso!');
        } else {
            return redirect()->back()->with('erro', 'Erro ao Eliminar');
        }
    }
}
