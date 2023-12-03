<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Empresa extends Model
{
    use HasFactory;
    protected $fillable = [
        'nome_empresa',
        'nif_empresa',
        'telemovel_empresa',
        'email_empresa',
        'logotipo_empresa',
        'endereco_empresa',
        'website_empresa',
        'regimes_id',
    ];

    public function readAll()
    {
        return $this::all();
    }

    public function bancos()
    {
        return $this->belongsToMany(Banco::class, 'contas_bancaria_empresas');
    }

    public function contas_bancaria()
    {
        return $this->belongsTo(ContasBancariaEmpresas::class);
    }

    public function regimes()
    {
        return $this->belongsTo(Regime::class);
    }


}
