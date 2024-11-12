<x-jet-form-section submit="createTag">
    <x-slot name="title">
        {{ __('Create Tag') }}
    </x-slot>

    <x-slot name="description">
        {{ __('Create Tag') }}
    </x-slot>

    <x-slot name="form">

        <div class="col-span-6 sm:col-span-4">
            <x-label for="name" value="{{ __('Tag Name') }}" />
            <x-input id="name" class="mt-2 block w-full" wire:model="name" />
            <x-input-error for="name" class="mt-2" />
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
