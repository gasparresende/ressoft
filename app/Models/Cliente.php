<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Cliente extends Model
{
    use HasFactory;

    protected $fillable = [
        'nome',
        'nif',
        'telemovel',
        'email',
        'endereco',
        'contas_id',
        'conta_corrente',
    ];
}
