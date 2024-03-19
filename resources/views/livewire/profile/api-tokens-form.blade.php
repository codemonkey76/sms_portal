<x-jet-form-section submit="createApiToken">
    <x-slot name="title">
        {{ __('API Tokens') }}
    </x-slot>

    <x-slot name="description">
        {{ __('Create API Tokens for access to our API from other services.') }}
    </x-slot>

    <x-slot name="form">
        <div class="col-span-6 sm:col-span-4">
            <x-label for="email_api" value="{{ __('Email Address') }}" />
            <x-input id="email_api" type="email" class="mt-1 block w-full" wire:model.defer="state.email" autocomplete="email" />
            <x-input-error for="email_api" class="mt-2" />
        </div>

        <div class="col-span-6 sm:col-span-4">
            <x-label for="current_password_api" value="{{ __('Current Password') }}" />
            <x-input id="current_password_api" type="password" class="mt-1 block w-full" wire:model.defer="state.current_password" autocomplete="current-password" />
            <x-input-error for="current_password_api" class="mt-2" />
        </div>


        <div class="col-span-6 sm:col-span-4">
            <x-label for="device_name" value="{{ __('Device Identifier') }}" />
            <x-input id="device_name" type="text" class="mt-1 block w-full" wire:model.defer="state.device_name" autocomplete="device_name" />
            <x-input-error for="device_name" class="mt-2" />
        </div>


        <x-messages.custom-action-message
            class="col-span-6 text-gray-600 text-sm bg-amber-50 border border-gray-300 rounded-lg p-2"
            on="createToken">

        </x-messages.custom-action-message>


        <table class="col-start-1 col-span-4 shadow overflow-hidden border-b border-gray-200 sm:rounded-lg min-w-full divide-y divide-gray-200">
           <thead class="bg-gray-50">
           <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">
                id
            </th>
            <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">
                device name
            </th>
            <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">
                last used
            </th>
            <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">
                delete
            </th>
           </thead>
            <tbody>
                @foreach(Auth::user()->tokens as $token)
                    <tr class="odd:bg-white even:bg-gray-50">
                        <td class="px-6 py-4 whitespace-nowrap text-sm font-medium text-gray-900">
                            {{ $token->id }}
                        </td>
                        <td class="px-6 py-4 whitespace-nowrap text-sm font-medium text-gray-900">
                            {{ $token->name }}
                        </td>
                        <td class="px-6 py-4 whitespace-nowrap text-sm font-medium text-gray-900">
                            {{ $token->last_used_at?->diffForHumans() ?? "never"}}
                        </td>
                        <td class="px-6 py-4 whitespace-nowrap text-sm font-medium text-gray-900">
                            <x-jet-button type="button" wire:click="deleteToken({{$token->id}})">Delete</x-jet-button>
                        </td>


                    </tr>
                @endforeach
            </tbody>
        </table>





{{--        <div class="col-span-6">--}}
{{--            <div class="flex flex-col">--}}
{{--                <div class="-my-2 overflow-x-auto sm:-mx-6 lg:-mx-8">--}}
{{--                    <div class="space-y-2 align-middle inline-block min-w-full sm:px-6 lg:px-8">--}}
{{--                        <table--}}
{{--                            class="shadow overflow-hidden border-b border-gray-200 sm:rounded-lg min-w-full divide-y divide-gray-200">--}}
{{--                            <thead class="bg-gray-50">--}}
{{--                            <tr>--}}
{{--                                <th scope="col"--}}
{{--                                    class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">--}}
{{--                                    id--}}
{{--                                </th>--}}
{{--                                <th scope="col"--}}
{{--                                    class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">--}}
{{--                                    Name--}}
{{--                                </th>--}}
{{--                                <th scope="col"--}}
{{--                                    class="px-6 py-3 text-right text-xs font-medium text-gray-500 uppercase tracking-wider">--}}
{{--                                    Delete--}}
{{--                                </th>--}}
{{--                            </tr>--}}
{{--                            </thead>--}}
{{--                            <tbody>--}}

{{--                            @foreach(Auth::user()->tokens as $token)--}}
{{--                                <tr class="odd:bg-white even:bg-gray-50">--}}
{{--                                    <td class="px-6 py-4 whitespace-nowrap text-sm font-medium text-gray-900">--}}
{{--                                        {{$token->id}}--}}
{{--                                    </td>--}}
{{--                                    <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-500">--}}
{{--                                        {{ $token->name }}--}}
{{--                                    </td>--}}
{{--                                    <td class="px-6 py-4 whitespace-nowrap text-right text-sm font-medium">--}}
{{--                                        --}}{{--                                                    <a href="{{ route('customers.edit', $customer->id) }}" class="text-indigo-600 hover:text-indigo-900">Edit</a>--}}
{{--                                    </td>--}}
{{--                                </tr>--}}
{{--                            @endforeach--}}
{{--                            </tbody>--}}
{{--                        </table>--}}

{{--                    </div>--}}
{{--                </div>--}}
{{--            </div>--}}

{{--        </div>--}}
    </x-slot>

    <x-slot name="actions">
        <x-jet-action-message class="mr-3" on="saved">
            {{ __('Saved.') }}
        </x-jet-action-message>

        <x-jet-button>
            {{ __('Save') }}
        </x-jet-button>
    </x-slot>
</x-jet-form-section>
