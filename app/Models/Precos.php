<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Precos extends Model
{
    use HasFactory;

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
