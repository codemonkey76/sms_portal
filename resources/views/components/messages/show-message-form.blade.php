<div {{ $attributes->merge(['class' => 'md:grid md:grid-cols-3 md:gap-6']) }}>
    <x-jet-section-title>
        <x-slot name="title">Message</x-slot>
        <x-slot name="description">Message details</x-slot>
    </x-jet-section-title>
    <div class="mt-5 md:mt-0 md:col-span-2">

        <div
            class="px-4 py-5 bg-white sm:p-6 shadow sm:rounded-tl-md sm:rounded-tr-md space-y-2">
            <div>
                <label for="first-name" class="block text-sm font-medium text-gray-700">
                    Sender
                </label>
                <div class="mt-1 p-2 border border-gray-300 rounded-md text-sm shadow-sm">
                    {{ $message->from }}
                </div>
            </div>

            <div>
                <label for="first-name" class="block text-sm font-medium text-gray-700">
                    Recipient
                </label>
                <div class="mt-1 p-2 border border-gray-300 rounded-md text-sm shadow-sm">
                    {{ $message->to }}
                </div>
            </div>


            <div>
                <label for="first-name" class="block text-sm font-medium text-gray-700">
                    Sent
                </label>
                <div class="mt-1 p-2 border border-gray-300 rounded-md text-sm shadow-sm">
                    {{ $message->dateCreated->format('d-M-Y g:ia') }}
                </div>
            </div>


            <div>
                <label for="first-name" class="block text-sm font-medium text-gray-700">
                    Credits
                </label>
                <div class="mt-1 p-2 border border-gray-300 rounded-md text-sm shadow-sm">
                    {{ $message->numSegments }}
                </div>
            </div>


            <div>
                <label for="first-name" class="block text-sm font-medium text-gray-700">
                    Message
                </label>
                <div class="mt-1 p-2 border border-gray-300 rounded-md text-sm shadow-sm">
                    {{ $message->body }}
                </div>
            </div>

        </div>


        <div
            class="flex items-center justify-end px-4 py-3 bg-gray-50 text-right sm:px-6 shadow sm:rounded-bl-md sm:rounded-br-md space-x-2">
            <a href="{{ route('messages.index') }}" class="inline-flex items-center px-4 py-2 bg-gray-800 border border-transparent rounded-md font-semibold text-xs text-white uppercase tracking-widest hover:bg-gray-700 active:bg-gray-900 focus:outline-none focus:border-gray-900 focus:ring focus:ring-gray-300 disabled:opacity-25 transition">
                Back
            </a>

        </div>
    </div>
</div>
