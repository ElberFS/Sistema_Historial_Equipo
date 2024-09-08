<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class DeviceType extends Model
{
    use HasFactory;

    protected $table = 'device_types';

    protected $fillable = [
        'name',
        'brand',
        'model',
        'current'
    ];

    //Definicion de relacion de migraciones 

    public function devices(){
        return $this->hasMany(Device::class);
    }
}
