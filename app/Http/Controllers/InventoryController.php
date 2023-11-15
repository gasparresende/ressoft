<?php

namespace App\Http\Controllers;

use App\Exports\InventoriesExport;
use App\Models\Entrada;
use App\Models\Inventory;
use App\Models\Product;
use App\Models\Saida;
use App\Models\Shop;
use App\Models\Transferencia;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Maatwebsite\Excel\Facades\Excel;
use PDF;

class InventoryController extends Controller
{
    private $inventories, $dependencias;

    public function __construct()
    {
        $i = new Inventory();
        $this->inventories = $i;
        $this->dependencias = $i->dependencias();
    }

    public function index()
    {
        //$inventories = Inventory::paginate(10);
        $inventories = Inventory::with('products', 'shops', 'sizes', 'colors', 'marcas', 'categorias', 'fornecedors')->get();

        return view('inventories.index', [
            'inventories' => $inventories,
            'shops' => Shop::all(),
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

        $products = Product::all();
        $shops = Shop::all();
        return view('inventories.create', [
            'products' => $products,
            'shops' => $shops,
        ]);
    }

    public function entradas()
    {
        return view('inventories.entrada', $this->dependencias);
    }

    public function saidas()
    {
        return view('inventories.saidas', $this->dependencias);
    }

    public function transferencias()
    {
        return view('inventories.transferencias', $this->dependencias);
    }


    /**
     * Store a newly created resource in storage.
     *
     * @param \Illuminate\Http\Request $request
     * @return \Illuminate\Http\RedirectResponse
     */
    public function store(Request $request)
    {
        if ($request->tipo === '1') {
            $count = 0;
            foreach ($request->products_id as $key => $products_id) {

                $dados = [
                    'products_id' => $products_id,
                    'shops_id' => $request->shops_id,
                    'sizes_id' => $request->sizes_id[$key],
                    'colors_id' => $request->colors_id[$key],
                    'marcas_id' => $request->marcas_id[$key],
                    'categorias_id' => $request->categorias_id[$key],
                    'qtd' => $request->qtd[$key],
                    'validade' => $request->validade[$key],
                    'data' => now(),
                    'hora' => now(),
                    'forncecedors_id' => $request->forncecedors_id,
                    'users_id' => auth()->id(),

                ];
                $entrada = Entrada::create($dados);
                $count++;

            }

            if ($count)
                return redirect()->route('inventories.index')->with('sucesso', 'Produtos adicionado com sucesso!');

            return redirect()->back()->with('erro', 'Erro ao adicionar produtos!')->withInput();

        } elseif($request->tipo === '2') {
            $count = 0;
            foreach ($request->products_id as $key => $products_id) {

                $dados = [
                    'products_id' => $products_id,
                    'shops_id' => $request->shops_id,
                    'sizes_id' => $request->sizes_id[$key],
                    'colors_id' => $request->colors_id[$key],
                    'marcas_id' => $request->marcas_id[$key],
                    'categorias_id' => $request->categorias_id[$key],
                    'qtd' => $request->qtd[$key],
                    'validade' => $request->validade[$key],
                    'data' => now(),
                    'hora' => now(),
                    'motivo' => $request->motivo,
                    'users_id' => auth()->id(),

                ];

                $parametros = [
                    'products_id' => $products_id,
                    'shops_id' => $request->shops_id,
                    'sizes_id' => $request->sizes_id[$key],
                    'colors_id' => $request->colors_id[$key],
                    'marcas_id' => $request->marcas_id[$key],
                    'categorias_id' => $request->categorias_id[$key],
                    'validade' => $request->validade[$key],
                ];
                if (getCurrentStock($parametros) >= $request->qtd[$key]) {
                    Saida::create($dados);
                    $count++;
                }


            }

            if ($count)
                return redirect()->route('inventories.index')->with('sucesso', 'Saída Registada com sucesso!');

            return redirect()->back()->with('erro', 'Erro ao Registar Saída!')->withInput();
        }
        else{
            $request['origem'] = $request->shops_id;
            $request['destino'] = $request->shops_id2;
            $request['data'] = now();
            $request['hora'] = now();
            $request['users_id'] = auth()->id();

            $parametros = [
                'products_id' => $request->products_id,
                'shops_id' => $request->shops_id,
                'sizes_id' => $request->sizes_id,
                'colors_id' => $request->colors_id,
                'marcas_id' => $request->marcas_id,
                'categorias_id' => $request->categorias_id,
                'validade' => $request->validade,
            ];

            if ($request->qtd <= getCurrentStock($parametros))
                $transferencia = Transferencia::create($request->all());
            else
                return redirect()->back()->with('alerta', 'Lamentamos, Stock insuficiente para concluír a Operação.')->withInput();


            if ($transferencia) {
                return redirect()->route('inventories.index')->with('sucesso', 'Trasnferencia Processada com sucesso!');
            }
            return redirect()->back()->with('erro', 'Erro ao processar Trasnferência')->withInput();
        }
    }

    public function exportar(Request $request)
    {

        $inventories = DB::table('inventories')
            ->join('products', 'products.id', 'inventories.products_id')
            ->join('shops', 'shops.id', 'inventories.shops_id')
            ->leftJoin('sizes', 'sizes.id', 'inventories.sizes_id')
            ->leftJoin('colors', 'colors.id', 'inventories.colors_id')
            ->where('inventories.shops_id', $request->shops_id)
            ->select(
                [
                    '*',
                    'inventories.id as id',
                    'inventories.qtd as qtd_final',
                ])
            ->get();

        if ($request->shops_id == '%'){
            $inventories = DB::table('inventories')
                ->join('products', 'products.id', 'inventories.products_id')
                ->join('shops', 'shops.id', 'inventories.shops_id')
                ->leftJoin('sizes', 'sizes.id', 'inventories.sizes_id')
                ->leftJoin('colors', 'colors.id', 'inventories.colors_id')
                ->select(
                    [
                        '*',
                        'inventories.id as id',
                        'inventories.qtd as qtd_final',
                    ])
                ->get();
        }


        if ($inventories->isEmpty())
            return redirect()->back()->with('alerta', 'Nenhum Registro encontrado!');

        $dados = [
            'inventories' => $inventories,
            'request' => $request,
            'img' => true,
        ];
        if ($request->tipo) {
            $pdf = PDF::loadView('report.stocks', $dados)
                ->setPaper('A4', 'landscape');
            return $pdf->download('Inventories.pdf');
        } else {
            return Excel::download(new InventoriesExport($dados), 'Inventories.xlsx');
        }
    }
    public function show(Inventory $inventory)
    {
        //if (Gate::denies('view'))
        // return redirect()->back()->with('erro', 'Não Tens Permissão para vizualizar este Item');

        $products = Product::all();
        $shops = Shop::all();
        return view('inventories.show', [
            'products' => $products,
            'shops' => $shops,
            'inventory' => $inventory,
        ]);
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param \App\Models\Inventory $inventory
     * @return \Illuminate\Http\Response
     */
    public function edit(Inventory $inventory)
    {
        //if (Gate::denies('update'))
        // return redirect()->back()->with('erro', 'Não Tens Permissão para alterar este Item');

        $products = Product::all();
        $shops = Shop::all();
        return view('inventories.edit', [
            'products' => $products,
            'shops' => $shops,
            'inventory' => $inventory,
        ]);
    }

    /**
     * Update the specified resource in storage.
     *
     * @param \Illuminate\Http\Request $request
     * @param \App\Models\Inventory $inventory
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, Product $product)
    {
        if ($product->update($request->all())) {
            return redirect()->route('inventories.index')->with('sucesso', 'Dados Alterado com sucesso!');
        } else {
            return redirect()->back()->with('erro', 'Erro ao Alterar');
        }
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param \App\Models\Inventory $inventory
     * @return \Illuminate\Http\Response
     */
    public function destroy(Inventory $inventory)
    {
        //if (Gate::denies('delete'))
        // return redirect()->back()->with('erro', 'Não Tens Permissão para eliminar este Item');

        if ($inventory->delete()) {
            return redirect()->route('inventories.index')->with('sucesso', 'Dados Eliminado com sucesso!');
        } else {
            return redirect()->back()->with('erro', 'Erro ao Eliminar');
        }
    }

    public function listar_by_nome(Request $request)
    {
        $produtos = DB::table('inventories')
            ->join('products', 'products.id', 'inventories.products_id')
            ->where('products.produto', 'LIKE', "%$request->produto%")->get();

        echo json_encode($produtos);
    }
}
