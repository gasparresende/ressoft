<?php

use App\Models\Inventory;
use Illuminate\Support\Carbon;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Storage;
use phputil\extenso\Extenso;
use Rawilk\Printing\Facades\Printing;


function capitalizeNomeProprio($nome)
{
    $partesNome = explode(" ", $nome);
    $exclude = array('da', 'das', 'de', 'do', 'dos', 'e');
    $nomeCapitalizado = '';
    foreach ($partesNome as $parte) {
        if (in_array(strtolower($parte), $exclude)) {
            $parte = strtolower($parte);
        } else {
            $parte = ucfirst($parte);
        }
        $nomeCapitalizado .= $parte . " ";
    }
    return trim($nomeCapitalizado);
}

function tipo_documento($id)
{
    return \App\Models\Tipo::all()->find($id);
}

function status_mesa($mesas_id)
{
    $status = DB::table('mesas')
        ->join('status_mesas', 'status_mesas.mesas_id', 'mesas.id')
        ->join('status', 'status.id', 'status_mesas.status_id')
        ->where('mesas.id', $mesas_id)->get();

    if ($status->isEmpty())
        return "Disponível";

    return $status->last()->statu;
}

function garcon($mesas_id)
{
    $status = DB::table('mesas')
        ->join('status_mesas', 'status_mesas.mesas_id', 'mesas.id')
        ->join('users', 'users.id', 'status_mesas.users_id')
        ->limit(1)
        ->where('mesas.id', $mesas_id)->get();

    if ($status->isEmpty())
        return null;

    return $status->last()->username;
}

function detalhes_mesas($mesas_id)
{
    return DB::table('status_mesas')
        ->join('mesas', 'mesas.id', 'status_mesas.mesas_id')
        ->join('status', 'status.id', 'status_mesas.status_id')
        ->leftJoin('users', 'users.id', 'status_mesas.users_id')
        ->orderByDesc('status_mesas.id')
        ->where('mesas.id', $mesas_id)
        ->limit(1)
        ->get([
            '*',
            'users.username as nome_garcon',
        ])
        ->last();
}

function extenso($valor, $moeda)
{
    $e = new Extenso();

    $res = str_replace('real', 'kwanza', str_replace('reais', 'kwanzas', $e->extenso($valor)));
    if ($moeda == 2) {
        $res = str_replace('real', 'dollar', str_replace('reais', 'dollares', $e->extenso($valor)));
    }

    //$res = str_replace('real', '', str_replace('reais', '', $e->extenso( $valor )));

    return capitalizeNomeProprio($res);
}

/*function empresas()
{
    //return \App\Models\Empresas::all()->first();
    return \Illuminate\Support\Facades\DB::table('empresas')
        ->leftJoin('contas_bancaria_empresas as cb', 'cb.empresas_id', 'empresas.id')
        ->leftJoin('regimes', 'regimes.id', 'empresas.regimes_id')
        ->leftJoin('taxas', 'taxas.id', 'empresas.taxas_id')
        ->get()->first();
}*/


function empresas()
{
    //return \App\Models\Empresas::all()->first();
    return \Illuminate\Support\Facades\DB::table('empresas')
        ->join('contas_bancaria_empresas as cb', 'cb.empresas_id', 'empresas.id')->get()->first();
}

function empresa()
{
    return \App\Models\Empresa::all()->first();
}

function formatar_moeda($valor)
{
    return number_format($valor, '2', ',', '.');
}

function total_carrinho()
{
    $total = 0;
    if (session('carrinho')) {
        foreach (session('carrinho') as $key => $cart) {
            $valor_desc = ($cart['preco_venda'] - ($cart['preco_venda'] * ($cart['desc'] / 100))) * $cart['qtd'];
            $total += $valor_desc;
        }
    }
    return formatar_moeda($total);
}

function troco()
{
    $total = 0;
    if (session('carrinho')) {
        foreach (session('carrinho') as $key => $cart) {
            $valor_desc = ($cart['preco_venda'] - ($cart['preco_venda'] * ($cart['desc'] / 100))) * $cart['qtd'];
            $total += $valor_desc;
        }
    }

    $meio = 0;
    if (session('carrinho_meio_pagamento')) {
        foreach (session('carrinho_meio_pagamento') as $key => $cart) {
            $meio += $cart['valor'];
        }
    }
    return formatar_moeda($meio - $total);
}

function primeiro_ultimo($fullname)
{
    $res = explode(' ', $fullname);
    return $res[0] . ' ' . $res[count($res) - 1];
}


function isMovimento($id)
{
    return DB::table('razao')->where('facturas_id', $id)->limit(1)->get()->isNotEmpty();
}


function data_formatada($data, $formato = 'd-m-Y')
{
    if (is_null($data))
        return null;
    return date($formato, strtotime($data));
}

function imprimir($file){
    $im = Printing::newPrintTask()
        ->printer(env('PRINT_TERMICA'))
        ->file($file)
        ->send();
}

function getCurrentStock($paramentros)
{

    $stock = Inventory::all()
        ->where('products_id', $paramentros['products_id'])
        ->where('shops_id', $paramentros['shops_id'])
        ->where('sizes_id', $paramentros['sizes_id'])
        ->where('colors_id', $paramentros['colors_id'])
        ->where('marcas_id', $paramentros['marcas_id'])
        ->where('categorias_id', $paramentros['categorias_id'])
        ->where('validade', $paramentros['validade']);

    return $stock->isEmpty() ? 0 : $stock->first()->qtd;

}

function numeros_com_algarismo($numero, $algarismo = 3)
{
    return str_pad($numero, $algarismo, '0', STR_PAD_LEFT);
}

