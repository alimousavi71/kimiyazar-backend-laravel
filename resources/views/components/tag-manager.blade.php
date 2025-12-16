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
        'search_success' => __('admin/tags.messages.retrieved'),
        'search_error' => __('admin/tags.messages.search_failed'),
        'create_success' => __('admin/tags.messages.created'),
        'create_error' => __('admin/tags.messages.create_failed'),
        'attach_success' => __('admin/tags.messages.attached'),
        'attach_error' => __('admin/tags.messages.attach_failed'),
        'detach_success' => __('admin/tags.messages.detached'),
        'detach_error' => __('admin/tags.messages.detach_failed'),
        'body_update_success' => __('admin/tags.messages.body_updated'),
        'body_update_error' => __('admin/tags.messages.update_failed'),
        'tag_added' => __('admin/tags.forms.messages.tag_added'),
        'tag_removed' => __('admin/tags.forms.messages.tag_removed'),
        'tag_exists' => __('admin/tags.forms.messages.tag_exists'),
        'no_results' => __('admin/tags.forms.messages.no_results'),
    ];
@endphp

<div x-data="tagManager({
    tagableType: @js($tagableType),
    tagableId: @js($tagableId),
    uniqueId: @js($uniqueId),
    translationKey: @js($translationKey),
    readOnly: @js($readOnly),
})" class="space-y-4" id="{{ $uniqueId }}">
    @if($label)
        <label class="text-sm font-medium text-gray-700">
            {{ $label }}
            @if($required)
                <span class="text-red-500">*</span>
            @endif
        </label>
    @endif

    <!-- Search and Add Tag -->
    <div x-show="!readOnly" class="space-y-2">
        <div class="flex gap-2">
            <div class="flex-1 relative">
                <input type="text"
                       x-ref="searchInput"
                       x-model="searchQuery"
                       @input.debounce.500ms="searchTags()"
                       @keydown.enter.prevent="handleEnterKey()"
                       @input="if (searchQuery.length === 0) loadRecentTags()"
                       :placeholder="__('admin/tags.forms.placeholders.search')"
                       class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:outline-none focus:ring-2 focus:ring-blue-500 focus:border-transparent">
                
                <!-- Search Results Dropdown -->
                <div x-show="searchResults.length > 0"
                     x-transition
                     class="absolute z-10 w-full mt-1 bg-white border border-gray-300 rounded-lg shadow-lg max-h-60 overflow-y-auto">
                    <template x-for="tag in searchResults" :key="tag.id">
                        <button type="button"
                                @click="addTag(tag)"
                                class="w-full text-right px-4 py-2 hover:bg-gray-100 transition-colors"
                                :class="{ 'bg-gray-50': isTagSelected(tag.id) }">
                            <div class="flex items-center justify-between">
                                <span x-text="tag.title" class="font-medium"></span>
                                <span x-show="isTagSelected(tag.id)" class="text-xs text-blue-600">✓ انتخاب شده</span>
                            </div>
                        </button>
                    </template>
                </div>
            </div>
            <button type="button"
                    @click="createNewTag()"
                    x-show="searchQuery.length > 0 && !isTagInResults(searchQuery)"
                    class="px-4 py-2 bg-blue-600 text-white rounded-lg hover:bg-blue-700 transition-colors">
                {{ __('admin/tags.forms.buttons.create') }}
            </button>
        </div>
    </div>

    <!-- Selected Tags -->
    <div x-show="tags.length > 0" class="flex flex-wrap gap-2">
        <template x-for="(tag, index) in tags" :key="tag.id">
            <div class="group relative inline-flex items-center gap-2 px-3 py-1.5 bg-blue-50 border border-blue-200 rounded-lg">
                <span x-text="tag.title" class="text-sm font-medium text-blue-900"></span>
                
                <!-- Body Display (Read-Only) -->
                <span x-show="readOnly && tag.body" class="text-xs text-gray-600" x-text="'(' + tag.body + ')'"></span>
                
                <!-- Body Input (Optional) -->
                <div x-show="!readOnly" class="hidden group-hover:flex items-center gap-1">
                    <input type="text"
                           :value="tag.body || ''"
                           @blur="updateTagBody(tag.tagable_id, tag.id, $event.target.value)"
                           :placeholder="__('admin/tags.forms.placeholders.body')"
                           class="text-xs px-2 py-1 w-32 border border-blue-300 rounded focus:outline-none focus:ring-1 focus:ring-blue-500">
                </div>
                
                <!-- Remove Button -->
                <button type="button"
                        x-show="!readOnly"
                        @click="removeTag(tag.id, tag.tagable_id)"
                        class="text-blue-600 hover:text-red-600 transition-colors">
                    <x-icon name="x" size="xs" />
                </button>
            </div>
        </template>
    </div>

    <!-- Empty State -->
    <div x-show="tags.length === 0" class="text-center py-4 text-gray-500 text-sm">
        <span x-show="!readOnly">{{ __('admin/tags.forms.labels.no_tags') }}</span>
        <span x-show="readOnly">-</span>
    </div>

    <!-- Error Message -->
    @if($error)
        <span class="text-sm text-red-600">{{ $error }}</span>
    @endif

    <!-- Hidden Inputs for Form Submission -->
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
            loading: false,
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
                // Load existing tags if tagable entity exists
                if (this.tagableType && this.tagableId) {
                    this.loadTags();
                }
                
                // Load last 50 tags for initial display
                this.loadRecentTags();
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

            async loadRecentTags() {
                try {
                    const response = await window.axios.get('{{ route("admin.tags.search") }}', {
                        params: {
                            query: '',
                            limit: 50,
                        }
                    });

                    if (response.data && response.data.success !== false) {
                        this.searchResults = response.data.data || [];
                    }
                } catch (error) {
                    console.error('Failed to load recent tags:', error);
                }
            },

            async searchTags() {
                // Clear results if query is empty and load recent tags
                if (this.searchQuery.length === 0) {
                    await this.loadRecentTags();
                    return;
                }

                // Only search if query is at least 2 characters
                if (this.searchQuery.length < 2) {
                    this.searchResults = [];
                    return;
                }

                try {
                    const response = await window.axios.get('{{ route("admin.tags.search") }}', {
                        params: {
                            query: this.searchQuery,
                            limit: 20,
                        }
                    });

                    if (response.data && response.data.success !== false) {
                        this.searchResults = response.data.data || [];
                    }
                } catch (error) {
                    console.error('Search error:', error);
                    if (window.Toast) {
                        window.Toast.error(this.translations.search_error);
                    }
                }
            },

            isTagSelected(tagId) {
                return this.tags.some(t => t.id === tagId);
            },

            isTagInResults(query) {
                return this.searchResults.some(t => 
                    t.title.toLowerCase() === query.toLowerCase() || 
                    t.slug.toLowerCase() === query.toLowerCase()
                );
            },

            handleEnterKey() {
                if (this.searchQuery.length > 0) {
                    if (this.searchResults.length > 0) {
                        // Add first result
                        this.addTag(this.searchResults[0]);
                    } else {
                        // Create new tag
                        this.createNewTag();
                    }
                }
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
                        this.addTag(tag);
                        this.searchQuery = '';
                        this.searchResults = [];

                        if (window.Toast) {
                            window.Toast.success(this.translations.create_success);
                        }
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

            addTag(tag) {
                if (this.isTagSelected(tag.id)) {
                    if (window.Toast) {
                        window.Toast.warning(this.translations.tag_exists);
                    }
                    return;
                }

                this.tags.push({
                    id: tag.id,
                    tag_id: tag.id,
                    title: tag.title,
                    slug: tag.slug,
                    body: null,
                    tagable_id: null, // Will be set when attached
                });

                this.searchQuery = '';
                this.searchResults = [];

                if (window.Toast) {
                    window.Toast.success(this.translations.tag_added);
                }
            },

            removeTag(tagId, tagableId) {
                this.tags = this.tags.filter(t => t.id !== tagId);

                // If tagable exists, detach from server
                if (this.tagableType && this.tagableId) {
                    this.detachTag(tagId);
                }

                if (window.Toast) {
                    window.Toast.success(this.translations.tag_removed);
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

            async updateTagBody(tagableId, tagId, body) {
                if (!tagableId || !this.tagableType || !this.tagableId) return;

                try {
                    await window.axios.put(`{{ route("admin.tags.update-body", ":id") }}`.replace(':id', tagableId), {
                        tag_id: tagId,
                        body: body || null,
                    });
                } catch (error) {
                    console.error('Update body error:', error);
                }
            },

            // Method to attach tags to entity (call after entity is created)
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

                    // Update tagable_id and reload tags to get correct tagable_id from server
                    this.tagableType = tagableType;
                    this.tagableId = tagableId;
                    
                    // Reload tags to get correct tagable_id from server
                    await this.loadTags();

                    if (window.Toast) {
                        window.Toast.success(this.translations.attach_success);
                    }
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

