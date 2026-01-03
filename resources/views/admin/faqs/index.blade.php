<x-layouts.admin :title="__('admin/faqs.title')" :header-title="__('admin/faqs.title')" :breadcrumbs="[
        ['label' => __('admin/components.buttons.back'), 'url' => route('admin.dashboard')],
        ['label' => __('admin/faqs.title')]
    ]">
    <div>
        <div class="mb-4 flex flex-col sm:flex-row sm:items-center sm:justify-between gap-3">
            <div>
                <h2 class="text-lg font-semibold text-gray-900">{{ __('admin/faqs.management') }}</h2>
                <p class="text-xs text-gray-600 mt-0.5">{{ __('admin/faqs.description') }}</p>
            </div>
            <a href="{{ route('admin.faqs.create') }}">
                <x-button variant="primary" size="md">
                    {{ __('admin/faqs.add_new') }}
                </x-button>
            </a>
        </div>


        <x-session-messages />


        <x-card>
            <x-table-wrapper :search-placeholder="__('admin/components.buttons.search')"
                filter-sidebar-id="faqs-filters" :filter-badges="[
                'is_published' => __('admin/faqs.fields.is_published'),
            ]" :paginator="$faqs ?? null">
                <x-table>
                    <x-table.head>
                        <x-table.row>
                            <x-table.cell header sortable
                                sort-field="id">{{ __('admin/components.table.id') }}</x-table.cell>
                            <x-table.cell header sortable
                                sort-field="question">{{ __('admin/faqs.fields.question') }}</x-table.cell>
                            <x-table.cell header>{{ __('admin/faqs.fields.answer') }}</x-table.cell>
                            <x-table.cell header sortable
                                sort-field="is_published">{{ __('admin/faqs.fields.is_published') }}</x-table.cell>
                            <x-table.cell header sortable
                                sort-field="created_at">{{ __('admin/faqs.fields.created_at') }}</x-table.cell>
                            <x-table.cell header
                                class="text-end">{{ __('admin/components.table.actions') }}</x-table.cell>
                        </x-table.row>
                    </x-table.head>
                    <x-table.body>
                        @if(isset($faqs) && $faqs->count() > 0)
                            @foreach($faqs as $faq)
                                <x-table.row data-faq-id="{{ $faq->id }}">
                                    <x-table.cell>
                                        <span class="font-medium text-gray-900 line-clamp-2">{{ $faq->question }}</span>
                                    </x-table.cell>
                                    <x-table.cell>
                                        <span class="text-gray-600 text-sm line-clamp-2">{{ $faq->answer }}</span>
                                    </x-table.cell>
                                    <x-table.cell>
                                        @if($faq->is_published)
                                            <x-badge variant="success" size="sm">{{ __('admin/faqs.status.published') }}</x-badge>
                                        @else
                                            <x-badge variant="warning" size="sm">{{ __('admin/faqs.status.unpublished') }}</x-badge>
                                        @endif
                                    </x-table.cell>
                                    <x-table.cell><x-date :date="$faq->created_at" type="date" /></x-table.cell>
                                    <x-table.cell>
                                        <div class="flex items-center justify-end">
                                            <x-dropdown-menu align="end">
                                                <x-dropdown-item href="{{ route('admin.faqs.show', $faq->id) }}" icon="show">
                                                    {{ __('admin/components.buttons.view') }}
                                                </x-dropdown-item>
                                                <x-dropdown-item href="{{ route('admin.faqs.edit', $faq->id) }}" icon="edit">
                                                    {{ __('admin/components.buttons.edit') }}
                                                </x-dropdown-item>
                                                <div class="border-t border-gray-200 my-1"></div>
                                                <x-dropdown-item variant="danger" icon="trash" type="button"
                                                    @click.stop="window.deleteData = { id: {{ $faq->id }}, name: '{{ addslashes($faq->question) }}' }; $dispatch('open-modal', 'delete-faq-modal'); $el.closest('[x-data]').__x.$data.open = false;">
                                                    {{ __('admin/components.buttons.delete') }}
                                                </x-dropdown-item>
                                            </x-dropdown-menu>
                                        </div>
                                    </x-table.cell>
                                </x-table.row>
                            @endforeach
                        @else
                            <x-table.row>
                                <x-table.cell colspan="6" class="text-center py-8 text-gray-500">
                                    {{ __('admin/faqs.table.empty') }}
                                </x-table.cell>
                            </x-table.row>
                        @endif
                    </x-table.body>
                </x-table>
            </x-table-wrapper>


            <x-filter-sidebar id="faqs-filters" :title="__('admin/components.buttons.filter')" method="GET"
                action="{{ request()->url() }}">
                <div class="space-y-6">

                    <div>
                        <label
                            class="block text-sm font-medium text-gray-700 mb-2">{{ __('admin/faqs.fields.is_published') }}</label>
                        <x-select name="filter[is_published]" class="w-full"
                            :value="request()->query('filter.is_published')">
                            <option value="">{{ __('admin/components.status.all') }}</option>
                            <option value="1" {{ request()->query('filter.is_published') === '1' ? 'selected' : '' }}>
                                {{ __('admin/faqs.status.published') }}
                            </option>
                            <option value="0" {{ request()->query('filter.is_published') === '0' ? 'selected' : '' }}>
                                {{ __('admin/faqs.status.unpublished') }}
                            </option>
                        </x-select>
                    </div>
                </div>
            </x-filter-sidebar>
        </x-card>


        <x-delete-confirmation-modal id="delete-faq-modal" route-name="admin.faqs.destroy"
            row-selector="tr[data-faq-id='__ID__']" />
    </div>

</x-layouts.admin>