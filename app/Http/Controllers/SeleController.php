<?php

namespace App\Http\Controllers;

use App\Models\Customer;
use App\Models\Inventory;
use App\Models\Sele;
use App\Models\SelesProduct;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Yajra\DataTables\DataTables;

class SeleController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        return view('seles.index');
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        if (caixaAbertoDiaAnterior()->status)
            return redirect()->back()->with('alerta', "Não foi Fechado o caixa do Dia ".data_formatada(caixaAbertoDiaAnterior()->data_caixa));

        elseif (isCaixaFechado())
            return redirect()->back()->with('alerta', "Caixa Actual Fecho, Deverá abrir o caixa de Hoje");

        $customers = Customer::all();
        return view('seles.create', [
            'customers' => $customers,
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
        $sele = Sele::create([
            'data' => date(now()),
            'caixas_id' => caixa()->id,
            'customers_id' => $request->customers_id,
            'total' => str_replace(',', '.', str_replace('.', '', total_carrinho())),
            'mes' => $request->mes,
            'ano' => $request->ano,
        ]);

        if ($sele) {

            foreach (session('carrinho') as $key => $cart) {
                $desconto = $cart['preco_venda'] * ($cart['desc'] / 100);
                $retencao = ($cart['tipo'] == 1) ? ($cart['preco_venda'] - $desconto) * 0.065 : 0;

                $seles_product = SelesProduct::create([
                    'seles_id' => $sele->id,
                    'inventories_id' => $cart['inventories_id'],
                    'quantidade' => $cart['qtd'],
                    'punitario' => $cart['preco_venda'],
                    'taxa_iva' => 0,
                    'desconto' => $cart['desc'],
                    'retencao' => $retencao,
                ]);
            }

            foreach (session('carrinho_meio_pagamento') as $key => $cart) {
                DB::table('seles_meio_pagamentos')->insert([
                    'seles_id' => $sele->id,
                    'meio_pagamentos_id' => $key,
                    'valor' => $cart['valor'],
                    'troco' => str_replace(',', '.', str_replace('.', '', troco())),
                ]);
            }

            return redirect()->route('seles.index')->with('sucesso', 'Venda Finalizada com sucesso!');

        } else {
            return redirect()->back()->with('erro', 'Erro Finalizar Venda!');
        }

    }

    /**
     * Display the specified resource.
     *
     * @param \App\Models\Sele $sele
     * @return \Illuminate\Http\Response
     */
    public function show(Sele $sele)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param \App\Models\Sele $sele
     * @return \Illuminate\Http\Response
     */
    public function edit(Sele $sele)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param \Illuminate\Http\Request $request
     * @param \App\Models\Sele $sele
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, Sele $sele)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param \App\Models\Sele $sele
     * @return \Illuminate\Http\Response
     */
    public function destroy(Sele $sele)
    {
        //
    }

    public function listar()
    {
        $seles = DB::table('seles')
            ->join('caixas', 'caixas.id', 'seles.caixas_id')
            ->join('users', 'users.id', 'caixas.users_id')
            ->join('customers', 'customers.id', 'seles.customers_id')
            ->select(['*', 'seles.id as numero']);

        return DataTables::of($seles)
            ->setRowClass('{{ $id % 2 == 0 ? "alert-success" : "alert-warning" }}')
            ->make(true);

    }

    public function next()
    {

        $meio_pagamentos = DB::table('meio_pagamentos')->get();
        return view('seles.next', [
            'meio_pagamentos' => $meio_pagamentos,
        ]);
    }

    public function next2()
    {
        if (troco() < 0)
            return back()->with('alerta', 'Valor entregue insuficiente');

        $customers = Customer::all();
        return view('seles.next2', [
            'customers' => $customers,
        ]);
    }
}
