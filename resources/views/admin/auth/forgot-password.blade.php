@php
    $title = __('admin/auth.forgot_password.title');
@endphp

<x-layouts.auth :title="$title">
    <div class="bg-white rounded-2xl shadow-xl border border-gray-100 overflow-hidden">
        
        <div class="bg-gradient-to-br from-green-500 to-emerald-400 px-6 py-8 text-center">
            <div
                class="inline-flex items-center justify-center w-16 h-16 rounded-2xl bg-white/20 backdrop-blur-sm mb-4">
                <x-icon name="key" size="2xl" class="text-white" />
            </div>
            <h1 class="text-2xl font-bold text-white mb-2">{{ __('admin/auth.forgot_password.title') }}</h1>
            <p class="text-green-100 text-sm">{{ __('admin/auth.forgot_password.subtitle') }}</p>
        </div>

        
        <form method="POST" action="{{ route('admin.password.email') }}" class="p-6 space-y-5">
            @csrf

            
            <x-form-group :label="__('admin/auth.fields.email')" required :error="$errors->first('email')">
                <x-input type="email" name="email" value="{{ old('email') }}"
                    :placeholder="__('admin/auth.placeholders.email')" required autofocus class="w-full" />
            </x-form-group>

            
            @if(session('status'))
                <div class="bg-green-50 border border-green-200 rounded-xl p-4">
                    <div class="flex items-start gap-3">
                        <x-icon name="check-circle" size="md" class="text-green-600 mt-0.5 flex-shrink-0" />
                        <div class="flex-1">
                            <p class="text-sm font-medium text-green-900">{{ session('status') }}</p>
                        </div>
                    </div>
                </div>
            @endif

            
            @if($errors->any() && !$errors->has('email'))
                <div class="bg-red-50 border border-red-200 rounded-xl p-4">
                    <div class="flex items-start gap-3">
                        <x-icon name="error-circle" size="md" class="text-red-600 mt-0.5 flex-shrink-0" />
                        <div class="flex-1">
                            <p class="text-sm font-medium text-red-900 mb-1">
                                {{ __('admin/auth.forgot_password.error_title') }}
                            </p>
                            <ul class="text-sm text-red-700 space-y-1">
                                @foreach($errors->all() as $error)
                                    <li>{{ $error }}</li>
                                @endforeach
                            </ul>
                        </div>
                    </div>
                </div>
            @endif

            
            <x-button type="submit" variant="primary" size="lg" class="w-full">
                <span class="flex items-center justify-center gap-2">
                    <x-icon name="mail-send" size="md" />
                    {{ __('admin/auth.forgot_password.submit') }}
                </span>
            </x-button>

            
            <div class="text-center pt-4 border-t border-gray-100">
                <a href="{{ route('admin.login') }}"
                    class="text-sm font-medium text-green-600 hover:text-green-700 transition-colors inline-flex items-center gap-1">
                    <x-icon name="arrow-back" size="sm" />
                    {{ __('admin/auth.forgot_password.back_to_login') }}
                </a>
            </div>
        </form>
    </div>
</x-layouts.auth>