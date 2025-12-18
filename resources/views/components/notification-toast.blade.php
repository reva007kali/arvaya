<div x-data="{ show: false, message: '', type: 'success' }"
    x-on:notify.window="show = true; message = $event.detail.message; type = $event.detail.type || 'success'; setTimeout(() => show = false, 3000)"
    x-show="show" x-transition:enter="transition ease-out duration-300"
    x-transition:enter-start="opacity-0 transform translate-y-[-10px]"
    x-transition:enter-end="opacity-100 transform translate-y-0" x-transition:leave="transition ease-in duration-200"
    x-transition:leave-start="opacity-100 transform translate-y-0"
    x-transition:leave-end="opacity-0 transform translate-y-[-10px]"
    class="fixed top-24 right-6 z-[99999] px-6 py-4 rounded-xl shadow-2xl text-white font-bold flex items-center gap-3 border border-white/20 backdrop-blur-sm"
    :class="{
        'bg-green-600/90': type === 'success',
        'bg-red-600/90': type === 'error',
        'bg-blue-600/90': type === 'info'
    }" style="display: none;">

    <i class="fa-solid text-lg" :class="{
            'fa-circle-check': type === 'success',
            'fa-circle-exclamation': type === 'error',
            'fa-circle-info': type === 'info'
        }"></i>

    <span x-text="message" class="text-sm"></span>
</div>