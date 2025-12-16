@props([
    'photoableType' => null,
    'photoableId' => null,
    'limit' => null,
    'accept' => 'image/jpeg,image/png,image/jpg,image/webp',
    'label' => null,
    'required' => false,
    'error' => null,
])

@php
    $uniqueId = 'photo-manager-' . uniqid();
    $translations = [
        'upload_success' => __('admin/photos.messages.uploaded'),
        'upload_error' => __('admin/photos.messages.upload_failed'),
        'delete_success' => __('admin/photos.messages.deleted'),
        'delete_error' => __('admin/photos.messages.delete_failed'),
        'delete_confirm' => __('admin/photos.forms.messages.delete_confirm'),
        'primary_set' => __('admin/photos.messages.primary_set'),
        'primary_set_error' => __('admin/photos.messages.primary_set_failed'),
        'reorder_error' => __('admin/photos.messages.reorder_failed'),
        'attach_error' => __('admin/photos.messages.attach_failed'),
        'max_limit_reached' => __('admin/photos.forms.messages.max_limit_reached'),
        'select_image' => __('admin/photos.forms.labels.file'),
    ];
@endphp

<div x-data="photoManager({
    photoableType: @js($photoableType),
    photoableId: @js($photoableId),
    limit: @js($limit),
    accept: @js($accept),
    uniqueId: @js($uniqueId),
    translations: @js($translations),
})" class="space-y-4" id="{{ $uniqueId }}">
    @if($label)
        <label class="text-sm font-medium text-gray-700">
            {{ $label }}
            @if($required)
                <span class="text-red-500">*</span>
            @endif
        </label>
    @endif

    <!-- Upload Area -->
    <div x-show="!limit || photos.length < limit" 
         class="border-2 border-dashed border-gray-300 rounded-lg p-6 text-center hover:border-blue-400 transition-colors"
         :class="{ 'border-blue-500 bg-blue-50': isDragging }"
         @dragover.prevent="isDragging = true"
         @dragleave.prevent="isDragging = false"
         @drop.prevent="handleDrop($event)"
         @click="$refs.fileInput.click()">
        <input type="file" 
               x-ref="fileInput" 
               :accept="accept" 
               multiple 
               class="hidden"
               @change="handleFileSelect($event)"
               :disabled="loading || (limit && photos.length >= limit)">
        
        <div class="flex flex-col items-center justify-center space-y-2">
            <x-icon name="cloud-upload" size="2xl" class="text-gray-400" />
            <div class="text-sm text-gray-600">
                <span class="font-medium text-blue-600 hover:text-blue-700 cursor-pointer">{{ __('admin/photos.forms.labels.click_to_upload') }}</span>
                <span class="text-gray-500"> {{ __('admin/photos.forms.labels.drag_and_drop') }}</span>
            </div>
            <p class="text-xs text-gray-500">{{ __('admin/photos.forms.labels.supported_formats') }} - {{ __('admin/photos.forms.labels.max_size') }}</p>
            <p x-show="limit" class="text-xs text-gray-500">
                {{ str_replace(':limit', '', __('admin/photos.forms.labels.max_photos')) }}<span x-text="limit"></span>
            </p>
        </div>
    </div>

    <!-- Loading Indicator -->
    <div x-show="loading" class="flex items-center justify-center py-4">
        <div class="animate-spin rounded-full h-8 w-8 border-b-2 border-blue-600"></div>
        <span class="ml-2 text-sm text-gray-600">{{ __('admin/photos.forms.messages.uploading') }}</span>
    </div>

    <!-- Photos Grid -->
    <div x-show="photos.length > 0" class="grid grid-cols-2 sm:grid-cols-3 md:grid-cols-4 lg:grid-cols-5 gap-4">
        <template x-for="(photo, index) in photos" :key="photo.id">
            <div class="relative group border border-gray-200 rounded-lg overflow-hidden bg-gray-50">
                <!-- Image -->
                <div class="aspect-square relative">
                    <img :src="photo.url || getPhotoUrl(photo.file_path)" 
                         :alt="photo.alt || 'Photo'"
                         class="w-full h-full object-cover">
                    
                    <!-- Overlay on Hover -->
                    <div class="absolute inset-0 bg-black bg-opacity-0 group-hover:bg-opacity-50 transition-opacity flex items-center justify-center space-x-2">
                        <!-- Primary Badge -->
                        <span x-show="photo.is_primary" 
                              class="absolute top-2 left-2 bg-blue-600 text-white text-xs px-2 py-1 rounded">
                            Primary
                        </span>
                        
                        <!-- Actions -->
                        <div class="opacity-0 group-hover:opacity-100 transition-opacity flex space-x-2">
                            <!-- Set Primary -->
                            <button type="button"
                                    @click="setPrimary(photo.id)"
                                    x-show="!photo.is_primary"
                                    class="bg-blue-600 text-white p-2 rounded hover:bg-blue-700 transition-colors"
                                    title="Set as primary">
                                <x-icon name="star" size="sm" />
                            </button>
                            
                            <!-- Move Up -->
                            <button type="button"
                                    @click="movePhoto(index, 'up')"
                                    x-show="index > 0"
                                    class="bg-gray-700 text-white p-2 rounded hover:bg-gray-800 transition-colors"
                                    title="Move up">
                                <x-icon name="up-arrow" size="sm" />
                            </button>
                            
                            <!-- Move Down -->
                            <button type="button"
                                    @click="movePhoto(index, 'down')"
                                    x-show="index < photos.length - 1"
                                    class="bg-gray-700 text-white p-2 rounded hover:bg-gray-800 transition-colors"
                                    title="Move down">
                                <x-icon name="down-arrow" size="sm" />
                            </button>
                            
                            <!-- Delete -->
                            <button type="button"
                                    @click="deletePhoto(photo.id)"
                                    class="bg-red-600 text-white p-2 rounded hover:bg-red-700 transition-colors"
                                    title="Delete">
                                <x-icon name="trash" size="sm" />
                            </button>
                        </div>
                    </div>
                </div>
                
                <!-- Alt Text Input -->
                <div class="p-2">
                    <input type="text"
                           :value="photo.alt || ''"
                           @blur="updateAlt(photo.id, $event.target.value)"
                           placeholder="{{ __('admin/photos.forms.placeholders.alt') }}"
                           class="w-full text-xs px-2 py-1 border border-gray-300 rounded focus:outline-none focus:ring-1 focus:ring-blue-500">
                </div>
            </div>
        </template>
    </div>

    <!-- Empty State -->
    <div x-show="photos.length === 0 && !loading" class="text-center py-8 text-gray-500">
        <x-icon name="image" size="2xl" class="text-gray-300 mb-2" />
        <p class="text-sm">{{ __('admin/photos.forms.messages.no_photos') }}</p>
    </div>

    <!-- Error Message -->
    @if($error)
        <span class="text-sm text-red-600">{{ $error }}</span>
    @endif

    <!-- Hidden Input for Form Submission -->
    <template x-for="photo in photos" :key="photo.id">
        <input type="hidden" :name="'photos[]'" :value="photo.id">
    </template>
