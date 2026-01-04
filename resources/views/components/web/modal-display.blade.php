@props(['modals' => collect()])

@if($modals->isNotEmpty())
    @foreach($modals as $modal)
        <div x-data="modalDisplay({{ $modal->id }}, {{ $modal->is_rememberable ? 'true' : 'false' }})" x-show="shouldShow"
            x-cloak class="fixed inset-0 z-[9999] flex items-center justify-center p-4" style="display: none;"
            id="modal-{{ $modal->id }}">

            <!-- Backdrop -->
            <div x-show="shouldShow" x-transition:enter="ease-out duration-300" x-transition:enter-start="opacity-0"
                x-transition:enter-end="opacity-100" x-transition:leave="ease-in duration-200"
                x-transition:leave-start="opacity-100" x-transition:leave-end="opacity-0" @click="closeModal()"
                class="fixed inset-0 bg-black/50 bg-opacity-50 transition-opacity" aria-hidden="true"></div>

            <!-- Modal Content -->
            <div x-show="shouldShow" x-transition:enter="ease-out duration-300"
                x-transition:enter-start="opacity-0 translate-y-4 sm:scale-95"
                x-transition:enter-end="opacity-100 translate-y-0 sm:scale-100" x-transition:leave="ease-in duration-200"
                x-transition:leave-start="opacity-100 translate-y-0 sm:scale-100"
                x-transition:leave-end="opacity-0 translate-y-4 sm:scale-95"
                class="relative bg-white rounded-2xl shadow-2xl w-full max-w-lg max-h-[90vh] overflow-hidden flex flex-col border border-gray-100 z-50"
                role="dialog" aria-modal="true" aria-labelledby="modal-title-{{ $modal->id }}" @click.stop>

                <!-- Header -->
                @if($modal->title)
                    <div class="px-6 py-4 border-b border-gray-100 flex items-center justify-between">
                        <h3 id="modal-title-{{ $modal->id }}" class="text-lg font-semibold text-gray-900">
                            {{ $modal->title }}
                        </h3>
                        <button @click="closeModal()"
                            class="text-gray-400 hover:text-gray-600 transition-colors p-2 rounded-xl hover:bg-gray-100"
                            aria-label="Close modal">
                            <i class="fas fa-times"></i>
                        </button>
                    </div>
                @else
                    <button @click="closeModal()"
                        class="absolute top-4 end-4 text-gray-400 hover:text-gray-600 transition-colors z-10 p-2 rounded-xl hover:bg-gray-100"
                        aria-label="Close modal">
                        <i class="fas fa-times"></i>
                    </button>
                @endif

                <!-- Content -->
                <div class="px-6 py-4 overflow-y-auto flex-1">
                    <div class="prose prose-sm max-w-none">
                        {!! $modal->content !!}
                    </div>
                </div>

                <!-- Footer -->
                <div class="px-6 py-4 border-t border-gray-100 flex items-center justify-between gap-3">
                    <div class="flex items-center gap-2">
                        @if($modal->is_rememberable)
                            <label class="flex items-center gap-2 cursor-pointer">
                                <input type="checkbox" x-model="dontShowAgain"
                                    class="w-4 h-4 text-green-600 border-gray-300 rounded focus:ring-green-500">
                                <span class="text-sm text-gray-600">دیگر نمایش نده</span>
                            </label>
                        @endif
                    </div>
                    <div class="flex items-center gap-3">
                        @if($modal->button_text && $modal->button_url)
                            <a href="{{ $modal->button_url }}"
                                class="px-4 py-2 bg-gradient-to-r from-green-500 to-emerald-400 text-white rounded-lg hover:from-green-600 hover:to-emerald-500 transition-all duration-300 font-semibold text-sm no-underline">
                                {{ $modal->button_text }}
                            </a>
                        @endif
                        <button @click="closeModal()"
                            class="px-4 py-2 bg-gray-100 text-gray-700 rounded-lg hover:bg-gray-200 transition-all duration-300 font-semibold text-sm">
                            {{ $modal->close_text ?? 'بستن' }}
                        </button>
                    </div>
                </div>
            </div>
        </div>
    @endforeach

    <style>
        [x-cloak] {
            display: none !important;
        }
    </style>

    <script>
        function modalDisplay(modalId, isRememberable) {
            return {
                modalId: modalId,
                isRememberable: isRememberable,
                shouldShow: false,
                dontShowAgain: false,

                init() {
                    // Check if modal should be shown (not dismissed via cookie)
                    const cookieName = `modal_${this.modalId}_dismissed`;
                    const isDismissed = this.getCookie(cookieName);

                    if (!isDismissed) {
                        // Small delay to ensure smooth animation
                        setTimeout(() => {
                            this.shouldShow = true;
                        }, 100);
                    }
                },

                closeModal() {
                    this.shouldShow = false;

                    // If "don't show again" is checked, set cookie
                    if (this.isRememberable && this.dontShowAgain) {
                        this.setDontShowAgainCookie();
                    }
                },

                setDontShowAgainCookie() {
                    const cookieName = `modal_${this.modalId}_dismissed`;
                    // Set cookie to expire in 1 year
                    const expiryDate = new Date();
                    expiryDate.setFullYear(expiryDate.getFullYear() + 1);

                    document.cookie = `${cookieName}=1; expires=${expiryDate.toUTCString()}; path=/; SameSite=Lax`;

                    // Also send to server to track
                    if (window.axios) {
                        window.axios.post('/api/modals/dont-show-again', {
                            modal_id: this.modalId
                        }).catch(err => {
                            console.warn('Failed to save modal dismissal:', err);
                        });
                    }
                },

                getCookie(name) {
                    const value = `; ${document.cookie}`;
                    const parts = value.split(`; ${name}=`);
                    if (parts.length === 2) {
                        return parts.pop().split(';').shift();
                    }
                    return null;
                }
            };
        }
    </script>
@endif