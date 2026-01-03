@props([
    'tagableType' => null,
    'tagableId' => null,
    'label' => null,
    'required' => false,
    'error' => null,
    'readOnly' => false,
])

@php
    // Use tag-manager prefix for backward compatibility with form-with-tags.js
    $uniqueId = 'tag-manager-' . uniqid();
@endphp

<div x-data="tagPicker()" x-init="initLoad()" class="space-y-2" id="{{ $uniqueId }}">
    @if($label)
        <label class="block text-sm font-medium text-gray-700 mb-2">
            {{ $label }}
            @if($required)
                <span class="text-red-500">*</span>
            @endif
        </label>
    @endif

    @if(!$readOnly)
        <div class="relative" @click.outside="closeDropdown()">
            <!-- Container for selected tags and input -->
            <div class="flex flex-wrap items-center gap-2 min-h-10 p-2 border border-gray-300 rounded-lg focus-within:ring-2 focus-within:ring-green-500 focus-within:border-transparent bg-white">

                <!-- Selected Tags -->
                <template x-for="(tag, index) in selectedTags" :key="tag.id || index">
                    <div class="inline-flex items-center gap-2 px-3 py-1.5 bg-green-50 border border-green-200 rounded-lg">
                        <span x-text="tag.title || tag.name || 'Unknown'" class="text-sm font-medium text-green-900"></span>
                        <button type="button" @click.stop="removeTag(tag)" class="text-green-600 hover:text-red-600 transition-colors focus:outline-none">
                            <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12"></path>
                            </svg>
                        </button>
                    </div>
                </template>

                <!-- Input -->
                <input type="text"
                       class="flex-1 min-w-32 px-2 py-1 border-none outline-none bg-transparent text-sm"
                       placeholder="{{ __('admin/tags.forms.placeholders.search') }}"
                       x-model="query"
                       @focus="handleFocus"
                       @input="handleInput"
                       @keydown.enter="handleEnter"
                       @keydown.backspace="handleBackspace"
                       x-ref="searchInput">
            </div>

            <!-- Dropdown -->
            <div x-show="isOpen"
                 x-cloak
                 x-transition:enter="transition ease-out duration-100"
                 x-transition:enter-start="opacity-0 scale-95"
                 x-transition:enter-end="opacity-100 scale-100"
                 x-transition:leave="transition ease-in duration-75"
                 x-transition:leave-start="opacity-100 scale-100"
                 x-transition:leave-end="opacity-0 scale-95"
                 class="absolute z-50 w-full mt-1 bg-white border border-gray-300 rounded-lg shadow-lg max-h-60 overflow-y-auto">

                <!-- Header -->
                <div class="px-4 py-2 text-sm font-semibold text-gray-700 border-b border-gray-200 bg-gray-50">
                    <span x-text="query.trim().length > 0 ? 'نتیجه جستجو' : 'برچسب‌های اخیر (۱۰۰ تا)'"></span>
                </div>

                <!-- Loading State -->
                <template x-if="loading">
                    <div class="px-4 py-3 text-sm text-gray-500 flex items-center gap-2">
                        <div class="w-4 h-4 border-2 border-gray-300 border-t-green-500 rounded-full animate-spin"></div>
                        در حال بارگذاری...
                    </div>
                </template>

                <!-- List of Tags -->
                <template x-if="!loading">
                    <template x-for="tag in tagsToShow" :key="tag.id">
                        <button type="button"
                                @click.stop="selectTag(tag)"
                                @mousedown.prevent
                                class="w-full text-right px-4 py-2 hover:bg-gray-100 transition-colors flex items-center justify-between border-b border-gray-100 last:border-b-0">
                            <span x-text="tag.title || tag.name" class="font-medium text-gray-900"></span>
                            <span class="text-xs text-gray-500">ID: <span x-text="tag.id"></span></span>
                        </button>
                    </template>

                    <!-- Create New Option -->
                    <template x-if="tagsToShow.length === 0 && query.trim().length > 0">
                        <button type="button"
                                @click.stop="createNewTag(query)"
                                @mousedown.prevent
                                class="w-full text-right px-4 py-2 hover:bg-gray-100 transition-colors text-green-600 border-t border-gray-200">
                            <span>ایجاد "<span x-text="query" class="font-semibold"></span>"</span>
                            <span class="text-xs text-gray-500 block">+ برچسب جدید</span>
                        </button>
                    </template>
                </template>
            </div>
        </div>
    @endif

    <div x-show="selectedTags.length === 0 && !readOnly" class="text-sm text-gray-500 py-2">
        {{ __('admin/tags.forms.labels.no_tags') }}
    </div>

    @if($error)
        <span class="text-sm text-red-600">{{ $error }}</span>
    @endif

    <!-- Hidden inputs for form submission -->
    <template x-for="tag in selectedTags" :key="tag.id">
        <input type="hidden" :name="'tags[]'" :value="tag.id">
    </template>
