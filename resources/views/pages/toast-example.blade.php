@php
    $title = 'Toast Examples';
    $headerTitle = 'Toast Notification Examples';
@endphp

<x-layouts.admin :title="$title" :headerTitle="$headerTitle">
    <div class="space-y-6">
        <!-- Header -->
        <div class="bg-white rounded-xl shadow-sm border border-gray-200 p-6">
            <h2 class="text-2xl font-bold text-gray-900 mb-2">Toast Notification Examples</h2>
            <p class="text-gray-600">
                This page demonstrates the custom Toast notification system with various examples.
            </p>
        </div>

        <!-- Custom Toast Examples -->
        <x-card>
            <div class="p-6">
                <h3 class="text-lg font-semibold text-gray-900 mb-4">Custom Toast System</h3>
                <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-4 gap-4">
                    <x-button variant="success" size="md" class="w-full"
                        onclick="window.Toast?.success('Operation completed successfully!')">
                        Success Toast
                    </x-button>
                    <x-button variant="danger" size="md" class="w-full"
                        onclick="window.Toast?.error('Something went wrong!')">
                        Error Toast
                    </x-button>
                    <x-button variant="secondary" size="md" class="w-full"
                        onclick="window.Toast?.warning('Please check your input')">
                        Warning Toast
                    </x-button>
                    <x-button variant="primary" size="md" class="w-full"
                        onclick="window.Toast?.info('Here is some information')">
                        Info Toast
                    </x-button>
                </div>
            </div>
        </x-card>

        <!-- Advanced Toast Examples -->
        <x-card>
            <div class="p-6">
                <h3 class="text-lg font-semibold text-gray-900 mb-4">Advanced Toast Examples</h3>
                <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-4">
                    <x-button variant="outline" size="md" class="w-full"
                        onclick="window.Toast?.success('Operation completed successfully!', 3000)">
                        Custom Duration (3s)
                    </x-button>
                    <x-button variant="outline" size="md" class="w-full"
                        onclick="window.Toast?.info('This is a longer message that demonstrates how the toast handles multiple lines of text content.', 5000)">
                        Long Message
                    </x-button>
                    <x-button variant="outline" size="md" class="w-full"
                        onclick="window.Toast?.success('First toast'); setTimeout(() => window.Toast?.info('Second toast'), 500); setTimeout(() => window.Toast?.warning('Third toast'), 1000)">
                        Multiple Toasts
                    </x-button>
                </div>
            </div>
        </x-card>

        <!-- Code Examples -->
        <x-card>
            <div class="p-6">
                <h3 class="text-lg font-semibold text-gray-900 mb-4">Usage Examples</h3>
                <div class="space-y-4">
                    <div>
                        <h4 class="font-medium text-gray-900 mb-2">Basic Usage</h4>
                        <pre class="bg-gray-50 rounded-lg p-4 text-sm overflow-x-auto"><code>// Success
window.Toast.success('Operation completed!');

// Error
window.Toast.error('Something went wrong!');

// Warning
window.Toast.warning('Please check your input');

// Info
window.Toast.info('Here is some information');</code></pre>
                    </div>
                    <div>
                        <h4 class="font-medium text-gray-900 mb-2">Advanced Usage</h4>
                        <pre class="bg-gray-50 rounded-lg p-4 text-sm overflow-x-auto border border-gray-200"><code>// Custom duration
window.Toast.success('Message', 3000); // 3 seconds

// Show multiple toasts
window.Toast.success('First message');
setTimeout(() => window.Toast.info('Second message'), 500);

// In async functions
async function submitForm() {
    try {
        const response = await fetch('/api/submit');
        window.Toast.success('Form submitted!');
    } catch (error) {
        window.Toast.error('Submission failed!');
    }
}</code></pre>
                    </div>
                </div>
            </div>
        </x-card>
    </div>

</x-layouts.admin>