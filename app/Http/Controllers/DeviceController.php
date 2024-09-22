<?php

namespace App\Http\Controllers;

use App\Models\Area;
use App\Models\Device;
use App\Models\DeviceType;
use Illuminate\Http\Request;

class DeviceController extends Controller
{
    /**
     * Muestra una lista de todos los dispositivos disponibles.
     * Devuelve una vista con los registros de dispositivos.
     */
    public function index()
    {
        $devices = Device::all(); // Obtiene todos los dispositivos
        return view('devices.index', compact('devices')); // Retorna la vista con los dispositivos
    }

    /**
     * Muestra el formulario para crear un nuevo dispositivo.
     * Incluye las áreas y los tipos de dispositivos disponibles.
     */
    public function create()
    {
        $areas = Area::all(); // Obtiene todas las áreas
        $deviceTypes = DeviceType::all(); // Obtiene todos los tipos de dispositivos

        return view('devices.create', compact('areas', 'deviceTypes')); // Retorna la vista de creación
    }

    /**
     * Almacena un nuevo dispositivo en la base de datos.
     * Valida los datos enviados desde el formulario.
     * Redirige a la lista de dispositivos con un mensaje de éxito.
     */
    public function store(Request $request)
    {
        $validatedData = $request->validate([
            'code' => 'required|string|max:50',
            'areas_id' => 'required|exists:areas,id',
            'device_types_id' => 'required|exists:device_types,id',
            'serial_number' => 'required|string|max:100',
            'current' => 'required|boolean'
        ]);

        Device::create($validatedData); // Crea el nuevo registro de dispositivo

        return redirect()->route('devices.index')->with('success', 'Dispositivo creado correctamente.');
    }

    /**
     * Muestra el formulario para editar un dispositivo existente.
     * Incluye la información del dispositivo, áreas y tipos de dispositivos.
     */
    public function edit($id)
    {
        $device = Device::findOrFail($id); // Busca el dispositivo por su ID
        $areas = Area::all(); // Obtiene todas las áreas
        $deviceTypes = DeviceType::all(); // Obtiene todos los tipos de dispositivos

        return view('devices.update', compact('device', 'areas', 'deviceTypes')); // Retorna la vista de edición
    }

    /**
     * Actualiza un dispositivo existente en la base de datos.
     * Valida los datos del formulario y actualiza el dispositivo seleccionado.
     * Redirige a la lista de dispositivos con un mensaje de éxito.
     */
    public function update(Request $request, $id)
    {
        $device = Device::findOrFail($id); // Busca el dispositivo por su ID

        $validatedData = $request->validate([
            'code' => 'nullable|string|max:50', // El campo es opcional
            'areas_id' => 'nullable|exists:areas,id',
            'device_types_id' => 'nullable|exists:device_types,id',
            'serial_number' => 'nullable|string|max:100',
            'current' => 'boolean' // Si no está presente, no cambia el valor
        ]);

        $device->update($validatedData); // Actualiza el dispositivo

        return redirect()->route('devices.index')->with('success', 'Dispositivo actualizado correctamente.');
    }

    /**
     * Elimina un dispositivo de la base de datos.
     * Busca el dispositivo por su ID y lo elimina.
     * Redirige a la lista de dispositivos con un mensaje de éxito.
     */
    public function destroy($id)
    {
        $device = Device::findOrFail($id); // Busca el dispositivo por su ID
        $device->delete(); // Elimina el dispositivo

        return redirect()->route('devices.index')->with('success', 'Dispositivo eliminado correctamente.');
    }
}
