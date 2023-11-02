<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class FacturaMeioPagamento extends Model
{
    use HasFactory;

    protected $fillable = [
        'facturas_id',
        'meios_pagamentos_id',
        'valor',
        'troco',
    ];
}
