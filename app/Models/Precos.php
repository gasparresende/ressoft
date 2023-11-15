<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use OwenIt\Auditing\Contracts\Auditable;

class Precos extends Model implements Auditable
{
    use HasFactory;
    use \OwenIt\Auditing\Auditable;

    protected $fillable = [
        'compra',
        'venda',
        'produtos_id',
        'status',
    ];

    public function produtos()
    {
        return $this->belongsTo(Product::class);
    }
}
