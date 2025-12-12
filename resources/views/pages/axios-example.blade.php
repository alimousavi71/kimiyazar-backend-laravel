@php
    $title = 'Axios Examples';
    $headerTitle = 'Axios Interceptor & Form Examples';
@endphp

<x-layouts.admin :title="$title" :headerTitle="$headerTitle">
    <div class="space-y-6">
        <!-- Header -->
        <div class="bg-white rounded-xl shadow-sm border border-gray-200 p-6">
            <h2 class="text-2xl font-bold text-gray-900 mb-2">Axios Interceptor & Form Examples</h2>
            <p class="text-gray-600">
                This page demonstrates Axios interceptors for centralized error handling and form submission examples.
            </p>
        </div>

        <!-- Form Example -->
        <x-card>
            <div class="p-6">
                <h3 class="text-lg font-semibold text-gray-900 mb-4">Form Submission Example</h3>
                <form id="axios-form" class="space-y-4">
                    @csrf
                    <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
                        <x-form-group label="Full Name" required>
                            <x-input type="text" name="name" id="name" placeholder="Enter your full name" required
                                class="w-full" />
                        </x-form-group>

                        <x-form-group label="Email Address" required>
                            <x-input type="email" name="email" id="email" placeholder="Enter your email" required
                                class="w-full" />
                        </x-form-group>
                    </div>

                    <x-form-group label="Age (Optional)">
                        <x-input type="number" name="age" id="age" placeholder="Enter your age" min="18" max="120"
                            class="w-full" />
                    </x-form-group>

                    <x-form-group label="Message" required>
                        <x-textarea name="message" id="message" rows="4"
                            placeholder="Enter your message (min 10 characters)" required class="w-full"></x-textarea>
                    </x-form-group>

                    <div class="flex items-center gap-3">
                        <x-button type="submit" variant="primary" size="lg" id="submit-btn">
                            <span class="flex items-center gap-2">
                                <x-icon name="paper-plane" size="sm" />
                                Submit Form
                            </span>
                        </x-button>
                        <x-button type="button" variant="secondary" size="lg" onclick="resetForm()">
                            <span class="flex items-center gap-2">
                                <x-icon name="refresh" size="sm" />
                                Reset
                            </span>
                        </x-button>
                    </div>
                </form>

                <!-- Response Display -->
                <div id="response-display" class="mt-6 hidden">
                    <h4 class="font-medium text-gray-900 mb-2">Response:</h4>
                    <pre
                        class="bg-gray-50 rounded-lg p-4 text-sm overflow-x-auto border border-gray-200"><code id="response-content"></code></pre>
                </div>
            </div>
        </x-card>

        <!-- API Test Examples -->
        <x-card>
            <div class="p-6">
                <h3 class="text-lg font-semibold text-gray-900 mb-4">API Test Examples</h3>
                <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-4">
                    <x-button variant="primary" size="md" class="w-full" onclick="testGetRequest()">
                        <span class="flex items-center justify-center gap-2">
                            <x-icon name="download" size="sm" />
                            Test GET Request
                        </span>
                    </x-button>

                    <x-button variant="success" size="md" class="w-full" onclick="testPostRequest()">
                        <span class="flex items-center justify-center gap-2">
                            <x-icon name="upload" size="sm" />
                            Test POST Request
                        </span>
                    </x-button>

                    <x-button variant="danger" size="md" class="w-full" onclick="testErrorRequest('500')">
                        <span class="flex items-center justify-center gap-2">
                            <x-icon name="error-circle" size="sm" />
                            Test 500 Error
                        </span>
                    </x-button>

                    <x-button variant="secondary" size="md" class="w-full" onclick="testErrorRequest('422')">
                        <span class="flex items-center justify-center gap-2">
                            <x-icon name="error-circle" size="sm" />
                            Test 422 Validation
                        </span>
                    </x-button>

                    <x-button variant="secondary" size="md" class="w-full" onclick="testErrorRequest('401')">
                        <span class="flex items-center justify-center gap-2">
                            <x-icon name="lock" size="sm" />
                            Test 401 Unauthorized
                        </span>
                    </x-button>

                    <x-button variant="secondary" size="md" class="w-full" onclick="testErrorRequest('404')">
                        <span class="flex items-center justify-center gap-2">
                            <x-icon name="file-blank" size="sm" />
                            Test 404 Not Found
                        </span>
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
                        <h4 class="font-medium text-gray-900 mb-2">Form Submission with Axios</h4>
                        <pre class="bg-gray-50 rounded-lg p-4 text-sm overflow-x-auto border border-gray-200"><code>// POST request with form data
