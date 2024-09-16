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
        'tickets_id',
        'documents_id',
        'devices_id',
        'current',
    ];

    // Definición de relaciones

    // Relación con Document
    public function document()
    {
        return $this->belongsTo(Document::class, 'documents_id');
    }

    // Relación con Ticket
    public function ticket()
    {
        return $this->belongsTo(Ticket::class, 'tickets_id');
    }

    // Relación con Device
    public function device()
    {
        return $this->belongsTo(Device::class, 'devices_id');
    }
}