</div>

@push('scripts')
<script>
function photoManager(config) {
    return {
        photos: [],
        loading: false,
        isDragging: false,
        photoableType: config.photoableType,
        photoableId: config.photoableId,
        limit: config.limit,
        accept: config.accept,
        uniqueId: config.uniqueId,

        init() {
            // Load existing photos if photoable entity exists
            if (this.photoableType && this.photoableId) {
                this.loadPhotos();
            }
        },

        async loadPhotos() {
            if (!this.photoableType || !this.photoableId) return;

            try {
                const response = await window.axios.get('{{ route("admin.photos.index") }}', {
                    params: {
                        photoable_type: this.photoableType,
                        photoable_id: this.photoableId,
                    }
                });

                if (response.data.success) {
                    this.photos = response.data.data.map(photo => ({
                        ...photo,
                        url: this.getPhotoUrl(photo.file_path)
                    }));
                }
            } catch (error) {
                console.error('Failed to load photos:', error);
            }
        },

        getPhotoUrl(filePath) {
            return filePath.startsWith('http') ? filePath : `/storage/${filePath}`;
        },

        handleFileSelect(event) {
            const files = Array.from(event.target.files);
            this.uploadFiles(files);
            event.target.value = ''; // Reset input
        },

        handleDrop(event) {
            this.isDragging = false;
            const files = Array.from(event.dataTransfer.files);
            this.uploadFiles(files);
        },

        async uploadFiles(files) {
            if (this.limit && this.photos.length >= this.limit) {
                if (window.Toast) {
                    window.Toast.error(this.translations.max_limit_reached);
                }
                return;
            }

            const filesToUpload = this.limit 
                ? files.slice(0, this.limit - this.photos.length)
                : files;

            for (const file of filesToUpload) {
                if (this.limit && this.photos.length >= this.limit) break;

                await this.uploadFile(file);
            }
        },

        async uploadFile(file) {
            if (!file.type.startsWith('image/')) {
                if (window.Toast) {
                    window.Toast.error(this.translations.select_image);
                }
                return;
            }

            this.loading = true;

            try {
                const formData = new FormData();
                formData.append('file', file);
                if (this.photoableType) {
                    formData.append('photoable_type', this.photoableType);
                }
                if (this.photoableId) {
                    formData.append('photoable_id', this.photoableId);
                }

                const response = await window.axios.post('{{ route("admin.photos.store") }}', formData, {
                    headers: {
                        'Content-Type': 'multipart/form-data',
                    }
                });

                if (response.data.success) {
                    const photo = {
                        ...response.data.data,
                        url: this.getPhotoUrl(response.data.data.file_path)
                    };
                    this.photos.push(photo);

                    if (window.Toast) {
                        window.Toast.success(this.translations.upload_success);
                    }
                }
            } catch (error) {
                console.error('Upload error:', error);
                if (window.Toast) {
                    window.Toast.error(error.response?.data?.message || this.translations.upload_error);
                }
            } finally {
                this.loading = false;
            }
        },

        async deletePhoto(photoId) {
            if (!confirm(this.translations.delete_confirm)) {
                return;
            }

            try {
                const response = await window.axios.delete(`{{ route("admin.photos.destroy", ":id") }}`.replace(':id', photoId));

                if (response.data.success) {
                    this.photos = this.photos.filter(p => p.id !== photoId);
                    if (window.Toast) {
                        window.Toast.success(this.translations.delete_success);
                    }
                }
            } catch (error) {
                console.error('Delete error:', error);
                if (window.Toast) {
                    window.Toast.error(error.response?.data?.message || this.translations.delete_error);
                }
            }
        },

        async setPrimary(photoId) {
            try {
                const response = await window.axios.put(`{{ route("admin.photos.update", ":id") }}`.replace(':id', photoId), {
                    is_primary: true
                });

                if (response.data.success) {
                    // Update local state
                    this.photos = this.photos.map(p => ({
                        ...p,
                        is_primary: p.id === photoId
                    }));

                    if (window.Toast) {
                        window.Toast.success(this.translations.primary_set);
                    }
                }
            } catch (error) {
                console.error('Set primary error:', error);
                if (window.Toast) {
                    window.Toast.error(error.response?.data?.message || this.translations.primary_set_error);
                }
            }
        },

        async updateAlt(photoId, alt) {
            try {
                await window.axios.put(`{{ route("admin.photos.update", ":id") }}`.replace(':id', photoId), {
                    alt: alt
                });
            } catch (error) {
                console.error('Update alt error:', error);
            }
        },

        async movePhoto(index, direction) {
            if (direction === 'up' && index === 0) return;
            if (direction === 'down' && index === this.photos.length - 1) return;

            const newIndex = direction === 'up' ? index - 1 : index + 1;
            const temp = this.photos[index];
            this.photos[index] = this.photos[newIndex];
            this.photos[newIndex] = temp;

            // Update sort orders
            const photoOrders = this.photos.map((photo, idx) => ({
                id: photo.id,
                sort_order: idx
            }));

            try {
                await window.axios.post('{{ route("admin.photos.reorder") }}', {
                    photos: photoOrders
                });
            } catch (error) {
                console.error('Reorder error:', error);
                // Revert on error
                const temp2 = this.photos[index];
                this.photos[index] = this.photos[newIndex];
                this.photos[newIndex] = temp2;
                if (window.Toast) {
                    window.Toast.error(this.translations.reorder_error);
                }
            }
        },

        // Method to attach photos to entity (call after entity is created)
        async attachPhotos(photoableType, photoableId) {
            if (this.photos.length === 0) return;

            const photoIds = this.photos.map(p => p.id);

            try {
                await window.axios.post('{{ route("admin.photos.attach") }}', {
                    photoable_type: photoableType,
                    photoable_id: photoableId,
                    photo_ids: photoIds
                });

                this.photoableType = photoableType;
                this.photoableId = photoableId;
            } catch (error) {
                console.error('Attach error:', error);
                if (window.Toast) {
                    window.Toast.error(this.translations.attach_error);
                }
            }
        }
    };
}
</script>
@endpush

