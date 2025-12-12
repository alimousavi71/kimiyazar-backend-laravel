@props(['label' => null, 'error' => null, 'required' => false, 'help' => null])

<div class="flex flex-col gap-1">
    @if($label)
        <label class="text-sm font-medium text-gray-700">
            {{ $label }}
            @if($required)
                <span class="text-red-500">*</span>
            @endif
        </label>
    @endif

    <div>
        {{ $slot }}
    </div>

    @if($help && !$error)
        <span class="text-sm text-gray-500">{{ $help }}</span>
    @endif

    @if($error)
        <span class="text-sm text-red-600">{{ $error }}</span>
    @endif
</div>