<x-jet-form-section submit="updateTemplate">
    <x-slot name="title">
        {{ __('Update Template') }}
    </x-slot>

    <x-slot name="description">
        {{ __('Templates are a basis for sending bulk SMS messages.') }}
    </x-slot>

    <x-slot name="form">
        <div class="col-span-6 sm:col-span-4">
            <x-jet-label for="description" value="{{ __('Description') }}" />
            <x-jet-input id="description" type="text" class="mt-1 block w-full" wire:model.defer="template.description" autocomplete="description" />
            <x-jet-input-error for="template.description" class="mt-2" />
        </div>
        <div class="col-span-6 sm:col-span-4">
            <x-jet-label for="content" value="{{ __('Content') }}" />
            <x-textarea id="content" class="mt-2 block w-full" wire:model.defer="template.content" />
            <div class="mt-1 flex justify-between w-full text-xs text-gray-700">

            </div>
            <x-jet-input-error for="template.content" class="mt-2" />
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
