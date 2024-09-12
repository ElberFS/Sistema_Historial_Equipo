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
        // Obtener todos los registros de DeviceType
        $deviceTypes = DeviceType::all();

        // Retornar la vista 'index' con la lista de tipos de dispositivos
        return view('device_types.index', compact('deviceTypes'));
    }

    /**
     * Muestra el formulario para crear un nuevo tipo de dispositivo.
     */
    public function create()
    {
        // Retornar la vista para crear un nuevo DeviceType
        return view('device_types.create');
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
            'current' => 'required|boolean' // 'required' asegura que sea enviado en el formulario
        ]);

        // Crear un nuevo DeviceType con los datos validados
        DeviceType::create($validatedData);

        // Redirigir a la lista de tipos de dispositivos con un mensaje de éxito
        return redirect()->route('device_types.index')->with('success', 'Tipo de equipo creado correctamente.');
    }

    /**
     * Muestra el formulario para editar un tipo de dispositivo existente.
     */
    public function edit($id)
    {
        // Buscar el DeviceType por su ID o lanzar una excepción si no se encuentra
        $deviceType = DeviceType::findOrFail($id);

        // Retornar la vista de edición con los datos del DeviceType
        return view('device_types.update', compact('deviceType'));
    }

    /**
     * Actualiza un tipo de dispositivo existente en la base de datos.
     */
    public function update(Request $request, $id)
    {
        // Buscar el DeviceType por su ID
        $deviceType = DeviceType::findOrFail($id);

        // Validar los datos del formulario
        $validatedData = $request->validate([
            'name' => 'nullable|string|max:255', // 'nullable' permite que el campo no sea obligatorio
            'brand' => 'nullable|string|max:255',
            'model' => 'nullable|string|max:255',
            'current' => 'boolean' // Si no está presente, no cambiará el valor
        ]);

        // Actualizar el DeviceType con los datos validados
        $deviceType->update($validatedData);

        // Redirigir a la lista de tipos de dispositivos con un mensaje de éxito
        return redirect()->route('device_types.index')->with('success', 'Tipo de equipo actualizado correctamente.');
    }

    /**
     * Elimina un tipo de dispositivo de la base de datos.
     */
    public function destroy($id)
    {
        // Buscar el DeviceType por su ID
        $deviceType = DeviceType::findOrFail($id);

        // Eliminar el DeviceType
        $deviceType->delete();

        // Redirigir a la lista de tipos de dispositivos con un mensaje de éxito
        return redirect()->route('device_types.index')->with('success', 'Tipo de equipo eliminado correctamente.');
    }
}
