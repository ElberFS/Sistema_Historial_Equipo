<?php

namespace App\Http\Controllers;

use App\Models\DeviceTicket;
use Illuminate\Http\Request;

class DeviceTicketController extends Controller
{
    /**
     * Muestra una lista de todos los device tickets.
     */
    public function index()
    {
        // Obtener todos los device tickets
        $deviceTickets = DeviceTicket::all();

        // Retornar la vista 'index' con la lista de device tickets
        return view('device_tickets.index', compact('deviceTickets'));
    }

    /**
     * Muestra el formulario para crear un nuevo device ticket.
     */
    public function create()
    {
        // Retornar la vista para crear un nuevo device ticket
        return view('device_tickets.create');
    }

    /**
     * Almacena un nuevo device ticket en la base de datos.
     */
    public function store(Request $request)
    {
        // Validar los datos del formulario
        $validatedData = $request->validate([
            'code' => 'required|string|max:50',
            'devices_id' => 'required|exists:devices,id',
            'current' => 'required|boolean' // Asegura que sea enviado en el formulario
        ]);

        // Crear un nuevo device ticket con los datos validados
        DeviceTicket::create($validatedData);

        // Redirigir a la lista de device tickets con un mensaje de éxito
        return redirect()->route('device_tickets.index')->with('success', 'Device ticket creado correctamente.');
    }

    /**
     * Muestra el formulario para editar un device ticket existente.
     */
    public function edit($id)
    {
        // Buscar el device ticket por su ID o lanzar una excepción si no se encuentra
        $deviceTicket = DeviceTicket::findOrFail($id);

        // Retornar la vista de edición con los datos del device ticket
        return view('device_tickets.update', compact('deviceTicket'));
    }

    /**
     * Actualiza un device ticket existente en la base de datos.
     */
    public function update(Request $request, $id)
    {
        // Buscar el device ticket por su ID
        $deviceTicket = DeviceTicket::findOrFail($id);

        // Validar los datos del formulario
        $validatedData = $request->validate([
            'code' => 'nullable|string|max:50', // Permitir que el campo no sea obligatorio
            'devices_id' => 'nullable|exists:devices,id',
            'current' => 'boolean' // Si no está presente, no cambiará el valor
        ]);

        // Actualizar el device ticket con los datos validados
        $deviceTicket->update($validatedData);

        // Redirigir a la lista de device tickets con un mensaje de éxito
        return redirect()->route('device_tickets.index')->with('success', 'Device ticket actualizado correctamente.');
    }

    /**
     * Elimina un device ticket de la base de datos.
     */
    public function destroy($id)
    {
        // Buscar el device ticket por su ID
        $deviceTicket = DeviceTicket::findOrFail($id);

        // Eliminar el device ticket
        $deviceTicket->delete();

        // Redirigir a la lista de device tickets con un mensaje de éxito
        return redirect()->route('device_tickets.index')->with('success', 'Device ticket eliminado correctamente.');
    }
}
