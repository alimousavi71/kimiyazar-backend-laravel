@php
    $title = 'Form Example';
    $headerTitle = 'Sample Form with Upload & Select2';
@endphp

<x-layouts.admin :title="$title" :headerTitle="$headerTitle">
    <div class="space-y-6">
        
        <div class="bg-white rounded-xl shadow-sm border border-gray-200 p-6">
            <h2 class="text-2xl font-bold text-gray-900 mb-2">Sample Form with File Upload</h2>
            <p class="text-gray-600">
                This form demonstrates various input types including file upload and Select2 component with remote API support.
            </p>
        </div>

        
        <x-card>
            <x-slot name="title">User Registration Form</x-slot>
            
            <form id="sample-form" enctype="multipart/form-data" class="space-y-6">
                @csrf

                
                <div class="space-y-4">
                    <h3 class="text-lg font-semibold text-gray-900 border-b border-gray-200 pb-2">Basic Information</h3>
                    
                    <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
                        <x-form-group label="Full Name" required>
                            <x-input type="text" name="name" id="name" placeholder="Enter your full name" required class="w-full" />
                        </x-form-group>

                        <x-form-group label="Email Address" required>
                            <x-input type="email" name="email" id="email" placeholder="Enter your email" required class="w-full" />
                        </x-form-group>
                    </div>

                    <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
                        <x-form-group label="Phone Number">
                            <x-input type="tel" name="phone" id="phone" placeholder="Enter your phone number" class="w-full" />
                        </x-form-group>

                        <x-form-group label="Date of Birth">
                            <x-input type="date" name="birthdate" id="birthdate" class="w-full" />
                        </x-form-group>
                    </div>
                </div>

                
                <div class="space-y-4">
                    <h3 class="text-lg font-semibold text-gray-900 border-b border-gray-200 pb-2">Select2 Examples</h3>
                    
                    
                    <x-form-group label="Country (Simple Select)" required>
                        <x-select2 
                            name="country" 
                            id="country"
                            :options="[
                                ['value' => 'us', 'text' => 'United States'],
                                ['value' => 'uk', 'text' => 'United Kingdom'],
                                ['value' => 'ca', 'text' => 'Canada'],
                                ['value' => 'au', 'text' => 'Australia'],
                                ['value' => 'de', 'text' => 'Germany'],
                                ['value' => 'fr', 'text' => 'France'],
                                ['value' => 'it', 'text' => 'Italy'],
                                ['value' => 'es', 'text' => 'Spain'],
                            ]"
                            placeholder="Select a country"
                            allow-clear
                            required
                        />
                    </x-form-group>

                    
                    <x-form-group label="User (Remote API Select)" help="Type to search users from API">
                        <x-select2 
                            name="user_id" 
                            id="user-select"
                            remote-url="{{ route('api.users.search') }}"
                            remote-search
                            :min-input-length="2"
                            search-param="q"
                            value-key="id"
                            text-key="name"
                            placeholder="Search and select a user..."
                            allow-clear
                        />
                    </x-form-group>

                    
                    <x-form-group label="Skills (Multiple Select)" help="Select multiple skills">
                        <x-select2 
                            name="skills[]" 
                            id="skills-select"
                            :options="[
                                ['value' => 'php', 'text' => 'PHP'],
                                ['value' => 'js', 'text' => 'JavaScript'],
                                ['value' => 'python', 'text' => 'Python'],
                                ['value' => 'java', 'text' => 'Java'],
                                ['value' => 'react', 'text' => 'React'],
                                ['value' => 'vue', 'text' => 'Vue.js'],
                                ['value' => 'laravel', 'text' => 'Laravel'],
                                ['value' => 'node', 'text' => 'Node.js'],
                            ]"
                            placeholder="Select skills"
                            multiple
                            allow-clear
                        />
                    </x-form-group>
                </div>

                
                <div class="space-y-4">
                    <h3 class="text-lg font-semibold text-gray-900 border-b border-gray-200 pb-2">File Upload</h3>
                    
                    <x-form-group label="Profile Picture" help="Upload your profile picture (Max 2MB, JPG/PNG)">
                        <div class="space-y-2">
                            <input 
                                type="file" 
                                name="avatar" 
                                id="avatar" 
                                accept="image/jpeg,image/png,image/jpg"
                                class="block w-full text-sm text-gray-500 file:me-4 file:py-2 file:px-4 file:rounded-xl file:border-0 file:text-sm file:font-semibold file:bg-blue-50 file:text-blue-700 hover:file:bg-blue-100 cursor-pointer"
                            />
                            <div id="avatar-preview" class="hidden mt-2">
                                <img id="avatar-preview-img" src="" alt="Preview" class="w-32 h-32 object-cover rounded-lg border border-gray-200">
                            </div>
                        </div>
                    </x-form-group>

                    <x-form-group label="Documents" help="Upload multiple documents (PDF, DOC, DOCX)">
                        <input 
                            type="file" 
                            name="documents[]" 
                            id="documents" 
                            multiple
                            accept=".pdf,.doc,.docx"
                            class="block w-full text-sm text-gray-500 file:me-4 file:py-2 file:px-4 file:rounded-xl file:border-0 file:text-sm file:font-semibold file:bg-blue-50 file:text-blue-700 hover:file:bg-blue-100 cursor-pointer"
                        />
                        <div id="documents-list" class="mt-2 space-y-1"></div>
                    </x-form-group>
                </div>

                
                <div class="space-y-4">
                    <h3 class="text-lg font-semibold text-gray-900 border-b border-gray-200 pb-2">Additional Information</h3>
                    
                    <x-form-group label="Bio">
                        <x-textarea 
                            name="bio" 
                            id="bio" 
                            rows="4" 
                            placeholder="Tell us about yourself..."
                            class="w-full"
                        />
                    </x-form-group>

                    <x-form-group label="Website">
                        <x-input 
                            type="url" 
                            name="website" 
                            id="website" 
                            placeholder="https://example.com"
                            class="w-full"
                        />
                    </x-form-group>

                    <div class="flex items-center gap-2">
                        <input 
                            type="checkbox" 
                            name="terms" 
                            id="terms" 
                            required
                            class="w-4 h-4 text-blue-600 bg-gray-100 border-gray-300 rounded focus:ring-blue-500"
                        />
                        <label for="terms" class="text-sm text-gray-700">
                            I agree to the <a href="#" class="text-blue-600 hover:underline">Terms and Conditions</a>
                        </label>
                    </div>
                </div>

                
                <div class="flex items-center justify-end gap-3 pt-4 border-t border-gray-200">
                    <x-button variant="secondary" type="reset">Reset</x-button>
                    <x-button variant="primary" type="submit" id="submit-btn">
                        <span class="submit-text">Submit Form</span>
                        <span class="loading-text hidden">Submitting...</span>
                    </x-button>
                </div>
            </form>
        </x-card>

        
        <x-card>
            <x-slot name="title">Form Response</x-slot>
            <div id="form-response" class="hidden">
                <pre id="response-content" class="bg-gray-50 rounded-lg p-4 text-sm overflow-x-auto border border-gray-200"></pre>
            </div>
            <p id="no-response" class="text-gray-500 text-sm">Submit the form to see the response here.</p>
        </x-card>
    </div>

    @push('scripts')
    <script>
        document.addEventListener('DOMContentLoaded', function() {
            const form = document.getElementById('sample-form');
            const submitBtn = document.getElementById('submit-btn');
            const submitText = submitBtn.querySelector('.submit-text');
            const loadingText = submitBtn.querySelector('.loading-text');
            const responseDiv = document.getElementById('form-response');
            const responseContent = document.getElementById('response-content');
            const noResponse = document.getElementById('no-response');
            const avatarInput = document.getElementById('avatar');
            const avatarPreview = document.getElementById('avatar-preview');
            const avatarPreviewImg = document.getElementById('avatar-preview-img');
            const documentsInput = document.getElementById('documents');
            const documentsList = document.getElementById('documents-list');

            // Avatar preview
            if (avatarInput) {
                avatarInput.addEventListener('change', function(e) {
                    const file = e.target.files[0];
                    if (file) {
                        const reader = new FileReader();
                        reader.onload = function(e) {
                            avatarPreviewImg.src = e.target.result;
                            avatarPreview.classList.remove('hidden');
                        };
                        reader.readAsDataURL(file);
                    } else {
                        avatarPreview.classList.add('hidden');
                    }
                });
            }

            // Documents list
            if (documentsInput) {
                documentsInput.addEventListener('change', function(e) {
                    const files = Array.from(e.target.files);
                    documentsList.innerHTML = '';
                    
                    if (files.length > 0) {
                        files.forEach((file, index) => {
                            const div = document.createElement('div');
                            div.className = 'flex items-center gap-2 text-sm text-gray-700 bg-gray-50 px-3 py-2 rounded-lg';
                            div.innerHTML = `
                                <svg class="w-4 h-4 text-gray-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12h6m-6 4h6m2 5H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z"></path>
                                </svg>
                                <span class="flex-1">${file.name}</span>
                                <span class="text-gray-500">${(file.size / 1024).toFixed(2)} KB</span>
                            `;
                            documentsList.appendChild(div);
                        });
                    }
                });
            }

            // Form submission
            form.addEventListener('submit', async function(e) {
                e.preventDefault();

                // Disable submit button
                submitBtn.disabled = true;
                submitText.classList.add('hidden');
                loadingText.classList.remove('hidden');

                try {
                    const formData = new FormData(form);

                    const response = await window.axios.post('{{ route("api.form-example.submit") }}', formData, {
                        headers: {
                            'Content-Type': 'multipart/form-data'
                        }
                    });

                    // Show success
                    if (window.Toast) {
                        window.Toast.success('Form submitted successfully!');
                    }

                    // Display response
                    responseContent.textContent = JSON.stringify(response.data, null, 2);
                    responseDiv.classList.remove('hidden');
                    noResponse.classList.add('hidden');

                } catch (error) {
                    console.error('Form submission error:', error);
                    // Error is handled by axios interceptor
                } finally {
                    // Re-enable submit button
                    submitBtn.disabled = false;
                    submitText.classList.remove('hidden');
                    loadingText.classList.add('hidden');
                }
            });
        });
    </script>
    @endpush
</x-layouts.admin>