const formData = new FormData(formElement);
window.axios.post('/api/example', formData)
    .then(response => {
        console.log('Success:', response.data);
        // Response interceptor handles success toast
    })
    .catch(error => {
        // Response interceptor handles error toast
        console.error('Error:', error);
    });</code></pre>
                    </div>

                    <div>
                        <h4 class="font-medium text-gray-900 mb-2">GET Request</h4>
                        <pre class="bg-gray-50 rounded-lg p-4 text-sm overflow-x-auto border border-gray-200"><code>// Simple GET request
window.axios.get('/api/example')
    .then(response => {
        console.log('Data:', response.data);
    });</code></pre>
                    </div>

                    <div>
                        <h4 class="font-medium text-gray-900 mb-2">Request with Custom Config</h4>
                        <pre class="bg-gray-50 rounded-lg p-4 text-sm overflow-x-auto border border-gray-200"><code>// Request without loading indicator
window.axios.post('/api/example', data, {
    showLoading: false  // Disable loading indicator
});

// Request with custom headers
window.axios.post('/api/example', data, {
    headers: {
        'Custom-Header': 'value'
    }
});</code></pre>
                    </div>
                </div>
            </div>
        </x-card>
    </div>

    @push('scripts')
        <script>
            // Form submission handler
            document.getElementById('axios-form').addEventListener('submit', async function (e) {
                e.preventDefault();

                const form = e.target;
                const submitBtn = document.getElementById('submit-btn');
                const responseDisplay = document.getElementById('response-display');
                const responseContent = document.getElementById('response-content');

                // Store original button content
                const originalContent = submitBtn.innerHTML;

                // Disable submit button
                submitBtn.disabled = true;
                submitBtn.innerHTML = '<span class="flex items-center gap-2"><span class="animate-spin">⏳</span> Submitting...</span>';

                try {
                    const formData = new FormData(form);

                    const response = await window.axios.post('/api/example', formData);

                    // Show response
                    responseDisplay.classList.remove('hidden');
                    responseContent.textContent = JSON.stringify(response.data, null, 2);

                    // Reset form on success
                    setTimeout(() => {
                        form.reset();
                        responseDisplay.classList.add('hidden');
                    }, 3000);

                } catch (error) {
                    // Error is handled by interceptor, but we can show response here too
                    if (error.response) {
                        responseDisplay.classList.remove('hidden');
                        responseContent.textContent = JSON.stringify(error.response.data, null, 2);
                    }
                } finally {
                    // Re-enable submit button
                    submitBtn.disabled = false;
                    submitBtn.innerHTML = originalContent;
                }
            });

            // Reset form function
            function resetForm() {
                document.getElementById('axios-form').reset();
                document.getElementById('response-display').classList.add('hidden');
            }

            // Test GET request
            async function testGetRequest() {
                try {
                    const response = await window.axios.get('/api/example');
                    console.log('GET Response:', response.data);
                } catch (error) {
                    console.error('GET Error:', error);
                }
            }

            // Test POST request
            async function testPostRequest() {
                try {
                    const response = await window.axios.post('/api/example', {
                        name: 'Test User',
                        email: 'test@example.com',
                        message: 'This is a test message from Axios',
                    });
                    console.log('POST Response:', response.data);
                } catch (error) {
                    console.error('POST Error:', error);
                }
            }

            // Test error requests
            async function testErrorRequest(type) {
                try {
                    await window.axios.get(`/api/example/test-error?type=${type}`);
                } catch (error) {
                    // Error is handled by interceptor
                    console.error('Error Response:', error.response);
                }
            }
        </script>
    @endpush
</x-layouts.admin>