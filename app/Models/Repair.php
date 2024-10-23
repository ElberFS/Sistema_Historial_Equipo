<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Repair extends Model
{
    use HasFactory;

    protected $fillable = [
        'code',
        'tickets_id',
        'device_tickets_id',
        'process',
        'current',
    ];

    /**
     * Relación con el modelo Ticket.
     */
    public function ticket()
    {
        return $this->belongsTo(Ticket::class, 'tickets_id');
    }

    /**
     * Relación con el modelo DeviceTicket.
     */
    public function deviceTicket()
    {
        return $this->belongsTo(DeviceTicket::class, 'device_tickets_id');
    }
}
