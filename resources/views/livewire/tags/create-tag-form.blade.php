<x-jet-form-section submit="createTag">
    <x-slot name="title">
        {{ __('Create Tag') }}
    </x-slot>

    <x-slot name="description">
        {{ __('Create a tag to enable retention configuration') }}
    </x-slot>

    <x-slot name="form">
        <div class="col-span-6 sm:col-span-4">
            <x-label for="name" value="{{ __('Name') }}" />
            <x-input id="name" type="text" class="mt-1 block w-full" wire:model.lazy="tag.name" />
            <x-input-error for="tag.name" class="mt-2" />
        </div>

        <div class="col-span-6 sm:col-span-4">
            <x-label for="retention_duration" value="{{ __('Retention Duration') }}" />
            <x-input id="retention_duration" type="text" class="mt-1 block w-full" wire:model.lazy="tag.retention_duration" />
            <x-input-error for="tag.retention_duration" class="mt-2" />
        </div>

        <div class="col-span-6 sm:col-span-4">
            <x-label for="retention_unit" value="{{ __('Retention Unit') }}" />
            <div class="flex space-x-2">
                <select id="retention_unit" name="retention_unit" class="mt-1 block w-full pl-3 pr-10 py-2 text-base border-gray-300 focus:outline-none focus:ring-indigo-500 focus:border-indigo-500 sm:text-sm rounded-md" wire:model="tag.retention_unit">
                    @foreach (['days', 'weeks', 'months', 'years'] as $unit)
                        <option value="{{ $unit }}">{{ Illuminate\Support\Str::ucfirst($unit) }}</option>
                    @endforeach
                </select>
            </div>
        </div>

        <div class="col-span-6 sm:col-span-4">
            <x-validation-errors />
        </div>

    </x-slot>

    <x-slot name="actions">
        <x-jet-action-message class="mr-3" on="saved">
            {{ __('Saved.') }}
            {{ __('Sent.') }}
        </x-jet-action-message>

        <x-jet-secondary-button wire:click="back" wire:loading.attr="disabled">
            {{ __('Back') }}
        </x-jet-secondary-button>
        <x-jet-button class="ml-3" wire:loading.attr="disabled">
            {{ __('Save') }}
        </x-jet-button>
    </x-slot>
</x-jet-form-section>
