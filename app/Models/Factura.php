<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use OwenIt\Auditing\Contracts\Auditable;

class Factura extends Model implements Auditable
{
    use HasFactory;
    use \OwenIt\Auditing\Auditable;

    protected $fillable = [
        'id',
        'numero',
        'valor_total',
        'data_emissao',
        'data_vencimento',
        'clientes_id',
        'mes',
        'ano',
        'users_id',
        'moedas_id',
        'status',
        'hash',
        'tipos_id',
        'retencao',
        'motivo_nc',
    ];
}
