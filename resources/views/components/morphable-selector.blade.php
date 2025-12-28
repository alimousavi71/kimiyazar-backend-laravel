@props([
    'typeFieldName' => 'morphable_type',
    'idFieldName' => 'morphable_id',
    'selectedType' => null,
    'selectedId' => null,
    'label' => null,
    'required' => false,
    'typeError' => null,
    'idError' => null,
])

@php
    $types = config('morphable.types', []);
    $typeOptions = collect($types)->map(function($config, $class) {
        return [
            'value' => $class,
            'label' => __($config['label_key'] ?? $config['label']),
        ];
    })->values();
    $minSearchLength = config('morphable.min_search_length', 2);
@endphp

<div x-data="morphableSelector(@js($typeFieldName), @js($idFieldName), @js($selectedType), @js($selectedId))" class="space-y-4">
    
    <x-form-group :label="$label ?? __('morphable.select_type')" :required="$required" :error="$typeError">
        <select 
            x-model="selectedType" 
            @change="onTypeChange()" 
            name="{{ $typeFieldName }}" 
            class="px-3 py-2.5 rounded-xl border focus:ring-2 focus:ring-green-500 focus:border-green-500 outline-none transition-all duration-200 bg-white disabled:bg-gray-50 disabled:cursor-not-allowed shadow-sm hover:shadow-md focus:shadow-md {{ $typeError ? 'border-red-500' : 'border-gray-200' }}"
        >
            <option value="">{{ __('morphable.choose_type') }}</option>
            @foreach($typeOptions as $option)
                <option value="{{ $option['value'] }}">{{ $option['label'] }}</option>
            @endforeach
        </select>
    </x-form-group>

    
    <template x-if="selectedType">
        <div>
            <x-form-group :label="__('morphable.select_item')" :required="$required" :error="$idError">
                <x-select2
                    :name="$idFieldName"
                    x-bind:remote-url="getRemoteUrl()"
                    remote-search
                    allow-clear
                    :min-input-length="$minSearchLength"
                    search-param="query"
                    value-key="id"
                    text-key="text"
                    :placeholder="__('morphable.search_items')"
                    x-bind:value="selectedId"
                />
            </x-form-group>
        </div>
    </template>
</div>

@push('scripts')
<script>
function morphableSelector(typeFieldName, idFieldName, initialType, initialId) {
    return {
        selectedType: initialType || null,
        selectedId: initialId || null,
        typeKey: 0, // Used to force re-render of select2 when type changes

        onTypeChange() {
            // Clear item selection when type changes
            // The x-if template will recreate the select2 component with cleared value
            this.selectedId = null;
            this.typeKey++;
        },

        getRemoteUrl() {
            if (!this.selectedType) return '';
            const baseUrl = @js(route('admin.morphable.search'));
            return `${baseUrl}?type=${encodeURIComponent(this.selectedType)}`;
        }
    };
}
</script>
@endpush
