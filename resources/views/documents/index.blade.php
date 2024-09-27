<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 dark:text-gray-200 leading-tight">
            {{ __('Documents List') }}
        </h2>
    </x-slot>

    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white dark:bg-gray-800 overflow-hidden shadow-xl sm:rounded-lg p-6 lg:p-8">
                <div class="bg-red dark:bg-gray-800 border-b border-gray-200 dark:border-gray-700">

                    <div class="mb-4">
                        <a href="{{ route('documents.create') }}"
                            class="bg-cyan-500 dark:bg-cyan-700 hover:bg-cyan-600 dark:hover:bg-cyan-800 text-white font-bold py-2 px-4 rounded">
                            Add New Document
                        </a>
                    </div>

                    <table class="table-auto w-full">
                        <thead>
                            <tr>
                                <th class="px-4 py-2 text-gray-900 dark:text-white text-center">Code</th>
                                <th class="px-4 py-2 text-gray-900 dark:text-white text-center">Title</th>
                                <th class="px-4 py-2 text-gray-900 dark:text-white text-center">Description</th>
                                <th class="px-4 py-2 text-gray-900 dark:text-white text-center">Manager</th>
                                <th class="px-4 py-2 text-gray-900 dark:text-white text-center">Current</th>
                                <th class="px-4 py-2 text-gray-900 dark:text-white text-center">Device ID</th>
                                <th class="px-4 py-2 text-gray-900 dark:text-white text-center">Actions</th>
                            </tr>
                        </thead>
                        <tbody>
                            @php
                            // Agrupar por 'code' directamente en la vista
                            $groupedDocuments = $documents->groupBy('code');
                            @endphp
                            @foreach ($groupedDocuments as $code => $groupedDocs)
                            @php
                            $rowspan = count($groupedDocs);
                            @endphp
                            @foreach ($groupedDocs as $index => $document)
                            <tr>
                                @if ($index === 0)
                                <td class="border px-4 py-2 text-gray-900 dark:text-white text-center" rowspan="{{ $rowspan }}">
                                    {{ $document->code }}
                                </td>
                                <td class="border px-4 py-2 text-gray-900 dark:text-white text-center" rowspan="{{ $rowspan }}">
                                    {{ $document->title }}
                                </td>
                                <td class="border px-4 py-2 text-gray-900 dark:text-white text-center" rowspan="{{ $rowspan }}">
                                    {{ $document->description }}
                                </td>
                                <td class="border px-4 py-2 text-gray-900 dark:text-white text-center" rowspan="{{ $rowspan }}">
                                    {{ $document->manager }}
                                </td>
                                <td class="border px-4 py-2 text-gray-900 dark:text-white text-center" rowspan="{{ $rowspan }}">
                                    @if($document->current)
                                    <span class="bg-green-200 dark:bg-green-700 text-green-800 dark:text-green-300 py-1 px-3 rounded-full text-xs">Current</span>
                                    @else
                                    <span class="bg-red-200 dark:bg-red-700 text-red-800 dark:text-red-300 py-1 px-3 rounded-full text-xs">Not Current</span>
                                    @endif
                                </td>
                                @endif
                                <td class="border px-4 py-2 text-gray-900 dark:text-white text-center">
                                    {{ $document->devices_id }}
                                </td>
                                @if ($index === 0)
                                <!-- Modificamos la columna Action solo aquí -->
                                <td class="border px-4 py-2 text-center" rowspan="{{ $rowspan }}">
                                    <div class="flex justify-center">
                                        <a href="{{ route('documents.update', $document->id) }}"
                                            class="bg-violet-500 dark:bg-violet-700 hover:bg-violet-600 dark:hover:bg-violet-800 text-white font-bold py-2 px-4 rounded mr-2">
                                            Edit
                                        </a>
                                        <form action="{{ route('documents.destroy', $document->id) }}" method="POST" class="inline">
                                            @csrf
                                            @method('DELETE')
                                            <button type="submit"
                                                class="bg-pink-400 dark:bg-pink-600 hover:bg-pink-500 dark:hover:bg-pink-700 text-white font-bold py-2 px-4 rounded">
                                                Delete
                                            </button>
                                        </form>
                                    </div>
                                </td>
                                @endif
                            </tr>
                            @endforeach
                            @endforeach
                        </tbody>

                    </table>

                    <div class="mt-4">
                        {{ $documents->links() }} <!-- Paginación -->
                    </div>

                </div>
            </div>
        </div>
    </div>
</x-app-layout>