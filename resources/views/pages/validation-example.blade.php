<x-layouts.admin header-title="Validation Examples" :breadcrumbs="[
        ['label' => 'Dashboard', 'url' => route('admin.dashboard')],
        ['label' => 'Validation Examples']
    ]">
    @vite('resources/js/validation-example.js')

    <div class="space-y-6">
        <!-- Basic Validation Example -->
        <x-card>
            <x-slot name="title">Basic Form Validation</x-slot>
            <x-slot name="footer">
                <p class="text-xs text-gray-500">Simple validation with required fields and email validation</p>
            </x-slot>

            <form id="basic-validation-form" class="space-y-4">
                <x-input id="basic-name" label="Full Name" name="name" placeholder="Enter your full name" />
                <x-input id="basic-email" label="Email" type="email" name="email" placeholder="Enter your email" />
                <x-input id="basic-password" label="Password" type="password" name="password"
                    placeholder="Enter your password" />

                <div class="flex items-center justify-end gap-3 pt-4 border-t border-gray-200">
                    <x-button variant="secondary" type="reset">Reset</x-button>
                    <x-button variant="primary" type="submit">Submit</x-button>
                </div>
            </form>
        </x-card>

        <!-- Advanced Validation Example -->
        <x-card>
            <x-slot name="title">Advanced Form Validation</x-slot>
            <x-slot name="footer">
                <p class="text-xs text-gray-500">Complex validation with custom rules, regex patterns, and password
                    matching</p>
            </x-slot>

            <form id="advanced-validation-form" class="space-y-4">
                <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
                    <x-input id="advanced-username" label="Username" name="username"
                        placeholder="Enter username (3-20 chars, alphanumeric)" />
                    <x-input id="advanced-email" label="Email" type="email" name="email"
                        placeholder="Enter your email" />
                </div>

                <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
                    <x-input id="advanced-phone" label="Phone Number" name="phone" placeholder="+1 (555) 123-4567" />
                    <x-input id="advanced-age" label="Age" type="number" name="age" placeholder="Enter your age" />
                </div>

                <x-input id="advanced-password" label="Password" type="password" name="password"
                    placeholder="Min 8 chars, uppercase, lowercase, number" />
                <x-input id="advanced-confirm-password" label="Confirm Password" type="password" name="confirm_password"
                    placeholder="Re-enter your password" />
                <x-input id="advanced-website" label="Website (Optional)" type="url" name="website"
                    placeholder="https://example.com" />

                <div class="flex items-center gap-2">
                    <input type="checkbox" id="advanced-terms" name="terms"
                        class="rounded border-gray-300 text-blue-600 focus:ring-blue-500">
                    <label for="advanced-terms" class="text-sm text-gray-700">
                        I agree to the <a href="#" class="text-blue-600 hover:underline">terms and conditions</a>
                    </label>
                </div>

                <div class="flex items-center justify-end gap-3 pt-4 border-t border-gray-200">
                    <x-button variant="secondary" type="reset">Reset</x-button>
                    <x-button variant="primary" type="submit">Submit</x-button>
                </div>
            </form>
        </x-card>

        <!-- Real-time Validation Example -->
        <x-card>
            <x-slot name="title">Real-time Validation</x-slot>
            <x-slot name="footer">
                <p class="text-xs text-gray-500">Validation occurs as you type (on blur)</p>
            </x-slot>

            <form id="realtime-validation-form" class="space-y-4">
                <x-input id="realtime-email" label="Email" type="email" name="email" placeholder="Enter your email" />
                <x-textarea id="realtime-message" label="Message" name="message" rows="4"
                    placeholder="Enter your message (10-500 characters)" />

                <div class="flex items-center justify-end gap-3 pt-4 border-t border-gray-200">
                    <x-button variant="secondary" type="reset">Reset</x-button>
                    <x-button variant="primary" type="submit">Submit</x-button>
                </div>
            </form>
        </x-card>

        <!-- Validation Rules Reference -->
        <x-card>
            <x-slot name="title">Available Validation Rules</x-slot>

            <div class="overflow-x-auto">
                <table class="min-w-full divide-y divide-gray-200">
                    <thead class="bg-gray-50">
                        <tr>
                            <th class="px-4 py-3 text-start text-xs font-medium text-gray-500 uppercase">Rule</th>
                            <th class="px-4 py-3 text-start text-xs font-medium text-gray-500 uppercase">Description
                            </th>
                            <th class="px-4 py-3 text-start text-xs font-medium text-gray-500 uppercase">Example</th>
                        </tr>
                    </thead>
                    <tbody class="bg-white divide-y divide-gray-200">
                        <tr>
                            <td class="px-4 py-3 text-sm font-medium text-gray-900">required</td>
                            <td class="px-4 py-3 text-sm text-gray-500">Field must not be empty</td>
                            <td class="px-4 py-3 text-sm text-gray-500"><code
                                    class="bg-gray-100 px-2 py-1 rounded">required</code></td>
                        </tr>
                        <tr>
                            <td class="px-4 py-3 text-sm font-medium text-gray-900">email</td>
                            <td class="px-4 py-3 text-sm text-gray-500">Valid email format</td>
                            <td class="px-4 py-3 text-sm text-gray-500"><code
                                    class="bg-gray-100 px-2 py-1 rounded">email</code></td>
                        </tr>
                        <tr>
                            <td class="px-4 py-3 text-sm font-medium text-gray-900">minLength</td>
                            <td class="px-4 py-3 text-sm text-gray-500">Minimum character length</td>
                            <td class="px-4 py-3 text-sm text-gray-500"><code
                                    class="bg-gray-100 px-2 py-1 rounded">minLength: 3</code></td>
                        </tr>
                        <tr>
                            <td class="px-4 py-3 text-sm font-medium text-gray-900">maxLength</td>
                            <td class="px-4 py-3 text-sm text-gray-500">Maximum character length</td>
                            <td class="px-4 py-3 text-sm text-gray-500"><code
                                    class="bg-gray-100 px-2 py-1 rounded">maxLength: 20</code></td>
                        </tr>
                        <tr>
                            <td class="px-4 py-3 text-sm font-medium text-gray-900">number</td>
                            <td class="px-4 py-3 text-sm text-gray-500">Must be a valid number</td>
                            <td class="px-4 py-3 text-sm text-gray-500"><code
                                    class="bg-gray-100 px-2 py-1 rounded">number</code></td>
                        </tr>
                        <tr>
                            <td class="px-4 py-3 text-sm font-medium text-gray-900">minNumber</td>
                            <td class="px-4 py-3 text-sm text-gray-500">Minimum numeric value</td>
                            <td class="px-4 py-3 text-sm text-gray-500"><code
                                    class="bg-gray-100 px-2 py-1 rounded">minNumber: 18</code></td>
                        </tr>
                        <tr>
                            <td class="px-4 py-3 text-sm font-medium text-gray-900">maxNumber</td>
                            <td class="px-4 py-3 text-sm text-gray-500">Maximum numeric value</td>
                            <td class="px-4 py-3 text-sm text-gray-500"><code
                                    class="bg-gray-100 px-2 py-1 rounded">maxNumber: 100</code></td>
                        </tr>
                        <tr>
                            <td class="px-4 py-3 text-sm font-medium text-gray-900">customRegexp</td>
                            <td class="px-4 py-3 text-sm text-gray-500">Custom regex pattern</td>
                            <td class="px-4 py-3 text-sm text-gray-500"><code
                                    class="bg-gray-100 px-2 py-1 rounded">customRegexp: /^[a-z]+$/</code></td>
                        </tr>
                    </tbody>
                </table>
            </div>
        </x-card>
    </div>
</x-layouts.admin>