<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 dark:text-gray-200 leading-tight">
            {{ __('Tickets List') }}
        </h2>
    </x-slot>

    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white dark:bg-gray-800 overflow-hidden shadow-xl sm:rounded-lg p-6 lg:p-8">
                <div class="bg-red dark:bg-gray-800 border-b border-gray-200 dark:border-gray-700">

                    <div class="mb-4">
                        <a href="{{ route('tickets.create') }}"
                            class="bg-cyan-500 dark:bg-cyan-700 hover:bg-cyan-600 dark:hover:bg-cyan-800 text-white font-bold py-2 px-4 rounded">
                            Add New Ticket
                        </a>
                    </div>

                    <table class="table-auto w-full">
                        <thead>
                            <tr>
                                <th class="px-4 py-2 text-gray-900 dark:text-white text-center">Code</th>
                                <th class="px-4 py-2 text-gray-900 dark:text-white text-center">Description</th>
                                <th class="px-4 py-2 text-gray-900 dark:text-white text-center">Document</th>
                                <th class="px-4 py-2 text-gray-900 dark:text-white text-center">User</th>
                                <th class="px-4 py-2 text-gray-900 dark:text-white text-center">Status</th>
                                <th class="px-4 py-2 text-gray-900 dark:text-white text-center">Current</th>
                                <th class="px-4 py-2 text-gray-900 dark:text-white text-center">Actions</th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach ($tickets as $ticket)
                                <tr>
                                    <td class="border px-4 py-2 text-gray-900 dark:text-white text-center">
                                        {{ $ticket->code }}
                                    </td>
                                    <td class="border px-4 py-2 text-gray-900 dark:text-white text-center">
                                        {{ $ticket->description }}
                                    </td>
                                    <td class="border px-4 py-2 text-gray-900 dark:text-white text-center">
                                        {{ $ticket->document->code ?? 'No Document' }}
                                    </td>
                                    <td class="border px-4 py-2 text-gray-900 dark:text-white text-center">
                                        {{ $ticket->user->name }}
                                    </td>
                                    <td class="border px-4 py-2 text-gray-900 dark:text-white text-center">
                                        @if($ticket->status === 'O') 
                                            <span class="bg-yellow-200 dark:bg-yellow-700 text-yellow-800 dark:text-yellow-300 py-1 px-3 rounded-full text-xs">Open</span>
                                        @elseif($ticket->status === 'C')
                                            <span class="bg-green-200 dark:bg-green-700 text-green-800 dark:text-green-300 py-1 px-3 rounded-full text-xs">Closed</span>
                                        @else
                                            <span class="bg-red-200 dark:bg-red-700 text-red-800 dark:text-red-300 py-1 px-3 rounded-full text-xs">Unknown</span>
                                        @endif
                                    </td>
                                    <td class="border px-4 py-2 text-gray-900 dark:text-white text-center">
                                        @if($ticket->current)
                                            <span class="bg-green-200 dark:bg-green-700 text-green-800 dark:text-green-300 py-1 px-3 rounded-full text-xs">Current</span>
                                        @else
                                            <span class="bg-red-200 dark:bg-red-700 text-red-800 dark:text-red-300 py-1 px-3 rounded-full text-xs">Not Current</span>
                                        @endif
                                    </td>
                                    <td class="border px-4 py-2 text-center">
                                        <div class="flex justify-center">
                                            <a href="{{ route('tickets.edit', $ticket->id) }}"
                                                class="bg-violet-500 dark:bg-violet-700 hover:bg-violet-600 dark:hover:bg-violet-800 text-white font-bold py-2 px-4 rounded mr-2">
                                                Edit
                                            </a>
                                            <form action="{{ route('tickets.destroy', $ticket->id) }}" method="POST" class="inline">
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

                    <div class="mt-4">
                        {{ $tickets->links() }} <!-- Paginación -->
                    </div>

                </div>
            </div>
        </div>
    </div>
</x-app-layout>
