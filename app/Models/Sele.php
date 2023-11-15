<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use OwenIt\Auditing\Contracts\Auditable;

class Sele extends Model implements Auditable
{
    use HasFactory;
    use \OwenIt\Auditing\Auditable;

    protected $fillable = [
        'data',
        'caixas_id',
        'customers_id',
        'total',
        'mes',
        'ano',
    ];

    public function caixas()
    {
        return $this->belongsTo(Caixa::class);
    }

    public function customers()
    {
        return $this->belongsTo(Customer::class);
    }

    public function getDataAttribute($value)
    {
        return data_formatada($value);
    }


}
