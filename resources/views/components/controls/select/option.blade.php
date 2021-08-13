@props(['item', 'photo', 'primary', 'secondary'])
<li class="bg-white">
    <div
        class="relative px-6 py-5 flex items-center space-x-3 hover:bg-gray-50 focus-within:ring-2 focus-within:ring-inset focus-within:ring-indigo-500">
        <div class="flex-shrink-0">
            <img class="h-10 w-10 rounded-full"
                 src="{{ $item[$photo] }}"
                 alt="">
        </div>
        <div class="flex-1 min-w-0">
            <a href="#" class="focus:outline-none">
                <!-- Extend touch target to entire panel -->
                <span class="absolute inset-0" aria-hidden="true"></span>
                <p class="text-sm font-medium text-gray-900">
                    {{ $item[$primary] }}
                </p>
                <p class="text-sm text-gray-500 truncate">
                    {{ $item[$secondary] }}
                </p>
            </a>
        </div>
    </div>
</li>
