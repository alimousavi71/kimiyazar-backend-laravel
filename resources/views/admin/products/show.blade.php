<x-layouts.admin :title="__('admin/products.show.title')" :header-title="__('admin/products.show.header_title')"
    :breadcrumbs="[
        ['label' => __('admin/products.forms.breadcrumbs.dashboard'), 'url' => route('admin.dashboard')],
        ['label' => __('admin/products.forms.breadcrumbs.products'), 'url' => route('admin.products.index')],
        ['label' => __('admin/products.forms.breadcrumbs.details')]
    ]">
    <div class="mb-4 flex flex-col sm:flex-row sm:items-center sm:justify-between gap-3">
        <div>
            <h2 class="text-lg font-semibold text-gray-900">{{ __('admin/products.show.title') }}</h2>
            <p class="text-xs text-gray-600 mt-0.5">{{ __('admin/products.show.description') }}</p>
        </div>
        <div class="flex gap-2">
            <a href="{{ route('admin.products.edit', $product->id) }}">
                <x-button variant="primary" size="md">
                    {{ __('admin/products.show.buttons.edit') }}
                </x-button>
            </a>
            <a href="{{ route('admin.products.index') }}">
                <x-button variant="secondary" size="md">
                    {{ __('admin/products.show.buttons.back_to_list') }}
                </x-button>
            </a>
        </div>
    </div>

    <div class="grid grid-cols-1 lg:grid-cols-3 gap-6">
        <!-- Main Information -->
        <div class="lg:col-span-2 space-y-6">
            <!-- Basic Information -->
            <x-card>
                <x-slot name="title">{{ __('admin/products.show.basic_info') }}</x-slot>

                <div class="space-y-4">
                    <div>
                        <label class="text-sm font-medium text-gray-500">{{ __('admin/products.fields.name') }}</label>
                        <p class="text-base text-gray-900 mt-1">{{ $product->name }}</p>
                    </div>

                    <div>
                        <label class="text-sm font-medium text-gray-500">{{ __('admin/products.fields.slug') }}</label>
                        <p class="text-base text-gray-900 mt-1">{{ $product->slug }}</p>
                    </div>

                    <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
                        <div>
                            <label
                                class="text-sm font-medium text-gray-500">{{ __('admin/products.fields.category') }}</label>
                            <p class="text-base text-gray-900 mt-1">
                                @if($product->category)
                                    <span class="text-gray-700">{{ $product->category->name }}</span>
                                @else
                                    <span
                                        class="text-gray-400">{{ __('admin/products.forms.placeholders.no_category') }}</span>
                                @endif
                            </p>
                        </div>

                        <div>
                            <label
                                class="text-sm font-medium text-gray-500">{{ __('admin/products.fields.unit') }}</label>
                            <p class="text-base text-gray-900 mt-1">{{ $product->unit->label() }}</p>
                        </div>
                    </div>

                    <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
                        <div>
                            <label
                                class="text-sm font-medium text-gray-500">{{ __('admin/products.fields.status') }}</label>
                            <div class="mt-1">
                                <x-badge
                                    variant="{{ $product->status->value === 'active' ? 'success' : ($product->status->value === 'draft' ? 'warning' : 'danger') }}"
                                    size="md">
                                    {{ $product->status->label() }}
                                </x-badge>
                            </div>
                        </div>

                        <div>
                            <label
                                class="text-sm font-medium text-gray-500">{{ __('admin/products.fields.is_published') }}</label>
                            <div class="mt-1">
                                @if($product->is_published)
                                    <x-badge variant="success"
                                        size="md">{{ __('admin/products.statuses.active') }}</x-badge>
                                @else
                                    <x-badge variant="danger"
                                        size="md">{{ __('admin/products.statuses.inactive') }}</x-badge>
                                @endif
                            </div>
                        </div>
                    </div>

                    @if($product->sale_description)
                        <div>
                            <label
                                class="text-sm font-medium text-gray-500">{{ __('admin/products.fields.sale_description') }}</label>
                            <p class="text-base text-gray-900 mt-1 whitespace-pre-line">{{ $product->sale_description }}</p>
                        </div>
                    @endif

                    @if($product->body)
                        <div>
                            <label class="text-sm font-medium text-gray-500">{{ __('admin/products.fields.body') }}</label>
                            <p class="text-base text-gray-900 mt-1 whitespace-pre-line">{{ $product->body }}</p>
                        </div>
                    @endif

                    <div>
                        <label
                            class="text-sm font-medium text-gray-500">{{ __('admin/products.fields.sort_order') }}</label>
                        <p class="text-base text-gray-900 mt-1">{{ $product->sort_order }}</p>
                    </div>
                </div>
            </x-card>

            <!-- Photos -->
            @if($product->photos->count() > 0)
                <x-card>
                    <x-slot name="title">{{ __('admin/photos.title') }}</x-slot>
                    <div class="rounded-xl border border-gray-200 bg-white shadow-sm p-4">
                        <x-photo-manager photoable-type="{{ \App\Models\Product::class }}" :photoable-id="$product->id"
                            :read-only="true" />
                    </div>
                </x-card>
            @endif

            <!-- Pricing Information -->
            @if($product->current_price || $product->price_label || $product->currency_code)
                <x-card>
                    <x-slot name="title">{{ __('admin/products.show.pricing_info') }}</x-slot>

                    <div class="space-y-4">
                        @if($product->current_price)
                            <div>
                                <label
                                    class="text-sm font-medium text-gray-500">{{ __('admin/products.fields.current_price') }}</label>
                                <p class="text-base text-gray-900 mt-1">
                                    {{ number_format($product->current_price) }} {{ $product->currency_code?->label() ?? '' }}
                                </p>
                            </div>
                        @endif

                        @if($product->price_label)
                            <div>
                                <label
                                    class="text-sm font-medium text-gray-500">{{ __('admin/products.fields.price_label') }}</label>
                                <p class="text-base text-gray-900 mt-1">{{ $product->price_label }}</p>
                            </div>
                        @endif

                        @if($product->price_effective_date)
                            <div>
                                <label
                                    class="text-sm font-medium text-gray-500">{{ __('admin/products.fields.price_effective_date') }}</label>
                                <p class="text-base text-gray-900 mt-1">{{ $product->price_effective_date->format('Y-m-d') }}
                                </p>
                            </div>
                        @endif

                        @if($product->price_updated_at)
                            <div>
                                <label
                                    class="text-sm font-medium text-gray-500">{{ __('admin/products.fields.price_updated_at') }}</label>
                                <p class="text-base text-gray-900 mt-1">{{ $product->price_updated_at->format('Y-m-d H:i:s') }}
                                </p>
                            </div>
                        @endif
                    </div>
                </x-card>
            @endif

            <!-- SEO Information -->
            @if($product->meta_title || $product->meta_description || $product->meta_keywords)
                <x-card>
                    <x-slot name="title">{{ __('admin/products.show.seo_info') }}</x-slot>

                    <div class="space-y-4">
                        @if($product->meta_title)
                            <div>
                                <label
                                    class="text-sm font-medium text-gray-500">{{ __('admin/products.fields.meta_title') }}</label>
                                <p class="text-base text-gray-900 mt-1">{{ $product->meta_title }}</p>
                            </div>
                        @endif

                        @if($product->meta_description)
                            <div>
                                <label
                                    class="text-sm font-medium text-gray-500">{{ __('admin/products.fields.meta_description') }}</label>
                                <p class="text-base text-gray-900 mt-1">{{ $product->meta_description }}</p>
                            </div>
                        @endif

                        @if($product->meta_keywords)
                            <div>
                                <label
                                    class="text-sm font-medium text-gray-500">{{ __('admin/products.fields.meta_keywords') }}</label>
                                <p class="text-base text-gray-900 mt-1">{{ $product->meta_keywords }}</p>
                            </div>
                        @endif
                    </div>
                </x-card>
            @endif

            <!-- Timestamps -->
            <x-card>
                <x-slot name="title">{{ __('admin/products.show.timestamps') }}</x-slot>

                <div class="space-y-4">
                    <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
                        <div>
                            <label
                                class="text-sm font-medium text-gray-500">{{ __('admin/products.fields.created_at') }}</label>
                            <p class="text-base text-gray-900 mt-1">{{ $product->created_at->format('Y-m-d H:i:s') }}
                            </p>
                        </div>
                        <div>
                            <label
                                class="text-sm font-medium text-gray-500">{{ __('admin/products.fields.updated_at') }}</label>
                            <p class="text-base text-gray-900 mt-1">{{ $product->updated_at->format('Y-m-d H:i:s') }}
                            </p>
                        </div>
                    </div>
                </div>
            </x-card>
        </div>

        <!-- Sidebar -->
        <div class="lg:col-span-1">
            <x-card>
                <x-slot name="title">{{ __('admin/products.show.quick_actions') }}</x-slot>

                <div class="space-y-3">
                    <a href="{{ route('admin.products.edit', $product->id) }}" class="block">
                        <x-button variant="primary" size="sm" class="w-full">
                            {{ __('admin/components.buttons.edit') }}
                        </x-button>
                    </a>
                    <a href="{{ route('admin.products.index') }}" class="block">
                        <x-button variant="secondary" size="sm" class="w-full">
                            {{ __('admin/components.buttons.back') }}
                        </x-button>
                    </a>
                </div>
            </x-card>
        </div>
    </div>
</x-layouts.admin>