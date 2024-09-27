<?php

namespace App\Http\Controllers;

use App\Models\DeviceType;
use Illuminate\Http\Request;

class DeviceTypeController extends Controller
{
    /**
     * Muestra una lista de todos los tipos de dispositivos.
     */
    public function index()
    {
        $deviceTypes = DeviceType::all(); // Obtener todos los registros de DeviceType
        return view('device_types.index',
        
        compact('deviceTypes')); // Retornar la vista con los tipos de dispositivos
    }

    /**
     * Muestra el formulario para crear un nuevo tipo de dispositivo.
     */
    public function create()
    {
        return view('device_types.create'); // Retornar la vista de creación
    }

    /**
     * Almacena un nuevo tipo de dispositivo en la base de datos.
     */
    public function store(Request $request)
    {
        // Validar los datos del formulario
        $validatedData = $request->validate([
            'name' => 'required|string|max:255',
            'brand' => 'required|string|max:255',
            'model' => 'required|string|max:255',
            'current' => 'required|boolean', // Verificar que 'current' sea enviado como booleano
        ]);

        DeviceType::create($validatedData); // Crear un nuevo DeviceType

        // Redirigir a la lista de tipos de dispositivos con un mensaje de éxito
        return redirect()->route('device_types.index')->with('success', 'Tipo de equipo creado correctamente.');
    }

    /**
     * Muestra el formulario para editar un tipo de dispositivo existente.
     */
    public function edit($id)
    {
        $deviceType = DeviceType::findOrFail($id); // Buscar el DeviceType por su ID
        return view('device_types.update', compact('deviceType')); // Retornar la vista de edición
    }

    /**
     * Actualiza un tipo de dispositivo existente en la base de datos.
     */
    public function update(Request $request, $id)
    {
        $deviceType = DeviceType::findOrFail($id); // Buscar el DeviceType por su ID

        // Validar los datos del formulario
        $validatedData = $request->validate([
            'name' => 'nullable|string|max:255', // Permitir que los campos sean opcionales
            'brand' => 'nullable|string|max:255',
            'model' => 'nullable|string|max:255',
            'current' => 'boolean', // 'boolean' asegura que solo sea true/false
        ]);

        $deviceType->update($validatedData); // Actualizar el DeviceType

        // Redirigir a la lista de tipos de dispositivos con un mensaje de éxito
        return redirect()->route('device_types.index')->with('success', 'Tipo de equipo actualizado correctamente.');
    }

    /**
     * Elimina un tipo de dispositivo de la base de datos.
     */
    public function destroy($id)
    {
        $deviceType = DeviceType::findOrFail($id); // Buscar el DeviceType por su ID
        $deviceType->delete(); // Eliminar el DeviceType

        // Redirigir a la lista de tipos de dispositivos con un mensaje de éxito
        return redirect()->route('device_types.index')->with('success', 'Tipo de equipo eliminado correctamente.');
    }
}
