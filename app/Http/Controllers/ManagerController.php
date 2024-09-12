<?php

namespace App\Http\Controllers;

use App\Models\Manager;
use Illuminate\Http\Request;

class ManagerController extends Controller
{
    /**
     * Muestra todos los managers.
     */
    public function index()
    {
        // Obtener todos los registros de Manager
        $managers = Manager::all();

        // Retornar la vista 'index' con la lista de managers
        return view('managers.index', compact('managers'));
    }

    /**
     * Muestra el formulario para crear un nuevo manager.
     */
    public function create()
    {
        // Retornar la vista para crear un nuevo Manager
        return view('managers.create');
    }

    /**
     * Almacena un nuevo manager en la base de datos.
     */
    public function store(Request $request)
    {
        // Validar los datos del formulario
        $validatedData = $request->validate([
            'fullname' => 'required|string|max:70',
            'dni' => ['required', 'regex:/^[0-9]{8}$/'],
            'phone' => ['required', 'regex:/^9[0-9]{8}$/'],
            'address' => 'required|string|max:100',
            'users_id' => 'required|exists:users,id',
            'current' => 'required|boolean'
        ]);

        // Crear un nuevo Manager con los datos validados
        Manager::create($validatedData);

        // Redirigir a la lista de managers con un mensaje de éxito
        return redirect()->route('managers.index')->with('success', 'Manager creado correctamente.');
    }

    /**
     * Muestra el formulario para editar un manager existente.
     */
    public function edit($id)
    {
        // Buscar el Manager por su ID o lanzar una excepción si no se encuentra
        $manager = Manager::findOrFail($id);

        // Retornar la vista de edición con los datos del Manager
        return view('managers.update', compact('manager'));
    }

    /**
     * Actualiza un manager existente en la base de datos.
     */
    public function update(Request $request, $id)
    {
        // Buscar el Manager por su ID
        $manager = Manager::findOrFail($id);

        // Validar los datos del formulario
        $validatedData = $request->validate([
            'fullname' => 'nullable|string|max:70',
            'dni' => ['required', 'regex:/^[0-9]{8}$/'],
            'phone' => ['required', 'regex:/^9[0-9]{8}$/'],
            'address' => 'nullable|string|max:100',
            'users_id' => 'exists:users,id',
            'current' => 'boolean'
        ]);

        // Actualizar el Manager con los datos validados
        $manager->update($validatedData);

        // Redirigir a la lista de managers con un mensaje de éxito
        return redirect()->route('managers.index')->with('success', 'Manager actualizado correctamente.');
    }

    /**
     * Elimina un manager de la base de datos.
     */
    public function destroy($id)
    {
        // Buscar el Manager por su ID
        $manager = Manager::findOrFail($id);

        // Eliminar el Manager
        $manager->delete();

        // Redirigir a la lista de managers con un mensaje de éxito
        return redirect()->route('managers.index')->with('success', 'Manager eliminado correctamente.');
    }
}
