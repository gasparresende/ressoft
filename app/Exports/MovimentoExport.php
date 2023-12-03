<?php

namespace App\Exports;

use App\Models\Contas;
use App\Models\Movimentos;
use Illuminate\Support\Facades\DB;
use Maatwebsite\Excel\Concerns\FromCollection;

class MovimentoExport implements FromCollection
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
            $res = DB::table('contas')
                ->join('movimentos', 'movimentos.contas_id', 'contas.id')
                ->where('contas.id', 'LIKE', $this->contas_id)
                ->whereBetween('data_movimento', [$this->data_inicio, $this->data_final])
                ->orderBy('data_movimento')->orderBy('movimentos.id')
                ->get()->all();

            //Saldo anterior
            $res2 = DB::table('contas')
                ->join('movimentos', 'movimentos.contas_id', 'contas.id')
                ->where('contas.id', 'LIKE', $this->contas_id)
                ->whereDate('data_movimento', '<', $this->data_inicio)
                ->orderBy('data_movimento')->orderBy('movimentos.id')
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
            $res = DB::table('contas')
                ->join('movimentos', 'movimentos.contas_id', 'contas.id')
                ->where('contas.id', 'LIKE', $this->contas_id)
                ->orderBy('data_movimento')->orderBy('movimentos.id')
                ->get()->all();
        }

        #dd($res, $res2, $saldo_anterior);


        $collection = collect([
            (object)[
                'Data Início: ' . $this->data_inicio,
                'Data Final: ' . $this->data_final,
            ]
        ]);

        $collection->add([
            [
                'Data Movimento',
                'Descrição',
                'Débito',
                'Crédito',
                'Saldo',
            ]
        ]);

        $collection->add([
            [
                null,
                'Saldo anterior',
                $saldo_anterior > 0? $saldo_anterior : 0,
                $saldo_anterior < 0? $saldo_anterior : 0,
                $saldo_anterior,
            ]
        ]);

        $debito = $saldo_anterior > 0? $saldo_anterior : 0 ;
        $credito = $saldo_anterior < 0? $saldo_anterior : 0;

        /*$debito = 0 ;
        $credito = 0;*/
        $saldo_final = $saldo_anterior;

        foreach ($res as $row) {
            $debito += $row->debito;
            $credito += $row->credito;
            $saldo_final += $row->debito - $row->credito;

            $collection->add([
                [
                    date('d-m-Y', strtotime($row->data_movimento)),
                    $row->razao,
                    $row->debito,
                    $row->credito,
                    //$row->debito - $row->credito,
                    $saldo_final
                ]
            ]);
        }

        $collection->add([
            [
                'TOTAL',
                null,
                $debito,
                $credito,
                $saldo_final,
            ]
        ]);

        return $collection;

//        dd($res);
    }
}
