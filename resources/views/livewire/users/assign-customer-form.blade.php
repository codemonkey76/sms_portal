<x-jet-form-section submit="assignCustomer">
    <x-slot name="title">
        {{ __('Assign Customer') }}
    </x-slot>

    <x-slot name="description">
        {{ __('Assign the user to one or more customers') }}
    </x-slot>

    <x-slot name="form">
        <div class="col-span-6 flex space-x-2 h-60 items-center">
            <x-controls.select :stacked="true" :list="$customers" photo="profile_photo_url" secondary="senderId" name="customers" wire:model="selectedCustomer" :selected="$selectedCustomer" />


            <div class="space-y-2">
                <x-jet-button wire:click.prevent="assignCustomer" class="flex items-center w-full" :disabled="! $add">
                    <span>Add</span>
                    <svg class="ml-2 h-4" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 320 512">
                        <path fill="currentColor" d="M285.476 272.971L91.132 467.314c-9.373 9.373-24.569 9.373-33.941 0l-22.667-22.667c-9.357-9.357-9.375-24.522-.04-33.901L188.505 256 34.484 101.255c-9.335-9.379-9.317-24.544.04-33.901l22.667-22.667c9.373-9.373 24.569-9.373 33.941 0L285.475 239.03c9.373 9.372 9.373 24.568.001 33.941z" />
                    </svg>
                </x-jet-button>
                <x-jet-button wire:click.prevent="unassignCustomer" class="flex items-center w-full" :disabled="! $remove">
                    <svg class="mr-2 h-4" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 320 512">
                        <path fill="currentColor" d="M34.52 239.03L228.87 44.69c9.37-9.37 24.57-9.37 33.94 0l22.67 22.67c9.36 9.36 9.37 24.52.04 33.9L131.49 256l154.02 154.75c9.34 9.38 9.32 24.54-.04 33.9l-22.67 22.67c-9.37 9.37-24.57 9.37-33.94 0L34.52 272.97c-9.37-9.37-9.37-24.57 0-33.94z" />
                    </svg>
                    <span>Remove</span>
                </x-jet-button>
            </div>
            <x-controls.select :stacked="false" :list="$assignedCustomers" photo="profile_photo_url" secondary="senderId" name="assignedCustomers" wire:model="selectedAssignCustomer" :selected="$selectedAssignCustomer" />
        </div>
    </x-slot>

</x-jet-form-section>
