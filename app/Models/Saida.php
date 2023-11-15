<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use OwenIt\Auditing\Contracts\Auditable;

class Saida extends Model implements Auditable
{
    use HasFactory;
    use \OwenIt\Auditing\Auditable;

    protected $fillable = [
        'products_id',
        'shops_id',
        'sizes_id',
        'colors_id',
        'marcas_id',
        'categorias_id',
        'users_id2',
        'validade',
        'motivo',
        'qtd',
        'data',
        'hora',
        'obs',
        'users_id',
    ];
}
