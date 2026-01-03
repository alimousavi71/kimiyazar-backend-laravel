<x-layouts.user-profile :title="__('user/price-inquiries.title')" :header-title="__('user/price-inquiries.title')"
    :breadcrumbs="[
        ['label' => __('user/profile.breadcrumbs.dashboard'), 'url' => route('user.profile.show')],
        ['label' => __('user/price-inquiries.title')]
    ]">
    <div>
        <div class="mb-4 flex flex-col sm:flex-row sm:items-center sm:justify-between gap-3">
            <div>
                <h2 class="text-lg font-semibold text-gray-900">{{ __('user/price-inquiries.management') }}</h2>
                <p class="text-xs text-gray-600 mt-0.5">{{ __('user/price-inquiries.description') }}</p>
            </div>
            <div>
                <a href="{{ route('price-inquiry.create') }}">
                    <x-button variant="primary" size="md">
                        {{ __('price-inquiry.forms.create.title') }}
                    </x-button>
                </a>
            </div>
        </div>


        <x-session-messages />


        <x-card>
            <x-table-wrapper :search-placeholder="__('admin/components.buttons.search')" :paginator="$priceInquiries ?? null">
                <x-table>
                    <x-table.head>
                        <x-table.row>
                            <x-table.cell header sortable
                                sort-field="id">{{ __('admin/components.table.id') }}</x-table.cell>
                            <x-table.cell header sortable
                                sort-field="created_at">{{ __('user/price-inquiries.fields.created_at') }}</x-table.cell>
                            <x-table.cell header>{{ __('user/price-inquiries.fields.products_count') }}</x-table.cell>
                            <x-table.cell header sortable
                                sort-field="is_reviewed">{{ __('user/price-inquiries.fields.is_reviewed') }}</x-table.cell>
                            <x-table.cell header
                                class="text-end">{{ __('admin/components.table.actions') }}</x-table.cell>
                        </x-table.row>
                    </x-table.head>
                    <x-table.body>
                        @if(isset($priceInquiries) && $priceInquiries->count() > 0)
                            @foreach($priceInquiries as $priceInquiry)
                                <x-table.row>
                                    <x-table.cell>
                                        <span class="text-gray-600">#{{ $priceInquiry->id }}</span>
                                    </x-table.cell>
                                    <x-table.cell>
                                        <span class="text-gray-900"><x-date :date="$priceInquiry->created_at"
                                                type="datetime" /></span>
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
                                                size="sm">{{ __('user/price-inquiries.status.reviewed') }}</x-badge>
                                        @else
                                            <x-badge variant="warning"
                                                size="sm">{{ __('user/price-inquiries.status.pending') }}</x-badge>
                                        @endif
                                    </x-table.cell>
                                    <x-table.cell>
                                        <div class="flex items-center justify-end">
                                            <x-dropdown-menu align="end">
                                                <x-dropdown-item
                                                    href="{{ route('user.profile.price-inquiries.show', $priceInquiry->id) }}"
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
                                <x-table.cell colspan="5" class="text-center py-8 text-gray-500">
                                    {{ __('admin/components.table.no_results') }}
                                </x-table.cell>
                            </x-table.row>
                        @endif
                    </x-table.body>
                </x-table>
            </x-table-wrapper>
        </x-card>
    </div>
</x-layouts.user-profile>