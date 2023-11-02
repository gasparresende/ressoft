<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Caixa extends Model
{
    use HasFactory;

    protected $fillable = [
        'status',
        'data_caixa',
        'users_id',
        'saldo_inicial',
        'total',
    ];
}
