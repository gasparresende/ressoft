<?php

namespace App\Exports;

use App\Models\Contas;
use App\Models\Razao;
use Illuminate\Support\Facades\DB;
use Maatwebsite\Excel\Concerns\FromCollection;

class PagamentosExport implements FromCollection
{

    public function __construct($contas_id, $data_inicio, $data_final)
    {
        $this->contas_id = $contas_id;
        $this->data_inicio = $data_inicio;
        $this->data_final = $data_final;
    }


    public function collection()
    {
        $saldo_anterior = 0;
        $saldo_final = 0;

        if (!is_null($this->data_inicio) && !is_null($this->data_final)) {
            $res = DB::table('clientes')
                ->join('contas', 'contas.id', 'clientes.contas_id')
                ->join('razao', 'razao.contas_id', 'contas.id')
                //->where('razao.contas_id', 'LIKE', '%' . $this->contas_id . '%')
                ->where('razao.contas_id', $this->contas_id)
                ->whereBetween('data_movimento', [$this->data_inicio, $this->data_final])
                ->orderBy('data_movimento')->orderBy('razao.id')
                //->groupBy('clientes.id')
                ->get()->all();

            //Saldo anterior
            $res2 = DB::table('clientes')
                ->join('contas', 'contas.id', 'clientes.contas_id')
                ->join('razao', 'razao.contas_id', 'contas.id')
                #->where('razao.contas_id', 'LIKE', '%' . $this->contas_id . '%')
                ->where('razao.contas_id',  $this->contas_id )
                ->whereDate('data_movimento', '<', $this->data_inicio)
                ->orderBy('data_movimento')
                ->get()->all();

            $d = 0;
            $c = 0;
            foreach ($res2 as $row) {
                $d += $row->debito;
                $c += $row->credito;
                $saldo_anterior = $d - $c;
            }
            //fim saldo anterior
        } else {
            $res = DB::table('clientes')
                ->join('contas', 'contas.id', 'clientes.contas_id')
                ->join('razao', 'razao.contas_id', 'contas.id')
                ->where('razao.contas_id', 'LIKE', '%' . $this->contas_id . '%')
                ->orderBy('data_movimento')->orderBy('razao.id')
                //->groupBy('clientes.id')
                ->get()->all();
        }

        $collection = collect([
            (object)[
                'Data Início: ' . $this->data_inicio,
                'Data Final: ' . $this->data_final,
            ]
        ]);

        $collection->add([
            [
                'Data',
                'Conta',
                'Nome do Cliente',
                'Débito',
                'Crédito',
                //'Saldo Devedor',
                //'Saldo Credor',
                'Saldo',
            ]
        ]);

        $collection->add([
            [
                null,
                null,
                'Saldo anterior',
                null,
                null,
                $saldo_anterior,
            ]
        ]);

        $total_dev = 0;
        $total_cre = 0;
        $saldo_final = $saldo_anterior;

        foreach ($res as $row) {
            $tipo_saldo = ($row->debito > $row->credito) ? "Saldo devedor" : "Saldo credor";
            $saldo_dev = ($row->debito > $row->credito) ? $row->debito - $row->credito : 0;
            $saldo_cre = ($row->debito > $row->credito) ? 0 : $row->credito - $row->debito;
            $total_dev += $saldo_dev;
            $total_cre += $saldo_cre;
            $saldo_final += $row->debito - $row->credito;

            $collection->add([
                [
                    date('d-m-Y', strtotime($row->data_movimento)),
                    $row->plano_de_contas,
                    $row->nome,
                    $row->debito,
                    $row->credito,
                    //$saldo_dev,
                    //$saldo_cre,
                    //$saldo_dev - $saldo_cre,
                    $saldo_final
                ]
            ]);
        }

        $collection->add([
            [
                'Total',
                null,
                null,
                $total_dev,
                $total_cre,
                $total_dev - $total_cre + $saldo_anterior,
            ]
        ]);

        return $collection;

//        dd($res);
    }
}
