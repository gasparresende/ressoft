<?php

namespace App\Http\Controllers;

use App\Models\ContasBancariaEmpresas;
use App\Models\Factura;
use Barryvdh\DomPDF\Facade\Pdf;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use SimpleSoftwareIO\QrCode\Facades\QrCode;
use Yajra\DataTables\DataTables;

//use Dompdf\Dompdf as PDF;

class FacturaController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Contracts\Foundation\Application|\Illuminate\Contracts\View\Factory|\Illuminate\Contracts\View\View|\Illuminate\Http\Response
     */
    public function index()
    {
        $facturas = Factura::all()
            ->where('tipo', 0)
            ->where('status', 1);


        return view('facturas.index', [
            'facturas' => $facturas
        ]);

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
     * @param \App\Models\Factura $factura
     * @return \Illuminate\Http\Response
     */
    public function show(Factura $factura)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param \App\Models\Factura $factura
     * @return \Illuminate\Http\Response
     */
    public function edit(Factura $factura)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param \Illuminate\Http\Request $request
     * @param \App\Models\Factura $factura
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, Factura $factura)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param \App\Models\Factura $factura
     * @return \Illuminate\Http\Response
     */
    public function destroy(Factura $factura)
    {
        //
    }

    public function listar()
    {
        $facturas = DB::table('facturas')
            ->leftJoin('clientes', 'clientes.id', 'facturas.clientes_id')
            ->join('tipos', 'tipos.id', 'facturas.tipos_id')
            ->where('facturas.tipo', 0)
            ->where('status', 1)
            ->orderByDesc('data_emissao')
            //->limit(20)
            ->get([
                '*',
                'facturas.id as id',
                'tipos.tipo as tipo',
            ]);

        $dados = [];
        foreach ($facturas as $item) {
            array_push($dados, [
                'id' => $item->id,
                'numero' => $item->sigla . ' ' . $item->numero . ' - ' . $item->mes . '/' . $item->ano,
                'nome' => $item->nome == null ? 'Consumidor Final' : $item->nome,
                'tipo' => $item->tipo,
                'sigla' => $item->sigla,
                'valor_total' => formatar_moeda($item->valor_total),
                'data_emissao' => data_formatada($item->data_emissao),
            ]);
        }

        return DataTables::of($dados)
            ->make(true);
    }


    public function preview_facturas(Request $request, $termica = false, $imprimir = true)
    {

        //$facturas = Facturas::all()->where('id', $request->id);
        $facturas = DB::table('facturas')
            ->join('facturas_products', 'facturas_products.facturas_id', 'facturas.id')
            ->join('inventories', 'inventories.id', 'facturas_products.inventories_id')
            ->join('products', 'products.id', 'inventories.products_id')
            ->leftJoin('clientes', 'clientes.id', 'facturas.clientes_id')
            ->leftJoin('users', 'users.id', 'facturas.users_id')
            ->leftjoin('unidades', 'unidades.id', 'products.unidades_id')
            ->leftjoin('regimes', 'regimes.id', 'products.regimes_id')
            ->leftjoin('moedas', 'moedas.id', 'facturas.moedas_id')
            ->where('facturas.id', $request->id)
            ->groupBy('inventories.id')
            ->selectRaw('*, sum(facturas_products.qtd) as qtd, inventories.id as id_servico, facturas.id as num, moedas.preco as pmoeda, facturas_products.preco as preco')
            ->get();


        $url = route('factura.qrcode', [
            'id' => $request->id,
            'valor_total' => $facturas->first()->valor_total,
            'clientes_id' => $facturas->first()->clientes_id,
            'mes' => $facturas->first()->mes,
        ]);

        $qrcode = base64_encode(QrCode::format('svg')->style('round')->size(75)->color(35, 107, 142)->errorCorrection('H')->generate($url));
        $sigla = tipo_documento($facturas->first()->tipos_id)->sigla;
        $tipo = tipo_documento($facturas->first()->tipos_id)->tipo . " Nº " . $sigla;

        #$dompdf->setPaper('A5');
        #$dompdf->setPaper([0, 0, 807.874, 221.102], 'landscape');
        #$dompdf->setPaper([0, 0, 700, 300], 'landscape');
        $customPaper = array(0, 0, 807.874, 222);

        if ($termica) {
            $pdf = PDF::loadView('report.factura_termica', [
                'facturas' => $facturas,
                'factura' => $facturas->first(),
                'tipo' => $tipo,
                't' => $sigla,
                'bancos' => ContasBancariaEmpresas::all(),
                'qrcode' => $qrcode,
                'img' => true,
            ])->setPaper($customPaper, 'landscape');
        } else {
            $pdf = PDF::loadView('report.factura', [
                'facturas' => $facturas,
                'factura' => $facturas->first(),
                'tipo' => $tipo,
                't' => $sigla,
                'bancos' => ContasBancariaEmpresas::all(),
                'qrcode' => $qrcode,
                'img' => true,
            ]);
        }

        if ($imprimir) {

            $path = "print/file_imprimir.pdf";
            $pdf->save($path);
            imprimir($path);
            return redirect()->back()->with('success', 'Factura impressa com sucesso!') ;

        } else {


            return $pdf->download($tipo . ' - ' . $facturas->first()->numero . ' - ' . $facturas->first()->nome . '.pdf');

        }


    }

    public function preview_facturas_consulta(Request $request, $termica = false, $imprimir = true)
    {

        //$facturas = Facturas::all()->where('id', $request->id);
        $facturas = DB::table('facturas')
            ->join('facturas_products', 'facturas_products.facturas_id', 'facturas.id')
            ->join('inventories', 'inventories.id', 'facturas_products.inventories_id')
            ->join('products', 'products.id', 'inventories.products_id')
            ->leftJoin('clientes', 'clientes.id', 'facturas.clientes_id')
            ->leftJoin('users', 'users.id', 'facturas.users_id')
            ->leftjoin('unidades', 'unidades.id', 'products.unidades_id')
            ->leftjoin('regimes', 'regimes.id', 'products.regimes_id')
            ->leftjoin('moedas', 'moedas.id', 'facturas.moedas_id')
            ->where('facturas.id', $request->id)
            ->get(['*', 'inventories.id as id_servico', 'facturas.id as num', 'moedas.preco as pmoeda', 'facturas_products.preco as preco', 'facturas_products.qtd as qtd']);


        $url = route('factura.qrcode', [
            'id' => $request->id,
            'valor_total' => $facturas->first()->valor_total,
            'clientes_id' => $facturas->first()->clientes_id,
            'mes' => $facturas->first()->mes,
        ]);

        $qrcode = base64_encode(QrCode::format('svg')->style('round')->size(75)->color(35, 107, 142)->errorCorrection('H')->generate($url));
        $sigla = tipo_documento($facturas->first()->tipos_id)->sigla;
        $tipo = tipo_documento($facturas->first()->tipos_id)->tipo . " Nº " . $sigla;
        if ($imprimir) {

            #$dompdf->setPaper('A5');
            #$dompdf->setPaper([0, 0, 807.874, 221.102], 'landscape');
            #$dompdf->setPaper([0, 0, 700, 300], 'landscape');
            $customPaper = array(0, 0, 807.874, 222);

            if ($termica) {
                $pdf = PDF::loadView('report.factura_termica', [
                    'facturas' => $facturas,
                    'factura' => $facturas->first(),
                    'tipo' => $tipo,
                    't' => $sigla,
                    'bancos' => ContasBancariaEmpresas::all(),
                    'qrcode' => $qrcode,
                    'img' => true,
                ])->setPaper($customPaper, 'landscape');
            } else {
                $pdf = PDF::loadView('report.factura', [
                    'facturas' => $facturas,
                    'factura' => $facturas->first(),
                    'tipo' => $tipo,
                    't' => $sigla,
                    'bancos' => ContasBancariaEmpresas::all(),
                    'qrcode' => $qrcode,
                    'img' => true,
                ]);
            }

            return $pdf->download($tipo . ' - ' . $facturas->first()->numero . ' - ' . $facturas->first()->nome . '.pdf');
        }


    }

    public function factura_hash(Request $request)
    {


        //$facturas = Facturas::all()->where('id', $request->id);
        $facturas = DB::table('facturas')
            ->join('facturas_products', 'facturas_products.facturas_id', 'facturas.id')
            ->join('inventories', 'inventories.id', 'facturas_products.inventories_id')
            ->join('products', 'products.id', 'inventories.products_id')
            ->leftJoin('clientes', 'clientes.id', 'facturas.clientes_id')
            ->leftJoin('users', 'users.id', 'facturas.users_id')
            ->leftjoin('unidades', 'unidades.id', 'products.unidades_id')
            ->leftjoin('regimes', 'regimes.id', 'products.regimes_id')
            ->leftjoin('moedas', 'moedas.id', 'facturas.moedas_id')
            ->where('facturas.id', $request->id)
            ->get(['*', 'inventories.id as id_servico', 'facturas.id as num', 'moedas.preco as pmoeda', 'facturas_products.preco as punitario']);

        $url = route('factura.qrcode', ['id' => $request->id, 'token' => $facturas->first()->hash]);
        $qrcode = base64_encode(QrCode::format('svg')->style('dot')->size(75)->color(35, 107, 142)->errorCorrection('H')->generate($url));

        $sigla = tipo_documento($facturas->first()->tipos_id)->sigla;
        $tipo = tipo_documento($facturas->first()->tipos_id)->tipo . " Nº " . $sigla;

        $pdf = PDF::loadView('report.factura', [
            'facturas' => $facturas,
            'factura' => $facturas->first(),
            'tipo' => $tipo,
            't' => $sigla,
            'bancos' => ContasBancariaEmpresas::all(),
            'qrcode' => $qrcode,
            'img' => true,
        ]);
        return $pdf->download($tipo . ' - ' . $facturas->first()->numero . ' - ' . $facturas->first()->nome . '.pdf');
    }
}
