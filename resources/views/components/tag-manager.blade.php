@props([
    'tagableType' => null,
    'tagableId' => null,
    'label' => null,
    'required' => false,
    'error' => null,
    'readOnly' => false,
])

@php
    $uniqueId = 'tag-manager-' . uniqid();
    $translationKey = str_replace('-', '_', $uniqueId);
    $translations = [
        'search_error' => __('admin/tags.messages.search_failed'),
        'create_error' => __('admin/tags.messages.create_failed'),
        'attach_error' => __('admin/tags.messages.attach_failed'),
    ];
@endphp

<div x-data="tagManager({
    tagableType: @js($tagableType),
    tagableId: @js($tagableId),
    uniqueId: @js($uniqueId),
    translationKey: @js($translationKey),
    readOnly: @js($readOnly),
})" class="space-y-2" id="{{ $uniqueId }}">
    @if($label)
        <label class="block text-sm font-medium text-gray-700 mb-2">
            {{ $label }}
            @if($required)
                <span class="text-red-500">*</span>
            @endif
        </label>
    @endif

    @if(!$readOnly)
        <div class="relative">
            <input type="text"
                   x-ref="searchInput"
                   x-model="searchQuery"
                   @focus="onInputFocus()"
                   @blur="onInputBlur()"
                   @input.debounce.300ms="searchTags()"
                   @keydown.enter.prevent="handleEnterKey()"
                   @keydown.arrow-down.prevent="navigateDown()"
                   @keydown.arrow-up.prevent="navigateUp()"
                   @keydown.escape="closeDropdown()"
                   :placeholder="__('admin/tags.forms.placeholders.search')"
                   class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:outline-none focus:ring-2 focus:ring-green-500 focus:border-transparent">

            <div x-show="showDropdown && searchResults.length > 0"
                 x-cloak
                 x-transition:enter="transition ease-out duration-100"
                 x-transition:enter-start="opacity-0 scale-95"
                 x-transition:enter-end="opacity-100 scale-100"
                 x-transition:leave="transition ease-in duration-75"
                 x-transition:leave-start="opacity-100 scale-100"
                 x-transition:leave-end="opacity-0 scale-95"
                 @click.away="closeDropdown()"
                 class="absolute z-50 w-full mt-1 bg-white border border-gray-300 rounded-lg shadow-lg max-h-60 overflow-y-auto">
                <template x-for="(tag, index) in searchResults" :key="tag.id">
                    <button type="button"
                            @click="selectTag(tag)"
                            @mouseenter="selectedIndex = index"
                            :class="{
                                'bg-green-50': selectedIndex === index,
                                'bg-gray-50': isTagSelected(tag.id)
                            }"
                            class="w-full text-right px-4 py-2 hover:bg-gray-100 transition-colors flex items-center justify-between">
                        <span x-text="tag.title" class="font-medium text-gray-900"></span>
                        <span x-show="isTagSelected(tag.id)" class="text-xs text-green-600">✓</span>
                    </button>
                </template>
            </div>
        </div>
    @endif

    <div x-show="tags.length > 0" class="flex flex-wrap gap-2 mt-2">
        <template x-for="(tag, index) in tags" :key="tag.id">
            <div class="inline-flex items-center gap-2 px-3 py-1.5 bg-green-50 border border-green-200 rounded-lg">
                <span x-text="tag.title" class="text-sm font-medium text-green-900"></span>
                
                @if(!$readOnly)
                    <button type="button"
                            @click="removeTag(tag.id, tag.tagable_id)"
                            class="text-green-600 hover:text-red-600 transition-colors focus:outline-none"
                            title="حذف">
                        <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12"></path>
                        </svg>
                    </button>
                @endif
            </div>
        </template>
    </div>

    <div x-show="tags.length === 0 && !readOnly" class="text-sm text-gray-500 py-2">
        {{ __('admin/tags.forms.labels.no_tags') }}
    </div>

    @if($error)
        <span class="text-sm text-red-600">{{ $error }}</span>
    @endif

    <template x-show="!readOnly" x-for="tag in tags" :key="tag.id">
        <input type="hidden" :name="'tags[]'" :value="tag.id">
    </template>
</div>

