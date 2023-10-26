<?php

namespace App\Http\Controllers;

use App\Models\Inventory;
use Illuminate\Http\Request;

class UrlController extends Controller
{
    public function stock_actual(Request $request)
    {
        $stock = Inventory::all()
            ->where('shops_id', $request->shops_id)
            ->where('products_id', $request->products_id)
            ->where('sizes_id', $request->sizes_id)
            ->where('colors_id', $request->colors_id)
            ->where('marcas_id', $request->marcas_id)
            ->where('categorias_id', $request->categorias_id)
            ->where('validade', $request->validade);

        $resultado = 0;
        if (!$stock->isEmpty())
            $resultado = $stock->first()->qtd;

        echo json_encode($resultado);
    }
}
