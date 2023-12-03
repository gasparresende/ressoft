<?php

namespace App\Http\Controllers;

use App\Exports\BalanceteExport;
use App\Exports\BancosExport;
use App\Exports\CaixasExport;
use App\Exports\PagamentosExport;
use App\Exports\MovimentoExport;
use App\Exports\DividasExport;
use Illuminate\Http\Request;
use Maatwebsite\Excel\Facades\Excel;

class ExcelController extends Controller
{
    public function export_balancete(Request $request)
    {
        return Excel::download(new BalanceteExport($request->contas_id, $request->data_inicio, $request->data_final), 'balancete.xlsx');
    }


    public function export_movimentos(Request $request)
    {
        return Excel::download(new MovimentoExport($request->contas_id, $request->data_inicio, $request->data_final), 'extracto_movimento.xlsx');
    }

    public function export_pagamentos(Request $request)
    {
        return Excel::download(new PagamentosExport($request->contas_id, $request->data_inicio, $request->data_final), 'pagamentos-receber_clientes.xlsx');
    }

    public function export_dividas(Request $request)
    {
        return Excel::download(new DividasExport($request->contas_id, $request->data_inicio, $request->data_final), 'dividas-pagar_fornecedores.xlsx');
    }

    public function export_caixas(Request $request)
    {
        return Excel::download(new CaixasExport($request->contas_id, $request->data_inicio, $request->data_final), 'relatorio-caixas.xlsx');
    }

    public function export_bancos(Request $request)
    {
        return Excel::download(new BancosExport($request->contas_id, $request->data_inicio, $request->data_final), 'relatorio-bancos.xlsx');
    }

}
