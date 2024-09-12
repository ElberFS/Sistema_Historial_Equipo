<?php

namespace App\Http\Controllers;

use App\Models\Ticket;
use Illuminate\Http\Request;

class TicketController extends Controller
{
    /**
     * Muestra todos los tickets.
     */
    public function index()
    {
        // Obtener todos los tickets
        $tickets = Ticket::all();

        // Retornar la vista 'index' con la lista de tickets
        return view('tickets.index', compact('tickets'));
    }

    /**
     * Muestra el formulario para crear un nuevo ticket.
     */
    public function create()
    {
        // Retornar la vista para crear un nuevo Ticket
        return view('tickets.create');
    }

    /**
     * Almacena un nuevo ticket en la base de datos.
     */
    public function store(Request $request)
    {
        // Validar los datos del formulario
        $validatedData = $request->validate([
            'code' => 'required|string|max:50',
            'description' => 'required|string|max:500',
            'documents_id' => 'nullable|exists:documents,id',
            'device_tickets_id' => 'nullable|exists:device_tickets,id',
            'users_id' => 'required|exists:users,id',
            'status' => 'required|in:A,P,C', // A: Abierto, P: Proceso, C: Cerrado
            'current' => 'required|boolean'
        ]);

        // Crear un nuevo Ticket con los datos validados
        Ticket::create($validatedData);

        // Redirigir a la lista de tickets con un mensaje de éxito
        return redirect()->route('tickets.index')->with('success', 'Ticket creado correctamente.');
    }

    /**
     * Muestra el formulario para editar un ticket existente.
     */
    public function edit($id)
    {
        // Buscar el Ticket por su ID o lanzar una excepción si no se encuentra
        $ticket = Ticket::findOrFail($id);

        // Retornar la vista de edición con los datos del Ticket
        return view('tickets.edit', compact('ticket'));
    }

    /**
     * Actualiza un ticket existente en la base de datos.
     */
    public function update(Request $request, $id)
    {
        // Buscar el Ticket por su ID
        $ticket = Ticket::findOrFail($id);

        // Validar los datos del formulario
        $validatedData = $request->validate([
            'code' => 'string|max:50',
            'description' => 'string|max:500',
            'documents_id' => 'nullable|exists:documents,id',
            'device_tickets_id' => 'nullable|exists:device_tickets,id',
            'users_id' => 'exists:users,id',
            'status' => 'in:A,P,C', // A: Abierto, P: Proceso, C: Cerrado
            'current' => 'boolean'
        ]);

        // Actualizar el Ticket con los datos validados
        $ticket->update($validatedData);

        // Redirigir a la lista de tickets con un mensaje de éxito
        return redirect()->route('tickets.index')->with('success', 'Ticket actualizado correctamente.');
    }

    /**
     * Elimina un ticket de la base de datos.
     */
    public function destroy($id)
    {
        // Buscar el Ticket por su ID
        $ticket = Ticket::findOrFail($id);

        // Eliminar el Ticket
        $ticket->delete();

        // Redirigir a la lista de tickets con un mensaje de éxito
        return redirect()->route('tickets.index')->with('success', 'Ticket eliminado correctamente.');
    }
}
