<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use OwenIt\Auditing\Contracts\Auditable;

class SelesProduct extends Model implements Auditable
{
    use HasFactory;
    use \OwenIt\Auditing\Auditable;

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
