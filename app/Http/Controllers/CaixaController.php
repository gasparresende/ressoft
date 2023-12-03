<?php

namespace App\Http\Controllers;

use App\DataTables\CaixaDataTable;
use App\Models\Caixa;
use App\Models\CaixaMeioPagamento;
use App\Models\MeioPagamento;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use mysql_xdevapi\RowResult;
use Yajra\DataTables\DataTables;

class CaixaController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Contracts\Foundation\Application|\Illuminate\Contracts\View\Factory|\Illuminate\Contracts\View\View|\Illuminate\Http\Response
     */

    public function index()
    {
        return view('caixas.index', [
            'users' => User::all(),
        ]);
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Contracts\Foundation\Application|\Illuminate\Contracts\View\Factory|\Illuminate\Contracts\View\View|\Illuminate\Http\Response
     */
    public function create()
    {
        //if (Gate::denies('new'))
        //  return redirect()->back()->with('erro', 'Não Tens Permissão para Cadastrar');
        $users = User::all();
        return view('caixas.create', [
            'users' => $users
        ]);
    }


    /**
     * Store a newly created resource in storage.
     *
     * @param \Illuminate\Http\Request $request
     * @return \Illuminate\Http\RedirectResponse
     */
    public function store(Request $request)
    {
        if (!isCaixaFechado())
            return redirect()->back()->with('alerta', 'Não foi possível abrir o caixa. O Caixa Anterior não foi fechado!');

        $caixa = Caixa::create([
            'users_id' => auth()->id(),
            'data_caixa' => date(now()),
            'saldo' => 0,
            'status' => 1,
            'saldo_inicial' => $request->saldo_inicial,
        ]);
        if ($caixa) {
            return redirect()->route('caixas.index')->with('sucesso', 'Caixa Aberto com sucesso!');
        } else {
            return redirect()->back()->with('erro', 'Erro ao Abrir Caixa');
        }
    }

    public function abrir()
    {
        if (!isCaixaFechado())
            return redirect()->back()->with('alerta', 'Não foi possível abrir o caixa. O Caixa Anterior não foi fechado!');

        $caixa = Caixa::create([
            'users_id' => auth()->id(),
            'data_caixa' => date(now()),
            'saldo' => 0,
            'status' => 1,
            'saldo_inicial' => 0,
        ]);
        if ($caixa) {
            return redirect()->back()->with('sucesso', 'Caixa Aberto com sucesso!');
        } else {
            return redirect()->back()->with('erro', 'Erro ao Abrir Caixa');
        }
    }

    /**
     * Display the specified resource.
     *
     * @param \App\Models\Caixa $produtos
     * @return \Illuminate\Contracts\Foundation\Application|\Illuminate\Contracts\View\Factory|\Illuminate\Contracts\View\View|\Illuminate\Http\Response
     */
    public function show(Caixa $caixa)
    {
        //if (Gate::denies('view'))
        // return redirect()->back()->with('erro', 'Não Tens Permissão para vizualizar este Item');

        return view('caixas.show', [
            'caixa' => $caixa
        ]);
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param \App\Models\Caixa $produtos
     * @return \Illuminate\Contracts\Foundation\Application|\Illuminate\Contracts\View\Factory|\Illuminate\Contracts\View\View|\Illuminate\Http\Response
     */
    public function edit(Caixa $caixa)
    {
        //if (Gate::denies('update'))
        // return redirect()->back()->with('erro', 'Não Tens Permissão para alterar este Item');

        return view('caixas.edit', [
            'caixa' => $caixa
        ]);
    }

    /**
     * Update the specified resource in storage.
     *
     * @param \Illuminate\Http\Request $request
     * @param \App\Models\Caixa $produtos
     * @return \Illuminate\Http\RedirectResponse
     */
    public function update(Request $request, Caixa $caixa)
    {
        if ($caixa->update($request->all())) {
            return redirect()->route('caixas.index')->with('sucesso', 'Dados Alterado com sucesso!');
        } else {
            return redirect()->back()->with('erro', 'Erro ao Alterar');
        }
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param \App\Models\Caixa $produtos
     * @return \Illuminate\Http\RedirectResponse
     */
    public function destroy(Caixa $caixa)
    {
        //if (Gate::denies('delete'))
        // return redirect()->back()->with('erro', 'Não Tens Permissão para eliminar este Item');

        if ($caixa->delete()) {
            return redirect()->route('caixas.index')->with('sucesso', 'Dados Eliminado com sucesso!');
        } else {
            return redirect()->back()->with('erro', 'Erro ao Eliminar');
        }
    }


    public function fechar_store(Request $request)
    {

        $caixa = Caixa::all()->find($request->id);
        $cash = str_replace(',', '.', str_replace('.', '', $request->cash));
        $tpa = str_replace(',', '.', str_replace('.', '', $request->tpa));
        $valor_total = $request->valor_total;


        if ($caixa->status == 0)
            return redirect()->back()->with('erro', 'O Caixa já está fechado!');

        $meioPagamento = MeioPagamento::all();
        foreach ($meioPagamento as $item) {
            CaixaMeioPagamento::create([
                'caixas_id' => $caixa->id,
                'meios_pagamentos_id' => $item->id,
                'valor' => $item->id == 1 ? $cash : $tpa,
            ]);
        }

        $caixa->update([
            'status' => 0,
            'diferenca' => $valor_total - ($cash + $tpa),
        ]);

        return redirect()->route('caixas.index')->with('sucesso', 'Caixa Fechado com sucesso!');


    }

    public function fechar(Request $request)
    {
        $caixa = Caixa::all()->find($request->id);

        return response()->json($caixa);

    }


    public function listar()
    {
        $caixas = DB::table('caixas')
            ->join('users', 'users.id', 'users_id')
            ->select([
                'caixas.id as id_caixa',
                'username',
                'data_caixa',
                'saldo_inicial',
                'total',
                'diferenca',
                'caixas.status',
            ]);

        return DataTables::of($caixas)
            ->make(true);
    }

    public function relatorio_geral(Request $request)
    {
        //Gerar Relatório de caixa PDF
        $caixas = DB::table('caixas')
            ->join('users', 'users.id', 'caixas.users_id')
            ->whereBetween('data_caixa', [$request->data1, $request->data2])
        ->get([
            '*',
            'caixas.id as id',
        ]);

        $pdf = \PDF::loadView('report.relatorio_caixa', [
            'caixas' => $caixas,
            'request'=>$request
        ]);
        return $pdf->download('Relatorio_Caixa.pdf');

    }
}