</div>

@push('scripts')

<script>
    function tagPicker() {
        return {
            query: '',
            selectedTags: [],
            latestTags: [], // Stores the top 100
            results: [],    // Stores search results
            isOpen: false,
            loading: false,
            debounceTimer: null,
            readOnly: {{ $readOnly ? 'true' : 'false' }},

            // For backward compatibility with form-with-tags.js
            get tags() {
                return this.selectedTags;
            },

            async initLoad() {
                // Load existing entity tags if tagableType/tagableId are provided
                @if($tagableType && $tagableId)
                try {
                    await this.loadTags('{{ $tagableType }}', {{ $tagableId }});
                } catch (error) {
                    console.error('Failed to initialize tags:', error);
                }
                @endif
            },

            async loadTags(tagableType, tagableId) {
                if (!tagableType || !tagableId) return;

                this.loading = true;
                try {
                    const response = await window.axios.get('{{ route("admin.tags.index") }}', {
                        params: {
                            tagable_type: tagableType,
                            tagable_id: parseInt(tagableId, 10),
                        }
                    });

                    if (response.data && response.data.success !== false && response.data.data) {
                        // Ensure we have an array and map to expected format
                        const tags = Array.isArray(response.data.data) ? response.data.data : [];
                        this.selectedTags = tags.map(tag => ({
                            id: tag.id || tag.tag_id,
                            title: tag.title || tag.name,
                            name: tag.title || tag.name,
                        }));
                    } else {
                        this.selectedTags = [];
                    }
                } catch (error) {
                    console.error('Failed to load entity tags:', error);
                    this.selectedTags = [];
                } finally {
                    this.loading = false;
                }
            },

            /**
             * COMPUTED PROPERTY (Getter)
             * Returns the correct list based on state.
             * If query is empty -> Show latestTags
             * If query has text -> Show results
             * Always filters out currently selected tags.
             */
            get tagsToShow() {
                let sourceList = [];

                if (this.query.trim().length === 0) {
                    sourceList = this.latestTags;
                } else {
                    sourceList = this.results;
                }

                // Filter out tags already selected to prevent duplicates in dropdown
                return sourceList.filter(tag =>
                    !this.selectedTags.some(selected => selected.id === tag.id)
                );
            },

            async handleFocus() {
                // Only load if we haven't loaded the latest list yet
                if (this.latestTags.length === 0) {
                    this.loading = true;
                    try {
                        const response = await window.axios.get('{{ route("admin.tags.search") }}', {
                            params: {
                                query: '',
                                limit: 100,
                            }
                        });

                        if (response.data && response.data.success !== false) {
                            this.latestTags = response.data.data || [];
                        }
                    } catch (error) {
                        console.error('Failed to load latest tags:', error);
                    } finally {
                        this.loading = false;
                    }
                }
                this.isOpen = true;
            },

            handleInput() {
                clearTimeout(this.debounceTimer);

                if (this.query.trim().length === 0) {
                    // If empty, results are cleared, tagsToShow reverts to latestTags
                    this.results = [];
                    return;
                }

                this.loading = true;

                // Debounce search
                this.debounceTimer = setTimeout(async () => {
                    try {
                        const response = await window.axios.get('{{ route("admin.tags.search") }}', {
                            params: {
                                query: this.query,
                                limit: 20,
                            }
                        });

                        if (response.data && response.data.success !== false) {
                            this.results = response.data.data || [];
                        }
                    } catch (error) {
                        console.error('Search error:', error);
                    } finally {
                        this.loading = false;
                    }
                }, 300);
            },

            selectTag(tag) {
                // Prevent duplicate selection
                if (this.selectedTags.some(t => t.id === tag.id)) {
                    return;
                }

                // Add to selected
                this.selectedTags = [...this.selectedTags, tag];

                // Cleanup Input
                this.query = '';
                this.results = []; // Reset search results
                
                // Keep dropdown open and refocus input for quick multi-selection
                this.$nextTick(() => {
                    if (this.$refs.searchInput) {
                        this.$refs.searchInput.focus();
                    }
                });
            },

            async createNewTag(name) {
                if(!name.trim()) return;

                this.loading = true;
                try {
                    const response = await window.axios.post('{{ route("admin.tags.store") }}', {
                        title: name.trim(),
                    });

                    if (response.data && response.data.success !== false) {
                        const tagData = response.data.data || response.data;
                        // Format tag to match expected structure
                        const newTag = {
                            id: tagData.id,
                            tag_id: tagData.id,
                            title: tagData.title || name.trim(),
                            name: tagData.title || name.trim(),
                        };
                        
                        // Prevent duplicate
                        if (!this.selectedTags.some(t => t.id === newTag.id)) {
                            this.selectedTags = [...this.selectedTags, newTag];
                        }
                        
                        this.query = '';
                        this.results = [];
                        this.isOpen = false;
                    }
                } catch (error) {
                    console.error('Create tag error:', error);
                } finally {
                    this.loading = false;
                }
            },

            removeTag(tagToRemove) {
                this.selectedTags = this.selectedTags.filter(t => t.id !== tagToRemove.id);

                // If we have tagable info, detach from database
                @if($tagableType && $tagableId)
                this.detachTag(tagToRemove.id);
                @endif
            },

            async detachTag(tagId) {
                try {
                    await window.axios.delete(`{{ route("admin.tags.detach", ":id") }}`.replace(':id', tagId), {
                        data: {
                            tagable_type: '{{ $tagableType }}',
                            tagable_id: '{{ $tagableId }}',
                        }
                    });
                } catch (error) {
                    console.error('Detach error:', error);
                }
            },

            // For backward compatibility with form-with-tags.js
            async attachTags(tagableType, tagableId) {
                // Ensure tagableId is an integer
                const finalTagableId = parseInt(tagableId, 10);
                
                if (!finalTagableId || isNaN(finalTagableId)) {
                    throw new Error('Invalid tagable ID');
                }

                // Map selected tags to the format expected by the API
                const tagData = this.selectedTags.map(t => ({
                    tag_id: parseInt(t.id || t.tag_id, 10),
                }));

                try {
                    const response = await window.axios.post('{{ route("admin.tags.attach") }}', {
                        tagable_type: tagableType,
                        tagable_id: finalTagableId,
                        tags: tagData,
                    });

                    // Update stored tagable info
                    this.tagableType = tagableType;
                    this.tagableId = finalTagableId;

                    // Reload tags to get fresh data from server (sync with database)
                    await this.loadTags(tagableType, finalTagableId);

                    return response;
                } catch (error) {
                    console.error('Failed to attach tags:', error);
                    throw error;
                }
            },

            handleEnter() {
                const trimmed = this.query.trim();
                if (!trimmed) return;

                // Check if text matches a displayed tag
                const match = this.tagsToShow.find(t =>
                    (t.title || t.name).toLowerCase() === trimmed.toLowerCase()
                );

                if (match) {
                    this.selectTag(match);
                } else {
                    this.createNewTag(trimmed);
                }
            },

            handleBackspace() {
                if (this.query === '' && this.selectedTags.length > 0) {
                    const lastTag = this.selectedTags[this.selectedTags.length - 1];
                    this.removeTag(lastTag);
                }
            },

            closeDropdown() {
                // Only close if input is not focused
                if (!this.$refs.searchInput || document.activeElement !== this.$refs.searchInput) {
                    this.isOpen = false;
                    // Don't clear query on close to allow user to continue typing
                }
            }
        }
    }
</script>
@endpush
