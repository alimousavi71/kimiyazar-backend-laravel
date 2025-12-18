<x-layouts.admin :title="$modal->title" :header-title="__('admin/modals.show.header_title')" :breadcrumbs="[
        ['label' => __('admin/modals.forms.breadcrumbs.dashboard'), 'url' => route('admin.dashboard')],
        ['label' => __('admin/modals.forms.breadcrumbs.modals'), 'url' => route('admin.modals.index')],
        ['label' => $modal->title]
    ]">
    <div class="mb-4 flex flex-col sm:flex-row sm:items-center sm:justify-between gap-3">
        <div>
            <h2 class="text-lg font-semibold text-gray-900">{{ $modal->title }}</h2>
            <p class="text-xs text-gray-600 mt-0.5">{{ __('admin/modals.show.viewing_modal') }}</p>
        </div>
        <div class="flex gap-2">
            <a href="{{ route('admin.modals.edit', $modal->id) }}">
                <x-button variant="secondary" size="md">
                    {{ __('admin/components.buttons.edit') }}
                </x-button>
            </a>
            <a href="{{ route('admin.modals.index') }}">
                <x-button variant="primary" size="md">
                    {{ __('admin/components.buttons.back') }}
                </x-button>
            </a>
        </div>
    </div>

    <!-- Success/Error Messages -->
    <x-session-messages />

    <div class="grid grid-cols-1 lg:grid-cols-3 gap-6">
        <!-- Main Content -->
        <div class="lg:col-span-2 space-y-6">
            <!-- Modal Information -->
            <x-card>
                <x-slot name="title">{{ __('admin/modals.show.information') }}</x-slot>

                <div class="space-y-6">
                    <!-- Title -->
                    <div class="grid grid-cols-3 gap-4 pb-4 border-b border-gray-200">
                        <div>
                            <label class="text-sm font-medium text-gray-700">{{ __('admin/modals.fields.title') }}</label>
                            <p class="mt-1 text-sm text-gray-900">{{ $modal->title }}</p>
                        </div>
                        <div>
                            <label class="text-sm font-medium text-gray-700">{{ __('admin/modals.fields.priority') }}</label>
                            <p class="mt-1 text-sm">
                                <span class="inline-flex items-center px-2.5 py-0.5 rounded-full text-xs font-medium bg-blue-100 text-blue-800">
                                    {{ $modal->priority }}
                                </span>
                            </p>
                        </div>
                        <div>
                            <label class="text-sm font-medium text-gray-700">{{ __('admin/modals.fields.is_published') }}</label>
                            <p class="mt-1 text-sm">
                                @if($modal->is_published)
                                    <x-badge variant="success" size="sm">{{ __('admin/modals.status.active') }}</x-badge>
                                @else
                                    <x-badge variant="danger" size="sm">{{ __('admin/modals.status.inactive') }}</x-badge>
                                @endif
                            </p>
                        </div>
                    </div>

                    <!-- Content -->
                    <div class="pb-4 border-b border-gray-200">
                        <label class="text-sm font-medium text-gray-700">{{ __('admin/modals.fields.content') }}</label>
                        <div class="mt-2 prose prose-sm max-w-none text-gray-900">
                            {!! nl2br(e($modal->content)) !!}
                        </div>
                    </div>

                    <!-- Button Information -->
                    <div class="grid grid-cols-1 md:grid-cols-2 gap-4 pb-4 border-b border-gray-200">
                        <div>
                            <label class="text-sm font-medium text-gray-700">{{ __('admin/modals.fields.button_text') }}</label>
                            <p class="mt-1 text-sm text-gray-900">{{ $modal->button_text ?? '-' }}</p>
                        </div>
                        <div>
                            <label class="text-sm font-medium text-gray-700">{{ __('admin/modals.fields.button_url') }}</label>
                            <p class="mt-1 text-sm">
                                @if($modal->button_url)
                                    <a href="{{ $modal->button_url }}" target="_blank" class="text-blue-600 hover:text-blue-800 break-all">
                                        {{ $modal->button_url }}
                                    </a>
                                @else
                                    <span class="text-gray-500">-</span>
                                @endif
                            </p>
                        </div>
                    </div>

                    <!-- Close Button Text -->
                    <div class="pb-4 border-b border-gray-200">
                        <label class="text-sm font-medium text-gray-700">{{ __('admin/modals.fields.close_text') }}</label>
                        <p class="mt-1 text-sm text-gray-900">{{ $modal->close_text }}</p>
                    </div>

                    <!-- Rememberable Checkbox -->
                    <div>
                        <label class="text-sm font-medium text-gray-700">{{ __('admin/modals.fields.is_rememberable') }}</label>
                        <p class="mt-1 text-sm">
                            @if($modal->is_rememberable)
                                <span class="inline-flex items-center px-2.5 py-0.5 rounded-full text-xs font-medium bg-green-100 text-green-800">
                                    {{ __('admin/modals.status.enabled') }}
                                </span>
                            @else
                                <span class="inline-flex items-center px-2.5 py-0.5 rounded-full text-xs font-medium bg-gray-100 text-gray-800">
                                    {{ __('admin/modals.status.disabled') }}
                                </span>
                            @endif
                        </p>
                    </div>
                </div>
            </x-card>

            <!-- Scheduling -->
            <x-card>
                <x-slot name="title">{{ __('admin/modals.show.scheduling') }}</x-slot>

                <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                    <div>
                        <label class="text-sm font-medium text-gray-700">{{ __('admin/modals.fields.start_at') }}</label>
                        <p class="mt-1 text-sm text-gray-900">
                            {{ $modal->start_at?->format('Y-m-d H:i:s') ?? __('admin/components.status.not_set') }}
                        </p>
                    </div>
                    <div>
                        <label class="text-sm font-medium text-gray-700">{{ __('admin/modals.fields.end_at') }}</label>
                        <p class="mt-1 text-sm text-gray-900">
                            {{ $modal->end_at?->format('Y-m-d H:i:s') ?? __('admin/components.status.not_set') }}
                        </p>
                    </div>
                </div>
            </x-card>

            <!-- Polymorphic Relationship -->
            @if($modal->modalable_type || $modal->modalable_id)
                <x-card>
                    <x-slot name="title">{{ __('admin/modals.show.association') }}</x-slot>

                    <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                        <div>
                            <label class="text-sm font-medium text-gray-700">{{ __('admin/modals.fields.modalable_type') }}</label>
                            <p class="mt-1 text-sm text-gray-900 font-mono text-xs bg-gray-50 p-2 rounded">
                                {{ $modal->modalable_type ?? '-' }}
                            </p>
                        </div>
                        <div>
                            <label class="text-sm font-medium text-gray-700">{{ __('admin/modals.fields.modalable_id') }}</label>
                            <p class="mt-1 text-sm text-gray-900">
                                {{ $modal->modalable_id ?? '-' }}
                            </p>
                        </div>
                    </div>
                </x-card>
            @endif
        </div>

        <!-- Sidebar -->
        <div class="space-y-6">
            <!-- Metadata Card -->
            <x-card>
                <x-slot name="title">{{ __('admin/modals.show.metadata') }}</x-slot>

                <div class="space-y-4">
                    <div>
                        <label class="text-sm font-medium text-gray-700">{{ __('admin/modals.fields.id') }}</label>
                        <p class="mt-1 text-sm font-mono text-gray-900">{{ $modal->id }}</p>
                    </div>

                    <div class="border-t border-gray-200 pt-4">
                        <label class="text-sm font-medium text-gray-700">{{ __('admin/modals.fields.created_at') }}</label>
                        <p class="mt-1 text-sm text-gray-900">{{ $modal->created_at->format('Y-m-d H:i:s') }}</p>
                    </div>

                    @if($modal->updated_at)
                        <div class="border-t border-gray-200 pt-4">
                            <label class="text-sm font-medium text-gray-700">{{ __('admin/modals.fields.updated_at') }}</label>
                            <p class="mt-1 text-sm text-gray-900">{{ $modal->updated_at->format('Y-m-d H:i:s') }}</p>
                        </div>
                    @endif
                </div>
            </x-card>

            <!-- Actions -->
            <x-card>
                <x-slot name="title">{{ __('admin/components.table.actions') }}</x-slot>

                <div class="space-y-2">
                    <a href="{{ route('admin.modals.edit', $modal->id) }}" class="block">
                        <x-button variant="primary" type="button" class="w-full">
                            {{ __('admin/components.buttons.edit') }}
                        </x-button>
                    </a>
                    <button type="button" @click.stop="window.deleteData = { id: {{ $modal->id }}, name: '{{ addslashes($modal->title) }}' }; $dispatch('open-modal', 'delete-modal-modal');" class="w-full">
                        <x-button variant="danger" type="button" class="w-full">
                            {{ __('admin/components.buttons.delete') }}
                        </x-button>
                    </button>
                </div>
            </x-card>
        </div>
    </div>

    <!-- Delete Confirmation Modal -->
    <x-delete-confirmation-modal id="delete-modal-modal" route-name="admin.modals.destroy"
        :item-id="$modal->id" />

</x-layouts.admin>
