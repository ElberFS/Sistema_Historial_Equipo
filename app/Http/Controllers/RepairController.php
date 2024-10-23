<?php

namespace App\Http\Controllers;

use App\Models\DeviceTicket;
use App\Models\Repair;
use App\Models\Ticket;
use Illuminate\Http\Request;

class RepairController extends Controller
{
    /**
     * Muestra una lista de todas las reparaciones.
     */
    public function index()
    {
        // Obtiene todas las reparaciones con sus relaciones de tickets y device_tickets
        $repairs = Repair::with(['ticket', 'deviceTicket'])->paginate(10); 

        // Retorna la vista con los datos de las reparaciones
        return view('repairs.index', compact('repairs'));
    }

    public function create()
    {
        // Obtiene los tickets y los device_tickets para el formulario
        $tickets = Ticket::all();
        $deviceTickets = DeviceTicket::all();

        // Retorna la vista con los datos de tickets y device_tickets
        return view('repairs.create', compact('tickets', 'deviceTickets'));
    }

    /**
     * Almacena una nueva reparación en la base de datos.
     */
    public function store(Request $request)
    {
        // Validación de los datos del formulario
        $request->validate([
            'code' => 'required|string|max:255',
            'tickets_id' => 'required|exists:tickets,id',
            'device_tickets_id' => 'required|exists:device_tickets,id',
            'process' => 'required|string',
            'current' => 'boolean',
        ]);

        // Creación de la nueva reparación
        Repair::create([
            'code' => $request->code,
            'tickets_id' => $request->tickets_id,
            'device_tickets_id' => $request->device_tickets_id,
            'process' => $request->process,
            'current' => $request->current ?? true, // Por defecto, se asume 'current' como true si no está presente
        ]);

        // Redirigir a la lista de reparaciones con mensaje de éxito
        return redirect()->route('repairs.index')->with('success', 'Repair created successfully.');
    } 
}
