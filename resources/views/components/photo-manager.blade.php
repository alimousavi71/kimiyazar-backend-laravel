@props([
    'photoableType' => null,
    'photoableId' => null,
    'limit' => null,
    'accept' => 'image/jpeg,image/png,image/jpg,image/webp',
    'label' => null,
    'required' => false,
    'error' => null,
    'readOnly' => false,
])

@php
    $uniqueId = 'photo-manager-' . uniqid();
    $translationKey = str_replace('-', '_', $uniqueId);
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
    translationKey: @js($translationKey),
    readOnly: @js($readOnly),
})" class="space-y-4" id="{{ $uniqueId }}">
    @if($label)
        <label class="text-sm font-medium text-gray-700">
            {{ $label }}
            @if($required)
                <span class="text-red-500">*</span>
            @endif
        </label>
    @endif

    
    <div x-show="!readOnly && (!limit || photos.length < limit)" 
         class="border-2 border-dashed border-gray-300 rounded-lg p-6 text-center hover:border-green-400 transition-colors"
         :class="{ 'border-green-500 bg-green-50': isDragging }"
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
            <svg class="w-8 h-8 text-gray-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M7 16a4 4 0 01-.88-7.903A5 5 0 1115.9 6L16 6a5 5 0 011 9.9M15 13l-3-3m0 0l-3 3m3-3v12"></path>
            </svg>
            <div class="text-sm text-gray-600">
                <span class="font-medium text-green-600 hover:text-green-700 cursor-pointer">{{ __('admin/photos.forms.labels.click_to_upload') }}</span>
                <span class="text-gray-500"> {{ __('admin/photos.forms.labels.drag_and_drop') }}</span>
            </div>
            <p class="text-xs text-gray-500">{{ __('admin/photos.forms.labels.supported_formats') }} - {{ __('admin/photos.forms.labels.max_size') }}</p>
            @if($limit)
                <p class="text-xs text-gray-500">
                    {{ str_replace(':limit', '', __('admin/photos.forms.labels.max_photos')) }}<span x-text="limit"></span>
                </p>
            @endif
        </div>
    </div>

    
    <div x-show="loading" class="flex items-center justify-center py-4">
        <div class="animate-spin rounded-full h-8 w-8 border-b-2 border-green-600"></div>
        <span class="ml-2 text-sm text-gray-600">{{ __('admin/photos.forms.messages.uploading') }}</span>
    </div>

    
    <div x-show="photos.length > 0" class="grid grid-cols-2 sm:grid-cols-3 md:grid-cols-4 lg:grid-cols-5 gap-4">
        <template x-for="(photo, index) in photos" :key="photo.id">
            <div class="relative group border border-gray-200 rounded-lg overflow-hidden bg-gray-50">
                
                <div class="aspect-square relative">
                    <img :src="photo.url || (photo.file_path ? (photo.file_path.startsWith('http') ? photo.file_path : (photo.file_path.startsWith('storage/') ? '/' + photo.file_path : '/storage/' + photo.file_path)) : '')" 
                         :alt="photo.alt || 'Photo'"
                         class="w-full h-full object-cover"                  
                         loading="lazy">
                    
                    
                    <div class="absolute inset-0 bg-black bg-opacity-0 group-hover:bg-opacity-50 transition-opacity flex items-center justify-center space-x-2">
                        
                        <span x-show="photo.is_primary" 
                              class="absolute top-2 left-2 bg-gradient-to-r from-green-500 to-emerald-400 text-white text-xs px-2 py-1 rounded">
                            Primary
                        </span>
                        
                        
                        <div x-show="!readOnly" class="opacity-0 group-hover:opacity-100 transition-opacity flex space-x-2">
                            
                            <button type="button"
                                    @click="setPrimary(photo.id)"
                                    x-show="!photo.is_primary"
                                    class="bg-gradient-to-r from-green-500 to-emerald-400 text-white p-2 rounded hover:from-green-600 hover:to-emerald-500 transition-colors"
                                    title="Set as primary">
                                <svg class="w-4 h-4" fill="currentColor" viewBox="0 0 20 20">
                                    <path d="M9.049 2.927c.3-.921 1.603-.921 1.902 0l1.07 3.292a1 1 0 00.95.69h3.462c.969 0 1.371 1.24.588 1.81l-2.8 2.034a1 1 0 00-.364 1.118l1.07 3.292c.3.921-.755 1.688-1.54 1.118l-2.8-2.034a1 1 0 00-1.175 0l-2.8 2.034c-.784.57-1.838-.197-1.539-1.118l1.07-3.292a1 1 0 00-.364-1.118L2.98 8.72c-.783-.57-.38-1.81.588-1.81h3.461a1 1 0 00.951-.69l1.07-3.292z"></path>
                                </svg>
                            </button>
                            
                            
                            <button type="button"
                                    @click="movePhoto(index, 'up')"
                                    x-show="index > 0"
                                    class="bg-gray-700 text-white p-2 rounded hover:bg-gray-800 transition-colors"
                                    title="Move up">
                                <svg class="w-4 h-4" fill="currentColor" viewBox="0 0 20 20">
                                    <path fill-rule="evenodd" d="M14.707 12.707a1 1 0 01-1.414 0L10 9.414l-3.293 3.293a1 1 0 01-1.414-1.414l4-4a1 1 0 011.414 0l4 4a1 1 0 010 1.414z" clip-rule="evenodd"></path>
                                </svg>
                            </button>
                            
                            
                            <button type="button"
                                    @click="movePhoto(index, 'down')"
                                    x-show="index < photos.length - 1"
                                    class="bg-gray-700 text-white p-2 rounded hover:bg-gray-800 transition-colors"
                                    title="Move down">
                                <svg class="w-4 h-4" fill="currentColor" viewBox="0 0 20 20">
                                    <path fill-rule="evenodd" d="M5.293 7.293a1 1 0 011.414 0L10 10.586l3.293-3.293a1 1 0 111.414 1.414l-4 4a1 1 0 01-1.414 0l-4-4a1 1 0 010-1.414z" clip-rule="evenodd"></path>
                                </svg>
                            </button>
                            
                            
                            <button type="button"
                                    @click="deletePhoto(photo.id)"
                                    class="bg-red-600 text-white p-2 rounded hover:bg-red-700 transition-colors"
                                    title="Delete">
                                <svg class="w-4 h-4" fill="currentColor" viewBox="0 0 20 20">
                                    <path fill-rule="evenodd" d="M9 2a1 1 0 000 2h2a1 1 0 100-2H9zM4 5a2 2 0 012-2v1a1 1 0 002 0V3h4v1a1 1 0 002 0V3a2 2 0 012 2v6a2 2 0 01-2 2H6a2 2 0 01-2-2V5zM8 8a1 1 0 012 0v3a1 1 0 11-2 0V8zm4 0a1 1 0 10-2 0v3a1 1 0 102 0V8z" clip-rule="evenodd"></path>
                                </svg>
                            </button>
                        </div>
                    </div>
                </div>
                
                
                <div x-show="!readOnly" class="p-2">
                    <input type="text"
                           :value="photo.alt || ''"
                           @blur="updateAlt(photo.id, $event.target.value)"
                           placeholder="{{ __('admin/photos.forms.placeholders.alt') }}"
                           class="w-full text-xs px-2 py-1 border border-gray-300 rounded focus:outline-none focus:ring-1 focus:ring-green-500">
                </div>
                
                
                <div x-show="readOnly && photo.alt" class="p-2">
                    <p class="text-xs text-gray-600">{{ __('admin/photos.fields.alt') }}: <span x-text="photo.alt"></span></p>
                </div>
            </div>
        </template>
    </div>

    
    <div x-show="photos.length === 0 && !loading" class="text-center py-8 text-gray-500">
        <svg class="w-16 h-16 text-gray-300 mb-2 mx-auto" fill="currentColor" viewBox="0 0 20 20">
            <path fill-rule="evenodd" d="M4 3a2 2 0 00-2 2v10a2 2 0 002 2h12a2 2 0 002-2V5a2 2 0 00-2-2H4zm12 12H4l4-8 3 6 2-4 3 6z" clip-rule="evenodd"></path>
        </svg>
        <p class="text-sm">{{ __('admin/photos.forms.messages.no_photos') }}</p>
    </div>

    
    @if($error)
        <span class="text-sm text-red-600">{{ $error }}</span>
    @endif

    
    <template x-show="!readOnly" x-for="photo in photos" :key="photo.id">
        <input type="hidden" :name="'photos[]'" :value="photo.id">
    </template>
