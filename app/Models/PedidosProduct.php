<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use OwenIt\Auditing\Contracts\Auditable;

class PedidosProduct extends Model implements Auditable
{
    use HasFactory;
    use \OwenIt\Auditing\Auditable;

    protected $fillable = [
        'pedidos_id',
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
