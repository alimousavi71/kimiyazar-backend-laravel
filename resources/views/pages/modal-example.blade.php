@php
    $title = 'Modal Examples';
    $headerTitle = 'Modal Component Examples';
@endphp

<x-layouts.admin :title="$title" :headerTitle="$headerTitle">
    <div class="space-y-6" x-data>
        <!-- Header -->
        <div class="bg-white rounded-xl shadow-sm border border-gray-200 p-6">
            <h2 class="text-2xl font-bold text-gray-900 mb-2">Modal Component Examples</h2>
            <p class="text-gray-600">
                This page demonstrates various modal use cases including different sizes, forms, confirmations, and
                more.
            </p>
        </div>

        <!-- Basic Modals -->
        <x-card>
            <x-slot name="title">Basic Modals</x-slot>

            <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-4 gap-4">
                <!-- Small Modal -->
                <div>
                    <h4 class="text-sm font-medium text-gray-700 mb-2">Small Modal</h4>
                    <button type="button"
                        class="inline-flex items-center justify-center rounded-xl font-medium transition-all duration-200 disabled:opacity-50 disabled:cursor-not-allowed shadow-sm hover:shadow-md px-3.5 py-2 text-base bg-blue-600 text-white hover:bg-blue-700 focus:ring-2 focus:ring-blue-500 focus:ring-offset-2"
                        @click="$dispatch('open-modal', 'small-modal')">
                        Open Small
                    </button>
                </div>

                <!-- Medium Modal -->
                <div>
                    <h4 class="text-sm font-medium text-gray-700 mb-2">Medium Modal</h4>
                    <button type="button"
                        class="inline-flex items-center justify-center rounded-xl font-medium transition-all duration-200 disabled:opacity-50 disabled:cursor-not-allowed shadow-sm hover:shadow-md px-3.5 py-2 text-base bg-blue-600 text-white hover:bg-blue-700 focus:ring-2 focus:ring-blue-500 focus:ring-offset-2"
                        @click="$dispatch('open-modal', 'medium-modal')">
                        Open Medium
                    </button>
                </div>

                <!-- Large Modal -->
                <div>
                    <h4 class="text-sm font-medium text-gray-700 mb-2">Large Modal</h4>
                    <button type="button"
                        class="inline-flex items-center justify-center rounded-xl font-medium transition-all duration-200 disabled:opacity-50 disabled:cursor-not-allowed shadow-sm hover:shadow-md px-3.5 py-2 text-base bg-blue-600 text-white hover:bg-blue-700 focus:ring-2 focus:ring-blue-500 focus:ring-offset-2"
                        @click="$dispatch('open-modal', 'large-modal')">
                        Open Large
                    </button>
                </div>

                <!-- Extra Large Modal -->
                <div>
                    <h4 class="text-sm font-medium text-gray-700 mb-2">Extra Large Modal</h4>
                    <button type="button"
                        class="inline-flex items-center justify-center rounded-xl font-medium transition-all duration-200 disabled:opacity-50 disabled:cursor-not-allowed shadow-sm hover:shadow-md px-3.5 py-2 text-base bg-blue-600 text-white hover:bg-blue-700 focus:ring-2 focus:ring-blue-500 focus:ring-offset-2"
                        @click="$dispatch('open-modal', 'xl-modal')">
                        Open XL
                    </button>
                </div>
            </div>
        </x-card>

        <!-- Modal with Form -->
        <x-card>
            <x-slot name="title">Modal with Form</x-slot>

            <div class="space-y-4">
                <p class="text-sm text-gray-600">Open a modal containing a form with validation.</p>
                <button type="button"
                    class="inline-flex items-center justify-center rounded-xl font-medium transition-all duration-200 disabled:opacity-50 disabled:cursor-not-allowed shadow-sm hover:shadow-md px-3.5 py-2 text-base bg-blue-600 text-white hover:bg-blue-700 focus:ring-2 focus:ring-blue-500 focus:ring-offset-2"
                    @click="$dispatch('open-modal', 'form-modal')">
                    Open Form Modal
                </button>
            </div>
        </x-card>

        <!-- Confirmation Modal -->
        <x-card>
            <x-slot name="title">Confirmation Modal</x-slot>

            <div class="space-y-4">
                <p class="text-sm text-gray-600">Modal for confirming actions like delete operations.</p>
                <button type="button"
                    class="inline-flex items-center justify-center rounded-xl font-medium transition-all duration-200 disabled:opacity-50 disabled:cursor-not-allowed shadow-sm hover:shadow-md px-3.5 py-2 text-base bg-red-600 text-white hover:bg-red-700 focus:ring-2 focus:ring-red-500 focus:ring-offset-2"
                    @click="$dispatch('open-modal', 'confirm-modal')">
                    Delete Item
                </button>
            </div>
        </x-card>

        <!-- Modal with Content -->
        <x-card>
            <x-slot name="title">Modal with Rich Content</x-slot>

            <div class="space-y-4">
                <p class="text-sm text-gray-600">Modal displaying detailed information or content.</p>
                <button type="button"
                    class="inline-flex items-center justify-center rounded-xl font-medium transition-all duration-200 disabled:opacity-50 disabled:cursor-not-allowed shadow-sm hover:shadow-md px-3.5 py-2 text-base bg-blue-600 text-white hover:bg-blue-700 focus:ring-2 focus:ring-blue-500 focus:ring-offset-2"
                    @click="$dispatch('open-modal', 'content-modal')">
                    View Details
                </button>
            </div>
        </x-card>

        <!-- Modal without Title -->
        <x-card>
            <x-slot name="title">Modal without Title</x-slot>

            <div class="space-y-4">
                <p class="text-sm text-gray-600">Modal without a title header, close button in corner.</p>
                <button type="button"
                    class="inline-flex items-center justify-center rounded-xl font-medium transition-all duration-200 disabled:opacity-50 disabled:cursor-not-allowed shadow-sm hover:shadow-md px-3.5 py-2 text-base bg-gray-200 text-gray-900 hover:bg-gray-300 focus:ring-2 focus:ring-gray-500 focus:ring-offset-2"
                    @click="$dispatch('open-modal', 'no-title-modal')">
                    Open No Title Modal
                </button>
            </div>
        </x-card>

        <!-- JavaScript Example -->
        <x-card>
            <x-slot name="title">JavaScript API</x-slot>

            <div class="space-y-4">
                <p class="text-sm text-gray-600 mb-4">You can also open modals using JavaScript:</p>
                <div class="space-y-2">
                    <x-button variant="primary" onclick="openModal('js-modal')">
                        Open via JavaScript
                    </x-button>
                    <pre class="bg-gray-50 rounded-lg p-4 text-sm overflow-x-auto border border-gray-200"><code>// Open modal
