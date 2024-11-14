<div>
    <div class="max-w-7xl mx-auto py-10 sm:px-6 lg:px-8">
        <div class="flex flex-col">
            <div class="-my-2 overflow-x-auto sm:-mx-6 lg:-mx-8">
                <div class="space-y-2 align-middle inline-block min-w-full sm:px-6 lg:px-8">

                    <div class="flex justify-between items-center py-1">
                            <a href="{{route('messages.create')}}"
                               class="inline-flex items-center px-4 py-2 bg-gray-800 border border-transparent rounded-md font-semibold text-xs text-white uppercase tracking-widest hover:bg-gray-700 active:bg-gray-900 focus:outline-none focus:border-gray-900 focus:ring focus:ring-gray-300 disabled:opacity-25 transition">
                                <svg class="-ml-1 mr-2 h-5 w-5" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 20 20"
                                     fill="currentColor" aria-hidden="true">
                                    <path fill-rule="evenodd"
                                          d="M10 3a1 1 0 011 1v5h5a1 1 0 110 2h-5v5a1 1 0 11-2 0v-5H4a1 1 0 110-2h5V4a1 1 0 011-1z"
                                          clip-rule="evenodd"/>
                                </svg>
                                <span>New Message</span>
                            </a>
                    </div>
                    <x-input.search wire:model.live="search"/>

                    <table
                        class="mt-2 w-full shadow overflow-hidden border-b border-gray-200 sm:rounded-lg min-w-full divide-y divide-gray-200">
                        <thead class="bg-gray-50">
                        <tr>
                            <th scope="col"
                                class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">
                                Sender
                            </th>
                            <th scope="col"
                                class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">
                                Recipient
                            </th>
                            <th scope="col"
                                class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">
                                Status
                            </th>
                            <th scope="col"
                                class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">
                                Credits
                            </th>
                            <th scope="col"
                                class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">
                                Date
                            </th>
                            <th scope="col"
                                class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">
                                Type
                            </th>
                            <th scope="col"
                                class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">
                                Message
                            </th>
                            <th scope="col"
                                class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">
                                {{ $archived ? 'UnArchive' : 'Archive' }}
                            </th>
                        </tr>
                        </thead>
                        <tbody>
                        @forelse ($messages as $message)
                            <tr class="odd:bg-white even:bg-gray-50">
                                <td class="px-6 py-4 whitespace-nowrap text-sm font-medium text-gray-900">
                                    {{ $message->user?->name ?? $message->from }}
                                </td>
                                <td class="px-6 py-4 whitespace-nowrap text-sm font-medium text-gray-900">
                                    {{ Str::limit($message->to, 12) }}
                                </td>
                                <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-500">
                                    {{  ucfirst($message->status) }}
                                </td>
                                <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-500">
                                    {{ $message->numSegments }}
                                </td>
                                <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-500">
                                    {{ $message->dateCreated->format('d-m-Y G:ia') }}
                                </td>
                                <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-500">
                                    {{ $message->isMMS?'MMS':'SMS' }}
                                </td>
                                <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-500">
                                    @if(!$message->isMMS)
                                        <a href="{{route('messages.show', $message->id)}}" class="hover:text-indigo-600">{{ $message->excerpt }}</a>
                                    @else
                                        <a href="{{ $message->body }}" class="text-indigo-600 hover:text-indigo-900">View</a>
                                    @endif
                                </td>
                                <td class="px-6 py-4 whitespace-nowrap text-sm text-center text-gray-500">
                                    <button type="button" wire:click="archiveMessage($message->id)" class="inline-flex items-center px-3 py-2 border border-transparent shadow-sm text-sm leading-4 font-medium rounded-md text-white bg-indigo-600 hover:bg-indigo-700 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-indigo-500">
                                        <svg class="h-4 w-4" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 512 512"><path fill="currentColor" d="M32 448c0 17.7 14.3 32 32 32h384c17.7 0 32-14.3 32-32V160H32v288zm160-212c0-6.6 5.4-12 12-12h104c6.6 0 12 5.4 12 12v8c0 6.6-5.4 12-12 12H204c-6.6 0-12-5.4-12-12v-8zM480 32H32C14.3 32 0 46.3 0 64v48c0 8.8 7.2 16 16 16h480c8.8 0 16-7.2 16-16V64c0-17.7-14.3-32-32-32z"/></svg>
                                    </button>
                                </td>
                            </tr>
                        @empty
                            <tr class="odd:bg-white even:bg-gray-50">
                                <td colspan="8" class="px-6 py-4 whitespace-nowrap text-sm font-medium text-gray-900 italic">
                                    No messages
                                </td>
                            </tr>
                        @endforelse
                        </tbody>
                    </table>
                    <div class="mt-2">
                        {{ $messages->links() }}
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
