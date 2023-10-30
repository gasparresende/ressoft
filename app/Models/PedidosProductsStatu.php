<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class PedidosProductsStatu extends Model
{
    use HasFactory;

    protected $fillable = [
        'pedidos_products_id',
        'status_id',
        'users_id',
        'data',
    ];
}
