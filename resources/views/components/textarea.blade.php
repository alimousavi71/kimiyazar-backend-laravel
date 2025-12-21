@props(['label' => null, 'error' => null, 'required' => false, 'rows' => 4])

<div class="flex flex-col gap-1">
    @if($label)
        <label class="text-sm font-medium text-gray-700">
            {{ $label }}
            @if($required)
                <span class="text-red-500">*</span>
            @endif
        </label>
    @endif

    <textarea rows="{{ $rows }}" {{ $attributes->merge(['class' => 'px-3 py-2.5 rounded-xl border border-gray-200 focus:ring-2 focus:ring-green-500 focus:border-green-500 outline-none transition-all duration-200 resize-y disabled:bg-gray-50 disabled:cursor-not-allowed bg-white shadow-sm hover:shadow-md focus:shadow-md']) }}>{{ $slot }}</textarea>

    @if($error)
        <span class="text-sm text-red-600">{{ $error }}</span>
    @endif
</div>