<x-layouts.admin :title="__('admin/price-inquiries.title')" :header-title="__('admin/price-inquiries.title')"
    :breadcrumbs="[
        ['label' => __('admin/components.buttons.back'), 'url' => route('admin.dashboard')],
        ['label' => __('admin/price-inquiries.title')]
    ]">
    <div>
        <div class="mb-4 flex flex-col sm:flex-row sm:items-center sm:justify-between gap-3">
            <div>
                <h2 class="text-lg font-semibold text-gray-900">{{ __('admin/price-inquiries.management') }}</h2>
                <p class="text-xs text-gray-600 mt-0.5">{{ __('admin/price-inquiries.description') }}</p>
            </div>
        </div>


        <x-session-messages />


        <x-card>
            <x-table-wrapper :search-placeholder="__('admin/components.buttons.search')"
                filter-sidebar-id="price-inquiries-filters" :filter-badges="[
                'is_reviewed' => __('admin/price-inquiries.fields.is_reviewed'),
            ]" :paginator="$priceInquiries ?? null">
                <x-table>
                    <x-table.head>
                        <x-table.row>
                            <x-table.cell header sortable
                                sort-field="id">{{ __('admin/components.table.id') }}</x-table.cell>
                            <x-table.cell header sortable
                                sort-field="first_name">{{ __('admin/price-inquiries.fields.full_name') }}</x-table.cell>
                            <x-table.cell header sortable
                                sort-field="email">{{ __('admin/price-inquiries.fields.email') }}</x-table.cell>
                            <x-table.cell header
                                sortable="phone_number">{{ __('admin/price-inquiries.fields.phone_number') }}</x-table.cell>
                            <x-table.cell header>{{ __('admin/price-inquiries.fields.products_count') }}</x-table.cell>
                            <x-table.cell header sortable
                                sort-field="is_reviewed">{{ __('admin/price-inquiries.fields.is_reviewed') }}</x-table.cell>
                            <x-table.cell header sortable
                                sort-field="created_at">{{ __('admin/price-inquiries.fields.created_at') }}</x-table.cell>
                            <x-table.cell header
                                class="text-end">{{ __('admin/components.table.actions') }}</x-table.cell>
                        </x-table.row>
                    </x-table.head>
                    <x-table.body>
                        @if(isset($priceInquiries) && $priceInquiries->count() > 0)
                            @foreach($priceInquiries as $priceInquiry)
                                <x-table.row>
                                    <x-table.cell>
                                        <span class="text-gray-600">{{ $priceInquiry->id }}</span>
                                    </x-table.cell>
                                    <x-table.cell>
                                        <span class="font-medium text-gray-900">{{ $priceInquiry->full_name }}</span>
                                        @if($priceInquiry->user)
                                            <span
                                                class="text-xs text-gray-500">({{ __('admin/price-inquiries.labels.registered_user') }})</span>
                                        @endif
                                    </x-table.cell>
                                    <x-table.cell>
                                        <a href="mailto:{{ $priceInquiry->email }}"
                                            class="text-blue-600 hover:text-blue-700">{{ $priceInquiry->email }}</a>
                                    </x-table.cell>
                                    <x-table.cell>
                                        <a href="tel:{{ $priceInquiry->phone_number }}"
                                            class="text-blue-600 hover:text-blue-700">{{ $priceInquiry->phone_number }}</a>
                                    </x-table.cell>
                                    <x-table.cell>
                                        @php
                                            $productCount = is_array($priceInquiry->products ?? [])
                                                ? count(array_filter(array_map('intval', $priceInquiry->products)))
                                                : 0;
                                        @endphp
                                        <span class="text-gray-700">{{ $productCount }}</span>
                                    </x-table.cell>
                                    <x-table.cell>
                                        @if($priceInquiry->is_reviewed)
                                            <x-badge variant="success"
                                                size="sm">{{ __('admin/price-inquiries.status.reviewed') }}</x-badge>
                                        @else
                                            <x-badge variant="warning"
                                                size="sm">{{ __('admin/price-inquiries.status.pending') }}</x-badge>
                                        @endif
                                    </x-table.cell>
                                    <x-table.cell><x-date :date="$priceInquiry->created_at" type="datetime" /></x-table.cell>
                                    <x-table.cell>
                                        <div class="flex items-center justify-end">
                                            <x-dropdown-menu align="end">
                                                <x-dropdown-item
                                                    href="{{ route('admin.price-inquiries.show', $priceInquiry->id) }}"
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
                                <x-table.cell colspan="8" class="text-center py-8 text-gray-500">
                                    {{ __('admin/components.table.no_results') }}
                                </x-table.cell>
                            </x-table.row>
                        @endif
                    </x-table.body>
                </x-table>
            </x-table-wrapper>


            <x-filter-sidebar id="price-inquiries-filters" :title="__('admin/components.buttons.filter')" method="GET"
                action="{{ request()->url() }}">
                <div class="space-y-6">

                    <div>
                        <label
                            class="block text-sm font-medium text-gray-700 mb-2">{{ __('admin/price-inquiries.fields.is_reviewed') }}</label>
                        <x-select name="filter[is_reviewed]" class="w-full"
                            :value="request()->query('filter.is_reviewed')">
                            <option value="">{{ __('admin/components.status.all') }}</option>
                            <option value="1" {{ request()->query('filter.is_reviewed') === '1' ? 'selected' : '' }}>
                                {{ __('admin/price-inquiries.status.reviewed') }}
                            </option>
                            <option value="0" {{ request()->query('filter.is_reviewed') === '0' ? 'selected' : '' }}>
                                {{ __('admin/price-inquiries.status.pending') }}
                            </option>
                        </x-select>
                    </div>
                </div>
            </x-filter-sidebar>
        </x-card>
    </div>
</x-layouts.admin>