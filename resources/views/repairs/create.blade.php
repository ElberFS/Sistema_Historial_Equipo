<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 dark:text-white leading-tight">
            {{ __('Create Repair') }}
        </h2>
    </x-slot>

    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white dark:bg-gray-800 overflow-hidden shadow-xl sm:rounded-lg p-6 lg:p-8">

                <form method="POST" action="{{ route('repairs.store') }}" class="max-w-sm mx-auto">
                    @csrf

                    <div class="mb-5">
                        <label for="code" class="block mb-2 text-sm font-medium text-gray-900 dark:text-white">Code</label>
                        <input type="text" name="code" id="code" class="bg-gray-50 border border-gray-300 text-gray-900 text-sm rounded-lg focus:ring-cyan-500 focus:border-cyan-500 block w-full p-2.5 dark:bg-gray-700 dark:border-gray-600 dark:placeholder-gray-400 dark:text-white dark:focus:ring-cyan-500 dark:focus:border-cyan-500" required>
                    </div>

                    <div class="mb-5">
                        <label for="tickets_id" class="block mb-2 text-sm font-medium text-gray-900 dark:text-white">Ticket</label>
                        <select name="tickets_id" id="tickets_id" class="bg-gray-50 border border-gray-300 text-gray-900 text-sm rounded-lg focus:ring-cyan-500 focus:border-cyan-500 block w-full p-2.5 dark:bg-gray-700 dark:border-gray-600 dark:placeholder-gray-400 dark:text-white dark:focus:ring-cyan-500 dark:focus:border-cyan-500" required>
                            @foreach ($tickets as $ticket)
                                <option value="{{ $ticket->id }}">{{ $ticket->code }}</option>
                            @endforeach
                        </select>
                    </div>

                    <div class="mb-5">
                        <label for="device_tickets_id" class="block mb-2 text-sm font-medium text-gray-900 dark:text-white">Device Ticket</label>
                        <select name="device_tickets_id" id="device_tickets_id" class="bg-gray-50 border border-gray-300 text-gray-900 text-sm rounded-lg focus:ring-cyan-500 focus:border-cyan-500 block w-full p-2.5 dark:bg-gray-700 dark:border-gray-600 dark:placeholder-gray-400 dark:text-white dark:focus:ring-cyan-500 dark:focus:border-cyan-500" required>
                            @foreach ($deviceTickets as $deviceTicket)
                                <option value="{{ $deviceTicket->id }}">{{ $deviceTicket->id }}</option>
                            @endforeach
                        </select>
                    </div>

                    <div class="mb-5">
                        <label for="process" class="block mb-2 text-sm font-medium text-gray-900 dark:text-white">Process</label>
                        <input type="text" name="process" id="process" class="bg-gray-50 border border-gray-300 text-gray-900 text-sm rounded-lg focus:ring-cyan-500 focus:border-cyan-500 block w-full p-2.5 dark:bg-gray-700 dark:border-gray-600 dark:placeholder-gray-400 dark:text-white dark:focus:ring-cyan-500 dark:focus:border-cyan-500" required>
                    </div>

                    <div class="mb-5">
                        <label for="current" class="block mb-2 text-sm font-medium text-gray-900 dark:text-white">Current</label>
                        <select name="current" id="current" class="bg-gray-50 border border-gray-300 text-gray-900 text-sm rounded-lg focus:ring-cyan-500 focus:border-cyan-500 block w-full p-2.5 dark:bg-gray-700 dark:border-gray-600 dark:placeholder-gray-400 dark:text-white dark:focus:ring-cyan-500 dark:focus:border-cyan-500" required>
                            <option value="1">Yes</option>
                            <option value="0">No</option>
                        </select>
                    </div>

                    <button type="submit" class="text-white bg-cyan-700 hover:bg-cyan-800 focus:ring-4 focus:outline-none focus:ring-cyan-300 font-medium rounded-lg text-sm w-full sm:w-auto px-5 py-2.5 text-center dark:bg-cyan-600 dark:hover:bg-cyan-700 dark:focus:ring-cyan-800">Save</button>
                    <a href="{{ route('repairs.index') }}" class="text-white bg-slate-700 hover:bg-slate-800 focus:ring-4 focus:outline-none focus:ring-slate-300 font-medium rounded-lg text-sm w-full sm:w-auto px-5 py-2.5 text-center dark:bg-slate-600 dark:hover:bg-slate-700 dark:focus:ring-slate-800">Cancel</a>
                </form>

            </div>
        </div>
    </div>
</x-app-layout>
