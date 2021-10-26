<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class UsersShop extends Model
{
    use HasFactory;

    protected $fillable = [
        'users_id',
        'shops_id',
    ];


    public function users()
    {
        return $this->belongsTo(User::class);
    }

    public function shops()
    {
        return $this->belongsTo(Shop::class);
    }
}