</div>

@push('scripts')
<script>
    window.photoManagerTranslations_{{ $translationKey }} = {!! json_encode($translations, JSON_UNESCAPED_UNICODE | JSON_HEX_APOS) !!};
</script>
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
        translationKey: config.translationKey,
        readOnly: config.readOnly || false,
        get translations() {
            const key = 'photoManagerTranslations_' + this.translationKey;
            return window[key] || {};
        },

        init() {
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

                if (response.data && response.data.success !== false) {
                    const photosData = response.data.data || [];
                    this.photos = photosData.map(photo => ({
                        ...photo,
                        url: photo.url || this.getPhotoUrl(photo.file_path)
                    }));
                }
            } catch (error) {
                console.error('Failed to load photos:', error);
            }
        },

        getPhotoUrl(filePath) {
            if (!filePath) return '';
            if (filePath.startsWith('http://') || filePath.startsWith('https://')) {
                return filePath;
            }
            if (filePath.startsWith('storage/')) {
                return `/${filePath}`;
            }
            return `/storage/${filePath}`;
        },

        handleFileSelect(event) {
            const files = Array.from(event.target.files);
            this.uploadFiles(files);
            event.target.value = '';
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

                if (response.data && response.data.success !== false) {
                    const photoData = response.data.data || response.data;
                    const photo = {
                        ...photoData,
                        url: photoData.url || this.getPhotoUrl(photoData.file_path)
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
                const deleteUrl = `{{ route("admin.photos.destroy", ":id") }}`.replace(':id', photoId);
                const response = await window.axios.delete(deleteUrl);

                if (response.data && response.data.success !== false) {
                    this.photos = this.photos.filter(p => String(p.id) !== String(photoId));
                    if (window.Toast) {
                        window.Toast.success(this.translations.delete_success);
                    }
                } else {
                    throw new Error(response.data?.message || 'Delete failed');
                }
            } catch (error) {
                console.error('Delete error:', error);
                if (window.Toast) {
                    window.Toast.error(error.response?.data?.message || error.message || this.translations.delete_error);
                }
            }
        },

        async setPrimary(photoId) {
            try {
                const response = await window.axios.put(`{{ route("admin.photos.update", ":id") }}`.replace(':id', photoId), {
                    is_primary: true
                });

                if (response.data.success) {
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
                const temp2 = this.photos[index];
                this.photos[index] = this.photos[newIndex];
                this.photos[newIndex] = temp2;
                if (window.Toast) {
                    window.Toast.error(this.translations.reorder_error);
                }
            }
        },

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