<?php

namespace App\Http\Controllers;

use App\Models\Device;
use App\Models\DeviceTicket;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use App\Models\Document;


class DeviceTicketController extends Controller
{
    /**
     * Muestra una lista de todos los device tickets.
     */
    public function index()
    {
        // Obtener todos los device tickets
        $deviceTickets = DeviceTicket::all();

        // Retornar la vista 'index' con la lista de device tickets
        return view('device_tickets.index', compact('deviceTickets'));
    }

    /**
     * Muestra el formulario para crear un nuevo device ticket.
     */
    public function create(Request $request)
    {
        // Obtener todos los dispositivos disponibles con su relación con DeviceType
        $devices = Device::with('deviceType')->get();

        // Obtener el código del documento si viene desde la redirección
        $code = $request->input('code', '');

        // Retornar la vista para crear un nuevo device ticket, pasando el code del documento si existe
        return view('device_tickets.create', compact('devices', 'code'));
    }




    /**
     * Almacena un nuevo device ticket en la base de datos.
     */
    public function store(Request $request)
    {
        // Validar los datos del formulario de DeviceTicket
        $validatedData = $request->validate([
            'code' => 'required|string|max:50',
            'devices_id' => 'required|array', // Asegúrate de que sea un array
            'devices_id.*' => 'exists:devices,id', // Asegura que cada ID exista en la tabla devices
            'current' => 'required|boolean',
        ]);

        // Iniciar la transacción
        DB::beginTransaction();

        try {
            // Iterar sobre cada dispositivo seleccionado y crear un DeviceTicket para cada uno
            foreach ($validatedData['devices_id'] as $deviceId) {
                DeviceTicket::create([
                    'code' => $validatedData['code'],
                    'devices_id' => $deviceId,
                    'current' => $validatedData['current'],
                    'documents_id' => Document::where('code', $validatedData['code'])->first()->id,
                ]);
            }

            // Si todo está bien, hacer commit de la transacción
            DB::commit();

            // Redirigir a la lista de device tickets con un mensaje de éxito
            return redirect()->route('device_tickets.index')->with('success', 'Device ticket(s) created successfully.');
        } catch (\Exception $e) {
            // Si ocurre un error, hacer rollback
            DB::rollBack();

            return redirect()->back()->withErrors(['error' => 'Error creating the device ticket. Please try again.']);
        }
    }


    /**
     * Muestra el formulario para editar un device ticket existente.
     */
    public function edit($id)
    {
        // Buscar el DeviceTicket por su ID
        $deviceTicket = DeviceTicket::findOrFail($id);
        $devices = Device::all();

        // Buscar el documento relacionado con el código del DeviceTicket
        $document = Document::where('code', $deviceTicket->code)->firstOrFail();

        // Retornar la vista de edición con ambos modelos
        return view('device_tickets.update', compact('deviceTicket', 'devices', 'document'));
    }



    /**
     * Actualiza un device ticket existente en la base de datos.
     */
    public function update(Request $request, $id)
    {
        // Verifica los datos que llegan desde el formulario
        

        // Buscar el device ticket por su ID
        $deviceTicket = DeviceTicket::findOrFail($id);

        // Validar los datos del formulario
        $validatedData = $request->validate([
            'code' => 'nullable|string|max:50',
            'devices_id' => 'nullable|exists:devices,id',
            'current' => 'boolean'
        ]);
        if (isset($validatedData['devices_id'])) {
            $validatedData['devices_id'] = $validatedData['devices_id'][0]; // Tomar el primer valor del array
        }
        // Iniciar la transacción
        DB::beginTransaction();

        try {
            // Actualizar el device ticket con los datos validados
            $deviceTicket->update($validatedData);

            // Si todo está bien, hacer commit de la transacción
            DB::commit();

            return redirect()->route('device_tickets.index')->with('success', 'Device ticket actualizado correctamente.');
        } catch (\Exception $e) {
            // Hacer rollback en caso de error
            
            return redirect()->back()->withErrors(['error' => 'Error actualizando el device ticket. Por favor, intente nuevamente.']);
        }
    }



    /**
     * Elimina un device ticket de la base de datos.
     */
    public function destroy($id)
    {
        // Buscar el device ticket por su ID
        $deviceTicket = DeviceTicket::findOrFail($id);

        // Eliminar el device ticket
        $deviceTicket->delete();

        // Redirigir a la lista de device tickets con un mensaje de éxito
        return redirect()->route('device_tickets.index')->with('success', 'Device ticket eliminado correctamente.');
    }
}
