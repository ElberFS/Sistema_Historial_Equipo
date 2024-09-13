<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Area extends Model
{
    use HasFactory;

    protected $table = 'areas';

    protected $fillable = [
        'name',
        'managers_id',
        'current'
    ];

    // Relación con el modelo Manager
    public function manager()
    {
        return $this->belongsTo(Manager::class, 'managers_id');
    }
    

    // Relación con el modelo Device (un área puede tener muchos dispositivos)
    public function devices()
    {
        return $this->hasMany(Device::class);
    }
}
