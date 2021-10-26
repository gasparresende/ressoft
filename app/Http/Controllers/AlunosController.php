<?php

namespace App\Http\Controllers;

use App\Models\Despesas;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class AlunosController extends Controller
{
    public function index()
    {
        $despesas = Despesas::all();

       return view('despesas.index', [
           'despesas' => $despesas
       ]);
    }
}
