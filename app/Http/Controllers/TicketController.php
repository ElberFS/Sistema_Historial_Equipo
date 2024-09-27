<?php

namespace App\Http\Controllers;

use App\Models\DeviceTicket;
use App\Models\Ticket;
use App\Models\Document;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class TicketController extends Controller
{
    /**
     * Muestra todos los tickets paginados.
     */
    public function index()
    {
        // Obtener todos los tickets con las relaciones de usuario y documento
        $tickets = Ticket::with(['user', 'document'])
            ->select('id', 'code', 'description', 'status', 'current', 'users_id', 'documents_id')
            ->paginate(10); // Paginación para mejorar el rendimiento

        return view('tickets.index', compact('tickets'));
    }
    



    /**
     * Muestra el formulario para crear un nuevo ticket.
     */
    public function create()
    {
        // Obtener todos los usuarios y documentos para los campos select
        $users = User::all();
        $documents = Document::all();

        return view('tickets.create', compact('users', 'documents'));
    }

    /**
     * Almacena un nuevo ticket en la base de datos.
     */
    public function store(Request $request)
    {
        // Validar los datos del formulario
        $validatedData = $request->validate([
            'code' => 'required|string|max:50',
            'description' => 'required|string|max:255',
            'documents_id' => 'nullable|exists:documents,id', // Documento opcional
            'users_id' => 'required|exists:users,id', // El usuario es obligatorio
            'status' => 'required|string|max:1', // Estado del ticket (carácter único)
            'current' => 'required|boolean', // Booleano que indica si el ticket está activo
        ]);

        // Si no se seleccionó un documento, guardar temporalmente en la sesión
        if (is_null($validatedData['documents_id'])) {
            session(['ticket_data' => $validatedData]); // Guardar los datos del ticket en la sesión

            // Redirigir a la creación de device tickets con un mensaje
            return redirect()->route('device_tickets.create', ['code' => $validatedData['code']])
                ->with('message', 'Por favor, complete el ticket de dispositivo.');
        }

        // Iniciar la transacción de la base de datos
        DB::beginTransaction();

        try {
            // Crear el ticket con el documento seleccionado
            Ticket::create($validatedData);

            // Confirmar la transacción
            DB::commit();

            // Redirigir a la lista de tickets con un mensaje de éxito
            return redirect()->route('tickets.index')
                ->with('success', 'Ticket creado correctamente.');
        } catch (\Exception $e) {
            // Si ocurre un error, revertir la transacción
            DB::rollBack();

            // Redirigir de nuevo con un mensaje de error
            return redirect()->back()->withErrors(['error' => 'Error al crear el ticket. Inténtalo de nuevo.']);
        }
    }

    /**
     * Muestra el formulario para editar un ticket existente.
     */
    public function show($id)
    {
        // Buscar el ticket por su ID o fallar si no existe
        $ticket = Ticket::findOrFail($id);

        // Obtener todos los usuarios y documentos para los campos select
        $users = User::all();
        $documents = Document::all();

        return view('tickets.update', compact('ticket', 'users', 'documents'));
    }

    /**
     * Actualiza un ticket existente en la base de datos.
     */
    public function update(Request $request, $id)
    {
        // Buscar el ticket por su ID
        $ticket = Ticket::findOrFail($id);

        // Validar los datos actualizados
        $validatedData = $request->validate([
            'code' => 'nullable|string|max:50|unique:tickets,code,' . $ticket->id, // El código debe ser único
            'description' => 'nullable|string|max:255',
            'users_id' => 'nullable|exists:users,id',
            'documents_id' => 'nullable|exists:documents,id',
            'status' => 'required|string|max:1', // Estado requerido
            'current' => 'required|boolean', // Estado actual booleano
        ]);

        // Actualizar el ticket con los datos validados
        $ticket->update($validatedData);

        // Redirigir a la lista de tickets con un mensaje de éxito
        return redirect()->route('tickets.index')
            ->with('success', 'Ticket actualizado correctamente.');
    }

    /**
     * Elimina un ticket de la base de datos.
     */
    public function destroy($id)
    {
        // Buscar el ticket por su ID
        $ticket = Ticket::findOrFail($id);

        // Eliminar el ticket
        $ticket->delete();

        // Redirigir a la lista de tickets con un mensaje de éxito
        return redirect()->route('tickets.index')->with('success', 'Ticket eliminado correctamente.');
    }
}