function paraArray($model, $value)
{
    $data = [];
    foreach ($model as $item) {
        array_push($data, $item->$value);
    }
    return $data;
}

function mes($mes_inteiro)
{
    $meses = array(
        1 => 'Janeiro',
        2 => 'Fevereiro',
        3 => 'Março',
        4 => 'Abril',
        5 => 'Maio',
        6 => 'Junho',
        7 => 'Julho',
        8 => 'Agosto',
        9 => 'Setembro',
        10 => 'Outubro',
        11 => 'Novembro',
        12 => 'Dezembro'
    );
    foreach ($meses as $key => $mes) {
        if ($key == $mes_inteiro)
            return $mes;
    }
}

function deleteDir($dir)
{
    if (Storage::exists($dir)) {
        Storage::deleteDirectory($dir);
    }
}

function upload($dir, $file)
{
    if ($file != null) {
        deleteDir($dir);
        $upload = $file->store($dir);

        return $upload;
    }
    return null;
}

function upload_as($dir, $file, $name)
{
    if ($file != null) {
        deleteDir($dir);
        $upload = $file->storeAs($dir, $name . '.' . $file->extension());

        return $upload;
    }
    return null;
}

function loja()
{
    $loja = DB::table('users_shops')
        ->join('users', 'users.id', 'users_shops.users_id')
        ->join('shops', 'shops.id', 'users_shops.shops_id')
        ->where('users.id', auth()->id())
        ->get();
    return $loja->isNotEmpty() ? $loja->first()->loja : null;
}

function caixa()
{
    $caixa = DB::table('caixas')
        ->where('users_id', auth()->id())
        ->get()->last();
    return $caixa;
}

function stock_inicial($shops_id, $products_id, $sizes_id, $colors_id, $marcas_id, $categorias_id, $validade, $data1, $data2)
{
    $stocks = DB::table('entradas')
        ->where('shops_id', $shops_id)
        ->where('products_id', $products_id)
        ->where('sizes_id', $sizes_id)
        ->where('colors_id', $colors_id)
        ->where('marcas_id', $marcas_id)
        ->where('categorias_id', $categorias_id)
        ->where('validade', $validade)
        ->where('data', '<', $data1)
        ->get();

    $entradas = 0;
    if (!$stocks->isEmpty())
        $entradas = $stocks->sum('qtd');

    $stocks2 = DB::table('saidas')
        ->where('shops_id', $shops_id)
        ->where('products_id', $products_id)
        ->where('sizes_id', $sizes_id)
        ->where('colors_id', $colors_id)
        ->where('marcas_id', $marcas_id)
        ->where('categorias_id', $categorias_id)
        ->where('validade', $validade)
        ->where('data', '<', $data1)
        ->get();

    $saidas = 0;
    if (!$stocks2->isEmpty())
        $saidas = $stocks2->sum('qtd');

    return $entradas - $saidas;
}

function getStock($shops_id, $products_id, $sizes_id, $colors_id, $marcas_id, $categorias_id, $validade, $data1, $data2)
{
    $final = DB::table('entradas')
        ->where('shops_id', $shops_id)
        ->where('products_id', $products_id)
        ->where('sizes_id', $sizes_id)
        ->where('colors_id', $colors_id)
        ->where('marcas_id', $marcas_id)
        ->where('categorias_id', $categorias_id)
        ->where('validade', $validade)
        ->whereBetween('data', [$data1, $data2])
        ->get();

    $entradas = DB::table('entradas')
        ->where('shops_id', $shops_id)
        ->where('products_id', $products_id)
        ->where('sizes_id', $sizes_id)
        ->where('colors_id', $colors_id)
        ->where('marcas_id', $marcas_id)
        ->where('categorias_id', $categorias_id)
        ->where('validade', $validade)
        ->whereBetween('data', [$data1, $data2])
        ->get();

    $qtd_entrada = 0;
    if (!$entradas->isEmpty())
        $qtd_entrada = $entradas->sum('qtd');

    $saidas = DB::table('saidas')
        ->where('shops_id', $shops_id)
        ->where('products_id', $products_id)
        ->where('sizes_id', $sizes_id)
        ->where('colors_id', $colors_id)
        ->where('marcas_id', $marcas_id)
        ->where('categorias_id', $categorias_id)
        ->where('validade', $validade)
        ->whereBetween('data', [$data1, $data2])
        ->get();

    $qtd_saida = 0;
    if (!$saidas->isEmpty())
        $qtd_saida = $saidas->sum('qtd');

    return [
        'inicial' => stock_inicial($shops_id, $products_id, $sizes_id, $colors_id, $marcas_id, $categorias_id, $validade, $data1, $data2),
        'entradas' => $qtd_entrada,
        'saidas' => $qtd_saida,
        'final' => 0,
    ];
}


function caixaAbertoDiaAnterior()
{
    $caixa = DB::table('caixas')
        ->where('users_id', auth()->id())
        ->where('data_caixa', '<', date(now()))
        ->get()->last();
    return $caixa;
}

function isCaixaFechado()
{
    $caixa = DB::table('caixas')
        ->where('users_id', auth()->id())
        ->get()->last();

    if ($caixa == null)
        return true;
    return ($caixa->status) ? false : true;
}

//Contabilidade - Funções

function qtd_stock($products_id, $shops_id, $qtd)
{
    $res = \App\Models\Entrada::all()
        ->where('products_id', $products_id)
        ->where('shops_id', $shops_id);

    $quantidade = $qtd;
    foreach ($res as $re) {
        $quantidade += $re->qtd;
    }

    return $quantidade;
}

//




