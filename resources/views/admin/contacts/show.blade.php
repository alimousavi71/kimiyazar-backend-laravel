<x-layouts.admin :title="__('admin/contacts.show.title')" :header-title="__('admin/contacts.show.header_title')"
    :breadcrumbs="[
        ['label' => __('admin/components.buttons.back'), 'url' => route('admin.dashboard')],
        ['label' => __('admin/contacts.title'), 'url' => route('admin.contacts.index')],
        ['label' => __('admin/contacts.show.title')]
    ]">
    <div class="mb-4 flex flex-col sm:flex-row sm:items-center sm:justify-between gap-3">
        <div>
            <h2 class="text-lg font-semibold text-gray-900">{{ __('admin/contacts.show.title') }}</h2>
            <p class="text-xs text-gray-600 mt-0.5">{{ __('admin/contacts.show.description') }}</p>
        </div>
        <div class="flex gap-2">
            <a href="{{ route('admin.contacts.index') }}">
                <x-button variant="secondary" size="md">
                    {{ __('admin/contacts.show.buttons.back_to_list') }}
                </x-button>
            </a>
        </div>
    </div>

    <div class="grid grid-cols-1 lg:grid-cols-3 gap-6">
        
        <div class="lg:col-span-2 space-y-6">
            <x-card>
                <x-slot name="title">{{ __('admin/contacts.show.contact_info') }}</x-slot>

                <div class="space-y-4">
                    <div>
                        <label class="text-sm font-medium text-gray-500">{{ __('admin/contacts.fields.title') }}</label>
                        <p class="text-base text-gray-900 mt-1">{{ $contact->title ?: __('admin/contacts.no_title') }}
                        </p>
                    </div>

                    <div>
                        <label class="text-sm font-medium text-gray-500">{{ __('admin/contacts.fields.text') }}</label>
                        <p class="text-base text-gray-900 mt-1 whitespace-pre-wrap">{{ $contact->text ?: '-' }}</p>
                    </div>

                    <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
                        <div>
                            <label
                                class="text-sm font-medium text-gray-500">{{ __('admin/contacts.fields.email') }}</label>
                            <p class="text-base text-gray-900 mt-1">
                                @if($contact->email)
                                    <a href="mailto:{{ $contact->email }}" class="text-blue-600 hover:text-blue-700">
                                        {{ $contact->email }}
                                    </a>
                                @else
                                    <span class="text-gray-400">-</span>
                                @endif
                            </p>
                        </div>
                        <div>
                            <label
                                class="text-sm font-medium text-gray-500">{{ __('admin/contacts.fields.mobile') }}</label>
                            <p class="text-base text-gray-900 mt-1">
                                @if($contact->mobile)
                                    <a href="tel:{{ $contact->mobile }}" class="text-blue-600 hover:text-blue-700">
                                        {{ $contact->mobile }}
                                    </a>
                                @else
                                    <span class="text-gray-400">-</span>
                                @endif
                            </p>
                        </div>
                    </div>

                    <div>
                        <label
                            class="text-sm font-medium text-gray-500">{{ __('admin/contacts.fields.is_read') }}</label>
                        <div class="mt-1">
                            @if($contact->is_read)
                                <x-badge variant="success" size="md">{{ __('admin/contacts.status.read') }}</x-badge>
                            @else
                                <x-badge variant="warning" size="md">{{ __('admin/contacts.status.unread') }}</x-badge>
                            @endif
                        </div>
                    </div>
                </div>
            </x-card>

            <x-card>
                <x-slot name="title">{{ __('admin/contacts.show.timestamps') }}</x-slot>

                <div class="space-y-4">
                    <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
                        <div>
                            <label
                                class="text-sm font-medium text-gray-500">{{ __('admin/contacts.fields.created_at') }}</label>
                            <p class="text-base text-gray-900 mt-1">{{ $contact->created_at->format('Y-m-d H:i:s') }}
                            </p>
                        </div>
                        <div>
                            <label
                                class="text-sm font-medium text-gray-500">{{ __('admin/contacts.fields.updated_at') }}</label>
                            <p class="text-base text-gray-900 mt-1">{{ $contact->updated_at->format('Y-m-d H:i:s') }}
                            </p>
                        </div>
                    </div>
                </div>
            </x-card>
        </div>

        
        <div class="lg:col-span-1">
            <x-card>
                <x-slot name="title">{{ __('admin/contacts.show.quick_actions') }}</x-slot>

                <div class="space-y-3">
                    <a href="{{ route('admin.contacts.index') }}" class="block">
                        <x-button variant="secondary" size="sm" class="w-full">
                            {{ __('admin/components.buttons.back') }}
                        </x-button>
                    </a>
                </div>
            </x-card>
        </div>
    </div>
</x-layouts.admin>