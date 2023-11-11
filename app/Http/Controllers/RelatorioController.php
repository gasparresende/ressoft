<?php

namespace App\Http\Controllers;

use App\Models\Inventory;
use Barryvdh\DomPDF\Facade\Pdf;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use SimpleSoftwareIO\QrCode\Facades\QrCode;

class RelatorioController extends Controller
{
    public function index()
    {
        return view('relatorios.index');
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
}
