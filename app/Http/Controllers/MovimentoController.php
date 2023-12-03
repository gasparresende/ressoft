<?php

namespace App\Http\Controllers;

use App\Models\Conta;
use App\Models\Movimento;
use App\Models\Registo;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Gate;
use Yajra\DataTables\DataTables;

class MovimentoController extends Controller
{
    public function index()
    {
        $contas = DB::table('contas')->orderBy('conta')->get();
        return view('movimentos.index', [
            'contas' => $contas,
        ]);
    }

    public function delete(Request $request)
    {

        if (DB::table('movimentos')->where('id', $request->id)->delete()) {
            DB::statement("ALTER TABLE movimentos AUTO_INCREMENT =  $request->id");
            return redirect()->back()->with('sucesso', 'Dados eliminado com sucesso!!');
        } else {
            return redirect()->back()->with('erro', 'Erro ao eliminar');
        }
    }

    public function movimento()
    {
        $movimentos = DB::table('movimentos')
            ->join('contas', 'contas.id', 'movimentos.contas_id')
            ->orderByDesc('movimentos.id')
            ->limit(100)
            ->get(['*', 'movimentos.id as idr'])->all();
        $contas = Conta::all()->sortBy('conta');

        return view('movimentos.index', [
            'movimentos' => $movimentos,
            'contas' => $contas,
        ]);
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */

    public function create()
    {
        if (Gate::denies('new'))
            return redirect()->back()->with('erro', 'Não Tens Permissão para Cadastrar');

        $contas = Conta::all()->sortBy('conta');
        return view('movimentos.create', [
            'contas' => $contas
        ]);
    }

    public function especifico()
    {
        if (Gate::denies('new'))
            return redirect()->back()->with('erro', 'Não Tens Permissão para Cadastrar');

        $contas = Conta::all()->sortBy('conta');
        return view('movimentos.create2', [
            'contas' => $contas
        ]);
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param \Illuminate\Http\Request $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {


        if (isset($request->id)) {
            $dados = [
                "contas_id" => $request->debito,
                "data_operacao" => date('Y-m-d H:i:s'),
                "debito" => ($request->tipo == 'D') ? str_replace(',', '.', str_replace('.', '', $request->valor)) : 0,
                "credito" => ($request->tipo == 'C') ? str_replace(',', '.', str_replace('.', '', $request->valor)) : 0,
                "data_movimento" => $request->data_movimento,
                "razao" => $request->razao,
                "users_id" => auth()->id(),
            ];
            $inserir = DB::table('movimentos')->where('id', $request->id)->update($dados);

        } else {
            $registo = Registo::create([
                'data' => now(),
                'users_id' => auth()->id(),
            ]);

            if ($registo) {

                //Débito
                foreach ($request->debito as $key =>$debito) {

                    $dados = [
                        "debito" => str_replace(',', '.', str_replace('.', '', $request->valor[$key])),
                        "credito" => 0,
                        "contas_id" => $debito,
                        "data_operacao" => now(),
                        "data_movimento" => $request->data_movimento,
                        "razao" => $request->razao,
                        "users_id" => auth()->id(),
                        "registos_id" => $registo->id,
                    ];

                    Movimento::create($dados);
                }

                //Crédito
                foreach ($request->credito as $key => $credito) {

                    $dados = [
                        "debito" => 0,
                        "credito" => str_replace(',', '.', str_replace('.', '', $request->valor2[$key])),
                        "contas_id" => $credito,
                        "data_operacao" => now(),
                        "data_movimento" => $request->data_movimento,
                        "razao" => $request->razao,
                        "users_id" => auth()->id(),
                        "registos_id" => $registo->id,
                    ];

                    Movimento::create($dados);
                }
            } else {
                return redirect()->back()->with("erro", "Erro ao Salvar Movimento");
            }
        }

        return redirect()->route('movimentos.index')->with("sucesso", "Dados Salvo com sucesso!");
    }

    public function store2(Request $request)
    {
        $movimentos = new Movimento();

        $movimentos->debito = ($request->tipo == 1) ? str_replace(',', '.', str_replace('.', '', $request->valor)) : 0;
        $movimentos->credito = ($request->tipo == 2) ? str_replace(',', '.', str_replace('.', '', $request->valor)) : 0;
        $movimentos->contas_id = $request->contas;
        $movimentos->data_operacao = date('Y-m-d H:i:s');
        $movimentos->data_movimento = $request->data_movimento;
        $movimentos->razao = $request->razao;
        $movimentos->users_id = auth()->id();

        DB::table('movimentos')->insert($movimentos->toArray());
        return redirect()->route('movimentos.index')->with('sucesso', 'Dados Salvo com sucesso!!');
    }


    public function show(Request $request)
    {
        echo json_encode(DB::table('movimentos')->where('id', $request->id)
            ->get());
    }



    public function edit($id)
    {
        if (Gate::denies('update'))
            return redirect()->back()->with('erro', 'Não Tens Permissão para alterar este Item');

        $movimentos = Movimento::all()->where('id', $id);
//        $movimentos->load('contas')
        $contas = Conta::all()->sortBy('conta');
        return view('movimentos.edit', [
            'movimentos' => $movimentos,
            'contas' => $contas,
        ]);
    }


    public function update(Request $request, $id)
    {

        $dados = [
            'debito' => str_replace(',', '.', str_replace('.', '', $request->debito)),
            'credito' => str_replace(',', '.', str_replace('.', '', $request->credito)),
            'razao' => $request->razao,
            'contas_id' => $request->contas,
            /*'data_operacao' => date,*/
            'data_movimento' => $request->data_movimento,
        ];
        if (Movimento::all()->find($id)->update($dados))
            return redirect()->route('movimentos.index')->with('sucesso', 'Dados Alterado com sucesso!!');
        else
            return redirect()->back()->with('erro', 'Erro ao alterar');
    }


    public function destroy($id)
    {
        if (Gate::denies('delete'))
            return redirect()->back()->with('erro', 'Não Tens Permissão para eliminar este Item');

        Movimento::destroy($id);
        return redirect()->route('movimentos.movimentos')->with('sucesso', 'Dados Removido com sucesso!!');
    }

    public function listar()
    {
        $movimentos = DB::table('movimentos')
            ->join('contas', 'contas.id', 'movimentos.contas_id')
            ->select([
                '*',
                'movimentos.id as id'
            ])->get();

        $res = [];
        foreach ($movimentos as $movimento) {
            array_push($res, [
                'id' => $movimento->id,
                'razao' => $movimento->razao,
                'data_movimento' => data_formatada($movimento->data_movimento),
                'data_operacao' => data_formatada($movimento->data_operacao),
                'contas' => $movimento->conta . ' - ' . $movimento->descricao,
                'debito' => formatar_moeda($movimento->debito),
                'credito' => formatar_moeda($movimento->credito),
            ]);
        }

        return DataTables::of($res)
            ->make(true);
    }
}
