<?php

namespace App\Http\Controllers;

use App\Models\Company;
use App\Models\Regime;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;

class CompanyController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        //$companies = Company::paginate(10);
        $companies = Company::all();
        return view('companies.index', [
            'companies' => $companies,
        ]);


    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        //if (Gate::denies('new'))
        //  return redirect()->back()->with('erro', 'Não Tens Permissão para Cadastrar');

        $regimes = Regime::all();
        return view('companies.create', [
            'regimes' => $regimes,
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
        $company = Company::create($request->all());
        if ($company) {
            upload($request, 'empresas', $company, 'logotipo');
            return redirect()->route('companies.index')->with('sucesso', 'Dados Salvo com sucesso!');
        } else {
            return redirect()->back()->with('erro', 'Erro ao salvar');
        }
    }

    /**
     * Display the specified resource.
     *
     * @param \App\Models\Company $company
     * @return \Illuminate\Http\Response
     */
    public function show(Company $company)
    {
        //if (Gate::denies('view'))
        // return redirect()->back()->with('erro', 'Não Tens Permissão para vizualizar este Item');

        $regimes = Regime::all();
        return view('companies.show', [
            'regimes' => $regimes,
            'company' => $company,
        ]);
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param \App\Models\Company $company
     * @return \Illuminate\Http\Response
     */
    public function edit(Company $company)
    {
        //if (Gate::denies('update'))
        // return redirect()->back()->with('erro', 'Não Tens Permissão para alterar este Item');

        $regimes = Regime::all();
        return view('companies.edit', [
            'regimes' => $regimes,
            'company' => $company,
        ]);
    }

    /**
     * Update the specified resource in storage.
     *
     * @param \Illuminate\Http\Request $request
     * @param \App\Models\Company $company
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, Company $company)
    {

        if ($company->update($request->all())) {
            upload($request, 'empresas', $company, 'logotipo');

            return redirect()->route('companies.index')->with('sucesso', 'Dados Alterado com sucesso!');
        } else {
            return redirect()->back()->with('erro', 'Erro ao Alterar');
        }
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param \App\Models\Company $company
     * @return \Illuminate\Http\Response
     */
    public function destroy(Company $company)
    {
        //if (Gate::denies('delete'))
        // return redirect()->back()->with('erro', 'Não Tens Permissão para eliminar este Item');

        if ($company->delete()) {
            Storage::deleteDirectory('empresas');
            return redirect()->route('companies.index')->with('sucesso', 'Dados Eliminado com sucesso!');
        } else {
            return redirect()->back()->with('erro', 'Erro ao Eliminar');
        }
    }
}
