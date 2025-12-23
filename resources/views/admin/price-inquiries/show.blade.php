<x-layouts.admin :title="__('admin/price-inquiries.show.title')"
    :header-title="__('admin/price-inquiries.show.header_title')" :breadcrumbs="[
        ['label' => __('admin/components.buttons.back'), 'url' => route('admin.dashboard')],
        ['label' => __('admin/price-inquiries.title'), 'url' => route('admin.price-inquiries.index')],
        ['label' => __('admin/price-inquiries.show.title')]
    ]">
    <div class="mb-4 flex flex-col sm:flex-row sm:items-center sm:justify-between gap-3">
        <div>
            <h2 class="text-lg font-semibold text-gray-900">{{ __('admin/price-inquiries.show.title') }}</h2>
            <p class="text-xs text-gray-600 mt-0.5">{{ __('admin/price-inquiries.show.description') }}</p>
        </div>
        <div class="flex gap-2">
            <form action="{{ route('admin.price-inquiries.toggle-review-status', $priceInquiry->id) }}" method="POST"
                class="inline">
                @csrf
                @method('POST')
                <x-button variant="{{ $priceInquiry->is_reviewed ? 'secondary' : 'primary' }}" size="md" type="submit">
                    {{ $priceInquiry->is_reviewed ? __('admin/price-inquiries.buttons.mark_unreviewed') : __('admin/price-inquiries.buttons.mark_reviewed') }}
                </x-button>
            </form>
            <a href="{{ route('admin.price-inquiries.index') }}">
                <x-button variant="secondary" size="md">
                    {{ __('admin/price-inquiries.show.buttons.back_to_list') }}
                </x-button>
            </a>
        </div>
    </div>

    <div class="grid grid-cols-1 lg:grid-cols-3 gap-6">
        <!-- Main Information -->
        <div class="lg:col-span-2 space-y-6">
            <x-card>
                <x-slot name="title">{{ __('admin/price-inquiries.show.contact_info') }}</x-slot>

                <div class="space-y-4">
                    <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
                        <div>
                            <label
                                class="text-sm font-medium text-gray-500">{{ __('admin/price-inquiries.fields.first_name') }}</label>
                            <p class="text-base text-gray-900 mt-1">{{ $priceInquiry->first_name }}</p>
                        </div>
                        <div>
                            <label
                                class="text-sm font-medium text-gray-500">{{ __('admin/price-inquiries.fields.last_name') }}</label>
                            <p class="text-base text-gray-900 mt-1">{{ $priceInquiry->last_name }}</p>
                        </div>
                    </div>

                    <div>
                        <label
                            class="text-sm font-medium text-gray-500">{{ __('admin/price-inquiries.fields.full_name') }}</label>
                        <p class="text-base text-gray-900 mt-1">{{ $priceInquiry->full_name }}</p>
                    </div>

                    <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
                        <div>
                            <label
                                class="text-sm font-medium text-gray-500">{{ __('admin/price-inquiries.fields.email') }}</label>
                            <p class="text-base text-gray-900 mt-1">
                                <a href="mailto:{{ $priceInquiry->email }}"
                                    class="text-blue-600 hover:text-blue-700">{{ $priceInquiry->email }}</a>
                            </p>
                        </div>
                        <div>
                            <label
                                class="text-sm font-medium text-gray-500">{{ __('admin/price-inquiries.fields.phone_number') }}</label>
                            <p class="text-base text-gray-900 mt-1">
                                <a href="tel:{{ $priceInquiry->phone_number }}"
                                    class="text-blue-600 hover:text-blue-700">{{ $priceInquiry->phone_number }}</a>
                            </p>
                        </div>
                    </div>

                    @if($priceInquiry->user)
                        <div>
                            <label
                                class="text-sm font-medium text-gray-500">{{ __('admin/price-inquiries.fields.user') }}</label>
                            <p class="text-base text-gray-900 mt-1">
                                <a href="{{ route('admin.users.show', $priceInquiry->user->id) }}"
                                    class="text-blue-600 hover:text-blue-700">
                                    {{ $priceInquiry->user->getFullName() }} (ID: {{ $priceInquiry->user->id }})
                                </a>
                            </p>
                        </div>
                    @endif

                    <div>
                        <label
                            class="text-sm font-medium text-gray-500">{{ __('admin/price-inquiries.fields.is_reviewed') }}</label>
                        <div class="mt-1">
                            @if($priceInquiry->is_reviewed)
                                <x-badge variant="success"
                                    size="md">{{ __('admin/price-inquiries.status.reviewed') }}</x-badge>
                            @else
                                <x-badge variant="warning"
                                    size="md">{{ __('admin/price-inquiries.status.pending') }}</x-badge>
                            @endif
                        </div>
                    </div>
                </div>
            </x-card>

            <!-- Products -->
            <x-card>
                <x-slot name="title">{{ __('admin/price-inquiries.show.products') }}</x-slot>

                <div class="space-y-4">
                    @if(!empty($priceInquiry->products) && is_array($priceInquiry->products) && $products->isNotEmpty())
                        @php
                            $productIds = array_filter(array_map('intval', $priceInquiry->products));
                        @endphp
                        <ul class="space-y-2">
                            @foreach($productIds as $productId)
                                @php
                                    $product = $products[$productId] ?? null;
                                @endphp
                                <li
                                    class="flex items-center gap-2 p-3 border border-gray-200 rounded-lg hover:bg-gray-50 transition-colors">
                                    <span class="text-gray-500">#{{ $loop->iteration }}</span>
                                    @if($product)
                                        <a href="{{ route('admin.products.show', $product->id) }}"
                                            class="text-blue-600 hover:text-blue-700 font-medium">
                                            {{ $product->name }}
                                        </a>
                                    @else
                                        <span class="text-red-500">
                                            Product #{{ $productId }} ({{ __('admin/price-inquiries.labels.not_found') }})
                                        </span>
                                    @endif
                                </li>
                            @endforeach
                        </ul>
                    @else
                        <p class="text-gray-500">{{ __('admin/price-inquiries.show.no_products') }}</p>
                    @endif
                </div>
            </x-card>

            <x-card>
                <x-slot name="title">{{ __('admin/price-inquiries.show.timestamps') }}</x-slot>

                <div class="space-y-4">
                    <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
                        <div>
                            <label
                                class="text-sm font-medium text-gray-500">{{ __('admin/price-inquiries.fields.created_at') }}</label>
                            <p class="text-base text-gray-900 mt-1">
                                {{ $priceInquiry->created_at->format('Y-m-d H:i:s') }}
                            </p>
                        </div>
                        <div>
                            <label
                                class="text-sm font-medium text-gray-500">{{ __('admin/price-inquiries.fields.updated_at') }}</label>
                            <p class="text-base text-gray-900 mt-1">
                                {{ $priceInquiry->updated_at->format('Y-m-d H:i:s') }}
                            </p>
                        </div>
                    </div>
                </div>
            </x-card>
        </div>

        <!-- Sidebar -->
        <div class="lg:col-span-1">
            <x-card>
                <x-slot name="title">{{ __('admin/price-inquiries.show.quick_actions') }}</x-slot>

                <div class="space-y-3">
                    <form action="{{ route('admin.price-inquiries.toggle-review-status', $priceInquiry->id) }}"
                        method="POST" class="w-full">
                        @csrf
                        @method('POST')
                        <x-button variant="{{ $priceInquiry->is_reviewed ? 'secondary' : 'primary' }}" size="sm"
                            type="submit" class="w-full">
                            {{ $priceInquiry->is_reviewed ? __('admin/price-inquiries.buttons.mark_unreviewed') : __('admin/price-inquiries.buttons.mark_reviewed') }}
                        </x-button>
                    </form>

                    <form action="{{ route('admin.price-inquiries.destroy', $priceInquiry->id) }}" method="POST"
                        class="w-full"
                        onsubmit="return confirm('{{ __('admin/price-inquiries.messages.delete_confirm') }}');">
                        @csrf
                        @method('DELETE')
                        <x-button variant="danger" size="sm" type="submit" class="w-full">
                            {{ __('admin/components.buttons.delete') }}
                        </x-button>
                    </form>

                    <a href="{{ route('admin.price-inquiries.index') }}" class="block">
                        <x-button variant="secondary" size="sm" class="w-full">
                            {{ __('admin/components.buttons.back') }}
                        </x-button>
                    </a>
                </div>
            </x-card>
        </div>
    </div>
</x-layouts.admin>