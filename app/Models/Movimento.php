<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use OwenIt\Auditing\Contracts\Auditable;

class Movimento extends Model implements Auditable
{
    use HasFactory;
    use \OwenIt\Auditing\Auditable;

    protected $fillable = [
        'debito',
        'credito',
        'razao',
        'contas_id',
        'data_operacao',
        'data_movimento',
        'registos_id',
    ];

    public function contas()
    {
        return $this->belongsTo(Contas::class);
    }
}
