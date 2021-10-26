<?php

namespace App\Http\Controllers;

use App\Models\Despesa;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Yajra\DataTables\DataTables;

class DespesaController extends Controller
{
    public function index()
    {
        return view('despesas.index');
    }

    public function listar()
    {
        $despesas = DB::table('despesas')->select(['id', 'descricao', 'valor']);

        return DataTables::of($despesas)
            ->make(true);
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {

    }

    /**
     * Store a newly created resource in storage.
     *
     * @param \Illuminate\Http\Request $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {


    }

    public function show(Despesa $despesa)
    {
        //
    }

    public function edit(Despesa $despesa)
    {
        //
    }


    public function update(Request $request, Despesa $despesa)
    {
        //
    }

    public function destroy(Despesa $despesa)
    {
        //
    }
}
