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
     * Muestra todos los documentos.
     */
    public function index()
    {
        // Ejecutar la consulta SQL con el constructor de consultas de Laravel
        $documents = DB::table('documents as d')
            ->join('device_tickets as dt', 'd.code', '=', 'dt.code')
            ->select(
                'd.id',
                'd.code as code',
                'd.title as title',
                'd.description as Description',
                'd.managers_id as manager',
                'd.current as current',
                'dt.devices_id'
            )
            ->paginate(10); // Usar la paginación aquí


        // Retornar la vista 'index' con la lista de documentos
        return view('documents.index', compact('documents'));
    }
    /**
     * Muestra el formulario para crear un nuevo documento.
     */
    public function create()

    {
        $managers = Manager::all();
        // Retornar la vista para crear un nuevo Document
        return view('documents.create', compact('managers'));
    }

    /**
     * Almacena un nuevo documento en la base de datos.
     */
    public function store(Request $request)
    {
        // Validar los datos del formulario del documento
        $validatedData = $request->validate([
            'code' => 'required|string|max:50',
            'title' => 'required|string|max:255',
            'description' => 'nullable|string',
            'managers_id' => 'required|exists:managers,id',
            'current' => 'required|boolean',
        ]);

        // Verificar si el código ya existe en la base de datos
        $originalCode = $validatedData['code'];
        $counter = 1;

        while (Document::where('code', $validatedData['code'])->exists()) {
            $validatedData['code'] = $originalCode . ' - ' . str_pad($counter, 2, '0', STR_PAD_LEFT);
            $counter++;
        }

        // Iniciar la transacción
        DB::beginTransaction();

        try {
            // Crear un nuevo documento
            $document = Document::create($validatedData);

            // Confirmar la transacción
            DB::commit();

            // Obtener el código del documento para el DeviceTicket
            $code = $document->code;

            // Redirigir al formulario de creación de device ticket con el mismo code
            return redirect()->route('device_tickets.create', ['code' => $code])
                ->with('success', 'Document created successfully. Now create a device ticket.');
        } catch (\Exception $e) {
            // Si ocurre un error, hacer rollback
            DB::rollBack();

            return redirect()->back()->withErrors(['error' => 'Error creating the document. Please try again.']);
        }
    }



    /**
     * Muestra el formulario para editar un documento existente.
     */



    /**
     * Actualiza un documento existente en la base de datos.
     */
    /**
     * Actualiza un documento existente en la base de datos.
     */
    public function update(Request $request, $id)
    {
        // Buscar el Document por su ID
        $document = Document::findOrFail($id);

        // Validar y actualizar el documento
        $validatedData = $request->validate([
            'code' => 'nullable|string|max:50|unique:documents,code,' . $document->id,
            'title' => 'nullable|string|max:255',
            'description' => 'nullable|string|max:500',
            'managers_id' => 'nullable|exists:managers,id',
            'current' => 'required|boolean',
        ]);

        $document->update($validatedData);

        // Buscar el DeviceTicket relacionado con el código del documento
        $deviceTicket = DeviceTicket::where('code', $document->code)->firstOrFail();

        // Redirigir al formulario de actualización del DeviceTicket con el ID del DeviceTicket
        return redirect()->route('device_tickets.edit', ['device_ticket' => $deviceTicket->id])
            ->with('success', 'Documento actualizado correctamente. Ahora actualiza el Device Ticket.');
    }


    public function show($id)
    {
        // Buscar el Document por su ID
        $document = Document::findOrFail($id);

        // Obtener todos los managers para el dropdown
        $managers = Manager::all();

        // Retornar la vista de edición con el documento y los managers
        return view('documents.update', compact('document', 'managers'));
    }



    /**
     * Elimina un documento de la base de datos.
     */
    public function destroy($id)
    {
        // Buscar el Document por su ID
        $document = Document::findOrFail($id);

        // Eliminar el Document
        $document->delete();

        // Redirigir a la lista de documentos con un mensaje de éxito
        return redirect()->route('documents.index')->with('success', 'Documento eliminado correctamente.');
    }
}
