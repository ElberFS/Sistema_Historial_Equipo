<?php

namespace App\Http\Controllers;

use App\Models\Device;
use App\Models\DeviceTicket;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use App\Models\Document;
use App\Models\Ticket;

class DeviceTicketController extends Controller
{
    /**
     * Muestra una lista de todos los device tickets.
     */
    public function index()
    {
        $deviceTickets = DeviceTicket::all(); // Obtener todos los device tickets
        return view('device_tickets.index', compact('deviceTickets')); // Retornar la vista con los device tickets
    }

    /**
     * Muestra el formulario para crear un nuevo device ticket.
     * Permite seleccionar dispositivos y opcionalmente cargar el código de un documento.
     */
    public function create(Request $request)
    {
        $devices = Device::with('deviceType')->get(); // Obtener dispositivos con sus tipos
        $code = $request->input('code', ''); // Obtener el código si proviene de una redirección
        
        return view('device_tickets.create', compact('devices', 'code')); // Retornar la vista de creación
    }

    /**
     * Almacena un nuevo device ticket en la base de datos.
     * Valida y maneja la creación, tanto para tickets desde documentos como desde la sesión.
     */
    public function store(Request $request)
    {
        // Validar los datos del formulario
        $validatedData = $request->validate([
            'code' => 'required|string|max:50',
            'devices_id' => 'required|array',
            'devices_id.*' => 'exists:devices,id', // Validar que cada dispositivo exista
            'current' => 'required|boolean',
        ]);

        DB::beginTransaction(); // Iniciar la transacción

        try {
            $ticketData = session('ticket_data'); // Obtener datos del ticket temporal de la sesión

            if (is_null($ticketData)) {
                // Caso: creación desde un documento existente
                $document = Document::where('code', $validatedData['code'])->firstOrFail();

                foreach ($validatedData['devices_id'] as $deviceId) {
                    DeviceTicket::create([
                        'code' => $validatedData['code'],
                        'devices_id' => $deviceId,
                        'current' => $validatedData['current'],
                        'documents_id' => $document->id, // Asociar con el documento
                    ]);
                }
            } else {
                // Caso: creación desde un ticket temporal en la sesión
                $ticket = Ticket::create($ticketData); // Crear el ticket

                foreach ($validatedData['devices_id'] as $deviceId) {
                    DeviceTicket::create([
                        'code' => $ticket->code, // Usar el código del ticket recién creado
                        'devices_id' => $deviceId,
                        'current' => $validatedData['current'],
                        'ticket_id' => $ticket->id, // Asociar con el ticket
                    ]);
                }
                session()->forget('ticket_data'); // Limpiar la sesión
            }

            DB::commit(); // Hacer commit si todo sale bien

            return redirect()->route('device_tickets.index')->with('success', 'Device ticket(s) created successfully.');
        } catch (\Exception $e) {
            DB::rollBack(); // Hacer rollback en caso de error
            return redirect()->back()->withErrors(['error' => 'Error creating the device ticket. Please try again.']);
        }
    }

    /**
     * Muestra el formulario para editar un device ticket existente.
     */
    public function edit($id)
    {
        $deviceTicket = DeviceTicket::findOrFail($id); // Buscar el device ticket
        $devices = Device::all(); // Obtener todos los dispositivos
        $document = Document::where('code', $deviceTicket->code)->firstOrFail(); // Buscar documento asociado

        return view('device_tickets.update', compact('deviceTicket', 'devices', 'document')); // Retornar la vista de edición
    }

    /**
     * Actualiza un device ticket existente en la base de datos.
     * Valida y actualiza los datos del device ticket.
     */
    public function update(Request $request, $id)
    {
        $deviceTicket = DeviceTicket::findOrFail($id); // Buscar el device ticket

        $validatedData = $request->validate([
            'code' => 'nullable|string|max:50',
            'devices_id' => 'nullable|exists:devices,id',
            'current' => 'boolean',
        ]);

        if (isset($validatedData['devices_id'])) {
            $validatedData['devices_id'] = $validatedData['devices_id'][0]; // Tomar el primer valor si es un array
        }

        DB::beginTransaction(); // Iniciar la transacción

        try {
            $deviceTicket->update($validatedData); // Actualizar el device ticket
            DB::commit(); // Hacer commit si todo sale bien

            return redirect()->route('device_tickets.index')->with('success', 'Device ticket actualizado correctamente.');
        } catch (\Exception $e) {
            DB::rollBack(); // Hacer rollback en caso de error
            return redirect()->back()->withErrors(['error' => 'Error actualizando el device ticket. Por favor, intente nuevamente.']);
        }
    }

    /**
     * Elimina un device ticket de la base de datos.
     */
    public function destroy($id)
    {
        $deviceTicket = DeviceTicket::findOrFail($id); // Buscar el device ticket
        $deviceTicket->delete(); // Eliminar el device ticket

        return redirect()->route('device_tickets.index')->with('success', 'Device ticket eliminado correctamente.');
    }
}
