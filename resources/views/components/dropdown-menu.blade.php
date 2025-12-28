@props(['align' => 'end', 'triggerClass' => ''])

@php
    $placements = [
        'start' => 'bottom-start',
        'end' => 'bottom-end',
    ];
    $placement = $placements[$align] ?? 'bottom-end';
@endphp

<div x-data="{
    open: false,
    popperInstance: null,
    init() {
        this.$watch('open', value => {
            if (value) {
                this.$nextTick(() => {
                    if (window.initDropdownPopper && this.$refs.trigger && this.$refs.dropdown && !this.popperInstance) {
                        this.popperInstance = window.initDropdownPopper(
                            this.$refs.trigger,
                            this.$refs.dropdown,
                            '{{ $placement }}'
                        );
                    }
                });
            } else {
                if (this.popperInstance) {
                    this.popperInstance.destroy();
                    this.popperInstance = null;
                }
            }
        });
    }
}" @click.away="open = false" @keydown.escape.window="open = false" class="relative inline-block">
    
    <button x-ref="trigger" type="button" @click="open = !open"
        class="inline-flex items-center cursor-pointer justify-center p-2 rounded-lg text-gray-500 hover:text-gray-700 hover:bg-gray-100 focus:outline-none focus:ring-2 focus:ring-green-500 focus:ring-offset-1 transition-all duration-200 {{ $triggerClass }}"
        aria-label="{{ __('admin/components.table.actions') }}">
        <x-icon name="dots-vertical-rounded" size="md" />
    </button>

    
    <div x-ref="dropdown" x-show="open" x-cloak
        class="absolute w-48 rounded-xl shadow-lg bg-white border border-gray-200 py-1 z-[100] transition-opacity duration-100 ease-out"
        :class="open ? 'opacity-100' : 'opacity-0'" style="display: none;" role="menu" aria-orientation="vertical">
        {{ $slot }}
    </div>
</div>