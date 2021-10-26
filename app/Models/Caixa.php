<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Caixa extends Model
{
    use HasFactory;

    protected $fillable = [
        'saldo_inicial',
        'users_id',
        'status',
        'data_caixa',
        'saldo',
    ];

    public function users()
    {
        return $this->belongsTo(User::class);
    }
}
