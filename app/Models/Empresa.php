<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use OwenIt\Auditing\Contracts\Auditable;

class Empresa extends Model implements Auditable
{
    use HasFactory;
    use \OwenIt\Auditing\Auditable;

    protected $fillable = [
        'nome_empresa',
        'nif_empresa',
        'telemovel_empresa',
        'logotipo_empresa',
        'endereco_empresa',
        'website_empresa',
        'regimes_id',
        'taxas_id',
    ];

    public function regimes()
    {
        return $this->belongsTo(Regime::class);
    }
}
