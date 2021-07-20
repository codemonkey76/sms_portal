<x-jet-form-section submit="createMessage">
    <x-slot name="title">
        {{ __('Create Message') }}
    </x-slot>

    <x-slot name="description">
        {{ __('Send SMS message.') }}
    </x-slot>

    <x-slot name="form">
        <!-- Recipient -->
            <div class="col-span-6 sm:col-span-4">
                <x-jet-label for="recipient" value="{{ __('Recipient') }}" />
                <x-jet-input id="recipient" type="text" class="mt-1 block w-full" wire:model.defer="recipient" autocomplete="recipient" />
                <x-jet-input-error for="recipient" class="mt-2" />
            </div>
{{--            <div>Current message: <span>{{ $message }}</span></div>--}}
{{--            <div>Characters: <span>{{ $this->messageSize . ' / ' . $this->messageUpperBreakpoint }}</span></div>--}}
{{--        <div>Total Messages: <span>{{ $this->messageCount }}</span></div>--}}
        <!-- Message -->
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
