@props(['id' => null, 'type' => 'info', 'message' => '', 'duration' => 5000])

@php
$colors = [
    'success' => 'bg-green-100 text-green-800 border border-green-300',
    'danger' => 'bg-red-100 text-red-800 border border-red-300',
    'warning' => 'bg-yellow-100 text-yellow-800 border border-yellow-300',
    'info' => 'bg-green-100 text-green-800 border border-green-300',
];

$icons = [
    'success' => '✓',
    'danger' => '✕',
    'warning' => '⚠',
    'info' => 'ℹ',
];
@endphp

<div 
    x-data="{ 
        show: true,
        isRtl: document.documentElement.dir === 'rtl'
    }"
    x-show="show"
    x-transition:enter="transition ease-out duration-300"
    x-bind:x-transition:enter-start="isRtl ? 'opacity-0 -translate-x-full' : 'opacity-0 translate-x-full'"
    x-transition:enter-end="opacity-100 translate-x-0"
    x-transition:leave="transition ease-in duration-200"
    x-transition:leave-start="opacity-100 translate-x-0"
    x-bind:x-transition:leave-end="isRtl ? 'opacity-0 -translate-x-full' : 'opacity-0 translate-x-full'"
    @if($id) id="{{ $id }}" @endif
    class="p-4 rounded-lg shadow-lg flex items-center gap-3 min-w-[300px] max-w-md {{ $colors[$type] }}"
    @if($duration > 0)
        x-init="setTimeout(() => show = false, {{ $duration }})"
    @endif
>
    <span class="font-semibold text-lg">{{ $icons[$type] }}</span>
    <div class="flex-1 space-y-1">
        @if(str_contains($message ?: $slot, "\n"))
            @foreach(explode("\n", $message ?: $slot) as $line)
                @if(trim($line))
                    <div class="text-sm font-medium">{{ trim($line) }}</div>
                @endif
            @endforeach
        @else
            <div class="text-sm font-medium">{{ $message ?: $slot }}</div>
        @endif
    </div>
    <button @click="show = false" class="text-current opacity-70 hover:opacity-100 transition-opacity">
        <span class="sr-only">{{ __('admin/components.buttons.close') }}</span>
        <span aria-hidden="true">&times;</span>
    </button>
</div>

