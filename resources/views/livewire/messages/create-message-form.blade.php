<x-jet-form-section submit="createMessage">
    <x-slot name="title">
        {{ __('Create Message') }}
    </x-slot>

    <x-slot name="description">
        {{ __('Send SMS message.') }}
    </x-slot>

    <x-slot name="form">
        <div class="col-span-6 sm:col-span-4">
            <x-label value="{{ __('Message Type') }}" class="mb-3"/>
            <div class="flex space-x-3">
            <div class="flex space-x-1">
                <x-input type="radio" id="type_single" name="message_type" class="h-4 w-4 border-gray-300 text-indigo-600 focus:ring-indigo-500" wire:model="message_type" value="single"/>
                <x-label for="message_type" class="ml-3" value="{{ __('Single Recipient') }}" />
            </div>
            <div class="flex space-x-1">
                <x-input type="radio" id="type_multiple" name="message_type" class="h-4 w-4 border-gray-300 text-indigo-600 focus:ring-indigo-500" wire:model="message_type" value="multiple"/>
                <x-label for="message_type" class="ml-3" value="{{ __('Bulk Messages') }}" />
            </div>
            </div>
        </div>
        @if($message_type === 'single')
            <div class="col-span-6 sm:col-span-4">
            <x-label for="recipient" value="{{ __('Recipient') }}"/>
            <x-input id="recipient" type="text" class="mt-1 block w-full" wire:model.defer="recipient"
                         autocomplete="recipient"/>
            <x-input-error for="recipient" class="mt-2"/>
        </div>
        @endif
        @if ($message_type === 'multiple')
            <div class="col-span-6 sm:col-span-4">
                <x-label for="recipient_list" value="{{ __('Recipients') }}"/>
                <div class="flex space-x-2">
                    <select id="recipient_list" name="recipient_list"
                            class="mt-1 block w-full pl-3 pr-10 py-2 text-base border-gray-300 focus:outline-none focus:ring-indigo-500 focus:border-indigo-500 sm:text-sm rounded-md"
                            wire:model="contactList">
                        <option value="" disabled>--- Select a list ---</option>
                        @foreach ($lists as $list)
                            <option value="{{ $list->id }}">{{ $list->name }}</option>
                        @endforeach
                    </select>
                </div>
            </div>
        @endif
        <div class="col-span-6 sm:col-span-4">
            <x-label for="template" value="{{ __('Template') }}"/>
            <div class="flex space-x-2">
                <select id="location" name="location"
                        class="mt-1 block w-full pl-3 pr-10 py-2 text-base border-gray-300 focus:outline-none focus:ring-indigo-500 focus:border-indigo-500 sm:text-sm rounded-md"
                        wire:model="selectedTemplate">

                    @foreach ($templates as $template)
                        <option value="{{ $template->id }}">{{ $template->description }}</option>
                    @endforeach
                </select>
                <x-jet-button type="button" wire:click="applyTemplate" class="mt-1">Apply</x-jet-button>
            </div>

        </div>
        <div class="col-span-6 sm:col-span-4">
            <x-label for="message" value="{{ __('Message') }}"/>
            <x-textarea id="message" class="mt-2 block w-full" wire:model="message"/>
            <div class="mt-1 flex justify-between w-full text-xs text-gray-700">
                <div>Characters: {{ $this->messageSize }}/{{ $this->messageUpperBreakpoint }}</div>
                <div>Message Count: {{ $this->messageCount }}</div>
                <div>Encoding: {{ $this->messageEncoding }}</div>
            </div>
            <x-input-error for="message" class="mt-2"/>
        </div>
        <div class="col-span-6 sm:col-span-4">
            <x-validation-errors />
        </div>
    </x-slot>

    <x-slot name="actions">
        <x-jet-action-message class="mr-3" on="saved">
            {{ __('Sent.') }}
        </x-jet-action-message>

        <x-jet-secondary-button wire:click="back" wire:loading.attr="disabled">
            {{ __('Back') }}
        </x-jet-secondary-button>
        <x-jet-button class="ml-3" wire:loading.attr="disabled">
            {{ __('Send') }}
        </x-jet-button>
    </x-slot>
</x-jet-form-section>
