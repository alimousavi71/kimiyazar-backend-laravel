@props([
    'name' => 'category_id',
    'id' => 'category_id',
    'value' => null,
    'categories' => collect(),
    'placeholder' => null,
    'required' => false,
    'class' => '',
])

@php
    $placeholder = $placeholder ?? __('admin/products.forms.placeholders.no_category');
    $uniqueId = uniqid('category-selector-');
@endphp

<div class="category-selector-wrapper" data-selector-id="{{ $uniqueId }}">
    <div class="relative">
        <!-- Hidden select for form submission -->
        <select name="{{ $name }}" id="{{ $id }}" class="hidden" {{ $required ? 'required' : '' }}>
            <option value="">{{ $placeholder }}</option>
            @foreach($categories as $category)
                <option value="{{ $category->id }}" {{ $value == $category->id ? 'selected' : '' }}>
                    {{ $category->name }}
                </option>
            @endforeach
        </select>

        <!-- Custom dropdown button -->
        <button type="button" 
            class="category-selector-button w-full px-3 py-2.5 rounded-xl border border-gray-200 focus:ring-2 focus:ring-blue-500 focus:border-blue-500 outline-none transition-all duration-200 bg-white disabled:bg-gray-50 disabled:cursor-not-allowed shadow-sm hover:shadow-md focus:shadow-md text-left flex items-center justify-between {{ $class }}"
            data-target="{{ $uniqueId }}">
            <span class="category-selector-text">
                {{ $placeholder }}
            </span>
            <x-icon name="chevron-down" size="sm" class="text-gray-400 transition-transform duration-200 category-selector-icon" />
        </button>

        <!-- Dropdown menu -->
        <div class="category-selector-dropdown absolute z-50 w-full mt-1 bg-white border border-gray-200 rounded-xl shadow-lg max-h-96 overflow-hidden hidden"
            data-dropdown="{{ $uniqueId }}">
            <!-- Search input -->
            <div class="p-3 border-b border-gray-200">
                <div class="relative">
                    <x-icon name="search" size="sm" class="absolute left-3 top-1/2 transform -translate-y-1/2 text-gray-400" />
                    <input type="text" 
                        class="category-selector-search w-full pl-9 pr-3 py-2 border border-gray-200 rounded-lg focus:ring-2 focus:ring-blue-500 focus:border-blue-500 outline-none text-sm"
                        placeholder="{{ __('admin/components.buttons.search') }}"
                        data-search="{{ $uniqueId }}">
                </div>
            </div>

            <!-- Category list -->
            <div class="category-selector-list overflow-y-auto max-h-80" data-list="{{ $uniqueId }}">
                <div class="category-selector-option p-2 px-3 text-sm text-gray-700 hover:bg-gray-50 cursor-pointer transition-colors"
                    data-value=""
                    data-text="{{ $placeholder }}">
                    {{ $placeholder }}
                </div>
                @foreach($categories as $category)
                    <div class="category-selector-option p-2 px-3 text-sm text-gray-700 hover:bg-gray-50 cursor-pointer transition-colors {{ $value == $category->id ? 'bg-blue-50 text-blue-700' : '' }}"
                        data-value="{{ $category->id }}"
                        data-text="{{ $category->name }}"
                        data-depth="{{ $category->depth ?? 0 }}"
                        style="padding-left: {{ ($category->depth ?? 0) * 20 + 12 }}px;">
                        <span class="category-name">{{ $category->name }}</span>
                    </div>
                @endforeach
            </div>
        </div>
    </div>
</div>
