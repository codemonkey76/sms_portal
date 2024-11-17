<x-jet-form-section submit="createTemplate">
    <x-slot name="title">
        {{ __('Create Template') }}
    </x-slot>

    <x-slot name="description">
        {{ __('Create template as a basis for sending bulk SMS messages.') }}
    </x-slot>

    <x-slot name="form">
        <div class="col-span-6 sm:col-span-4">
            <x-label for="description" value="{{ __('Description') }}" />
            <x-input id="description" type="text" class="mt-1 block w-full" wire:model.defer="description" autocomplete="description" />
            <x-input-error for="description" class="mt-2" />
        </div>
        <div class="col-span-6 sm:col-span-4">
            <x-label for="content" value="{{ __('Content') }}" />
            <x-textarea id="content" class="mt-2 block w-full" wire:model="content" />
            <div class="mt-1 flex justify-between w-full text-xs text-gray-700">

            </div>
            <x-input-error for="content" class="mt-2" />
        </div>
        <div class="col-span-6 sm:col-span-4">
            <x-label for="tags" value="{{ __('Tags') }}" />
            <x-tag-select id="tags" :tags="$tags" wire:model="selected_tags" />
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
