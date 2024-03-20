<x-jet-form-section submit="editList">
    <x-slot name="title">
        {{ __('Create List') }}
    </x-slot>

    <x-slot name="description">
        {{ __('Edit list') }}
    </x-slot>


    <x-slot name="form">
        <div class="col-span-6 sm:col-span-4">
            <x-label for="name" value="{{ __('List Name') }}" />
            <x-input id="name" type="text" class="mt-1 block w-full" wire:model.lazy="list.name" />
            <x-input-error for="list.name" class="mt-2" />
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
