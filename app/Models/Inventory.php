<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use OwenIt\Auditing\Contracts\Auditable;

class Inventory extends Model implements Auditable
{
    use HasFactory;
    use \OwenIt\Auditing\Auditable;

    public function dependencias()
    {

        return  [
            'products' => Product::all(),
            'shops' => Shop::all(),
            'sizes'=>Size::all(),
            'colors'=>Color::all(),
            'marcas'=>Marca::all(),
            'categorias'=>Categoria::all(),
            'fornecedors'=>Forncecedor::all(),
        ];
    }

    public function products()
    {
        return $this->belongsTo(Product::class);
    }

    public function colors()
    {
        return $this->belongsTo(Color::class);
    }

    public function sizes()
    {
        return $this->belongsTo(Size::class);
    }

    public function shops()
    {
        return $this->belongsTo(Shop::class);
    }

    public function marcas()
    {
        return $this->belongsTo(Marca::class);
    }

    public function categorias()
    {
        return $this->belongsTo(Categoria::class);
    }

    public function fornecedors()
    {
        return $this->belongsTo(Forncecedor::class);
    }

}
