<?php

namespace App\Http\Controllers;

use App\Models\Cliente;
use App\Models\ContasBancariaEmpresas;
use App\Models\Factura;
use App\Models\FacturasProduct;
use App\Models\Imposto;
use App\Models\Impostos;
use App\Models\Inventory;
use App\Models\inventories;
use App\Models\Moeda;
use App\Models\Shop;
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
            'facturas' => $facturas,
        ]);

    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        $inventories = Inventory::with('products')->with('sizes')
            ->with('colors')->with('categorias')->with('marcas')
            ->where('qtd', '>', 0);

        $shops = Shop::all();

        if (!auth()->user()->hasRole('Admin')) {
            $shops_users = DB::table('users_shops')->where('users_id', auth()->id())->get();
            $inventories = $inventories
                ->whereIn('shops_id', $shops_users->pluck('shops_id'));

            $shops = Shop::all()->whereIn('id', $shops_users->pluck('shops_id'));

        }

        $unidades = DB::table('unidades')->get();
        $marcas = DB::table('marcas')->get();
        $categorias = DB::table('categorias')->get();

        return view('facturas.create', [
            'inventories' => $inventories->get(),
            'unidades' => $unidades,
            'marcas' => $marcas,
            'categorias' => $categorias,
            'shops' => $shops,
        ]);
    }



    public function store(Request $request)
    {

        $factura = Factura::all()
            ->where('ano', $request->ano)
            ->where('tipos_id', $request->tipos_id)
            ->last();
        $factura_anterior = Factura::all()->last();


        $numero = is_null($factura) ? 1 : $factura->numero + 1;

        $request['valor_total'] = str_replace(',', '.', str_replace('.', '', $request->valor));
        $request['data_emissao'] = now();
        $request['users_id'] = auth()->id();
        $request['numero'] = $numero;

        $prev_hash = (is_null($factura_anterior)) ? null : $factura_anterior->hash;

        $factura = Factura::create($request->all());
        if ($factura) {
            //Assinaturaacturas
            //2018-05-18;2018-05-18T11:22:19;FAC 001/18;53.002;
            $dados_hash = date('Y-m-d') . ';' . date('Y-m-d H:i:s') . ';' . tipo_documento($factura->tipos_id)->sigla . " " .
                $numero . '/' . $factura->ano . ';' . $factura->valor_total . $prev_hash;

            $factura->update([
                'hash' => assinarHash64($dados_hash)
            ]);

            //


            $retencao = 0;
            foreach (session('carrinho_factura') as $key => $cart) {

                $desconto = $cart['valor'] * ($cart['desc'] / 100);
                $retencao += ($cart['tipo'] == 1) ? ($cart['valor'] - $desconto) * 0.065 : 0;
                $dados = [
                    'desconto' => $cart['desc'],
                    'facturas_id' => $factura->id,
                    'inventories_id' => $key,
                    'qtd' => $cart['qtd'],
                    'preco' => $cart['valor'],
                ];

                FacturasProduct::create($dados);

                $carrinho = session()->get('carrinho_factura');
                if (isset($carrinho[$key])) {
                    unset($carrinho[$key]);
                    session()->put('carrinho_factura', $carrinho);
                }
            }
            $factura->update([
                'retencao' => $retencao
            ]);


            return redirect()->route('facturas.index')->with('sucesso', 'Factura finalizada com sucesso!!');
        } else
            return redirect()->back()->with('erro', 'Erro ao finalizar Factura');
    }


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


    public function preview_facturas(Request $request, $imprimir = false)
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

        $dados = [];
        $total = 0;
        foreach ($facturas as $factura) {
            $regime = $factura->regimes_id ? " [$factura->codigo]" : "";
            $dados[]=[
                'id'=>$factura->id_servico,
                'qtd'=>$factura->qtd,
                'unidade'=>$factura->unidade,
                'preco'=>$factura->preco_venda,
                'desconto'=>$factura->desconto,
                'preco_total'=>$factura->preco_venda * $factura->qtd,
                'product'=>str_contains($factura->product, 'Serviço')? $factura->product. "- Ref. ".$factura->mes. $regime : $factura->product.$regime,
            ];

            $total +=$factura->preco_venda * $factura->qtd;
        }

        $pdf = PDF::loadView('report.factura', [
            'facturas' => $dados,
            'factura' => $facturas->first(),
            'tipo' => $tipo,
            't' => $sigla,
            'bancos' => ContasBancariaEmpresas::all(),
            'qrcode' => $qrcode,
            'img' => true,
            'dados_finais'=>[
                'total'=>$total,
                'desconto'=>$facturas->first()->desconto,
                'retencao'=>0,
                'imposto'=>0,
                'total_final'=>0,
            ],
        ]);

        if (false) {

            $path = "print/file_imprimir.pdf";
            $pdf->save($path);
            imprimir($path);
            return redirect()->back()->with('success', 'Factura impressa com sucesso!');

        } else {

            return $pdf->download($tipo . ' - ' . $facturas->first()->numero . ' - ' . $facturas->first()->nome . '.pdf');

        }


    }

    public function preview_termica(Request $request, $imprimir = false)
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

        $pdf = PDF::loadView('report.factura_termica', [
            'facturas' => $facturas,
            'factura' => $facturas->first(),
            'tipo' => $tipo,
            't' => $sigla,
            'bancos' => ContasBancariaEmpresas::all(),
            'qrcode' => $qrcode,
            'img' => true,
        ])->setPaper($customPaper, 'landscape');

        if (false) {

            $path = "print/file_imprimir.pdf";
            $pdf->save($path);
            imprimir($path);
            return redirect()->back()->with('success', 'Factura impressa com sucesso!');

        } else {


            return $pdf->download($tipo . ' - ' . $facturas->first()->numero . ' - ' . $facturas->first()->nome . '.pdf');

        }


    }

    public function finalizar()
    {
        $clientes = Cliente::all();
        $moeda = Moeda::all();
        $impostos = Imposto::all();
        $tipos = DB::table('tipos')->get()->where('id', '!=', 3);

        $total = 0;
        if (session('carrinho_factura')) {
            foreach (session('carrinho_factura') as $key => $cart) {
                $valor_desc = ($cart['valor'] - ($cart['valor'] * ($cart['desc'] / 100))) * $cart['qtd'];
                $total += $valor_desc;
            }

        }

        return view('facturas.finalizar', [
            'clientes' => $clientes,
            'moeda' => $moeda,
            'tipos' => $tipos,
            'impostos' => $impostos,
            'total' => $total
        ]);
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
