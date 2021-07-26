<x-jet-form-section submit="createCustomer">
    <x-slot name="title">
        {{ __('Create Customer') }}
    </x-slot>

    <x-slot name="description">
        {{ __('Create customer, ensure you set a valid sender ID') }}
    </x-slot>

    <x-slot name="form">
        <div class="col-span-6 sm:col-span-4">
            <x-jet-label for="name" value="{{ __('Name') }}" />
            <x-jet-input id="name" type="text" class="mt-1 block w-full" wire:model.lazy="name" autocomplete="name" />
            <x-jet-input-error for="name" class="mt-2" />
        </div>

        <div class="col-span-6 sm:col-span-4">
            <x-jet-label for="senderId" value="{{ __('Sender ID') }}" />
            <x-jet-input id="senderId" type="text" class="mt-1 block w-full" wire:model.lazy="senderId" autocomplete="senderId" />
            <x-jet-input-error for="senderId" class="mt-2" />
        </div>
    </x-slot>

    <x-slot name="actions">
        <x-jet-action-message class="mr-3" on="saved">
            {{ __('Saved.') }}
        </x-jet-action-message>

        <x-jet-secondary-button wire:click="back" wire:loading.attr="disabled">
            {{ __('Back') }}
        </x-jet-secondary-button>
        <x-jet-button class="ml-3" wire:loading.attr="disabled">
            {{ __('Save') }}
        </x-jet-button>
    </x-slot>
</x-jet-form-section>
