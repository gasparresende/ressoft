<?php

namespace App\Http\Controllers;

use App\Models\Mesa;
use App\Models\MesaStatu;
use App\Models\Statu;
use App\Models\StatusMesa;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Yajra\DataTables\DataTables;

class MesaController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Contracts\Foundation\Application|\Illuminate\Contracts\View\Factory|\Illuminate\Contracts\View\View|\Illuminate\Http\Response
     */
    public function index()
    {
        return view('mesas.index');
    }

    public function abrir()
    {

        $status_id = [];
        foreach (Mesa::all() as $item) {
            $status_mesas = StatusMesa::all()
                ->where('mesas_id', $item->id)
                ->whereIn('status_id', [1, 4])
                ->last();

            $status_id[] = $status_mesas ? $status_mesas->mesas_id : null;

        }
        $mesas = Mesa::all()->whereNotIn('id', $status_id);

        return view('mesas.abrir', [
            'mesas' => $mesas,
            'users' => User::all(),
            'status' => Statu::all()->whereIn('id', [1, 4]),
        ]);
    }

    public function abrir_store(Request $request)
    {
        if (isset($request->origem_pedido)) {
            $dados = [
                'mesas_id' => $request->mesas_id,
                'status_id' => 1,
                'users_id' => $request->users_id,
                'data' => now()
            ];
        } else {
            $request->validate([
                'mesas_id' => 'required',
                'status_id' => 'required',
            ]);
            $dados = [
                'mesas_id' => $request->mesas_id,
                'status_id' => $request->status_id,
                'users_id' => $request->users_id,
                'data' => now()
            ];

            //$mesa = Mesa::find($request->mesas_id);
            //$mesa->status_id = $request->status_id;

        }

        if (StatusMesa::create($dados)) {
            if (isset($request->origem_pedido))
                return redirect()->back()->with("sucesso", "Mesa aberta com sucesso!");
            return redirect()->route('mesas.index')->with("sucesso", "Mesa aberta com sucesso!");
        } else
            return redirect()->back()->with("erro", "Erro ao abrir mesa")->withInput();
    }

    public function fechar()
    {

    }

    public function historico()
    {

    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param \Illuminate\Http\Request $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        //
    }

    /**
     * Display the specified resource.
     *
     * @param \App\Models\Mesa $mesa
     * @return \Illuminate\Http\Response
     */
    public function show(Mesa $mesa)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param \App\Models\Mesa $mesa
     * @return \Illuminate\Http\Response
     */
    public function edit(Mesa $mesa)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param \Illuminate\Http\Request $request
     * @param \App\Models\Mesa $mesa
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, Mesa $mesa)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param \App\Models\Mesa $mesa
     * @return \Illuminate\Http\Response
     */
    public function destroy(Mesa $mesa)
    {
        //
    }

    public function listar()
    {
        $mesas = DB::table('mesas')->get();

        $dados = [];
        foreach ($mesas as $mesa) {
            $status_mesas = StatusMesa::with('users')->with('status')->where('mesas_id', $mesa->id)
                ->get()->last();
            $dados[] = [
                'id' => $mesa->id,
                'mesa' => $mesa->mesa,
                'statu' => $status_mesas ? $status_mesas->status->statu : '',
                'username' => $status_mesas ? $status_mesas->users->username : '',
                'data' => $status_mesas ? data_formatada($status_mesas->data) : '',
            ];
        }

        return DataTables::of($dados)
            ->make(true);
    }
}
