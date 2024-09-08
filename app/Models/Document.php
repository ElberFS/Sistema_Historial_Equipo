<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Document extends Model
{
    use HasFactory;
    protected $table = 'documents';

    protected $fillable = [
        'code', 
        'title', 
        'description',
        'managers_id',
        'device_tickets_id',
        'current'
    ];

    // Definición de relaciones

    public function deviceTicket()
    {
        return $this->belongsTo(DeviceTicket::class);
    }

    public function manager()
    {
        return $this->belongsTo(Manager::class);
    }
}
