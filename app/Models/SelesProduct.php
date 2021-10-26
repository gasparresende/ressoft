<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class SelesProduct extends Model
{
    use HasFactory;

    protected $fillable = [
        'seles_id',
        'inventories_id',
        'quantidade',
        'punitario',
        'taxa_iva',
        'desconto',
        'retencao',
    ];
}
