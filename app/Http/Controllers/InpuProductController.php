<?php

namespace App\Http\Controllers;

use App\Models\InpuProduct;
use Illuminate\Http\Request;

class InpuProductController extends Controller
{
    public function store(Request $request)
    {
        $res = InpuProduct::create([
            'products_id' => $request->products_id,
            'shops_id' => $request->shops_id,
            'qtd' => $request->qtd,
            'data' => date('Y-m-d'),
        ]);

        echo json_encode('Entrada Adicionada com sucesso!!');
    }
}
