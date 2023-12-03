<?php

namespace App\Http\Controllers;

use App\Models\Empresa;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Gate;
use Yajra\DataTables\DataTables;

class EmpresaController extends Controller
{
    protected $empresa;

    public function __construct(Empresa $empresa)
    {
        $this->empresa = $empresa;
    }

    public function index()
    {
        $empresas = $this->empresa->readAll();
        $regimes = DB::table('regimes')->get();
        $taxas = DB::table('taxas')->get();
        return view('empresas.index', compact('empresas', 'regimes', 'taxas'));
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

        $inserir = DB::table('empresas')->updateOrInsert(['id' => $request->id], $request->except('_token'));

        if ($inserir) {
            if (isset($request->logotipo_empresa)) {
                $empresa = Empresa::all()->find($request->id);
                $up = upload('empresas/' . $empresa->id, $request->logotipo_empresa);
                $empresa->update([
                    'logotipo_empresa' => $up
                ]);
            }
            return redirect()->back()->with("sucesso", "Dados Salvo com sucesso!");
        } else
            return redirect()->back()->with("erro", "Erro ao Salvar");
    }

    /**
     * Display the specified resource.
     *
     * @param \App\Models\Empresa $empresas
     * @return \Illuminate\Http\Response
     */
    public function show(Request $request)
    {
        echo json_encode(DB::table('empresas')->where('id', $request->id)
            ->get());
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param \App\Models\Empresa $empresas
     * @return \Illuminate\Http\Response
     */
    public function edit(Empresa $empresa)
    {

    }

    /**
     * Update the specified resource in storage.
     *
     * @param \Illuminate\Http\Request $request
     * @param \App\Models\Empresa $empresas
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, Empresa $empresa)
    {
        if ($empresa->update($request->all()))
            return redirect()->route('empresas.index')->with('sucesso', 'Dados Alterado com sucesso!!');
        else
            return redirect()->back()->with('erro', 'Erro ao alterar');
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param \App\Models\Empresa $empresas
     * @return \Illuminate\Http\Response
     */
    public function destroy(Empresa $empresa)
    {
        if ($empresa->delete()) {

            return redirect()->route('empresas.index')->with('sucesso', 'Dados Removido com sucesso!!');
        } else {
            return redirect()->route('empresas.index')->with('erro', 'Erro ao eliminar');
        }
    }

    public function delete(Request $request)
    {

        if (DB::table('empresas')->where('id', $request->id)->delete()) {
            DB::statement("ALTER TABLE empresas AUTO_INCREMENT =  $request->id");
            return redirect()->back()->with('sucesso', 'Dados eliminado com sucesso!!');
        } else {
            return redirect()->back()->with('erro', 'Erro ao eliminar');
        }
    }

    public function listar()
    {
        $empresas = DB::table('empresas')
            ->leftJoin('regimes', 'regimes.id', 'empresas.regimes_id')
            ->leftJoin('taxas', 'taxas.id', 'empresas.taxas_id')
            ->select([
                '*',
                'empresas.id as id'
            ])->get();

        $dados = [];
        foreach ($empresas as $empresa) {
            array_push($dados, [
                'id' => $empresa->id,
                'nome_empresa' => $empresa->nome_empresa,
                'email_empresa' => $empresa->email_empresa,
                'telemovel_empresa' => $empresa->telemovel_empresa,
                'motivo' => $empresa->motivo,
                'taxa' => $empresa->taxa . ' %',
            ]);
        }

        return DataTables::of($dados)
            ->make(true);
    }
}
