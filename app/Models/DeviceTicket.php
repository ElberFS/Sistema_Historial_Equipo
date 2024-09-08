<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class DeviceTicket extends Model
{
    use HasFactory;
    protected $table = 'device_tickets';

    protected $fillable = [
        'code',
        'devices_id',
        'current'
    ];

    // Definición de relaciones

    public function device()
    {
        return $this->belongsTo(Device::class,);
    }
}
