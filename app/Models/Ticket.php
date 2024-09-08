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
        'description'
    ];


    // Definición de relaciones

    public function document()
    {
        return $this->belongsTo(Document::class);
    }

    public function deviceTicket()
    {
        return $this->belongsTo(DeviceTicket::class);
    }
}
