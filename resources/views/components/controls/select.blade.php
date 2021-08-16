@props([
'stacked',
'list',
'primary' => 'name',
'secondary' => '',
'photo' => 'photo',
'valueProp' => 'id',
'selected' => ''
])
<nav x-data {{ $attributes->wire('model') }} class="h-full border overflow-y-auto" aria-label="Directory">
    <div class="relative">
        @if ($stacked)
            @foreach($list as $key => $group)
                <div
                    class="z-10 sticky top-0 border-t border-b border-gray-200 bg-gray-50 px-6 py-1 text-sm font-medium text-gray-500">
                    <h3>{{$key}}</h3>
                </div>
                <ul class="relative z-0 divide-y divide-gray-200">
                    @foreach($group as $item)
                        <li class="bg-white">
                            <div
                                class="relative px-6 py-5 flex items-center space-x-3 hover:bg-gray-50 {{ $item[$valueProp] == $selected ? 'ring-2 ring-inset ring-indigo-500' : '' }}">
                                <div class="flex-shrink-0">
                                    <img class="h-10 w-10 rounded-full"
                                         src="{{ $item[$photo] }}"
                                         alt="">
                                </div>
                                <div class="flex-1 min-w-0">
                                    <a href="#" @click.prevent="$dispatch('input', {{$item[$valueProp]}})" class="focus:outline-none">
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
                    @endforeach
                </ul>
            @endforeach
        @else
            <ul class="relative z-0 divide-y divide-gray-200">
                @foreach($list as $item)
                    <li class="bg-white">
                        <div
                            class="relative px-6 py-5 flex items-center space-x-3 hover:bg-gray-50 {{ $item[$valueProp] == $selected ? 'ring-2 ring-inset ring-indigo-500' : '' }}">
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
                @endforeach
            </ul>
        @endif
    </div>
</nav>
