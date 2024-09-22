<?php

namespace App\Http\Controllers;

use App\Models\Area;
use App\Models\Manager;
use Illuminate\Http\Request;

class AreaController extends Controller
{
    /**
     * Muestra una lista de todas las áreas disponibles.
     * Devuelve una vista con los registros de áreas.
     */
    public function index()
    {
        $areas = Area::all(); // Obtiene todas las áreas
        return view('areas.index', compact('areas')); // Retorna la vista con las áreas
    }

    /**
     * Muestra el formulario para crear una nueva área.
     * Incluye una lista de todos los managers.
     */
    public function create()
    {
        $managers = Manager::all(); // Obtiene todos los managers
        return view('areas.create', compact('managers')); // Retorna la vista de creación
    }

    /**
     * Almacena una nueva área en la base de datos.
     * Valida los datos enviados desde el formulario.
     * Redirige a la lista de áreas con un mensaje de éxito.
     */
    public function store(Request $request)
    {
        $validatedData = $request->validate([
            'name' => 'required|string|max:100',
            'managers_id' => 'required|exists:managers,id',
            'current' => 'required|boolean'
        ]);

        Area::create($validatedData); // Crea el nuevo registro de área

        return redirect()->route('areas.index')->with('success', 'Área creada correctamente.');
    }

    /**
     * Muestra el formulario para editar un área existente.
     * Incluye la información del área y la lista de managers.
     */
    public function edit($id)
    {
        $area = Area::findOrFail($id); // Busca el área por su ID
        $managers = Manager::all(); // Obtiene todos los managers

        return view('areas.update', compact('area', 'managers')); // Retorna la vista de edición
    }

    /**
     * Actualiza un área existente en la base de datos.
     * Valida los datos del formulario y actualiza el área seleccionada.
     * Redirige a la lista de áreas con un mensaje de éxito.
     */
    public function update(Request $request, $id)
    {
        $area = Area::findOrFail($id); // Busca el área por su ID

        $validatedData = $request->validate([
            'name' => 'required|string|max:100',
            'managers_id' => 'required|exists:managers,id',
            'current' => 'boolean' // Si no está presente, no cambia el valor
        ]);

        $area->update($validatedData); // Actualiza el área

        return redirect()->route('areas.index')->with('success', 'Área actualizada correctamente.');
    }

    /**
     * Elimina un área de la base de datos.
     * Busca el área por su ID y la elimina.
     * Redirige a la lista de áreas con un mensaje de éxito.
     */
    public function destroy($id)
    {
        $area = Area::findOrFail($id); // Busca el área por su ID
        $area->delete(); // Elimina el área

        return redirect()->route('areas.index')->with('success', 'Área eliminada correctamente.');
    }
}
