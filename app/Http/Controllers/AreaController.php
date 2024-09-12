<?php

namespace App\Http\Controllers;

use App\Models\Area;
use Illuminate\Http\Request;

class AreaController extends Controller
{
    /**
     * Muestra una lista de todas las áreas.
     */
    public function index()
    {
        // Obtener todas las áreas
        $areas = Area::all();

        // Retornar la vista 'index' con la lista de áreas
        return view('areas.index', compact('areas'));
    }

    /**
     * Muestra el formulario para crear una nueva área.
     */
    public function create()
    {
        // Retornar la vista para crear una nueva área
        return view('areas.create');
    }

    /**
     * Almacena una nueva área en la base de datos.
     */
    public function store(Request $request)
    {
        // Validar los datos del formulario
        $validatedData = $request->validate([
            'name' => 'required|string|max:100',
            'managers_id' => 'required|exists:managers,id',
            'current' => 'required|boolean' // Asegura que sea enviado en el formulario
        ]);

        // Crear una nueva área con los datos validados
        Area::create($validatedData);

        // Redirigir a la lista de áreas con un mensaje de éxito
        return redirect()->route('areas.index')->with('success', 'Área creada correctamente.');
    }

    /**
     * Muestra el formulario para editar una área existente.
     */
    public function edit($id)
    {
        // Buscar el área por su ID o lanzar una excepción si no se encuentra
        $area = Area::findOrFail($id);

        // Retornar la vista de edición con los datos del área
        return view('areas.update', compact('area'));
    }

    /**
     * Actualiza una área existente en la base de datos.
     */
    public function update(Request $request, $id)
    {
        // Buscar el área por su ID
        $area = Area::findOrFail($id);

        // Validar los datos del formulario
        $validatedData = $request->validate([
            'name' => 'nullable|string|max:100', // Permitir que el campo no sea obligatorio
            'managers_id' => 'nullable|exists:managers,id',
            'current' => 'boolean' // Si no está presente, no cambiará el valor
        ]);

        // Actualizar el área con los datos validados
        $area->update($validatedData);

        // Redirigir a la lista de áreas con un mensaje de éxito
        return redirect()->route('areas.index')->with('success', 'Área actualizada correctamente.');
    }

    /**
     * Elimina una área de la base de datos.
     */
    public function destroy($id)
    {
        // Buscar el área por su ID
        $area = Area::findOrFail($id);

        // Eliminar el área
        $area->delete();

        // Redirigir a la lista de áreas con un mensaje de éxito
        return redirect()->route('areas.index')->with('success', 'Área eliminada correctamente.');
    }
}
