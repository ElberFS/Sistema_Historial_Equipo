<?php

namespace App\Http\Controllers;

use App\Models\Document;
use App\Models\Manager;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use App\Models\DeviceTicket;


class DocumentController extends Controller
{
    /**
     * Muestra todos los documentos.
     */
    public function index()
    {
        // Obtener todos los registros de Document con paginación
        $documents = Document::paginate(10); // Cambiado a paginación para mejor rendimiento

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
    public function edit($id)
    {
        // Buscar el Document por su ID o lanzar una excepción si no se encuentra
        $document = Document::findOrFail($id);

        // Retornar la vista de edición con los datos del Document
        return view('documents.update', compact('document'));
    }

    /**
     * Actualiza un documento existente en la base de datos.
     */
    public function update(Request $request, $id)
    {
        // Buscar el Document por su ID
        $document = Document::findOrFail($id);

        // Validar los datos del formulario
        $validatedData = $request->validate([
            'code' => 'nullable|string|max:50|unique:documents,code,' . $document->id, // Verificar que el código sea único, excepto para el registro actual
            'title' => 'nullable|string|max:255',
            'description' => 'nullable|string|max:500',
            'managers_id' => 'nullable|exists:managers,id',
            'current' => 'require|boolean',
        ]);

        // Actualizar el Document con los datos validados
        $document->update($validatedData);

        // Redirigir a la lista de documentos con un mensaje de éxito
        return redirect()->route('documents.index')->with('success', 'Documento actualizado correctamente.');
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
