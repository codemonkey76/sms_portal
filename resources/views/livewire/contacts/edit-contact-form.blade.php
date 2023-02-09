<x-jet-form-section submit="editContact">
    <x-slot name="title">
        {{ __('Edit Contact') }}
    </x-slot>

    <x-slot name="description">
        {{ __('Edit contact, ensure you enter a valid phone number') }}
    </x-slot>

    <x-slot name="form">
        <div class="col-span-6 sm:col-span-4">
            <x-jet-label for="number" value="{{ __('Phone Number') }}" />
            <x-jet-input id="number" type="text" class="mt-1 block w-full" wire:model.lazy="contact.number" />
            <x-jet-input-error for="contact.number" class="mt-2" />
        </div>

        <div class="col-span-6 sm:col-span-4">
            <x-jet-label for="first_name" value="{{ __('First Name') }}" />
            <x-jet-input id="first_name" type="text" class="mt-1 block w-full" wire:model.lazy="contact.first_name" />
            <x-jet-input-error for="contact.first_name" class="mt-2" />
        </div>

        <div class="col-span-6 sm:col-span-4">
            <x-jet-label for="last_name" value="{{ __('Last Name') }}" />
            <x-jet-input id="last_name" type="text" class="mt-1 block w-full" wire:model.lazy="contact.last_name" />
            <x-jet-input-error for="contact.last_name" class="mt-2" />
        </div>

        <div class="col-span-6 sm:col-span-4">
            <x-jet-label for="company" value="{{ __('Company Name') }}" />
            <x-jet-input id="company" type="text" class="mt-1 block w-full" wire:model.lazy="contact.company_name" />
            <x-jet-input-error for="contact.company_name" class="mt-2" />
        </div>

        <div class="col-span-6 sm:col-span-4">
            <x-jet-label for="template" value="{{ __('Contact List') }}" />
            <div class="flex space-x-2">
                <select id="location" name="location" class="mt-1 block w-full pl-3 pr-10 py-2 text-base border-gray-300 focus:outline-none focus:ring-indigo-500 focus:border-indigo-500 sm:text-sm rounded-md" wire:model="contact.contact_list_id">
                    @foreach ($lists as $list)
                        <option value="{{ $list->id }}">{{ $list->name }}</option>
                    @endforeach
                </select>
            </div>

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
