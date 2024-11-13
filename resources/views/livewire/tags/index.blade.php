<div>
    <div class="max-w-7xl mx-auto py-10 sm:px-6 lg:px-8">
        <div class="flex flex-col">
            <div class="-my-2 overflow-x-auto sm:-mx-6 lg:-mx-8">
                <div class="space-y-2 align-middle inline-block min-w-full sm:px-6 lg:px-8">

                    <div class="flex justify-between items-center py-1">
                        <a href="{{route('tags.create')}}"
                           class="inline-flex items-center px-4 py-2 bg-gray-800 border border-transparent rounded-md font-semibold text-xs text-white uppercase tracking-widest hover:bg-gray-700 active:bg-gray-900 focus:outline-none focus:border-gray-900 focus:ring focus:ring-gray-300 disabled:opacity-25 transition">
                            <svg class="-ml-1 mr-2 h-5 w-5" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 20 20"
                                 fill="currentColor" aria-hidden="true">
                                <path fill-rule="evenodd"
                                      d="M10 3a1 1 0 011 1v5h5a1 1 0 110 2h-5v5a1 1 0 11-2 0v-5H4a1 1 0 110-2h5V4a1 1 0 011-1z"
                                      clip-rule="evenodd"/>
                            </svg>
                            <span>New Tag</span>
                        </a>
                    </div>
                    <x-input.search wire:model.live="search"/>

                    <table
                        class="shadow overflow-hidden border-b border-gray-200 sm:rounded-lg min-w-full divide-y divide-gray-200">
                        <thead class="bg-gray-50">
                        <tr>
                            <th scope="col"
                                class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">
                                Id
                            </th>
                            <th scope="col"
                                class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">
                                Name
                            </th>
                            <th scope="col"
                                class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">
                                Policy
                            </th>
                            <th scope="col"
                                class="px-6 py-3 text-right text-xs font-medium text-gray-500 uppercase tracking-wider">
                                Actions
                            </th>
                        </tr>
                        </thead>
                        <tbody>

                        @foreach($tags as $tag)
                            <tr class="odd:bg-white even:bg-gray-50">
                                <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-500">
                                    {{ $tag->id }}
                                </td>
                                <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-500">
                                    {{ $tag->name }}
                                </td>
                                <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-500">
                                    {{ $tag->retentionPolicy }}
                                </td>
                                <td class="px-6 py-4 whitespace-nowrap text-right text-sm font-medium">
                                    <div class="flex items-baseline justify-end space-x-2">
                                        <a title="Edit" href="{{ route('tags.edit', $tag->id) }}">
                                            <x-icons.pencil class="text-indigo-600 hover:text-indigo-900"/>
                                        </a>
                                        <button wire:click="delete({{ $tag->id }})" type="button" title="Delete">
                                            <x-icons.trash class="text-indigo-600 hover:text-indigo-900"/>
                                        </button>
                                    </div>
                                </td>
                            </tr>
                        @endforeach
                        </tbody>
                    </table>
                    {{ $tags->links() }}
                </div>
            </div>
        </div>
    </div>
    <form wire:submit.prevent="confirmDelete">
        <x-jet-confirmation-modal wire:model="showDeleteModal">
            <x-slot name="title">Delete tag</x-slot>
            <x-slot name="content">Are you sure you want to delete this tag?</x-slot>
            <x-slot name="footer">
                <div class="flex space-x-2">
                    <x-button.secondary wire:click="cancelDelete">Cancel</x-button.secondary>
                    <x-button.danger type="submit">Delete</x-button.danger>
                </div>
            </x-slot>
        </x-jet-confirmation-modal>
    </form>
</div>
