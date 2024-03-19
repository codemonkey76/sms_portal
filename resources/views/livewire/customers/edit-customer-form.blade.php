<x-jet-form-section submit="editCustomer">
    <x-slot name="title">
        {{ __('Edit Customer') }}
    </x-slot>

    <x-slot name="description">
        {{ __('Edit customer, ensure you set a valid sender ID') }}
    </x-slot>

    <x-slot name="form">
        <div class="col-span-6 sm:col-span-4">
            <x-label for="name" value="{{ __('Name') }}" />
            <x-input id="name" type="text" class="mt-1 block w-full" wire:model.lazy="customer.name" autocomplete="name" />
            <x-input-error for="customer.name" class="mt-2" />
        </div>

        <div class="col-span-6 sm:col-span-4">
            <x-label for="senderId" value="{{ __('Sender ID') }}" />
            <x-input id="senderId" type="text" class="mt-1 block w-full" wire:model.lazy="customer.senderId" autocomplete="senderId" />
            <x-input-error for="customer.senderId" class="mt-2" />
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
