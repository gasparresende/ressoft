<?php

namespace App\Exports;

use App\Models\Contas;
use App\Models\Razao;
use Illuminate\Contracts\View\View;
use Illuminate\Support\Facades\DB;
use Maatwebsite\Excel\Concerns\FromCollection;
use Maatwebsite\Excel\Concerns\FromView;

class BalanceteExport implements FromView
{

    public function __construct($contas_id, $data_inicio, $data_final)
    {
        $this->contas_id = $contas_id;
        $this->data_inicio = $data_inicio;
        $this->data_final = $data_final;
    }


    public function view(): View
    {


        if (!is_null($this->data_inicio) || !is_null($this->data_final)) {

            if ($this->contas_id == '%') {
                $res = DB::table('razao')
                    ->select(DB::raw(
                        '
                *,
                plano_de_contas,
                contas_id,
                descricao,
                SUM(debito) as tot_deb,
                SUM(credito) as tot_cre
                '
                    ))
                    ->join('contas', 'contas.id', 'razao.contas_id')
                    //->where('contas_id', $this->contas_id)
                    ->whereBetween('data_movimento', [$this->data_inicio, $this->data_final])
                    ->groupBy('razao.contas_id')
                    ->orderBy('plano_de_contas')
                    ->get();
            } else {
                $res = DB::table('razao')
                    ->select(DB::raw(
                        '
                *,
                plano_de_contas,
                contas_id,
                descricao,
                SUM(debito) as tot_deb,
                SUM(credito) as tot_cre
                '
                    ))
                    ->join('contas', 'contas.id', 'razao.contas_id')
                    ->where('contas_id', $this->contas_id)
                    ->whereBetween('data_movimento', [$this->data_inicio, $this->data_final])
                    ->groupBy('razao.contas_id')
                    ->orderBy('plano_de_contas')
                    ->get();
            }


        } else {

            if ($this->contas_id == '%') {
                $res = DB::table('razao')
                    ->select(DB::raw(
                        '
                *,
                plano_de_contas,
                descricao,
                SUM(debito) as tot_deb,
                SUM(credito) as tot_cre
                '
                    ))
                    ->join('contas', 'contas.id', 'razao.contas_id')
                    ->groupBy('razao.contas_id')
                    ->orderBy('plano_de_contas')
                    ->get();
            } else {
                $res = DB::table('razao')
                    ->select(DB::raw(
                        '
                *,
                plano_de_contas,
                descricao,
                SUM(debito) as tot_deb,
                SUM(credito) as tot_cre
                '
                    ))
                    ->join('contas', 'contas.id', 'razao.contas_id')
                    ->where('contas_id', $this->contas_id)
                    ->groupBy('razao.contas_id')
                    ->orderBy('plano_de_contas')
                    ->get();
            }


        }

        return view('excel.balancete', [
            'data' => $res->first(),
            'dados' => $res->where('tipo', '!=', 'Custos')->where('tipo', '!=', 'Proveitos'),
            'dados2' => $res->where('plano_de_contas', '>=', 60)->where('plano_de_contas', '<=', 79),
            'inicio' => $this->data_inicio,
            'final' => $this->data_final,
        ]);
    }
}
