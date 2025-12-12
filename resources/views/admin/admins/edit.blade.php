<x-layouts.admin title="Edit Admin" header-title="Edit Admin" :breadcrumbs="[
        ['label' => 'Dashboard', 'url' => route('admin.dashboard')],
        ['label' => 'Admins', 'url' => route('admin.admins.index')],
        ['label' => 'Edit']
    ]">
    <div class="mb-4">
        <h2 class="text-lg font-semibold text-gray-900">Edit Admin</h2>
        <p class="text-xs text-gray-600 mt-0.5">Update administrator information</p>
    </div>

    <div class="grid grid-cols-1 lg:grid-cols-3 gap-6">
        <!-- Main Form -->
        <div class="lg:col-span-2">
            <x-card>
                <x-slot name="title">Admin Information</x-slot>

                <form action="{{ route('admin.admins.update', $admin->id) }}" method="POST" class="space-y-6">
                    @csrf
                    @method('PUT')

                    <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                        <x-form-group label="First Name" required :error="$errors->first('first_name')">
                            <x-input type="text" name="first_name" id="first_name" placeholder="Enter first name"
                                value="{{ old('first_name', $admin->first_name) }}" required class="w-full" />
                        </x-form-group>

                        <x-form-group label="Last Name" required :error="$errors->first('last_name')">
                            <x-input type="text" name="last_name" id="last_name" placeholder="Enter last name"
                                value="{{ old('last_name', $admin->last_name) }}" required class="w-full" />
                        </x-form-group>
                    </div>

                    <x-form-group label="Email Address" required :error="$errors->first('email')">
                        <x-input type="email" name="email" id="email" placeholder="Enter email address"
                            value="{{ old('email', $admin->email) }}" required class="w-full" />
                    </x-form-group>

                    <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                        <x-form-group label="Password" help="Leave blank to keep current password"
                            :error="$errors->first('password')">
                            <x-input type="password" name="password" id="password" placeholder="Enter new password"
                                class="w-full" />
                        </x-form-group>

                        <x-form-group label="Confirm Password">
                            <x-input type="password" name="password_confirmation" id="password_confirmation"
                                placeholder="Confirm new password" class="w-full" />
                        </x-form-group>
                    </div>

                    <x-form-group label="Status">
                        <x-toggle name="is_block" id="is_block" :checked="old('is_block', $admin->is_block)"
                            label="Block this admin" />
                    </x-form-group>

                    <div class="flex items-center justify-end gap-3 pt-4 border-t border-gray-200">
                        <a href="{{ route('admin.admins.index') }}">
                            <x-button variant="secondary" type="button">
                                Cancel
                            </x-button>
                        </a>
                        <x-button variant="primary" type="submit">
                            Update Admin
                        </x-button>
                    </div>
                </form>
            </x-card>
        </div>

        <!-- Avatar Section -->
        <div class="lg:col-span-1">
            <x-card>
                <x-slot name="title">Avatar</x-slot>

                <div class="space-y-4">
                    <div class="flex justify-center">
                        @if($admin->avatar)
                            <img src="{{ asset('storage/' . $admin->avatar) }}" alt="{{ $admin->full_name }}"
                                class="w-32 h-32 rounded-full object-cover border-4 border-gray-200">
                        @else
                            <div class="w-32 h-32 bg-blue-100 rounded-full flex items-center justify-center">
                                <span
                                    class="text-blue-600 font-semibold text-2xl">{{ strtoupper(substr($admin->first_name, 0, 1) . substr($admin->last_name, 0, 1)) }}</span>
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
                            Upload Avatar
                        </x-button>
                    </form>

                    @if($admin->avatar)
                        <form id="avatar-delete-form" class="mt-2">
                            @csrf
                            <x-button variant="danger" size="sm" type="submit" class="w-full" id="delete-btn">
                                Delete Avatar
                            </x-button>
                        </form>
                    @endif
                </div>
            </x-card>
        </div>
    </div>

    @push('scripts')
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
                                window.Toast.error('Please select an image file');
                            }
                            return;
                        }

                        uploadBtn.disabled = true;
                        uploadBtn.textContent = 'Uploading...';

                        try {
                            const response = await window.axios.post('{{ route('admin.admins.avatar.upload', $admin->id) }}', formData, {
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
                            uploadBtn.textContent = 'Upload Avatar';
                        }
                    });
                }

                if (deleteForm) {
                    deleteForm.addEventListener('submit', async function (e) {
                        e.preventDefault();

                        if (!confirm('Are you sure you want to delete the avatar?')) {
                            return;
                        }

                        deleteBtn.disabled = true;
                        deleteBtn.textContent = 'Deleting...';

                        try {
                            const response = await window.axios.delete('{{ route('admin.admins.avatar.delete', $admin->id) }}');

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
                            deleteBtn.textContent = 'Delete Avatar';
                        }
                    });
                }
            });
        </script>
    @endpush
</x-layouts.admin>