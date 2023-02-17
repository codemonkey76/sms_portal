@props([
    'placeholder' => null,
    'trailingAddOn' => null,
])

<div class="flex">
    <select {{ $attributes->merge(['class' => 'mt-1 block w-full rounded-md border-gray-300 py-2 pl-3 pr-10 text-base focus:border-indigo-500 focus:outline-none focus:ring-indigo-500 sm:text-sm' . ($trailingAddOn ? ' rounded-r-none' : '')]) }}>
        @if ($placeholder)
            <option disabled value="">{{ $placeholder }}</option>
        @endif

        {{ $slot }}
    </select>

    @if ($trailingAddOn)
        {{ $trailingAddOn }}
    @endif
</div>
