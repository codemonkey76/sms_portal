<div>
    <x-jet-secondary-button class="flex items-center space-x-2" wire:click="$toggle('showImportContacts')">
        <x-icons.upload class="text-gray-500" />
        <span>Import</span>
    </x-jet-secondary-button>

    <form wire:submit.prevent="import">
        <x-jet-dialog-modal wire:model="showImportContacts">
            <x-slot name="title">Import Contacts</x-slot>
            <x-slot name="content">
                @unless ($upload)
                    <div class="py-12 flex flex-col items-center jusify-center">
                        <div class="flex items-center space-x-2 text-xl">
                            <x-icons.upload class="text-gray-400 w-8 h-8" />
                            <x-input.file-upload id="upload" wire:model="upload">
                                <span class="text-gray-500 font-bold">CSV File</span>
                            </x-input.file-upload>
                        </div>
                        @error('upload')<div class="mt-3 text-red-500 text-sm">{{ $message }}</div>@enderror
                    </div>
                @else
                    <div>
                        <x-input.group for="first_name" label="First Name" :error="$errors->first('fieldColumnMap.first_name')">
                            <x-input.select id="first_name" wire:model="fieldColumnMap.first_name">
                                <option value="">Select Column...</option>
                                @foreach ($columns as $column)
                                    <option>{{ $column }}</option>
                                @endforeach
                            </x-input.select>
                        </x-input.group>
                        <x-input.group for="last_name" label="Last Name" :error="$errors->first('fieldColumnMap.last_name')">
                            <x-input.select id="last_name" wire:model="fieldColumnMap.last_name">
                                <option value="">Select Column...</option>
                                @foreach ($columns as $column)
                                    <option>{{ $column }}</option>
                                @endforeach
                            </x-input.select>
                        </x-input.group>
                        <x-input.group for="company" label="Company Name" :error="$errors->first('fieldColumnMap.company_name')">
                            <x-input.select id="company" wire:model="fieldColumnMap.company_name">
                                <option value="">Select Column...</option>
                                @foreach ($columns as $column)
                                    <option>{{ $column }}</option>
                                @endforeach
                            </x-input.select>
                        </x-input.group>
                        <x-input.group for="number" label="Phone Number" :error="$errors->first('fieldColumnMap.number')">
                            <x-input.select id="number" wire:model="fieldColumnMap.number">
                                <option value="" disabled>Select Column...</option>
                                @foreach ($columns as $column)
                                    <option>{{ $column }}</option>
                                @endforeach
                            </x-input.select>
                        </x-input.group>
                        <x-input.group for="list" label="List" :error="$errors->first('selectedList')">
                            <x-input.select id="list" wire:model="selectedList">
                                <option value="" disabled>Select List...</option>
                                @foreach ($lists as $list)
                                    <option value="{{$list->id}}">{{ $list->name }}</option>
                                @endforeach
                            </x-input.select>
                        </x-input.group>
                    </div>
                @endunless
            </x-slot>
            <x-slot name="footer">
                <x-jet-secondary-button wire:click="$set('showImportContacts', false)">Cancel</x-jet-secondary-button>
                <x-jet-button type="submit">Import</x-jet-button>
            </x-slot>
        </x-jet-dialog-modal>
    </form>
</div>
