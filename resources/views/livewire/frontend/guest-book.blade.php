<div class="max-w-3xl mx-auto">
    {{-- Form Kirim Ucapan --}}
    <div class="bg-white p-6 rounded-xl shadow-sm border border-gray-100 mb-8">
        <h3 class="font-serif text-xl font-bold mb-4 text-center">Kirim Doa & Ucapan</h3>

        <form wire:submit="sendMessage" class="space-y-4">
            <div>
                <input type="text" wire:model="sender_name"
                    class="w-full rounded-lg border-gray-300 focus:border-pink-500" placeholder="Nama Anda"
                    {{ $guest ? 'readonly' : '' }}>
            </div>
            <div>
                <textarea wire:model="content" rows="3" class="w-full rounded-lg border-gray-300 focus:border-pink-500"
                    placeholder="Tuliskan doa restu Anda..."></textarea>
                @error('content')
                    <span class="text-xs text-red-500">{{ $message }}</span>
                @enderror
            </div>
            <div class="text-right">
                <button type="submit"
                    class="px-6 py-2 bg-gray-900 text-white rounded-lg hover:bg-gray-800 text-sm font-medium">
                    <span wire:loading.remove>Kirim Ucapan</span>
                    <span wire:loading>...</span>
                </button>
            </div>
            @if (session('msg_status'))
                <p class="text-sm text-green-600 text-center">{{ session('msg_status') }}</p>
            @endif
        </form>
    </div>

    {{-- List Ucapan --}}
    <div class="space-y-4">
        @foreach ($messages as $msg)
            <div class="bg-white p-5 rounded-xl shadow-sm border-l-4 border-pink-400">
                <div class="flex justify-between items-start mb-2">
                    <h4 class="font-bold text-gray-800">{{ $msg->sender_name }}</h4>
                    <span class="text-xs text-gray-400">{{ $msg->created_at->diffForHumans() }}</span>
                </div>
                <p class="text-gray-600 text-sm">{{ $msg->content }}</p>

                {{-- Balasan Mempelai (Reply) --}}
                @foreach ($msg->replies as $reply)
                    <div class="mt-3 ml-4 bg-gray-50 p-3 rounded-lg border border-gray-200">
                        <div class="flex items-center gap-2 mb-1">
                            <i class="fa-solid fa-crown text-yellow-500 text-xs"></i>
                            <span class="text-xs font-bold text-gray-900">Mempelai</span>
                        </div>
                        <p class="text-xs text-gray-600">{{ $reply->content }}</p>
                    </div>
                @endforeach
            </div>
        @endforeach

        <div class="pt-4">
            {{ $messages->links() }}
        </div>
    </div>
</div>
