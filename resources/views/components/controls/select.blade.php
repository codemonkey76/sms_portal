@props([
"stacked" => true,
"primary" => "name",
"photo" => "profilePhotoUrl",
"secondary" => "position",
"category" => "letter",
"list"
])
<nav {{ $attributes->merge(['class' => 'h-full overflow-y-auto']) }} aria-label="Directory">
    <div class="relative">
        @if ($stacked)
            @foreach($list as $key => $group)
                <div
                    class="z-10 sticky top-0 border-t border-b border-gray-200 bg-gray-50 px-6 py-1 text-sm font-medium text-gray-500">
                    <h3>{{$key}}</h3>
                </div>
                <ul class="relative z-0 divide-y divide-gray-200">
                    @foreach($group as $item)
                        <x-controls.select.option :item="$item" :photo="$photo" :primary="$primary" :secondary="$secondary"/>
                    @endforeach
                </ul>
            @endforeach
        @else
            <ul class="relative z-0 divide-y divide-gray-200">
                @foreach($list as $item)
                    <x-controls.select.option :item="$item" :photo="$photo" :primary="$primary" :secondary="$secondary"/>
                @endforeach
            </ul>
        @endif
    </div>
    <input type="hidden" value="">
</nav>
