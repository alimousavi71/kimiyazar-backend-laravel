<x-layouts.admin :title="__('admin/contacts.title')" :header-title="__('admin/contacts.title')" :breadcrumbs="[
        ['label' => __('admin/components.buttons.back'), 'url' => route('admin.dashboard')],
        ['label' => __('admin/contacts.title')]
    ]">
    <div>
        <div class="mb-4 flex flex-col sm:flex-row sm:items-center sm:justify-between gap-3">
            <div>
                <h2 class="text-lg font-semibold text-gray-900">{{ __('admin/contacts.management') }}</h2>
                <p class="text-xs text-gray-600 mt-0.5">{{ __('admin/contacts.description') }}</p>
            </div>
        </div>


        <x-session-messages />


        <x-card>
            <x-table-wrapper :search-placeholder="__('admin/components.buttons.search')"
                filter-sidebar-id="contacts-filters" :filter-badges="[
                'is_read' => __('admin/contacts.fields.is_read'),
            ]" :paginator="$contacts ?? null">
                <x-table>
                    <x-table.head>
                        <x-table.row>
                            <x-table.cell header sortable
                                sort-field="id">{{ __('admin/components.table.id') }}</x-table.cell>
                            <x-table.cell header sortable
                                sort-field="title">{{ __('admin/contacts.fields.title') }}</x-table.cell>
                            <x-table.cell header sortable
                                sort-field="email">{{ __('admin/contacts.fields.email') }}</x-table.cell>
                            <x-table.cell header sortable
                                sort-field="mobile">{{ __('admin/contacts.fields.mobile') }}</x-table.cell>
                            <x-table.cell header sortable
                                sort-field="is_read">{{ __('admin/contacts.fields.is_read') }}</x-table.cell>
                            <x-table.cell header sortable
                                sort-field="created_at">{{ __('admin/contacts.fields.created_at') }}</x-table.cell>
                            <x-table.cell header
                                class="text-end">{{ __('admin/components.table.actions') }}</x-table.cell>
                        </x-table.row>
                    </x-table.head>
                    <x-table.body>
                        @if(isset($contacts) && $contacts->count() > 0)
                            @foreach($contacts as $contact)
                                <x-table.row data-contact-id="{{ $contact->id }}">
                                    <x-table.cell>
                                        <span class="text-gray-600">{{ $contact->id }}</span>
                                    </x-table.cell>
                                    <x-table.cell>
                                        <span
                                            class="font-medium text-gray-900">{{ $contact->title ?: __('admin/contacts.no_title') }}</span>
                                    </x-table.cell>
                                    <x-table.cell>
                                        <span class="text-gray-700">{{ $contact->email ?: '-' }}</span>
                                    </x-table.cell>
                                    <x-table.cell>
                                        <span class="text-gray-700">{{ $contact->mobile ?: '-' }}</span>
                                    </x-table.cell>
                                    <x-table.cell>
                                        @if($contact->is_read)
                                            <x-badge variant="success" size="sm">{{ __('admin/contacts.status.read') }}</x-badge>
                                        @else
                                            <x-badge variant="warning" size="sm">{{ __('admin/contacts.status.unread') }}</x-badge>
                                        @endif
                                    </x-table.cell>
                                    <x-table.cell><x-date :date="$contact->created_at" type="datetime" /></x-table.cell>
                                    <x-table.cell>
                                        <div class="flex items-center justify-end">
                                            <x-dropdown-menu align="end">
                                                <x-dropdown-item href="{{ route('admin.contacts.show', $contact->id) }}"
                                                    icon="show">
                                                    {{ __('admin/components.buttons.view') }}
                                                </x-dropdown-item>
                                            </x-dropdown-menu>
                                        </div>
                                    </x-table.cell>
                                </x-table.row>
                            @endforeach
                        @else
                            <x-table.row>
                                <x-table.cell colspan="7" class="text-center py-8 text-gray-500">
                                    {{ __('admin/components.table.no_results') }}
                                </x-table.cell>
                            </x-table.row>
                        @endif
                    </x-table.body>
                </x-table>
            </x-table-wrapper>


            <x-filter-sidebar id="contacts-filters" :title="__('admin/components.buttons.filter')" method="GET"
                action="{{ request()->url() }}">
                <div class="space-y-6">

                    <div>
                        <label
                            class="block text-sm font-medium text-gray-700 mb-2">{{ __('admin/contacts.fields.is_read') }}</label>
                        <x-select name="filter[is_read]" class="w-full" :value="request()->query('filter.is_read')">
                            <option value="">{{ __('admin/components.status.all') }}</option>
                            <option value="1" {{ request()->query('filter.is_read') === '1' ? 'selected' : '' }}>
                                {{ __('admin/contacts.status.read') }}
                            </option>
                            <option value="0" {{ request()->query('filter.is_read') === '0' ? 'selected' : '' }}>
                                {{ __('admin/contacts.status.unread') }}
                            </option>
                        </x-select>
                    </div>
                </div>
            </x-filter-sidebar>
        </x-card>
    </div>

</x-layouts.admin>