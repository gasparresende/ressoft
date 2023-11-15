<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use OwenIt\Auditing\Contracts\Auditable;

class UsersShop extends Model implements Auditable
{
    use HasFactory;
    use \OwenIt\Auditing\Auditable;

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
