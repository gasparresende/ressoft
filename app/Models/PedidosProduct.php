<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class PedidosProduct extends Model
{
    use HasFactory;

    protected $fillable = [
        'status_mesas_id',
        'inventories_id',
        'qtd',
        'preco',
        'cozinha',
        'obs'
    ];

    public function inventories()
    {
        return $this->belongsTo(Inventory::class);
    }

    public function status_mesas()
    {
        return $this->belongsTo(StatusMesa::class);
    }
}
