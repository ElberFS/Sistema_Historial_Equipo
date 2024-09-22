<?php

namespace App\Http\Controllers;

use App\Models\DeviceTicket;
use App\Models\Document;
use App\Models\Manager;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class DocumentController extends Controller
{
    /**
     * Muestra una lista de todos los documentos con paginación.
     */
    public function index()
    {
        // Obtener todos los documentos con relación a DeviceTicket usando JOIN y paginación
        $documents = DB::table('documents as d')
            ->join('device_tickets as dt', 'd.code', '=', 'dt.code')
            ->select(
                'd.id',
                'd.code',
                'd.title',
                'd.description',
                'd.managers_id as manager',
                'd.current',
                'dt.devices_id'
            )
            ->paginate(10); // Paginar los resultados

        return view('documents.index', compact('documents')); // Retornar la vista con los documentos
    }

    /**
     * Muestra el formulario para crear un nuevo documento.
     */
    public function create()
    {
        $managers = Manager::all(); // Obtener todos los managers
        return view('documents.create', compact('managers')); // Retornar la vista de creación
    }

    /**
     * Almacena un nuevo documento en la base de datos.
     */
    public function store(Request $request)
    {
        // Validar los datos del formulario
        $validatedData = $request->validate([
            'code' => 'required|string|max:50',
            'title' => 'required|string|max:255',
            'description' => 'nullable|string',
            'managers_id' => 'required|exists:managers,id',
            'current' => 'required|boolean',
        ]);

        // Verificar si el código ya existe y modificarlo si es necesario
        $originalCode = $validatedData['code'];
        $counter = 1;
        while (Document::where('code', $validatedData['code'])->exists()) {
            $validatedData['code'] = $originalCode . ' - ' . str_pad($counter++, 2, '0', STR_PAD_LEFT);
        }

        // Iniciar transacción para garantizar la consistencia de los datos
        DB::beginTransaction();

        try {
            // Crear un nuevo documento
            $document = Document::create($validatedData);

            // Confirmar la transacción
            DB::commit();

            // Redirigir a la creación de DeviceTicket con el mismo código
            return redirect()->route('device_tickets.create', ['code' => $document->code])
                ->with('success', 'Documento creado correctamente. Ahora crea un Device Ticket.');
        } catch (\Exception $e) {
            // Si hay un error, revertir la transacción
            DB::rollBack();

            return redirect()->back()->withErrors(['error' => 'Error al crear el documento. Inténtelo de nuevo.']);
        }
    }

    /**
     * Muestra el formulario para editar un documento existente.
     */
    public function show($id)
    {
        $document = Document::findOrFail($id); // Buscar el documento por su ID
        $managers = Manager::all(); // Obtener todos los managers

        return view('documents.update', compact('document', 'managers')); // Retornar la vista de edición
    }

    /**
     * Actualiza un documento existente en la base de datos.
     */
    public function update(Request $request, $id)
    {
        $document = Document::findOrFail($id); // Buscar el documento por su ID

        // Validar los datos del formulario y asegurarse de que el código sea único
        $validatedData = $request->validate([
            'code' => 'nullable|string|max:50|unique:documents,code,' . $document->id,
            'title' => 'nullable|string|max:255',
            'description' => 'nullable|string|max:500',
            'managers_id' => 'nullable|exists:managers,id',
            'current' => 'required|boolean',
        ]);

        // Actualizar el documento
        $document->update($validatedData);

        // Buscar el DeviceTicket relacionado por el código del documento
        $deviceTicket = DeviceTicket::where('code', $document->code)->firstOrFail();

        // Redirigir a la edición del DeviceTicket correspondiente
        return redirect()->route('device_tickets.edit', ['device_ticket' => $deviceTicket->id])
            ->with('success', 'Documento actualizado correctamente. Ahora actualiza el Device Ticket.');
    }

    /**
     * Elimina un documento de la base de datos.
     */
    public function destroy($id)
    {
        $document = Document::findOrFail($id); // Buscar el documento por su ID
        $document->delete(); // Eliminar el documento

        // Redirigir a la lista de documentos con un mensaje de éxito
        return redirect()->route('documents.index')->with('success', 'Documento eliminado correctamente.');
    }
}
