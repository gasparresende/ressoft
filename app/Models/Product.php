<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Product extends Model
{
    use HasFactory;

    protected $table = "products";

    protected $fillable = [
        'product',
        'codigo',
        'status',
        'tipo',
        'isstock',
        'localizacao',
        'regimes_id',
        'unidades_id',
    ];

    public function units()
    {
        return $this->belongsTo(Unity::class);
    }

    public function dependencias()
    {
        $produto = Product::all()->last();
        $codigo = 1;
        if ($produto)
            $codigo = $produto->codigo + 1;

        $unidades = Unidade::all();
        $regimes = Regime::with('taxas')->get();
        return [
            'unidades' => $unidades,
            'regimes' => $regimes,
            'codigo'=>numeros_com_algarismo($codigo),
        ];
    }

    public function categories()
    {
        return $this->belongsTo(Category::class);
    }

    public function setPrecoCompraAttribute($value)
    {
        $this->attributes['preco_compra'] = str_replace(',', '.', str_replace('.', '', $value));;
    }

    public function setPrecoVendaAttribute($value)
    {
        $this->attributes['preco_venda'] = str_replace(',', '.', str_replace('.', '', $value));;
    }


}
