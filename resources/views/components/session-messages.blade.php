@props(['showSuccess' => true, 'showError' => true, 'showInfo' => false, 'showWarning' => false, 'showStatus' => false])

@if($showSuccess && session('success'))
    <x-alert type="success" dismissible>
        {{ session('success') }}
    </x-alert>
@endif

@if($showError && session('error'))
    <x-alert type="danger" dismissible>
        {{ session('error') }}
    </x-alert>
@endif

@if($showInfo && session('info'))
    <x-alert type="info" dismissible>
        {{ session('info') }}
    </x-alert>
@endif

@if($showWarning && session('warning'))
    <x-alert type="warning" dismissible>
        {{ session('warning') }}
    </x-alert>
@endif

@if($showStatus && session('status'))
    <x-alert type="success" dismissible>
        {{ session('status') }}
    </x-alert>
@endif