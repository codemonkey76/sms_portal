<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            {{ __('Profile') }}
        </h2>
    </x-slot>

    <div>
        <div class="max-w-7xl mx-auto py-10 sm:px-6 lg:px-8">
            @if (Laravel\Fortify\Features::canUpdateProfileInformation())
                @livewire('profile.update-profile-information-form')

                <x-jet-section-border />
            @endif

            @if (Laravel\Fortify\Features::enabled(Laravel\Fortify\Features::updatePasswords()))
                <div class="mt-10 sm:mt-0">
                    @livewire('profile.update-password-form')
                </div>

                <x-jet-section-border />
            @endif

            @if (Laravel\Fortify\Features::canManageTwoFactorAuthentication())
                <div class="mt-10 sm:mt-0">
                    @livewire('profile.two-factor-authentication-form')
                </div>

                <x-jet-section-border />
            @endif

            <div class="mt-10 sm:mt-0">
                @livewire('profile.logout-other-browser-sessions-form')
            </div>

            @if (Laravel\Jetstream\Jetstream::hasAccountDeletionFeatures())
                <x-jet-section-border />

                <div class="mt-10 sm:mt-0">
                    @livewire('profile.delete-user-form')
                </div>
            @endif

                <x-jet-section-border />

                <div class="mt-10 sm:mt-0">
                    <x-jet-action-section>
                        <x-slot name="title">
                            {{ __('Toggle Dark Mode') }}
                        </x-slot>

                        <x-slot name="description">
                            {{ __('Toggle dark mode UI.') }}
                        </x-slot>

                        <x-slot name="content">
                            <div class="max-w-xl text-sm text-gray-600">
                                {{ __('You can toggle dark mode on or off, you can have a different setting to your system-wide setting.') }}
                            </div>

                            <div class="mt-5">
                                <button
                                    x-data="{
                    toggle: () => {
                        if (localStorage.theme === 'dark') {
                            localStorage.theme = 'light';
                            document.documentElement.classList.remove('dark');
                        } else {
                            localStorage.theme = 'dark';
                            document.documentElement.classList.add('dark');
                        }
                    },
                }"
                                    class="mt-2 px-3 py-2 bg-pink-400 rounded-lg font-semibold text-white focus:outline-none"
                                    @click="toggle"
                                >
                                    Toggle Modes
                                </button>
                            </div>
                        </x-slot>
                    </x-jet-action-section>
                </div>
        </div>
    </div>
</x-app-layout>
