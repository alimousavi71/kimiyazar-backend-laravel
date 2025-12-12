@props([
    'id', 
    'routeName',
    'title' => null,
    'rowSelector' => null, // e.g., 'tr[data-admin-id="__ID__"]' or 'tr[data-user-id="__ID__"]'
])

@php
    $title = $title ?? __('admin/components.delete_modal.title');
    $message = __('admin/components.delete_modal.message');
    $andData = __('admin/components.delete_modal.and_data');
    $deleting = __('admin/components.delete_modal.deleting');
    $cancel = __('admin/components.buttons.cancel');
    $delete = __('admin/components.buttons.delete');
@endphp

<x-modal :id="$id" :title="$title" size="sm">
    <div class="space-y-4" 
        x-data="deleteModalData('{{ $id }}', '{{ route($routeName, '__ID__') }}', {{ $rowSelector ? json_encode($rowSelector) : 'null' }})"
        @open-modal.window="handleModalOpen($event)">
        <div class="flex items-start gap-3">
            <div class="shrink-0">
                <div class="w-10 h-10 rounded-full bg-red-100 flex items-center justify-center">
                    <x-icon name="error-circle" size="xl" class="text-red-600" />
                </div>
            </div>
            <div class="flex-1">
                <h4 class="text-lg font-semibold text-gray-900 mb-1">{{ __('admin/components.delete_modal.title') }}</h4>
                <p class="text-sm text-gray-600">
                    {{ $message }}
                    <strong x-text="itemName"></strong> {{ $andData }}
                </p>
            </div>
        </div>
        <div class="flex items-center justify-end gap-3 pt-4 mt-4 border-t border-gray-200">
            <x-button variant="secondary" type="button" x-bind:disabled="deleting"
                @click="deleting = false; $dispatch('close-modal', '{{ $id }}')">
                {{ $cancel }}
            </x-button>
            <x-button variant="danger" type="button" x-bind:disabled="deleting" @click="deleteItem()">
                <span x-show="!deleting">{{ $delete }}</span>
                <span x-show="deleting">{{ $deleting }}</span>
            </x-button>
        </div>
    </div>
</x-modal>

<script>
function deleteModalData(modalId, routeUrl, rowSelector) {
    return {
        deleting: false,
        itemId: null,
        itemName: '',
        
        handleModalOpen(event) {
            if (event.detail === modalId) {
                this.deleting = false;
                this.itemId = window.deleteData?.id || null;
                this.itemName = window.deleteData?.name || '';
            }
        },
        
        deleteItem() {
            this.deleting = true;
            const deleteUrl = routeUrl.replace('__ID__', this.itemId);
            
            window.axios.delete(deleteUrl, {
                headers: {
                    'Accept': 'application/json',
                    'X-Requested-With': 'XMLHttpRequest'
                }
            })
            .then(response => {
                this.deleting = false;
                this.$dispatch('close-modal', modalId);
                
                // Remove row with fade animation
                if (rowSelector) {
                    const selector = rowSelector.replace('__ID__', this.itemId);
                    const row = document.querySelector(selector);
                    if (row) {
                        row.style.transition = 'opacity 0.3s ease-out';
                        row.style.opacity = '0';
                        setTimeout(() => row.remove(), 300);
                    } else {
                        window.location.reload();
                    }
                } else {
                    window.location.reload();
                }
            })
            .catch(error => {
                this.deleting = false;
            });
        }
    };
}
</script>

