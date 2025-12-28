<x-layouts.admin header-title="IMask Test Page">
    <div class="max-w-4xl">
        <x-alert type="info" class="mb-6">
            <strong>IMask Test Page:</strong> This page demonstrates various input masking examples using IMask library.
        </x-alert>

        <div class="grid gap-6">
            
            <x-card title="Phone Number Mask">
                <form class="space-y-4">
                    <x-input label="Phone Number (US Format)" name="phone" id="phone-input" type="tel"
                        placeholder="(555) 123-4567" />
                    <p class="text-sm text-gray-600">Format: (XXX) XXX-XXXX</p>
                </form>
            </x-card>

            
            <x-card title="Date Mask">
                <form class="space-y-4">
                    <x-input label="Date (MM/DD/YYYY)" name="date" id="date-input" placeholder="MM/DD/YYYY" />
                    <p class="text-sm text-gray-600">Format: MM/DD/YYYY</p>
                </form>
            </x-card>

            
            <x-card title="Credit Card Mask">
                <form class="space-y-4">
                    <x-input label="Credit Card Number" name="credit_card" id="credit-card-input"
                        placeholder="0000 0000 0000 0000" />
                    <p class="text-sm text-gray-600">Format: XXXX XXXX XXXX XXXX</p>
                </form>
            </x-card>

            
            <x-card title="Currency Mask">
                <form class="space-y-4">
                    <x-input label="Amount (USD)" name="amount" id="currency-input" placeholder="$0.00" />
                    <p class="text-sm text-gray-600">Format: $X,XXX.XX</p>
                </form>
            </x-card>

            
            <x-card title="IP Address Mask">
                <form class="space-y-4">
                    <x-input label="IP Address" name="ip_address" id="ip-input" placeholder="192.168.1.1" />
                    <p class="text-sm text-gray-600">Format: XXX.XXX.XXX.XXX</p>
                </form>
            </x-card>

            
            <x-card title="Time Mask">
                <form class="space-y-4">
                    <x-input label="Time (24-hour format)" name="time" id="time-input" placeholder="23:59" />
                    <p class="text-sm text-gray-600">Format: HH:MM (24-hour)</p>
                </form>
            </x-card>

            
            <x-card title="Custom Pattern Mask">
                <form class="space-y-4">
                    <x-input label="License Plate (ABC-1234)" name="license_plate" id="license-plate-input"
                        placeholder="ABC-1234" />
                    <p class="text-sm text-gray-600">Format: ABC-1234 (3 letters, dash, 4 numbers)</p>
                </form>
            </x-card>

            
            <x-card title="Dynamic Mask (Phone or Email)">
                <form class="space-y-4">
                    <x-input label="Phone or Email" name="contact" id="dynamic-input"
                        placeholder="Enter phone or email" />
                    <p class="text-sm text-gray-600">Accepts both phone numbers and email addresses</p>
                </form>
            </x-card>
        </div>

        
        <x-card title="Test Results" class="mt-6">
            <div id="test-results" class="space-y-2">
                <p class="text-sm text-gray-600">Enter values in the fields above to see the masked output here.</p>
            </div>
        </x-card>
    </div>

    @push('scripts')
        @vite('resources/js/imask-test.js')
    @endpush
</x-layouts.admin>