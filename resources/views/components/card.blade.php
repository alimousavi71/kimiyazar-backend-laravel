@props(['title' => null, 'footer' => null])

<div {{ $attributes->merge(['class' => 'bg-white rounded-2xl shadow-sm border border-gray-100 p-4 sm:p-5']) }}>
    @if($title)
        <div class="mb-4 pb-4 border-b border-gray-100">
            <h3 class="text-lg font-semibold text-gray-900">{{ $title }}</h3>
        </div>
    @endif

    <div class="text-gray-700">
        {{ $slot }}
    </div>

    @if($footer)
        <div class="mt-4 pt-4 border-t border-gray-100">
            {{ $footer }}
        </div>
    @endif
</div>