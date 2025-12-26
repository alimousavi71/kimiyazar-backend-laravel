@props(['menu' => null, 'type' => null])

@php
    if ($menu) {
        $links = $menu->getOrderedLinks();
    } elseif ($type) {
        $menuData = \App\Models\Menu::findByType($type);
        $links = $menuData ? $menuData->getOrderedLinks() : [];
    } else {
        $links = [];
    }
@endphp

@if(!empty($links))
    <ul {{ $attributes->merge(['class' => 'space-y-3']) }}>
        @foreach($links as $link)
            <li>
                <a href="{{ $link['url'] ?? '#' }}"
                   class="text-gray-700 hover:text-blue-600 transition-colors"
                   @if(str_contains($link['url'] ?? '', 'http'))
                       target="_blank" rel="noopener noreferrer"
                   @endif>
                    {{ $link['title'] ?? '' }}
                </a>
            </li>
        @endforeach
    </ul>
@endif