@push('scripts')
<script>
    window.tagManagerTranslations_{{ $translationKey }} = {!! json_encode($translations, JSON_UNESCAPED_UNICODE | JSON_HEX_APOS) !!};

    function tagManager(config) {
        return {
            tags: [],
            searchQuery: '',
            searchResults: [],
            showDropdown: false,
            selectedIndex: -1,
            loading: false,
            searchTimeout: null,
            tagableType: config.tagableType,
            tagableId: config.tagableId,
            uniqueId: config.uniqueId,
            translationKey: config.translationKey,
            readOnly: config.readOnly || false,
            
            get translations() {
                const key = 'tagManagerTranslations_' + this.translationKey;
                return window[key] || {};
            },

            init() {
                if (this.tagableType && this.tagableId) {
                    this.loadTags();
                }
            },

            async loadTags() {
                if (!this.tagableType || !this.tagableId) return;

                try {
                    const response = await window.axios.get('{{ route("admin.tags.index") }}', {
                        params: {
                            tagable_type: this.tagableType,
                            tagable_id: this.tagableId,
                        }
                    });

                    if (response.data && response.data.success !== false) {
                        this.tags = response.data.data || [];
                    }
                } catch (error) {
                    console.error('Failed to load tags:', error);
                }
            },

            onInputFocus() {
                if (this.searchQuery.length >= 2) {
                    this.showDropdown = true;
                } else if (this.searchQuery.length === 0) {
                    this.loadRecentTags();
                }
            },

            onInputBlur() {
                setTimeout(() => {
                    this.closeDropdown();
                }, 200);
            },

            closeDropdown() {
                this.showDropdown = false;
                this.selectedIndex = -1;
            },

            async loadRecentTags() {
                if (this.loading) return;
                
                try {
                    const response = await window.axios.get('{{ route("admin.tags.search") }}', {
                        params: {
                            query: '',
                            limit: 10,
                        }
                    });

                    if (response.data && response.data.success !== false) {
                        this.searchResults = response.data.data || [];
                        if (this.searchResults.length > 0 && this.$refs.searchInput === document.activeElement) {
                            this.showDropdown = true;
                        }
                    }
                } catch (error) {
                    console.error('Failed to load recent tags:', error);
                }
            },

            async searchTags() {
                if (this.searchTimeout) {
                    clearTimeout(this.searchTimeout);
                }

                this.searchTimeout = setTimeout(async () => {
                    if (this.searchQuery.length === 0) {
                        this.searchResults = [];
                        this.closeDropdown();
                        return;
                    }

                    if (this.searchQuery.length < 2) {
                        this.searchResults = [];
                        this.closeDropdown();
                        return;
                    }

                    this.loading = true;

                    try {
                        const response = await window.axios.get('{{ route("admin.tags.search") }}', {
                            params: {
                                query: this.searchQuery,
                                limit: 20,
                            }
                        });

                        if (response.data && response.data.success !== false) {
                            this.searchResults = response.data.data || [];
                            this.selectedIndex = -1;
                            if (this.searchResults.length > 0) {
                                this.showDropdown = true;
                            }
                        }
                    } catch (error) {
                        console.error('Search error:', error);
                        if (window.Toast) {
                            window.Toast.error(this.translations.search_error);
                        }
                    } finally {
                        this.loading = false;
                    }
                }, 300);
            },

            isTagSelected(tagId) {
                return this.tags.some(t => t.id === tagId);
            },

            navigateDown() {
                if (this.searchResults.length === 0) return;
                this.showDropdown = true;
                this.selectedIndex = Math.min(this.selectedIndex + 1, this.searchResults.length - 1);
            },

            navigateUp() {
                if (this.searchResults.length === 0) return;
                this.showDropdown = true;
                this.selectedIndex = Math.max(this.selectedIndex - 1, -1);
            },

            handleEnterKey() {
                if (this.selectedIndex >= 0 && this.searchResults[this.selectedIndex]) {
                    this.selectTag(this.searchResults[this.selectedIndex]);
                } else if (this.searchQuery.trim().length > 0) {
                    if (this.searchResults.length > 0) {
                        this.selectTag(this.searchResults[0]);
                    } else {
                        this.createNewTag();
                    }
                }
            },

            selectTag(tag) {
                if (this.isTagSelected(tag.id)) {
                    return;
                }

                this.tags.push({
                    id: tag.id,
                    tag_id: tag.id,
                    title: tag.title,
                    slug: tag.slug,
                    body: null,
                    tagable_id: tag.tagable_id || null,
                });

                this.searchQuery = '';
                this.searchResults = [];
                this.closeDropdown();
                this.$refs.searchInput.focus();
            },

            async createNewTag() {
                if (!this.searchQuery.trim()) return;

                this.loading = true;

                try {
                    const response = await window.axios.post('{{ route("admin.tags.store") }}', {
                        title: this.searchQuery.trim(),
                    });

                    if (response.data && response.data.success !== false) {
                        const tag = response.data.data || response.data;
                        this.selectTag(tag);
                    }
                } catch (error) {
                    console.error('Create tag error:', error);
                    if (window.Toast) {
                        window.Toast.error(error.response?.data?.message || this.translations.create_error);
                    }
                } finally {
                    this.loading = false;
                }
            },

            removeTag(tagId, tagableId) {
                this.tags = this.tags.filter(t => t.id !== tagId);

                if (this.tagableType && this.tagableId) {
                    this.detachTag(tagId);
                }
            },

            async detachTag(tagId) {
                try {
                    await window.axios.delete(`{{ route("admin.tags.detach", ":id") }}`.replace(':id', tagId), {
                        data: {
                            tagable_type: this.tagableType,
                            tagable_id: this.tagableId,
                        }
                    });
                } catch (error) {
                    console.error('Detach error:', error);
                }
            },

            async attachTags(tagableType, tagableId) {
                if (this.tags.length === 0) return;

                const tagData = this.tags.map(t => ({
                    tag_id: t.id,
                    body: t.body || null,
                }));

                try {
                    await window.axios.post('{{ route("admin.tags.attach") }}', {
                        tagable_type: tagableType,
                        tagable_id: tagableId,
                        tags: tagData,
                    });

                    this.tagableType = tagableType;
                    this.tagableId = tagableId;
                    await this.loadTags();
                } catch (error) {
                    console.error('Attach error:', error);
                    if (window.Toast) {
                        window.Toast.error(error.response?.data?.message || this.translations.attach_error);
                    }
                }
            }
        };
    }
</script>
@endpush
