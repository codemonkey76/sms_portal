<x-jet-form-section submit="editUser">
    <x-slot name="title">
        {{ __('Edit User') }}
    </x-slot>

    <x-slot name="description">
        {{ __('Edit user') }}
    </x-slot>

    <x-slot name="form">
        <div class="col-span-6 sm:col-span-4">
            <x-jet-label for="name" value="{{ __('Name') }}" />
            <x-jet-input id="name" type="text" class="mt-1 block w-full" wire:model.lazy="user.name" autocomplete="name" />
            <x-jet-input-error for="user.name" class="mt-2" />
        </div>

        <div class="col-span-6 sm:col-span-4">
            <x-jet-label for="email" value="{{ __('Email Address') }}" />
            <x-jet-input id="email" type="email" class="mt-1 block w-full" wire:model.lazy="user.email" autocomplete="email" />
            <x-jet-input-error for="user.email" class="mt-2" />
        </div>

        <div class="col-span-6 sm:col-span-4">
            <fieldset>
                <legend class="text-base font-medium text-gray-900">
                    By Email
                </legend>
                <div class="mt-4 space-y-4">
                    <div class="relative flex items-start">
                        <div class="flex items-center h-5">
                            <input id="isAdmin" name="isAdmin" type="checkbox" wire:model="user.isAdmin" class="focus:ring-indigo-200 h-4 w-4 text-indigo-500 border-gray-300 rounded">
                        </div>
                        <div class="ml-3 text-sm">
                            <label for="isAdmin" class="font-medium text-gray-700">Admin</label>
                            <p class="text-gray-500">User is an admin and can see and make changes to customers and users.</p>
                        </div>
                    </div>
                    <div class="relative flex items-start">
                        <div class="flex items-center h-5">
                            <input id="isActive" name="isActive" type="checkbox" wire:model="user.isActive" class="focus:ring-indigo-500 h-4 w-4 text-indigo-600 border-gray-300 rounded">
                        </div>
                        <div class="ml-3 text-sm">
                            <label for="isActive" class="font-medium text-gray-700">Active</label>
                            <p class="text-gray-500">User is active and can send and receive messages.</p>
                        </div>
                    </div>
                </div>
            </fieldset>
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
