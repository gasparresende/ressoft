<?php

namespace App\Http\Controllers;

use App\Models\Inventory;
use App\Models\Shop;
use App\Models\User;
use Barryvdh\DomPDF\Facade\Pdf;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use SimpleSoftwareIO\QrCode\Facades\QrCode;

class RelatorioController extends Controller
{
    public function index()
    {
        $users = User::all();
        if (!auth()->user()->hasRole('Admin')) {
            $users = User::all()->where('id', auth()->id());
        }

        $shops = Shop::all();
        $users_shops = DB::table('users_shops')->where('users_id', auth()->id())->get();
        if (!auth()->user()->hasRole('Admin')) {
            $shops = $shops->whereIn('id', $users_shops->pluck('shops_id'));
        }

        return view('relatorios.index', [
            'users' => $users,
            'lojas' => $shops,
        ]);
    }

    public function cardapio()
    {
        $produtos = Inventory::all();


        $pdf = PDF::loadView('report.cardapio', [
            'entradas' => $produtos->where('categorias_id', 1),
            'sobremesas' => $produtos->where('categorias_id', 2),
            'pratos' => $produtos->where('categorias_id', 3),
            'bebidas' => $produtos->where('categorias_id', 4),
            'img' => true,
        ]);

        return $pdf->download('Cardapio.pdf');
    }

    public function relatorio_venda(Request $request)
    {
        //Gerar Relatórios de Venda PDF
        $facturas = DB::table('facturas')
            ->join('facturas_products', 'facturas_products.facturas_id', 'facturas.id')
            ->join('inventories', 'inventories.id', 'facturas_products.inventories_id')
            ->join('products', 'products.id', 'inventories.products_id')
            ->leftJoin('colors', 'colors.id', 'inventories.colors_id')
            ->leftJoin('sizes', 'sizes.id', 'inventories.sizes_id')
            ->leftJoin('marcas', 'marcas.id', 'inventories.marcas_id')
            ->leftJoin('categorias', 'categorias.id', 'inventories.categorias_id')
            ->whereBetween('data_emissao', [$request->data1, $request->data2])
            ->groupBy('inventories_id')
            ->select([
                '*',
                'inventories.id as id',
                DB::raw('sum(facturas_products.qtd) as qtd'),
            ])
            ->get();
        if ($request->users_id != null) {
           $facturas = $facturas->where('users_id', $request->users_id);
        }

        if ($request->shops_id != null) {
            $facturas = $facturas->where('shops_id', $request->shops_id);
        }

        $total = 0;
        foreach ($facturas as $factura) {
            $total += $factura->preco * $factura->qtd;
        }

        $pdf = PDF::loadView('report.relatorio_venda', [
            'facturas' => $facturas,
            'request'=>$request,
            'total' => $total,
        ]);
        return $pdf->download('Relatorio_Venda.pdf');
    }


}
