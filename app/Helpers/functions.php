<?php

use App\Models\Razao;
use App\Models\SubsidiosFuncionarios;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Storage;
use phputil\extenso\Extenso;

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

function empresas()
{
    //return \App\Models\Empresas::all()->first();
    return \Illuminate\Support\Facades\DB::table('empresas')
        ->join('contas_bancaria_empresas as cb', 'cb.empresas_id', 'empresas.id')->get()->first();
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

function upload($request, $dir, $table, $nome = 'path')
{
    if ($request->hasFile($nome) && $request->file($nome)) {
        Storage::deleteDirectory($dir);
        $file = $request->file($nome)->store($dir);
        $table->update([$nome => $file]);
        return true;
    }
}

function loja()
{
    $loja = DB::table('users_shops')
        ->join('users', 'users.id', 'users_shops.users_id')
        ->join('shops', 'shops.id', 'users_shops.shops_id')
        ->where('users.id', auth()->id())
        ->get();
    return $loja->isNotEmpty()? $loja->first()->loja : null;
}

function caixa()
{
    $caixa = DB::table('caixas')
        ->where('users_id', auth()->id())
        ->get()->last();
    return $caixa;
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

    return ($caixa->status) ? false : true;
}

//Contabilidade - Funções

function qtd_stock($products_id, $shops_id, $qtd)
{
    $res = \App\Models\InpuProduct::all()
        ->where('products_id', $products_id)
        ->where('shops_id', $shops_id);

    $quantidade = $qtd;
    foreach ($res as $re) {
        $quantidade += $re->qtd;
    }

    return $quantidade;
}

//




