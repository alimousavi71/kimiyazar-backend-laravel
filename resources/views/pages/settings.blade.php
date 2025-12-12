<x-layouts.admin header-title="Settings">
    <div class="max-w-4xl">
        <x-alert type="info" class="mb-6">
            <strong>Note:</strong> Changes to settings will take effect immediately.
        </x-alert>

        <div class="space-y-6">
            <!-- General Settings -->
            <x-card title="General Settings">
                <form class="space-y-4">
                    <x-input label="Site Name" name="site_name" value="Admin Panel" />
                    <x-input label="Site URL" type="url" name="site_url" value="https://example.com" />
                    <x-textarea label="Site Description" name="site_description" rows="3">
                        A modern admin panel built with Laravel and Tailwind CSS
                    </x-textarea>
                    <x-select label="Timezone" name="timezone">
                        <option value="UTC">UTC</option>
                        <option value="America/New_York">America/New_York</option>
                        <option value="Europe/London">Europe/London</option>
                        <option value="Asia/Tokyo">Asia/Tokyo</option>
                    </x-select>

                    <div class="flex items-center justify-end gap-3 pt-4 border-t border-gray-200">
                        <x-button variant="secondary" type="button">Reset</x-button>
                        <x-button variant="primary" type="submit">Save Changes</x-button>
                    </div>
                </form>
            </x-card>

            <!-- Email Settings -->
            <x-card title="Email Settings">
                <form class="space-y-4">
                    <x-input label="SMTP Host" name="smtp_host" value="smtp.example.com" />
                    <x-input label="SMTP Port" type="number" name="smtp_port" value="587" />
                    <x-input label="SMTP Username" name="smtp_username" />
                    <x-input label="SMTP Password" type="password" name="smtp_password" />
                    <x-input label="From Email" type="email" name="from_email" value="noreply@example.com" />
                    <x-input label="From Name" name="from_name" value="Admin Panel" />

                    <div class="flex items-center justify-end gap-3 pt-4 border-t border-gray-200">
                        <x-button variant="secondary" type="button">Test Connection</x-button>
                        <x-button variant="primary" type="submit">Save Changes</x-button>
                    </div>
                </form>
            </x-card>

            <!-- Security Settings -->
            <x-card title="Security Settings">
                <form class="space-y-4">
                    <x-toggle name="two_factor_auth" label="Two-Factor Authentication"
                        description="Require 2FA for all admin users" checked />

                    <x-toggle name="password_complexity" label="Password Complexity"
                        description="Require strong passwords" checked />

                    <x-input label="Session Timeout (minutes)" type="number" name="session_timeout" value="30" />

                    <div class="flex items-center justify-end gap-3 pt-4 border-t border-gray-200">
                        <x-button variant="primary" type="submit">Save Changes</x-button>
                    </div>
                </form>
            </x-card>

            <!-- Danger Zone -->
            <x-card title="Danger Zone">
                <div class="space-y-4">
                    <div class="p-4 border-2 border-red-200 rounded-lg bg-red-50">
                        <p class="font-medium text-red-900 mb-2">Clear All Cache</p>
                        <p class="text-sm text-red-700 mb-4">This will clear all application cache. This action cannot
                            be undone.</p>
                        <x-button variant="danger" size="sm">Clear Cache</x-button>
                    </div>

                    <div class="p-4 border-2 border-red-200 rounded-lg bg-red-50">
                        <p class="font-medium text-red-900 mb-2">Reset Database</p>
                        <p class="text-sm text-red-700 mb-4">This will reset the entire database. All data will be lost.
                            This action cannot be undone.</p>
                        <x-button variant="danger" size="sm">Reset Database</x-button>
                    </div>
                </div>
            </x-card>
        </div>
    </div>
</x-layouts.admin>