document.dispatchEvent(new CustomEvent('open-modal', {
    detail: 'modal-id'
}));

// Close modal
document.dispatchEvent(new CustomEvent('close-modal', {
    detail: 'modal-id'
}));</code></pre>
                </div>
            </div>
        </x-card>
    </div>

    <!-- Small Modal -->
    <x-modal id="small-modal" title="Small Modal" size="sm">
        <p class="text-gray-700">This is a small modal (max-w-md). Perfect for simple confirmations or short messages.
        </p>
        <div class="flex items-center justify-end gap-3 pt-4 mt-4 border-t border-gray-200">
            <x-button variant="secondary" @click="$dispatch('close-modal', 'small-modal')">
                Close
            </x-button>
        </div>
    </x-modal>

    <!-- Medium Modal -->
    <x-modal id="medium-modal" title="Medium Modal" size="md">
        <p class="text-gray-700 mb-4">This is a medium modal (max-w-lg). Good for forms and moderate content.</p>
        <div class="bg-gray-50 rounded-lg p-4 mb-4">
            <p class="text-sm text-gray-600">This modal size is the default and works well for most use cases.</p>
        </div>
        <div class="flex items-center justify-end gap-3 pt-4 mt-4 border-t border-gray-200">
            <x-button variant="secondary" @click="$dispatch('close-modal', 'medium-modal')">
                Cancel
            </x-button>
            <x-button variant="primary" @click="$dispatch('close-modal', 'medium-modal')">
                Confirm
            </x-button>
        </div>
    </x-modal>

    <!-- Large Modal -->
    <x-modal id="large-modal" title="Large Modal" size="lg">
        <div class="space-y-4">
            <p class="text-gray-700">This is a large modal (max-w-2xl). Great for detailed forms or extensive content.
            </p>
            <div class="grid grid-cols-2 gap-4">
                <div class="bg-blue-50 rounded-lg p-4">
                    <h4 class="font-semibold text-blue-900 mb-2">Feature 1</h4>
                    <p class="text-sm text-blue-700">Description of feature one</p>
                </div>
                <div class="bg-green-50 rounded-lg p-4">
                    <h4 class="font-semibold text-green-900 mb-2">Feature 2</h4>
                    <p class="text-sm text-green-700">Description of feature two</p>
                </div>
            </div>
            <div class="flex items-center justify-end gap-3 pt-4 mt-4 border-t border-gray-200">
                <x-button variant="secondary" @click="$dispatch('close-modal', 'large-modal')">
                    Close
                </x-button>
            </div>
        </div>
    </x-modal>

    <!-- Extra Large Modal -->
    <x-modal id="xl-modal" title="Extra Large Modal" size="xl">
        <div class="space-y-4">
            <p class="text-gray-700">This is an extra large modal (max-w-4xl). Perfect for complex forms, tables, or
                detailed views.</p>
            <div class="grid grid-cols-3 gap-4">
                <div class="bg-purple-50 rounded-lg p-4">
                    <h4 class="font-semibold text-purple-900 mb-2">Column 1</h4>
                    <p class="text-sm text-purple-700">Content here</p>
                </div>
                <div class="bg-pink-50 rounded-lg p-4">
                    <h4 class="font-semibold text-pink-900 mb-2">Column 2</h4>
                    <p class="text-sm text-pink-700">Content here</p>
                </div>
                <div class="bg-indigo-50 rounded-lg p-4">
                    <h4 class="font-semibold text-indigo-900 mb-2">Column 3</h4>
                    <p class="text-sm text-indigo-700">Content here</p>
                </div>
            </div>
            <div class="flex items-center justify-end gap-3 pt-4 mt-4 border-t border-gray-200">
                <x-button variant="secondary" @click="$dispatch('close-modal', 'xl-modal')">
                    Close
                </x-button>
            </div>
        </div>
    </x-modal>

    <!-- Form Modal -->
    <x-modal id="form-modal" title="Create New Item" size="md">
        <form class="space-y-4" onsubmit="window.handleFormSubmit(event); return false;">
            <x-form-group label="Name" required>
                <x-input type="text" name="name" placeholder="Enter name" required class="w-full" />
            </x-form-group>

            <x-form-group label="Email" required>
                <x-input type="email" name="email" placeholder="Enter email" required class="w-full" />
            </x-form-group>

            <x-form-group label="Category">
                <x-select name="category" class="w-full">
                    <option value="">Select category</option>
                    <option value="1">Category 1</option>
                    <option value="2">Category 2</option>
                    <option value="3">Category 3</option>
                </x-select>
            </x-form-group>

            <x-form-group label="Description">
                <x-textarea name="description" rows="4" placeholder="Enter description" class="w-full"></x-textarea>
            </x-form-group>

            <div class="flex items-center gap-2">
                <input type="checkbox" id="active" name="active"
                    class="w-4 h-4 text-blue-600 bg-gray-100 border-gray-300 rounded focus:ring-blue-500">
                <label for="active" class="text-sm text-gray-700">Mark as active</label>
            </div>

            <div class="flex items-center justify-end gap-3 pt-4 mt-4 border-t border-gray-200">
                <x-button variant="secondary" type="button" @click="$dispatch('close-modal', 'form-modal')">
                    Cancel
                </x-button>
                <x-button variant="primary" type="submit">
                    Create Item
                </x-button>
            </div>
        </form>
    </x-modal>

    <!-- Confirmation Modal -->
    <x-modal id="confirm-modal" title="Confirm Delete" size="sm">
        <div class="space-y-4">
            <div class="flex items-start gap-3">
                <div class="flex-shrink-0">
                    <div class="w-10 h-10 rounded-full bg-red-100 flex items-center justify-center">
                        <x-icon name="alert" size="lg" class="text-red-600" />
                    </div>
                </div>
                <div class="flex-1">
                    <h4 class="text-lg font-semibold text-gray-900 mb-1">Are you sure?</h4>
                    <p class="text-sm text-gray-600">
                        This action cannot be undone. This will permanently delete the item and all associated data.
                    </p>
                </div>
            </div>
            <div class="flex items-center justify-end gap-3 pt-4 mt-4 border-t border-gray-200">
                <x-button variant="secondary" @click="$dispatch('close-modal', 'confirm-modal')">
                    Cancel
                </x-button>
                <x-button variant="danger" onclick="window.handleDelete()">
                    Delete
                </x-button>
            </div>
        </div>
    </x-modal>

    <!-- Content Modal -->
    <x-modal id="content-modal" title="Item Details" size="lg">
        <div class="space-y-6">
            <!-- Header Info -->
            <div class="flex items-center gap-4 pb-4 border-b border-gray-200">
                <div
                    class="w-16 h-16 rounded-xl bg-gradient-to-br from-blue-500 to-blue-600 flex items-center justify-center text-white font-bold text-xl">
                    JD
                </div>
                <div>
                    <h4 class="text-lg font-semibold text-gray-900">John Doe</h4>
                    <p class="text-sm text-gray-600">john.doe@example.com</p>
                    <p class="text-sm text-gray-500">Member since January 2024</p>
                </div>
            </div>

            <!-- Details Grid -->
            <div class="grid grid-cols-2 gap-4">
                <div>
                    <label class="text-xs font-medium text-gray-500 uppercase">Status</label>
                    <p class="text-sm text-gray-900 mt-1">Active</p>
                </div>
                <div>
                    <label class="text-xs font-medium text-gray-500 uppercase">Role</label>
                    <p class="text-sm text-gray-900 mt-1">Administrator</p>
                </div>
                <div>
                    <label class="text-xs font-medium text-gray-500 uppercase">Last Login</label>
                    <p class="text-sm text-gray-900 mt-1">2 hours ago</p>
                </div>
                <div>
                    <label class="text-xs font-medium text-gray-500 uppercase">Total Orders</label>
                    <p class="text-sm text-gray-900 mt-1">127</p>
                </div>
            </div>

            <!-- Activity -->
            <div>
                <h5 class="text-sm font-semibold text-gray-900 mb-3">Recent Activity</h5>
                <div class="space-y-2">
                    <div class="flex items-center gap-3 p-3 bg-gray-50 rounded-lg">
                        <x-icon name="check" size="sm" class="text-green-600" />
                        <div class="flex-1">
                            <p class="text-sm text-gray-900">Order #1234 completed</p>
                            <p class="text-xs text-gray-500">2 hours ago</p>
                        </div>
                    </div>
                    <div class="flex items-center gap-3 p-3 bg-gray-50 rounded-lg">
                        <x-icon name="edit" size="sm" class="text-blue-600" />
                        <div class="flex-1">
                            <p class="text-sm text-gray-900">Profile updated</p>
                            <p class="text-xs text-gray-500">1 day ago</p>
                        </div>
                    </div>
                </div>
            </div>

            <div class="flex items-center justify-end gap-3 pt-4 mt-4 border-t border-gray-200">
                <x-button variant="secondary" @click="$dispatch('close-modal', 'content-modal')">
                    Close
                </x-button>
                <x-button variant="primary" @click="$dispatch('close-modal', 'content-modal')">
                    Edit Profile
                </x-button>
            </div>
        </div>
    </x-modal>

    <!-- No Title Modal -->
    <x-modal id="no-title-modal" size="md">
        <div class="space-y-4">
            <div class="text-center">
                <div class="w-16 h-16 rounded-full bg-blue-100 flex items-center justify-center mx-auto mb-4">
                    <x-icon name="info-circle" size="xl" class="text-blue-600" />
                </div>
                <h3 class="text-lg font-semibold text-gray-900 mb-2">No Title Modal</h3>
                <p class="text-sm text-gray-600">
                    This modal doesn't have a title header. The close button is positioned in the top-right corner.
                </p>
            </div>
            <div class="flex items-center justify-center gap-3 pt-4 mt-4 border-t border-gray-200">
                <x-button variant="primary" @click="$dispatch('close-modal', 'no-title-modal')">
                    Got it
                </x-button>
            </div>
        </div>
    </x-modal>

    <!-- JavaScript Modal -->
    <x-modal id="js-modal" title="JavaScript Opened Modal" size="md">
        <p class="text-gray-700">This modal was opened using JavaScript instead of Alpine.js directives.</p>
        <div class="flex items-center justify-end gap-3 pt-4 mt-4 border-t border-gray-200">
            <x-button variant="secondary" onclick="closeModal('js-modal')">
                Close
            </x-button>
        </div>
    </x-modal>

    <script>
        // Helper functions for opening/closing modals via JavaScript
        // Define immediately so they're available for onclick handlers
        window.openModal = function (modalId) {
            const modal = document.getElementById(modalId);
            if (modal) {
                // Try to set Alpine.js data directly first
                if (window.Alpine && window.Alpine.$data) {
                    try {
                        const modalData = window.Alpine.$data(modal);
                        if (modalData && typeof modalData.open === "boolean") {
                            modalData.open = true;
                            return;
                        }
                    } catch (error) {
                        console.warn('Alpine.js direct access failed, using event:', error);
                    }
                }

                // Fallback: dispatch event to window for Alpine listeners
                const event = new CustomEvent('open-modal', {
                    detail: modalId,
                    bubbles: true,
                    cancelable: true
                });
                window.dispatchEvent(event);
                document.dispatchEvent(event);
            } else {
                console.error('Modal not found:', modalId);
            }
        };

        window.closeModal = function (modalId) {
            const modal = document.getElementById(modalId);
            if (modal) {
                // Try to set Alpine.js data directly first
                if (window.Alpine && window.Alpine.$data) {
                    try {
                        const modalData = window.Alpine.$data(modal);
                        if (modalData && typeof modalData.open === "boolean") {
                            modalData.open = false;
                            return;
                        }
                    } catch (error) {
                        console.warn('Alpine.js direct access failed, using event:', error);
                    }
                }

                // Fallback: dispatch event to window for Alpine listeners
                const event = new CustomEvent('close-modal', {
                    detail: modalId,
                    bubbles: true,
                    cancelable: true
                });
                window.dispatchEvent(event);
                document.dispatchEvent(event);
            } else {
                console.error('Modal not found:', modalId);
            }
        };

        // Handle form submission in modal
        window.handleFormSubmit = function (event) {
            event.preventDefault();
            const formData = new FormData(event.target);

            if (window.Toast) {
                window.Toast.success('Form submitted successfully!');
            }

            window.closeModal('form-modal');
        };

        // Handle delete action
        window.handleDelete = function () {
            if (window.Toast) {
                window.Toast.success('Item deleted successfully!');
            }

            window.closeModal('confirm-modal');
        };
    </script>
</x-layouts.admin>