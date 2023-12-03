<?php

namespace App\Http\Controllers;

use App\Models\Conta;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Gate;
use Yajra\DataTables\DataTables;

class ContaController extends Controller
{
    public function index()
    {
        /*if (Gate::denies('no_restriction'))
            $contas = Conta::all()->where('users_id', auth()->id());
        else*/
        $contas = Conta::all();

        return view('contas.index');
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

        return view('contas.create');
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param \Illuminate\Http\Request $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        $inserir = DB::table('contas')->updateOrInsert(['id' => $request->id], $request->except('_token'));

        if ($inserir)
            return redirect()->back()->with("sucesso", "Dados Salvo com sucesso!");
        else
            return redirect()->back()->with("erro", "Erro ao Salvar");
    }

    public function show(Request $request)
    {
        echo json_encode(DB::table('contas')->where('id', $request->id)
            ->get());
    }


    public function edit($id)
    {

    }


    public function update(Request $request, $id)
    {

    }

    /**
     * Remove the specified resource from storage.
     *
     * @param \App\Models\Contas $contas
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        if (Gate::denies('delete'))
            return redirect()->back()->with('erro', 'Não Tens Permissão para eliminar este Item');

        Conta::destroy($id);
        return redirect()->route('contas.index')->with('sucesso', 'Dados Removido com sucesso!!');
    }


    public function delete(Request $request)
    {

        if (DB::table('contas')->where('id', $request->id)->delete()) {
            DB::statement("ALTER TABLE contas AUTO_INCREMENT =  $request->id");
            return redirect()->back()->with('sucesso', 'Dados eliminado com sucesso!!');
        } else {
            return redirect()->back()->with('erro', 'Erro ao eliminar');
        }
    }

    public function listar()
    {
        $contas = DB::table('contas')
            ->select([
                '*',
            ]);

        return DataTables::of($contas)
            ->make(true);
    }

}
