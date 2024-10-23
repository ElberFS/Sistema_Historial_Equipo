<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 dark:text-white leading-tight">
            {{ __('Repairs List') }}
        </h2>
    </x-slot>

    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white dark:bg-gray-800 overflow-hidden shadow-xl sm:rounded-lg p-6 lg:p-8">
                <div class="bg-cyan-100 dark:bg-gray-800 border-b border-gray-200 dark:border-gray-700">
                    <div class="mb-4">
                        <a href="{{ route('repairs.create') }}"
                            class="bg-cyan-500 dark:bg-cyan-700 hover:bg-cyan-600 dark:hover:bg-cyan-800 text-white font-bold py-2 px-4 rounded">
                            Create Repair
                        </a>
                    </div>

                    <table class="table-auto w-full">
                        <thead>
                            <tr>
                                <th class="px-4 py-2 text-gray-900 dark:text-white text-center">ID</th>
                                <th class="px-4 py-2 text-gray-900 dark:text-white text-center">Code</th>
                                <th class="px-4 py-2 text-gray-900 dark:text-white text-center">Ticket</th>
                                <th class="px-4 py-2 text-gray-900 dark:text-white text-center">Device Ticket</th>
                                <th class="px-4 py-2 text-gray-900 dark:text-white text-center">Process</th>
                                <th class="px-4 py-2 text-gray-900 dark:text-white text-center">Current</th>
                                <th class="px-4 py-2 text-gray-900 dark:text-white text-center">Actions</th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach ($repairs as $repair)
                                <tr>
                                    <td class="border px-4 py-2 text-gray-900 dark:text-white text-center">{{ $repair->id }}</td>
                                    <td class="border px-4 py-2 text-gray-900 dark:text-white text-center">{{ $repair->code }}</td>
                                    <td class="border px-4 py-2 text-gray-900 dark:text-white text-center">{{ $repair->ticket->code }}</td>
                                    <td class="border px-4 py-2 text-gray-900 dark:text-white text-center">{{ $repair->deviceTicket->code }}</td>
                                    <td class="border px-4 py-2 text-gray-900 dark:text-white text-center">{{ $repair->process }}</td>
                                    <td class="border px-4 py-2 text-gray-900 dark:text-white text-center">
                                        @if($repair->current)
                                            <span class="bg-cyan-200 dark:bg-cyan-700 text-cyan-800 dark:text-cyan-300 py-1 px-3 rounded-full text-xs">Current</span>
                                        @else
                                            <span class="bg-red-200 dark:bg-red-700 text-red-800 dark:text-red-300 py-1 px-3 rounded-full text-xs">Not Current</span>
                                        @endif
                                    </td>
                                    <td class="border px-4 py-2 text-center">
                                        <div class="flex justify-center">
                                            <a href="{{ route('repairs.edit', $repair->id) }}"
                                                class="bg-violet-500 dark:bg-violet-700 hover:bg-violet-600 dark:hover:bg-violet-800 text-white font-bold py-2 px-4 rounded mr-2">Edit</a>
                                            <button type="button"
                                                class="bg-pink-400 dark:bg-pink-600 hover:bg-pink-500 dark:hover:bg-pink-700 text-white font-bold py-2 px-4 rounded"
                                                onclick="confirmDelete('{{ $repair->id }}')">Delete</button>
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

<script>
    function confirmDelete(id) {
        alertify.confirm("Are you sure you want to delete this repair?",
            function() {
                let form = document.createElement('form');
                form.method = 'POST';
                form.action = '/repairs/' + id;
                form.innerHTML = '@csrf @method("DELETE")';
                document.body.appendChild(form);
                form.submit();
                alertify.success('Deleted');
            },
            function() {
                alertify.error('Cancelled');
            });
    }
</script>
