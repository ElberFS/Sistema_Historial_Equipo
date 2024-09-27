
<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 dark:text-gray-200 leading-tight">
            {{ __('Devices List') }}
        </h2>
    </x-slot>

    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white dark:bg-gray-800 overflow-hidden shadow-xl sm:rounded-lg p-6 lg:p-8">
                <div class="bg-red dark:bg-gray-800 border-b border-gray-200 dark:border-gray-700">

                    <div class="mb-4">
                        <a href="{{ route('devices.create') }}"
                            class="bg-cyan-500 dark:bg-cyan-700 hover:bg-cyan-600 dark:hover:bg-cyan-800 text-white font-bold py-2 px-4 rounded">
                            Add New Device
                        </a>
                    </div>

                    <table class="table-auto w-full">
                        <thead>
                            <tr>
                                <th class="px-4 py-2 text-gray-900 dark:text-white text-center">Code</th>
                                <th class="px-4 py-2 text-gray-900 dark:text-white text-center">Area</th>
                                <th class="px-4 py-2 text-gray-900 dark:text-white text-center">Device Type</th>
                                <th class="px-4 py-2 text-gray-900 dark:text-white text-center">Serial Number</th>
                                <th class="px-4 py-2 text-gray-900 dark:text-white text-center">Current</th>
                                <th class="px-4 py-2 text-gray-900 dark:text-white text-center">Actions</th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach ($devices as $device)
                                <tr>
                                    <td class="border px-4 py-2 text-gray-900 dark:text-white text-center">
                                        {{ $device->code }}
                                    </td>
                                    <td class="border px-4 py-2 text-gray-900 dark:text-white text-center">
                                        {{ $device->areas_id }}
                                    </td>
                                    <td class="border px-4 py-2 text-gray-900 dark:text-white text-center">
                                        {{ $device->device_types_id }}
                                    </td>
                                    <td class="border px-4 py-2 text-gray-900 dark:text-white text-center">
                                        {{ $device->serial_number }}
                                    </td>
                                    <td class="border px-4 py-2 text-gray-900 dark:text-white text-center">
                                        @if($device->current)
                                            <span class="bg-green-200 dark:bg-green-700 text-green-800 dark:text-green-300 py-1 px-3 rounded-full text-xs">Current</span>
                                        @else
                                            <span class="bg-red-200 dark:bg-red-700 text-red-800 dark:text-red-300 py-1 px-3 rounded-full text-xs">Not Current</span>
                                        @endif
                                    </td>
                                    <td class="border px-4 py-2 text-center">
                                        <div class="flex justify-center">
                                            <a href="{{ route('devices.edit', $device->id) }}"
                                                class="bg-violet-500 dark:bg-violet-700 hover:bg-violet-600 dark:hover:bg-violet-800 text-white font-bold py-2 px-4 rounded mr-2">
                                                Edit
                                            </a>
                                            <form action="{{ route('devices.destroy', $device->id) }}" method="POST" class="inline">
                                                @csrf
                                                @method('DELETE')
                                                <button type="submit"
                                                    class="bg-pink-400 dark:bg-pink-600 hover:bg-pink-500 dark:hover:bg-pink-700 text-white font-bold py-2 px-4 rounded">
                                                    Delete
                                                </button>
                                            </form>
                                        </div>
                                    </td>
                                </tr>
                            @endforeach
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
    </div>
</x-app-layout>

