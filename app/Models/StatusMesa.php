<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class StatusMesa extends Model
{
    use HasFactory;

    protected $fillable = [
        'mesas_id',
        'status_id',
        'users_id',
        'data',
        'data_fecho'
    ];


    public function users()
    {
        return $this->belongsTo(User::class);
    }

    public function mesas()
    {
        return $this->belongsTo(Mesa::class);
    }

    public function status()
    {
        return $this->belongsTo(Statu::class);
    }
}
