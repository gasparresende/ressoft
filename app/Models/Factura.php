<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Factura extends Model
{
    use HasFactory;

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
        'impostos_id'
    ];
}
