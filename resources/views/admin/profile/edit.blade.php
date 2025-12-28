<x-layouts.admin :title="__('admin/profile.forms.edit.title')"
    :header-title="__('admin/profile.forms.edit.header_title')" :breadcrumbs="[
        ['label' => __('admin/profile.breadcrumbs.dashboard'), 'url' => route('admin.dashboard')],
        ['label' => __('admin/profile.breadcrumbs.profile'), 'url' => route('admin.profile.show')],
        ['label' => __('admin/profile.breadcrumbs.edit')]
    ]">
    <div class="mb-4">
        <h2 class="text-lg font-semibold text-gray-900">{{ __('admin/profile.forms.edit.title') }}</h2>
        <p class="text-xs text-gray-600 mt-0.5">{{ __('admin/profile.forms.edit.description') }}</p>
    </div>

    <div class="grid grid-cols-1 lg:grid-cols-3 gap-6">
        
        <div class="lg:col-span-2">
            <x-card>
                <x-slot name="title">{{ __('admin/profile.forms.edit.card_title') }}</x-slot>

                <form id="profile-edit-form" action="{{ route('admin.profile.update') }}" method="POST"
                    class="space-y-6">
                    @csrf
                    @method('PUT')

                    <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                        <x-form-group :label="__('admin/admins.fields.first_name')" required
                            :error="$errors->first('first_name')">
                            <x-input type="text" name="first_name" id="first_name"
                                :placeholder="__('admin/admins.forms.placeholders.first_name')"
                                value="{{ old('first_name', $admin->first_name) }}" required class="w-full" />
                        </x-form-group>

                        <x-form-group :label="__('admin/admins.fields.last_name')" required
                            :error="$errors->first('last_name')">
                            <x-input type="text" name="last_name" id="last_name"
                                :placeholder="__('admin/admins.forms.placeholders.last_name')"
                                value="{{ old('last_name', $admin->last_name) }}" required class="w-full" />
                        </x-form-group>
                    </div>

                    <x-form-group :label="__('admin/admins.fields.email')" required :error="$errors->first('email')">
                        <x-input type="email" name="email" id="email"
                            :placeholder="__('admin/admins.forms.placeholders.email')"
                            value="{{ old('email', $admin->email) }}" required class="w-full" />
                    </x-form-group>

                    <div class="flex items-center justify-end gap-3 pt-4 border-t border-gray-200">
                        <a href="{{ route('admin.profile.show') }}">
                            <x-button variant="secondary" type="button">
                                {{ __('admin/components.buttons.cancel') }}
                            </x-button>
                        </a>
                        <x-button variant="primary" type="submit">
                            {{ __('admin/profile.forms.edit.submit') }}
                        </x-button>
                    </div>
                </form>
            </x-card>
        </div>

        
        <div class="lg:col-span-1">
            <x-card>
                <x-slot name="title">{{ __('admin/profile.forms.edit.avatar_card_title') }}</x-slot>

                <div class="space-y-4">
                    <div class="flex justify-center">
                        @if($admin->avatar)
                            <img src="{{ asset('storage/' . $admin->avatar) }}" alt="{{ $admin->full_name }}"
                                class="w-32 h-32 rounded-full object-cover border-4 border-gray-200">
                        @else
                            <div class="w-32 h-32 bg-blue-100 rounded-full flex items-center justify-center">
                                <span
                                    class="text-blue-600 font-semibold text-2xl">{{ mb_substr($admin->first_name, 0, 1, 'UTF-8') . mb_substr($admin->last_name, 0, 1, 'UTF-8') }}</span>
                            </div>
                        @endif
                    </div>

                    <form id="avatar-upload-form" enctype="multipart/form-data" class="space-y-3">
                        @csrf
                        <x-form-group>
                            <input type="file" name="avatar" id="avatar"
                                accept="image/jpeg,image/png,image/jpg,image/gif"
                                class="block w-full text-sm text-gray-500 file:me-4 file:py-2 file:px-4 file:rounded-xl file:border-0 file:text-sm file:font-semibold file:bg-blue-50 file:text-blue-700 hover:file:bg-blue-100 cursor-pointer" />
                        </x-form-group>
                        <x-button variant="primary" size="sm" type="submit" class="w-full" id="upload-btn">
                            {{ __('admin/admins.forms.labels.upload_avatar') }}
                        </x-button>
                    </form>

                    @if($admin->avatar)
                        <form id="avatar-delete-form" class="mt-2">
                            @csrf
                            <x-button variant="danger" size="sm" type="submit" class="w-full" id="delete-btn">
                                {{ __('admin/admins.forms.labels.delete_avatar') }}
                            </x-button>
                        </form>
                    @endif
                </div>
            </x-card>
        </div>
    </div>

    @push('scripts')
        @vite('resources/js/admin-form-validation.js')
        <script>
            document.addEventListener('DOMContentLoaded', function () {
                const uploadForm = document.getElementById('avatar-upload-form');
                const deleteForm = document.getElementById('avatar-delete-form');
                const uploadBtn = document.getElementById('upload-btn');
                const deleteBtn = document.getElementById('delete-btn');

                if (uploadForm) {
                    uploadForm.addEventListener('submit', async function (e) {
                        e.preventDefault();

                        const formData = new FormData(uploadForm);
                        const fileInput = document.getElementById('avatar');

                        if (!fileInput.files[0]) {
                            if (window.Toast) {
                                window.Toast.error('{{ __('admin/admins.forms.javascript.select_image') }}');
                            }
                            return;
                        }

                        uploadBtn.disabled = true;
                        uploadBtn.textContent = '{{ __('admin/admins.forms.labels.uploading') }}';

                        try {
                            const response = await window.axios.post('{{ route('admin.profile.avatar.upload') }}', formData, {
                                headers: {
                                    'Content-Type': 'multipart/form-data'
                                }
                            });

                            if (response.data.success) {
                                if (window.Toast) {
                                    window.Toast.success(response.data.message);
                                }
                                setTimeout(() => location.reload(), 1000);
                            }
                        } catch (error) {
                            console.error('Upload error:', error);
                        } finally {
                            uploadBtn.disabled = false;
                            uploadBtn.textContent = '{{ __('admin/admins.forms.labels.upload_avatar') }}';
                        }
                    });
                }

                if (deleteForm) {
                    deleteForm.addEventListener('submit', async function (e) {
                        e.preventDefault();

                        if (!confirm('{{ __('admin/admins.forms.javascript.delete_avatar_confirm') }}')) {
                            return;
                        }

                        deleteBtn.disabled = true;
                        deleteBtn.textContent = '{{ __('admin/admins.forms.labels.deleting') }}';

                        try {
                            const response = await window.axios.delete('{{ route('admin.profile.avatar.delete') }}');

                            if (response.data.success) {
                                if (window.Toast) {
                                    window.Toast.success(response.data.message);
                                }
                                setTimeout(() => location.reload(), 1000);
                            }
                        } catch (error) {
                            console.error('Delete error:', error);
                        } finally {
                            deleteBtn.disabled = false;
                            deleteBtn.textContent = '{{ __('admin/admins.forms.labels.delete_avatar') }}';
                        }
                    });
                }
            });
        </script>
    @endpush
</x-layouts.admin>