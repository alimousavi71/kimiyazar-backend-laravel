<x-layouts.admin :title="__('admin/menus.forms.edit.title')" :header-title="__('admin/menus.forms.edit.header_title')"
    :breadcrumbs="[
        ['label' => __('admin/menus.forms.breadcrumbs.dashboard'), 'url' => route('admin.dashboard')],
        ['label' => __('admin/menus.forms.breadcrumbs.menus'), 'url' => route('admin.menus.index')],
        ['label' => __('admin/menus.forms.breadcrumbs.edit')]
    ]">
    <div class="mb-4">
        <h2 class="text-lg font-semibold text-gray-900">{{ __('admin/menus.forms.edit.title') }}</h2>
        <p class="text-xs text-gray-600 mt-0.5">{{ __('admin/menus.forms.edit.description') }}</p>
    </div>

    <div x-data="menuLinkManager({{ json_encode($menu->links ?? []) }}, {{ $menu->id }})" class="space-y-6">
        <!-- Menu Name Form -->
        <x-card>
            <x-slot name="title">{{ __('admin/menus.forms.edit.menu_info') }}</x-slot>

            <form id="menu-edit-form" action="{{ route('admin.menus.update', $menu->id) }}" method="POST"
                class="space-y-6">
                @csrf
                @method('PATCH')

                <x-input
                    name="name"
                    :label="__('admin/menus.fields.name')"
                    :placeholder="__('admin/menus.forms.placeholders.name')"
                    :value="old('name', $menu->name)"
                    required
                    :error="$errors->first('name')"
                    class="w-full"
                />

                <x-select
                    name="type"
                    :label="__('admin/menus.fields.type')"
                    required
                    :error="$errors->first('type')"
                    class="w-full"
                >
                    <option value="">{{ __('admin/components.form.select_option') }}</option>
                    <option value="quick_access" @selected(old('type', $menu->type) === 'quick_access')>
                        {{ __('admin/menus.types.quick_access') }}
                    </option>
                    <option value="services" @selected(old('type', $menu->type) === 'services')>
                        {{ __('admin/menus.types.services') }}
                    </option>
                    <option value="custom" @selected(old('type', $menu->type) === 'custom')>
                        {{ __('admin/menus.types.custom') }}
                    </option>
                </x-select>

                <div class="flex items-center justify-end gap-3 pt-4 border-t border-gray-200">
                    <a href="{{ route('admin.menus.index') }}">
                        <x-button variant="secondary" size="md" type="button">
                            {{ __('admin/components.buttons.cancel') }}
                        </x-button>
                    </a>
                    <x-button variant="primary" size="md" type="submit">
                        {{ __('admin/components.buttons.save') }}
                    </x-button>
                </div>
            </form>
        </x-card>

        <!-- Menu Links Manager -->
        <x-card>
            <x-slot name="title">{{ __('admin/menus.forms.edit.links_manager') }}</x-slot>

            <div class="space-y-6">
                <!-- Add New Link Button -->
                <div class="flex justify-end">
                    <x-button variant="primary" size="md" type="button" @click="showAddLinkModal = true">
                        {{ __('admin/menus.buttons.add_link') }}
                    </x-button>
                </div>

                <!-- Links List (Sortable) -->
                <div class="space-y-2" x-ref="linksList">
                    <template x-if="links.length === 0">
                        <div class="text-center py-8 text-gray-500">
                            {{ __('admin/menus.messages.no_links') }}
                        </div>
                    </template>

                    <template x-for="(link, index) in links" :key="link.id">
                        <div class="flex items-center gap-3 p-4 bg-gray-50 rounded-lg border border-gray-200 cursor-move hover:bg-gray-100 transition-colors"
                            draggable="true" @dragstart="dragStart($event, index)"
                            @dragover.prevent="dragOver($event, index)" @drop="drop($event, index)"
                            @dragend="dragEnd()">
                            <!-- Drag Handle -->
                            <div class="text-gray-400 hover:text-gray-600">
                                <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                        d="M4 6h16M4 12h16M4 18h16"></path>
                                </svg>
                            </div>

                            <!-- Link Info -->
                            <div class="flex-1">
                                <div class="font-medium text-gray-900" x-text="link.title"></div>
                                <div class="text-sm text-gray-500" x-text="link.url"></div>
                                <div class="text-xs text-gray-400 mt-1">
                                    <span
                                        x-text="link.type === 'content' ? '{{ __('admin/menus.link_types.content') }}' : '{{ __('admin/menus.link_types.custom') }}'"></span>
                                    <span x-show="link.order"> • {{ __('admin/menus.fields.order') }}: <span
                                            x-text="link.order"></span></span>
                                </div>
                            </div>

                            <!-- Actions -->
                            <div class="flex items-center gap-2">
                                <x-button variant="secondary" size="sm" type="button" @click="editLink(index)">
                                    {{ __('admin/components.buttons.edit') }}
                                </x-button>
                                <x-button variant="danger" size="sm" type="button" @click="removeLink(index)">
                                    {{ __('admin/components.buttons.delete') }}
                                </x-button>
                            </div>
                        </div>
                    </template>
                </div>

                <!-- Save Links Button -->
                <div class="flex justify-end pt-4 border-t border-gray-200">
                    <x-button variant="primary" size="md" type="button" @click="saveLinks()" x-bind:disabled="saving">
                        <span x-show="!saving">{{ __('admin/components.buttons.save_links') }}</span>
                        <span x-show="saving">{{ __('admin/components.buttons.saving') }}...</span>
                    </x-button>
                </div>
            </div>
        </x-card>

        <!-- Add/Edit Link Modal -->
        <div x-show="showAddLinkModal" x-cloak
            class="fixed inset-0 bg-black bg-opacity-50 flex items-center justify-center z-50"
            @click.self="closeModal()">
            <div class="bg-white rounded-lg shadow-xl p-6 w-full max-w-md mx-4" @click.stop>
                <h3 class="text-lg font-semibold text-gray-900 mb-4"
                    x-text="editingLinkIndex !== null ? '{{ __('admin/menus.modal.edit_link') }}' : '{{ __('admin/menus.modal.add_link') }}'">
                </h3>

                <form @submit.prevent="addOrUpdateLink()" class="space-y-4">
                    <!-- Link Type -->
                    <div>
                        <label class="block text-sm font-medium text-gray-700 mb-2">
                            {{ __('admin/menus.fields.link_type') }}
                        </label>
                        <select x-model="currentLink.type" @change="onLinkTypeChange()"
                            class="w-full rounded-md border-gray-300">
                            <option value="custom">{{ __('admin/menus.link_types.custom') }}</option>
                            <option value="content">{{ __('admin/menus.link_types.content') }}</option>
                        </select>
                    </div>

                    <!-- Content Selection (if type is content) -->
                    <div x-show="currentLink.type === 'content'">
                        <label class="block text-sm font-medium text-gray-700 mb-2">
                            {{ __('admin/menus.fields.select_content') }}
                        </label>
                        <select x-model="currentLink.content_id" @change="onContentSelected()"
                            class="w-full rounded-md border-gray-300">
                            <option value="">{{ __('admin/menus.forms.placeholders.select_content') }}</option>
                            @foreach($contents as $content)
                                <option value="{{ $content->id }}"
                                    data-url="/{{ $content->type->value }}/{{ $content->slug }}">
                                    {{ $content->title }}
                                </option>
                            @endforeach
                        </select>
                    </div>

                    <!-- Title -->
                    <div>
                        <label class="block text-sm font-medium text-gray-700 mb-2">
                            {{ __('admin/menus.fields.title') }} <span class="text-red-500">*</span>
                        </label>
                        <input type="text" x-model="currentLink.title" required
                            class="w-full rounded-md border-gray-300"
                            :placeholder="'{{ __('admin/menus.forms.placeholders.link_title') }}'">
                    </div>

                    <!-- URL (if type is custom) -->
                    <div x-show="currentLink.type === 'custom'">
                        <label class="block text-sm font-medium text-gray-700 mb-2">
                            {{ __('admin/menus.fields.url') }} <span class="text-red-500">*</span>
                        </label>
                        <input type="text" x-model="currentLink.url" required class="w-full rounded-md border-gray-300"
                            placeholder="/example-page">
                    </div>

                    <!-- Actions -->
                    <div class="flex justify-end gap-3 pt-4 border-t border-gray-200">
                        <x-button variant="secondary" size="md" type="button" @click="closeModal()">
                            {{ __('admin/components.buttons.cancel') }}
                        </x-button>
                        <x-button variant="primary" size="md" type="submit">
                            {{ __('admin/components.buttons.save') }}
                        </x-button>
                    </div>
                </form>
            </div>
        </div>
    </div>

    @push('scripts')
        <script>
            function menuLinkManager(initialLinks, menuId) {
                return {
                    links: initialLinks.map((link, index) => ({
                        ...link,
                        order: link.order || (index + 1)
                    })),
                    menuId: menuId,
                    showAddLinkModal: false,
                    editingLinkIndex: null,
                    saving: false,
                    draggedIndex: null,
                    currentLink: {
                        id: null,
                        title: '',
                        url: '#',
                        type: 'custom',
                        content_id: null,
                        order: 1
                    },

                    init() {
                        // Sort links by order
                        this.links.sort((a, b) => (a.order || 0) - (b.order || 0));
                    },

                    addOrUpdateLink() {
                        if (!this.currentLink.title) return;

                        // Generate ID for new links
                        if (!this.currentLink.id) {
                            this.currentLink.id = 'link_' + Date.now();
                        }

                        // Update order if new link
                        if (this.editingLinkIndex === null) {
                            this.currentLink.order = this.links.length + 1;
                        }

                        if (this.editingLinkIndex !== null) {
                            // Update existing link
                            this.links[this.editingLinkIndex] = { ...this.currentLink };
                        } else {
                            // Add new link
                            this.links.push({ ...this.currentLink });
                        }

                        this.closeModal();
                    },

                    editLink(index) {
                        this.currentLink = { ...this.links[index] };
                        this.editingLinkIndex = index;
                        this.showAddLinkModal = true;
                    },

                    removeLink(index) {
                        if (confirm('{{ __('admin/menus.messages.confirm_delete_link') }}')) {
                            this.links.splice(index, 1);
                            // Reorder remaining links
                            this.links.forEach((link, idx) => {
                                link.order = idx + 1;
                            });
                        }
                    },

                    onLinkTypeChange() {
                        if (this.currentLink.type === 'content') {
                            this.currentLink.url = '#';
                        }
                    },

                    onContentSelected() {
                        const select = event.target;
                        const selectedOption = select.options[select.selectedIndex];
                        if (selectedOption && selectedOption.dataset.url) {
                            this.currentLink.url = selectedOption.dataset.url;
                            if (!this.currentLink.title) {
                                this.currentLink.title = selectedOption.text;
                            }
                        }
                    },

                    closeModal() {
                        this.showAddLinkModal = false;
                        this.editingLinkIndex = null;
                        this.currentLink = {
                            id: null,
                            title: '',
                            url: '#',
                            type: 'custom',
                            content_id: null,
                            order: 1
                        };
                    },

                    dragStart(event, index) {
                        this.draggedIndex = index;
                        event.dataTransfer.effectAllowed = 'move';
                        event.target.style.opacity = '0.5';
                    },

                    dragOver(event, index) {
                        event.preventDefault();
                        if (this.draggedIndex === null || this.draggedIndex === index) return;

                        const items = Array.from(event.currentTarget.parentElement.children);
                        const draggedItem = items[this.draggedIndex];
                        const targetItem = items[index];

                        if (this.draggedIndex < index) {
                            targetItem.parentNode.insertBefore(draggedItem, targetItem.nextSibling);
                        } else {
                            targetItem.parentNode.insertBefore(draggedItem, targetItem);
                        }

                        // Update array
                        const temp = this.links[this.draggedIndex];
                        this.links.splice(this.draggedIndex, 1);
                        this.links.splice(index, 0, temp);
                        this.draggedIndex = index;
                    },

                    drop(event, index) {
                        event.preventDefault();
                    },

                    dragEnd(event) {
                        event.target.style.opacity = '1';
                        // Update orders
                        this.links.forEach((link, idx) => {
                            link.order = idx + 1;
                        });
                        this.draggedIndex = null;
                    },

                    async saveLinks() {
                        this.saving = true;
                        try {
                            const response = await window.axios.post(
                                `{{ route('admin.menus.links.update', $menu->id) }}`,
                                { links: this.links }
                            );

                            if (response.data && response.data.success !== false) {
                                if (window.Toast) {
                                    window.Toast.success('{{ __('admin/menus.messages.links_saved') }}');
                                }
                            }
                        } catch (error) {
                            console.error('Save links error:', error);
                            if (window.Toast) {
                                window.Toast.error('{{ __('admin/menus.messages.save_failed') }}');
                            }
                        } finally {
                            this.saving = false;
                        }
                    }
                };
            }
        </script>
    @endpush
</x-layouts.admin>