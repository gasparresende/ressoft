<?php

namespace App\Http\Controllers;

use App\Models\Conta;
use App\Models\Movimento;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class BalanceteController extends Controller
{
    public function index()
    {
        $balancete = Movimento::all();
        $contas = Conta::all()->sortBy('conta');

        $movimentos = DB::select('SELECT * , SUM(debito) AS tot_deb, SUM(credito) AS tot_cre
                            FROM movimentos r JOIN contas c ON c.id=r.contas_id GROUP BY r.contas_id ORDER BY c.conta');

        return view('balancetes.index', [
            'balancete' => $movimentos,
            'contas' => $contas,
        ]);
    }
}
