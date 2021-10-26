<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Product extends Model
{
    use HasFactory;

    protected $table = "products";

    protected $fillable = [
        'produto',
        'codigo',
        'units_id',
        'categories_id',
        'preco_compra',
        'preco_venda',
        'status',
        'tipo',
        'validade',
    ];

    public function units()
    {
        return $this->belongsTo(Unity::class);
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
