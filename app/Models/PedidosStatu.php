<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class PedidosStatu extends Model
{
    use HasFactory;

    protected $fillable = [
        'status_mesas_id',
        'status_id',
        'users_id',
        'data',
    ];
}
