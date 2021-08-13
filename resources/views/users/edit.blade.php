<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            {{ __('Edit User') }}
        </h2>
    </x-slot>
    <div>
        <div class="max-w-7xl mx-auto py-10 sm:px-6 lg:px-8">
            <livewire:users.edit-user-form :user="$user"/>
            <x-jet-section-border/>
        </div>
        <div class="max-w-7xl mx-auto py-10 sm:px-6 lg:px-8">
            <form method="get">
                <label for="company_id">
                    Company
                </label>
                <x-controls.select id="company_id" name="company_id">
                    <x-controls.select.option value="1">Company 1</x-controls.select.option>
                    <x-controls.select.option value="2">Company 2</x-controls.select.option>
                    <x-controls.select.option value="3">Company 3</x-controls.select.option>
                    <x-controls.select.option value="4">Company 4</x-controls.select.option>
                    <x-controls.select.option value="5">Company 5</x-controls.select.option>
                </x-controls.select>
                <button type="submit">Submit</button>
            </form>
            {{--            <livewire:users.assign-customer-form :user="$user" />--}}
            <x-jet-section-border/>
        </div>
    </div>
</x-app-layout>
