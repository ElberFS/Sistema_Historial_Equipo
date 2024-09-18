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
        'current',
    ];

    // Definición de relaciones

    // Relación con DeviceTicket
    public function deviceTickets()
    {
        return $this->hasMany(DeviceTicket::class, 'documents_id');
    }

    // Relación con Manager
    public function manager()
    {
        return $this->belongsTo(Manager::class, 'managers_id');
    }
}
