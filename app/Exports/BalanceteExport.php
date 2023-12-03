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
    private $parametros;

    public function __construct($contas_id, $data_inicio, $data_final)
    {
        $this->parametros = [
            'contas_id' => $contas_id,
            'data_inicio' => $data_inicio,
            'data_final' => $data_final,
        ];
    }


    public function view(): View
    {

        $contas = DB::table('contas')
            ->orderBy('conta')
            ->where('tipo', 'Activo')
            ->orWhere('tipo', 'Passivo')
            ->orWhere('tipo', 'Capital Próprio')
            ->orWhere('tipo', 'Resultados')
            ->get();

        $contas2 = DB::table('contas')
            ->orderBy('conta')
            //->where('tipo', 'Capital Próprio')
            ->Where('tipo', 'Custos')
            ->orWhere('tipo', 'Proveitos')
            ->get();

        $this->parametros['contas'] = $contas;

        $this->parametros['contas2'] = $contas2;

        return view('excel.balancete', $this->parametros);
    }
}
