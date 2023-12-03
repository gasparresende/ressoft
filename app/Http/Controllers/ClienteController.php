<?php

namespace App\Http\Controllers;

use App\Http\Requests\ClienteRequest;
use App\Models\Cliente;
use App\Models\Contas;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Gate;
use Yajra\DataTables\DataTables;

class ClienteController extends Controller
{

    public function index()
    {
        return view('clientes.index');
    }


    public function store(ClienteRequest $request)
    {

        $inserir = DB::table('clientes')->updateOrInsert(['id' => $request->id], $request->except('_token'));

        if ($inserir)
            return redirect()->back()->with("sucesso", "Dados Salvo com sucesso!");
        else
            return redirect()->back()->with("erro", "Erro ao Salvar");
    }


    public function show(Request $request)
    {
        echo json_encode(DB::table('clientes')->where('id', $request->id)
            ->get());
    }




    public function pagamentos()
    {

        $contas = Contas::all()->sortBy('plano_de_contas');
        $pagamentos = DB::select('
SELECT
     *,
     sum(debito) AS deb,
     sum(credito) AS cred
FROM
     clientes c
     JOIN contas co ON c.contas_id = co.id
     JOIN razao r ON co.id = r.contas_id
     group by c.id
 ');
        //dd($contas->plano_de_contas);
        return view('clientes.pagamentos', [
            'clientes' => $pagamentos,
            'contas' => $contas,
        ]);
    }


    public function update(Request $request, Cliente $cliente)
    {
        if ($cliente->update($request->all()))
            return redirect()->route('clientes.index')->with('sucesso', 'Dados Alterado com sucesso!!');
        else
            return redirect()->back()->with('erro', 'Erro ao alterar');
    }


    public function destroy(Cliente $cliente)
    {
        if ($cliente->delete()) {
            return redirect()->route('clientes.index')->with('sucesso', 'Dados Removido com sucesso!!');
        } else {
            return redirect()->route('clientes.index')->with('erro', 'Erro ao eliminar');
        }
    }

    public function delete(Request $request)
    {

        if (DB::table('clientes')->where('id', $request->id)->delete()) {
            DB::statement("ALTER TABLE clientes AUTO_INCREMENT =  $request->id");
            return redirect()->back()->with('sucesso', 'Dados eliminado com sucesso!!');
        } else {
            return redirect()->back()->with('erro', 'Erro ao eliminar');
        }
    }

    public function listar()
    {
        $clientes = DB::table('clientes')
            ->select([
                '*',
            ]);

        return DataTables::of($clientes)
            ->make(true);
    }

    public function teste()
    {
        return Cliente::all();
    }

}
