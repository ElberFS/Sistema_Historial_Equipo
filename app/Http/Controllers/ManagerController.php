<?php

namespace App\Http\Controllers;

use App\Models\Manager;
use App\Models\User;
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
        // Obtener todos los usuarios para el campo select en el formulario
        $users = User::all(); // O User::pluck('name', 'id') si solo se necesita el nombre y ID

        // Retornar la vista 'create' con la lista de usuarios
        return view('managers.create', compact('users'));
    }

    /**
     * Almacena un nuevo manager en la base de datos.
     */
    public function store(Request $request)
    {
        // Validar los datos enviados desde el formulario
        $validatedData = $request->validate([
            'fullname' => 'required|string|max:70',
            'dni' => ['required', 'regex:/^[0-9]{8}$/'], // DNI debe ser un número de 8 dígitos
            'phone' => ['required', 'regex:/^9[0-9]{8}$/'], // Teléfono debe iniciar con 9 y tener 9 dígitos
            'address' => 'required|string|max:100',
            'users_id' => 'required|exists:users,id', // Asegurarse de que el usuario exista
            'current' => 'required|boolean' // Estado actual del manager (booleano)
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
        $users = User::all(); // Obtener todos los usuarios para el campo select

        // Retornar la vista 'update' con los datos del Manager y los usuarios
        return view('managers.update', compact('manager', 'users'));
    }

    /**
     * Actualiza un manager existente en la base de datos.
     */
    public function update(Request $request, $id)
    {
        // Buscar el Manager por su ID
        $manager = Manager::findOrFail($id);

        // Validar los datos enviados desde el formulario
        $validatedData = $request->validate([
            'fullname' => 'nullable|string|max:70',
            'dni' => ['required', 'regex:/^[0-9]{8}$/'], // El DNI debe seguir el mismo formato
            'phone' => ['required', 'regex:/^9[0-9]{8}$/'], // Validar el formato del teléfono
            'address' => 'nullable|string|max:100',
            'users_id' => 'exists:users,id', // Verificar que el ID del usuario exista
            'current' => 'boolean' // El campo current es booleano
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
