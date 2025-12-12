@props([
    'name' => null,
    'id' => null,
    'label' => null,
    'description' => null,
    'checked' => false,
    'value' => '1',
    'disabled' => false,
    'size' => 'md',
    'color' => 'blue',
])

@php
    $toggleId = $id ?? 'toggle-' . uniqid();
    $toggleName = $name ?? $toggleId;
    // Handle checked prop - can be boolean, string 'checked', or attribute without value
    $isChecked = (bool) ($checked === true || $checked === 'checked' || $checked === '1' || $checked === 1 || (isset($attributes['checked']) && $attributes['checked'] !== false && $attributes['checked'] !== 'false'));
    
    $sizes = [
        'sm' => ['track' => 'w-9 h-5', 'thumb' => 'h-4 w-4', 'top' => 'top-[2px]'],
        'md' => ['track' => 'w-11 h-6', 'thumb' => 'h-5 w-5', 'top' => 'top-[2px]'],
        'lg' => ['track' => 'w-14 h-7', 'thumb' => 'h-6 w-6', 'top' => 'top-[2px]'],
    ];
    
    $colors = [
        'blue' => ['checked' => 'bg-blue-600', 'ring' => 'ring-blue-300'],
        'green' => ['checked' => 'bg-green-600', 'ring' => 'ring-green-300'],
        'red' => ['checked' => 'bg-red-600', 'ring' => 'ring-red-300'],
        'purple' => ['checked' => 'bg-purple-600', 'ring' => 'ring-purple-300'],
    ];
    
    $sizeClasses = $sizes[$size] ?? $sizes['md'];
    $colorConfig = $colors[$color] ?? $colors['blue'];
@endphp

<div class="flex items-center justify-between p-4 bg-gray-50 rounded-lg">
    @if($label || $description)
        <div class="flex-1 me-4">
            @if($label)
                <p class="font-medium text-gray-900">{{ $label }}</p>
            @endif
            @if($description)
                <p class="text-sm text-gray-600 mt-0.5">{{ $description }}</p>
            @endif
        </div>
    @endif
    
    <label 
        class="relative inline-flex items-center cursor-pointer" 
        :class="{ 'cursor-not-allowed opacity-50': {{ $disabled ? 'true' : 'false' }} }"
        x-data="{ 
            isRtl: document.documentElement.dir === 'rtl',
            isChecked: {{ $isChecked ? 'true' : 'false' }}
        }"
    >
        <input 
            type="checkbox" 
            name="{{ $toggleName }}"
            id="{{ $toggleId }}"
            value="{{ $value }}"
            {{ $isChecked ? 'checked' : '' }}
            {{ $disabled ? 'disabled' : '' }}
            class="sr-only"
            x-model="isChecked"
        />
        <div 
            class="{{ $sizeClasses['track'] }} focus-within:outline-none focus-within:ring-4 rounded-full transition-colors duration-200 relative"
            :class="{
                '{{ $colorConfig['checked'] }}': isChecked,
                'bg-gray-200': !isChecked,
                'focus-within:{{ $colorConfig['ring'] }}': true
            }"
        >
            <div 
                class="absolute {{ $sizeClasses['top'] }} {{ $sizeClasses['thumb'] }} bg-white border rounded-full transition-all duration-200"
                :class="{
                    'start-[2px]': (isChecked && isRtl) || (!isChecked && !isRtl),
                    'end-[2px]': (isChecked && !isRtl) || (!isChecked && isRtl),
                    'border-white': isChecked,
                    'border-gray-300': !isChecked
                }"
            ></div>
        </div>
    </label>
</div>
