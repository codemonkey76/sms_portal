<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            {{ __('Dashboard') }}
        </h2>
    </x-slot>

    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white overflow-hidden shadow-xl sm:rounded-lg">
                <div class="p-6 sm:px-20 bg-white border-b border-gray-200">
                    <div>
                        <x-icons.logo-full class="text-brand-400 h-12 w-auto" />
                    </div>

                    <div class="mt-8 text-2xl">
                        Your account is currently inactive!
                    </div>

                    <div class="mt-6 text-gray-500">
                        Please come back once ASG Communications has confirmed activation of your account.
                    </div>
                </div>

            </div>
        </div>
    </div>
</x-app-layout>
