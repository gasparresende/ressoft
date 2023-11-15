<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use OwenIt\Auditing\Contracts\Auditable;

class Transferencia extends Model implements Auditable
{
    use HasFactory;
    use \OwenIt\Auditing\Auditable;

    protected $fillable = [
        'origem',
        'destino',
        'products_id',
        'sizes_id',
        'colors_id',
        'marcas_id',
        'categorias_id',
        'users_id',
        'qtd',
        'data',
        'hora',
        'motivo',
        'obs',
        'validade',
    ];
}
