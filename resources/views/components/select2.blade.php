@props([
    'label' => null,
    'error' => null,
    'required' => false,
    'placeholder' => 'Select an option',
    'name' => null,
    'id' => null,
    'value' => null,
    'options' => [],
    'remoteUrl' => null,
    'remoteSearch' => false,
    'multiple' => false,
    'tags' => false,
    'allowClear' => false,
    'minInputLength' => 0,
    'searchParam' => 'search',
    'valueKey' => 'id',
    'textKey' => 'name',
])

@php
    $selectId = $id ?? 'select2-' . uniqid();
    $selectName = $name ?? $selectId;
@endphp

<div class="flex flex-col gap-1" x-data="select2Component('{{ $selectId }}', {
    remoteUrl: @js($remoteUrl),
    remoteSearch: @js($remoteSearch),
    multiple: @js($multiple),
    tags: @js($tags),
    allowClear: @js($allowClear),
    minInputLength: @js($minInputLength),
    searchParam: @js($searchParam),
    valueKey: @js($valueKey),
    textKey: @js($textKey),
    options: @js($options),
    value: @js($value),
})">
    @if($label)
        <label class="text-sm font-medium text-gray-700" for="{{ $selectId }}">
            {{ $label }}
            @if($required)
                <span class="text-red-500">*</span>
            @endif
        </label>
    @endif

    <div class="relative" x-ref="selectContainer">
        <!-- Hidden select for form submission -->
        <select 
            name="{{ $selectName }}{{ $multiple ? '[]' : '' }}" 
            id="{{ $selectId }}"
            {{ $multiple ? 'multiple' : '' }}
            x-ref="hiddenSelect"
            class="hidden"
            {{ $attributes->merge(['id' => $selectId])->except(['class', 'options', 'remoteUrl', 'remoteSearch', 'multiple', 'tags', 'allowClear', 'minInputLength', 'searchParam', 'valueKey', 'textKey', 'value']) }}
        >
            <template x-for="option in selectedOptions" :key="option.value">
                <option :value="option.value" :selected="true" x-text="option.text"></option>
            </template>
        </select>

        <!-- Custom Select2 Dropdown -->
        <div 
            class="relative"
            @click.away="closeDropdown()"
        >
            <!-- Selected Value Display -->
            <button 
                x-ref="select2Trigger"
                type="button"
                @click="toggleDropdown()"
                class="w-full px-3 py-2.5 rounded-xl border border-gray-200 focus:ring-2 focus:ring-green-500 focus:border-green-500 outline-none transition-all duration-200 disabled:bg-gray-50 disabled:cursor-not-allowed bg-white shadow-sm hover:shadow-md focus:shadow-md text-start flex items-center justify-between min-h-[42px]"
                :class="{
                    'ring-2 ring-green-500 border-green-500 shadow-md': isOpen
                }"
            >
                <span class="flex-1 truncate text-gray-900" x-show="selectedOptions.length > 0">
                    <template x-for="(option, index) in selectedOptions" :key="option.value">
                        <span>
                            <span x-text="option.text" class="inline-block me-2"></span>
                            <template x-if="multiple && index < selectedOptions.length - 1">
                                <span class="text-gray-400">,</span>
                            </template>
                        </span>
                    </template>
                </span>
                <span x-show="selectedOptions.length === 0" class="text-gray-400 flex-1 text-start">{{ $placeholder }}</span>
                
                <div class="flex items-center gap-2 ms-2 flex-shrink-0">
                    <template x-if="allowClear && selectedOptions.length > 0">
                        <button 
                            type="button"
                            @click.stop="clearSelection()"
                            class="text-gray-400 hover:text-gray-600 transition-colors p-0.5 rounded"
                        >
                            <x-icon name="x" size="sm" />
                        </button>
                    </template>
                    <span 
                        class="transition-transform duration-200 text-gray-400"
                        x-bind:class="isOpen ? 'rotate-180' : ''"
                    >
                        <x-icon name="chevron-down" size="sm" />
                    </span>
                </div>
            </button>

            <!-- Dropdown -->
            <div 
                x-ref="select2Dropdown"
                x-show="isOpen"
                x-cloak
                class="absolute z-50 w-full bg-white rounded-xl shadow-md border border-gray-200 max-h-60 overflow-hidden transition-opacity duration-150 ease-out"
                :class="isOpen ? 'opacity-100' : 'opacity-0'"
                style="display: none;"
            >
                <!-- Search Input (if remote search or tags enabled) -->
                <div x-show="remoteSearch || tags" class="p-2 border-b border-gray-200">
                    <input 
                        type="text"
                        x-model="searchQuery"
                        @input.debounce.300ms="handleSearch()"
                        @keydown.escape="closeDropdown()"
                        :placeholder="@js(__('admin/components.form.type_to_search'))"
                        class="w-full px-3 py-2.5 rounded-xl border border-gray-200 focus:ring-2 focus:ring-green-500 focus:border-green-500 outline-none transition-all duration-200 bg-white shadow-sm hover:shadow-md focus:shadow-md text-sm"
                    />
                </div>

                <!-- Loading State -->
                <div x-show="isLoading" class="p-4 text-center text-gray-500 text-sm">
                    <div class="inline-flex items-center gap-2">
                        <div class="w-4 h-4 border-2 border-green-500 border-t-transparent rounded-full animate-spin"></div>
                        <span>Loading...</span>
                    </div>
                </div>

                <!-- Options List -->
                <div 
                    x-show="!isLoading"
                    class="max-h-48 overflow-y-auto"
                >
                    <template x-if="filteredOptions.length === 0 && !isLoading">
                        <div class="p-4 text-center text-gray-500 text-sm">
                            <span x-show="remoteSearch && searchQuery.length < minInputLength">
                                Type at least {{ $minInputLength }} characters to search
                            </span>
                            <span x-show="remoteSearch && searchQuery.length >= minInputLength && !isLoading">
                                No results found
                            </span>
                            <span x-show="!remoteSearch">
                                No options available
                            </span>
                        </div>
                    </template>

                    <template x-for="option in filteredOptions" :key="option.value">
                        <div 
                            @click="selectOption(option)"
                            :class="[
                                'px-3 py-2.5 cursor-pointer hover:bg-gray-50 transition-colors flex items-center justify-between text-sm',
                                isSelected(option) ? 'bg-green-50 text-green-700 font-medium' : 'text-gray-900'
                            ]"
                        >
                            <span x-text="option.text" class="flex-1"></span>
                            <template x-if="isSelected(option)">
                                <x-icon name="check" size="sm" class="text-green-600 ms-2 flex-shrink-0" />
                            </template>
                        </div>
                    </template>
                </div>
            </div>
        </div>
    </div>

    @if($error)
        <span class="text-sm text-red-600">{{ $error }}</span>
    @endif
