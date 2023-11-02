<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class FacturasProduct extends Model
{
    use HasFactory;

    protected $fillable = [
        'desconto',
        'facturas_id',
        'inventories_id',
        'qtd',
        'preco',
    ];
}
