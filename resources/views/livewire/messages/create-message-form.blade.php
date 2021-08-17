<x-jet-form-section submit="createMessage">
    <x-slot name="title">
        {{ __('Create Message') }}
    </x-slot>

    <x-slot name="description">
        {{ __('Send SMS message.') }}
    </x-slot>

    <x-slot name="form">
            <div class="col-span-6 sm:col-span-4">
                <x-jet-label for="recipient" value="{{ __('Recipient') }}" />
                <x-jet-input id="recipient" type="text" class="mt-1 block w-full" wire:model.defer="recipient" autocomplete="recipient" />
                <x-jet-input-error for="recipient" class="mt-2" />
            </div>
            <div class="col-span-6 sm:col-span-4">
                <x-jet-label for="template" value="{{ __('Template') }}" />
                <div class="flex space-x-2">
                    <select id="location" name="location" class="mt-1 block w-full pl-3 pr-10 py-2 text-base border-gray-300 focus:outline-none focus:ring-indigo-500 focus:border-indigo-500 sm:text-sm rounded-md">
                        @foreach ($templates as $template)
                            <option value="{{ $template->id }}">{{ $template->description }}</option>
                        @endforeach
                    </select>
                    <x-jet-button type="button" wire:click="applyTemplate" class="mt-1">Apply</x-jet-button>
                </div>

            </div>
            <div class="col-span-6 sm:col-span-4">
                <x-jet-label for="message" value="{{ __('Message') }}" />
                <x-textarea id="message" class="mt-2 block w-full" wire:model="message" />
                <div class="mt-1 flex justify-between w-full text-xs text-gray-700">
                    <div>Characters: {{ $this->messageSize }}/{{ $this->messageUpperBreakpoint }}</div>
                    <div>Message Count: {{ $this->messageCount }}</div>
                    <div>Encoding: {{ $this->messageEncoding }}</div>
                </div>
                <x-jet-input-error for="message" class="mt-2" />
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
