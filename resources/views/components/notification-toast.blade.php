<div x-data="{ show: false, message: '', type: 'success' }"
    x-on:notify.window="show = true; message = $event.detail.message; type = $event.detail.type || 'success'; setTimeout(() => show = false, 3000)"
    x-show="show" x-transition:enter="transition ease-out duration-300"
    x-transition:enter-start="opacity-0 transform translate-y-2"
    x-transition:enter-end="opacity-100 transform translate-y-0" x-transition:leave="transition ease-in duration-200"
    x-transition:leave-start="opacity-100 transform translate-y-0"
    x-transition:leave-end="opacity-0 transform translate-y-2"
    class="fixed bottom-5 right-5 z-50 px-6 py-3 rounded-lg shadow-lg text-white font-medium flex items-center gap-3"
    :class="{
        'bg-green-600': type === 'success',
        'bg-red-600': type === 'error',
        'bg-blue-600': type === 'info'
    }"
    style="display: none;">

    <i class="fa-solid"
        :class="{
            'fa-check-circle': type === 'success',
            'fa-exclamation-circle': type === 'error',
            'fa-info-circle': type === 'info'
        }"></i>

    <span x-text="message"></span>
</div>
