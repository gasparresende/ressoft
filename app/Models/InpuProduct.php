<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class InpuProduct extends Model
{
    use HasFactory;

    protected $fillable = [
        'products_id',
        'shops_id',
        'qtd',
        'data',
        'tipo_entrada',
    ];

    protected $table = "input_products";
}
