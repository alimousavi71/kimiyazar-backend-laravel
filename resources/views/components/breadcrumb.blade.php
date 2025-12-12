@props(['items' => []])

<nav aria-label="Breadcrumb" class="py-1">
    <ol class="flex items-center gap-1.5 text-xs justify-end">
        @foreach($items as $index => $item)
            <li class="flex items-center gap-1.5">
                @if($index > 0)
                    <x-icon name="chevron-right" size="xs" class="text-gray-400" />
                @endif
                @if(isset($item['url']) && !$loop->last)
                    <a href="{{ $item['url'] }}" class="text-gray-500 hover:text-gray-700 transition-colors">
                        {{ $item['label'] }}
                    </a>
                @else
                    <span class="text-gray-900 font-medium">{{ $item['label'] }}</span>
                @endif
            </li>
        @endforeach
    </ol>
</nav>