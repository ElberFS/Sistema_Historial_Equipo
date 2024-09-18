<?php

namespace App\Http\Controllers;

use App\Models\Document;
use Illuminate\Http\Request;

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
        // Retornar la vista para crear un nuevo Document
        return view('documents.create');
    }

    /**
     * Almacena un nuevo documento en la base de datos.
     */
    public function store(Request $request)
    {
        // Validar los datos del formulario
        $validatedData = $request->validate([
            'code' => 'required|string|unique:documents,code|max:50',
            'title' => 'required|string|max:255',
            'description' => 'required|string|max:500',
            'managers_id' => 'required|exists:managers,id',
            'current' => 'required|boolean',
        ]);

        // Crear un nuevo Document con los datos validados
        Document::create($validatedData);

        // Redirigir a la lista de documentos con un mensaje de éxito
        return redirect()->route('documents.index')->with('success', 'Documento creado correctamente.');
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
            'current' => 'nullable|boolean',
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
