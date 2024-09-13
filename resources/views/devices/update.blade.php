<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 dark:text-white leading-tight">
            {{ __('Edit Device') }}
        </h2>
    </x-slot>

    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white dark:bg-gray-800 overflow-hidden shadow-xl sm:rounded-lg p-6 lg:p-8">
                <form method="POST" action="{{ route('devices.update', $device->id) }}" class="max-w-sm mx-auto">
                    @csrf
                    @method('PUT')

                    <div class="mb-5">
                        <label for="code" class="block mb-2 text-sm font-medium text-gray-900 dark:text-white">Code</label>
                        <input type="text" name="code" id="code" value="{{ old('code', $device->code) }}" class="bg-gray-50 border border-gray-300 text-gray-900 text-sm rounded-lg w-full p-2.5 dark:bg-gray-700 dark:border-gray-600 dark:text-white">
                    </div>

                    <div class="mb-5">
                        <label for="areas_id" class="block mb-2 text-sm font-medium text-gray-900 dark:text-white">Area</label>
                        <select name="areas_id" id="areas_id" class="bg-gray-50 border border-gray-300 text-gray-900 text-sm rounded-lg focus:ring-blue-500 focus:border-blue-500 block w-full p-2.5 dark:bg-gray-700 dark:border-gray-600 dark:placeholder-gray-400 dark:text-white dark:focus:ring-blue-500 dark:focus:border-blue-500">
                            @foreach ($areas as $area)
                            <option value="{{ $area->id }}" {{ old('areas_id', isset($device) ? $device->areas_id : '') == $area->id ? 'selected' : '' }}>
                                {{ $area->name }}
                            </option>
                            @endforeach
                        </select>

                    </div>

                    <select name="device_types_id" id="device_types_id" class="bg-gray-50 border border-gray-300 text-gray-900 text-sm rounded-lg focus:ring-blue-500 focus:border-blue-500 block w-full p-2.5 dark:bg-gray-700 dark:border-gray-600 dark:placeholder-gray-400 dark:text-white dark:focus:ring-blue-500 dark:focus:border-blue-500">
                        @foreach ($deviceTypes as $deviceType)
                        <option value="{{ $deviceType->id }}" {{ old('device_types_id', isset($device) ? $device->device_types_id : '') == $deviceType->id ? 'selected' : '' }}>
                            {{ $deviceType->name }}
                        </option>
                        @endforeach
                    </select>


                    <div class="mb-5">
                        <label for="serial_number" class="block mb-2 text-sm font-medium text-gray-900 dark:text-white">Serial Number</label>
                        <input type="text" name="serial_number" id="serial_number" value="{{ old('serial_number', $device->serial_number) }}" class="bg-gray-50 border border-gray-300 text-gray-900 text-sm rounded-lg w-full p-2.5 dark:bg-gray-700 dark:border-gray-600 dark:text-white">
                    </div>

                    <div class="mb-5">
                        <label for="current" class="block mb-2 text-sm font-medium text-gray-900 dark:text-white">Current</label>
                        <select name="current" id="current" class="bg-gray-50 border border-gray-300 text-gray-900 text-sm rounded-lg w-full p-2.5 dark:bg-gray-700 dark:border-gray-600 dark:text-white">
                            <option value="0" {{ old('current', $device->current) == 0 ? 'selected' : '' }}>No</option>
                            <option value="1" {{ old('current', $device->current) == 1 ? 'selected' : '' }}>Yes</option>
                        </select>
                    </div>

                    <button type="submit" class="bg-blue-700 hover:bg-blue-800 text-white px-5 py-2.5 rounded-lg">Save</button>
                    <a href="{{ route('devices.index') }}" class="bg-slate-700 hover:bg-slate-800 text-white px-5 py-2.5 rounded-lg">Cancel</a>
                </form>
            </div>
        </div>
    </div>
</x-app-layout>