</div>

@push('scripts')
<script>
function select2Component(selectId, config) {
    return {
        isOpen: false,
        isLoading: false,
        searchQuery: '',
        options: config.options || [],
        filteredOptions: [],
        selectedOptions: [],
        remoteUrl: config.remoteUrl,
        remoteSearch: config.remoteSearch,
        multiple: config.multiple || false,
        tags: config.tags || false,
        allowClear: config.allowClear || false,
        minInputLength: config.minInputLength || 0,
        searchParam: config.searchParam || 'search',
        valueKey: config.valueKey || 'id',
        textKey: config.textKey || 'name',
        componentSelectId: selectId, // Store selectId for reference
        popperInstance: null,

        init() {
            // Store reference to component for external access
            const selectElement = document.getElementById(selectId);
            if (selectElement) {
                selectElement._select2Component = this;
            }
            // Also store on the container for easier access
            const container = this.$el;
            if (container) {
                container._select2Component = this;
            }

            // Store globally for easier access by ID
            window._select2Components = window._select2Components || {};
            window._select2Components[selectId] = this;

            // Initialize selected options from value
            if (config.value) {
                if (this.multiple && Array.isArray(config.value)) {
                    this.selectedOptions = config.value.map(val => {
                        const option = this.options.find(opt => opt.value == val);
                        return option || { value: val, text: val };
                    });
                } else {
                    const option = this.options.find(opt => opt.value == config.value);
                    if (option) {
                        this.selectedOptions = [option];
                    }
                }
            }

            // Load initial options
            if (this.remoteUrl && !this.remoteSearch) {
                this.loadRemoteOptions();
            } else {
                this.filteredOptions = this.options;
            }

            // Update hidden select
            this.updateHiddenSelect();

            // Watch isOpen to initialize/destroy Popper
            this.$watch('isOpen', value => {
                if (value) {
                    this.$nextTick(() => {
                        if (window.initDropdownPopper && this.$refs.select2Trigger && this.$refs.select2Dropdown && !this.popperInstance) {
                            this.popperInstance = window.initDropdownPopper(
                                this.$refs.select2Trigger,
                                this.$refs.select2Dropdown,
                                'bottom-start'
                            );
                        }
                    });
                } else {
                    if (this.popperInstance) {
                        this.popperInstance.destroy();
                        this.popperInstance = null;
                    }
                }
            });
        },

        toggleDropdown() {
            this.isOpen = !this.isOpen;
            if (this.isOpen && this.remoteSearch && this.filteredOptions.length === 0) {
                this.loadRemoteOptions();
            }
        },

        closeDropdown() {
            this.isOpen = false;
        },

        selectOption(option) {
            if (this.multiple) {
                const index = this.selectedOptions.findIndex(opt => opt.value == option.value);
                if (index > -1) {
                    this.selectedOptions.splice(index, 1);
                } else {
                    this.selectedOptions.push(option);
                }
            } else {
                this.selectedOptions = [option];
                this.closeDropdown();
                // Dispatch event for single select
                window.dispatchEvent(new CustomEvent('select2-selected', {
                    detail: {
                        selectId: this.componentSelectId,
                        value: option.value,
                        text: option.text
                    }
                }));
            }
            this.updateHiddenSelect();
        },

        clearSelection() {
            const wasMultiple = this.multiple;
            const hadSelection = this.selectedOptions.length > 0;
            this.selectedOptions = [];
            this.updateHiddenSelect();
            // Dispatch event for single select clear
            if (!wasMultiple && hadSelection) {
                window.dispatchEvent(new CustomEvent('select2-cleared', {
                    detail: {
                        selectId: this.componentSelectId
                    }
                }));
            }
        },

        isSelected(option) {
            return this.selectedOptions.some(opt => opt.value == option.value);
        },

        async handleSearch() {
            if (this.remoteSearch && this.remoteUrl) {
                if (this.searchQuery.length < this.minInputLength) {
                    this.filteredOptions = [];
                    return;
                }
                await this.loadRemoteOptions();
            } else {
                this.filterOptions();
            }
        },

        filterOptions() {
            if (!this.searchQuery) {
                this.filteredOptions = this.options;
                return;
            }
            const query = this.searchQuery.toLowerCase();
            this.filteredOptions = this.options.filter(option => 
                option.text.toLowerCase().includes(query)
            );
        },

        async loadRemoteOptions() {
            if (!this.remoteUrl) return;

            this.isLoading = true;
            try {
                const url = new URL(this.remoteUrl, window.location.origin);
                if (this.remoteSearch && this.searchQuery) {
                    url.searchParams.set(this.searchParam, this.searchQuery);
                }

                const response = await window.axios.get(url.toString());
                const data = response.data?.data || response.data || [];

                this.options = data.map(item => ({
                    value: item[this.valueKey],
                    text: item[this.textKey]
                }));

                this.filterOptions();
            } catch (error) {
                console.error('Error loading remote options:', error);
                if (window.Toast) {
                    window.Toast.error('Failed to load options');
                }
            } finally {
                this.isLoading = false;
            }
        },

        updateHiddenSelect() {
            this.$nextTick(() => {
                const hiddenSelect = this.$refs.hiddenSelect;
                if (!hiddenSelect) return;

                // Clear existing options
                hiddenSelect.innerHTML = '';

                // Add selected options
                this.selectedOptions.forEach(option => {
                    const optionElement = document.createElement('option');
                    optionElement.value = option.value;
                    optionElement.textContent = option.text;
                    optionElement.selected = true;
                    hiddenSelect.appendChild(optionElement);
                });
            });
        }
    }
}

// Helper function to find and clear a Select2 component by ID
window.clearSelect2 = function(selectId) {
    if (window._select2Components && window._select2Components[selectId]) {
        window._select2Components[selectId].clearSelection();
        return true;
    }
    const selectElement = document.getElementById(selectId);
    if (selectElement && selectElement._select2Component) {
        selectElement._select2Component.clearSelection();
        return true;
    }
    return false;
};
</script>
@endpush
