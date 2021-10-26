<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Inventory extends Model
{
    use HasFactory;

    public function products()
    {
        return $this->belongsTo(Product::class);
    }

    public function shops()
    {
        return $this->belongsTo(Shop::class);
    }
}
