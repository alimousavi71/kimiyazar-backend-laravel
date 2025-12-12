@props(['responsive' => true])

@php
    $wrapperClass = $responsive ? 'overflow-x-auto' : '';
@endphp

<div class="{{ $wrapperClass }} rounded-xl border border-gray-200 overflow-hidden">
    <table {{ $attributes->merge(['class' => 'min-w-full divide-y divide-gray-200 bg-white']) }}>
        {{ $slot }}
    </table>
</div>