<?php

namespace App\Http\Controllers;

use App\Models\Area;
use App\Models\Device;
use App\Models\DeviceType;
use Illuminate\Http\Request;

class DeviceController extends Controller
{
    /**
     * Muestra una lista de todos los dispositivos.
     */
    public function index()
    {
        // Obtener todos los dispositivos
        $devices = Device::all();

        // Retornar la vista 'index' con la lista de dispositivos
        return view('devices.index', compact('devices'));
    }

    /**
     * Muestra el formulario para crear un nuevo dispositivo.
     */
    public function create()
    {
        // Retrieve all areas and device types
        $areas = Area::all();
        $deviceTypes = DeviceType::all();

        // Pass them to the view
        return view('devices.create', compact('areas', 'deviceTypes'));
    }



    /**
     * Almacena un nuevo dispositivo en la base de datos.
     */
    public function store(Request $request)
    {
        // Validar los datos del formulario
        $validatedData = $request->validate([
            'code' => 'required|string|max:50',
            'areas_id' => 'required|exists:areas,id',
            'device_types_id' => 'required|exists:device_types,id',
            'serial_number' => 'required|string|max:100',
            'current' => 'required|boolean' // Asegura que sea enviado en el formulario
        ]);

        // Crear un nuevo dispositivo con los datos validados
        Device::create($validatedData);

        // Redirigir a la lista de dispositivos con un mensaje de éxito
        return redirect()->route('devices.index')->with('success', 'Dispositivo creado correctamente.');
    }

    /**
     * Muestra el formulario para editar un dispositivo existente.
     */
    public function edit($id)
    {
        // Retrieve the device to edit
        $device = Device::findOrFail($id);

        // Retrieve all areas and device types
        $areas = Area::all();
        $deviceTypes = DeviceType::all();

        // Pass them to the view
        return view('devices.update', compact('device', 'areas', 'deviceTypes'));
    }


    /**
     * Actualiza un dispositivo existente en la base de datos.
     */
    public function update(Request $request, $id)
    {
        // Buscar el dispositivo por su ID
        $device = Device::findOrFail($id);

        // Validar los datos del formulario
        $validatedData = $request->validate([
            'code' => 'nullable|string|max:50', // Permitir que el campo no sea obligatorio
            'areas_id' => 'nullable|exists:areas,id',
            'device_types_id' => 'nullable|exists:device_types,id',
            'serial_number' => 'nullable|string|max:100',
            'current' => 'boolean' // Si no está presente, no cambiará el valor
        ]);

        // Actualizar el dispositivo con los datos validados
        $device->update($validatedData);

        // Redirigir a la lista de dispositivos con un mensaje de éxito
        return redirect()->route('devices.index')->with('success', 'Dispositivo actualizado correctamente.');
    }

    /**
     * Elimina un dispositivo de la base de datos.
     */
    public function destroy($id)
    {
        // Buscar el dispositivo por su ID
        $device = Device::findOrFail($id);

        // Eliminar el dispositivo
        $device->delete();

        // Redirigir a la lista de dispositivos con un mensaje de éxito
        return redirect()->route('devices.index')->with('success', 'Dispositivo eliminado correctamente.');
    }
}
