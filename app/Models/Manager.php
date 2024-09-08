<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Manager extends Model
{
    use HasFactory;

    protected $table = 'managers';

    protected $fillable = [
        'fullname',
        'dni',
        'phone',
        'address',
        'users_id',
        'current'
    ];

    // Relación con el modelo User (cada manager está relacionado con un usuario)
    public function user()
    {
        return $this->belongsTo(User::class);
    }

    // Relación con el modelo Area (un manager puede estar a cargo de muchas áreas)
    public function areas()
    {
        return $this->hasMany(Area::class);
    }
}
