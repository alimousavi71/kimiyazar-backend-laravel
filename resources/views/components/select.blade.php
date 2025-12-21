@props(['label' => null, 'error' => null, 'required' => false, 'placeholder' => null])

@php
    $placeholder = $placeholder ?? __('admin/components.form.select_option');
@endphp

<div class="flex flex-col gap-1">
    @if($label)
        <label class="text-sm font-medium text-gray-700">
            {{ $label }}
            @if($required)
                <span class="text-red-500">*</span>
            @endif
        </label>
    @endif

    <select {{ $attributes->merge(['class' => 'px-3 py-2.5 rounded-xl border border-gray-200 focus:ring-2 focus:ring-green-500 focus:border-green-500 outline-none transition-all duration-200 bg-white disabled:bg-gray-50 disabled:cursor-not-allowed shadow-sm hover:shadow-md focus:shadow-md']) }}>
        @if($placeholder)
            <option value="">{{ $placeholder }}</option>
        @endif
        {{ $slot }}
    </select>

    @if($error)
        <span class="text-sm text-red-600">{{ $error }}</span>
    @endif
</div>