<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class ContasBancariaEmpresas extends Model
{
    use HasFactory;

    protected $fillable = [
        'numero_conta_empresa',
        'iban_empresa',
        'bancos_id',
        'empresas_id',
    ];
}
