<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Device extends Model
{
    use HasFactory;
    protected $table = 'devices';

    protected $fillable = [
        'code', 
        'areas_id',
        'device_types_id',
        'serial_number',
        'current'
    ];

    //Definicion de relacion de migraciones 

    public function deviceType()
    {
        return $this->belongsTo(DeviceType::class, 'device_types_id');
    }

    public function area()
    {
        return $this->belongsTo(Area::class);
    }

}
