<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Ticket extends Model
{
    use HasFactory;

    protected $table = 'tickets';

    protected $fillable = [
        'code',
        'description',
        'documents_id',
        'users_id',
        'status',
        'current',
    ];

    // Definición de relaciones

    // Relación con Document
    public function document()
    {
        return $this->belongsTo(Document::class, 'documents_id');
    }

    // Relación con User
    public function user()
    {
        return $this->belongsTo(User::class, 'users_id');
    }

    // Relación con DeviceTicket
    public function deviceTickets()
    {
        return $this->hasMany(DeviceTicket::class, 'tickets_id');
    }
}
