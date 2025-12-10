<div class="py-6 max-w-4xl mx-auto">
    <div class="flex justify-between items-center mb-6">
        <div>
            <h2 class="font-bold text-xl text-gray-800">Buku Tamu & Ucapan</h2>
            <p class="text-sm text-gray-500">Kelola dan balas ucapan dari tamu.</p>
        </div>
        <a href="{{ route('dashboard.index') }}" class="text-sm text-gray-600 hover:underline">
            <i class="fa-solid fa-arrow-left"></i> Kembali
        </a>
    </div>

    <div class="space-y-6">
        @forelse($messages as $msg)
            <div class="bg-white p-6 rounded-xl shadow-sm border border-gray-100">
                {{-- Header Pesan --}}
                <div class="flex justify-between items-start mb-3">
                    <div class="flex items-center gap-3">
                        <div class="w-10 h-10 rounded-full bg-pink-100 flex items-center justify-center text-pink-600 font-bold">
                            {{ substr($msg->sender_name, 0, 1) }}
                        </div>
                        <div>
                            <h4 class="font-bold text-gray-800">{{ $msg->sender_name }}</h4>
                            <span class="text-xs text-gray-400">{{ $msg->created_at->format('d M Y, H:i') }}</span>
                        </div>
                    </div>
                    <button wire:click="delete({{ $msg->id }})" wire:confirm="Hapus pesan ini?" class="text-gray-400 hover:text-red-500">
                        <i class="fa-solid fa-trash"></i>
                    </button>
                </div>

                {{-- Isi Pesan --}}
                <p class="text-gray-700 text-sm mb-4 pl-14">{{ $msg->content }}</p>

                {{-- List Balasan --}}
                <div class="pl-14 space-y-3">
                    @foreach($msg->replies as $reply)
                        <div class="bg-gray-50 p-3 rounded-lg border border-gray-200">
                            <div class="flex justify-between items-start">
                                <div class="flex items-center gap-2 mb-1">
                                    <span class="text-xs font-bold bg-yellow-100 text-yellow-800 px-2 py-0.5 rounded">Mempelai</span>
                                    <span class="text-[10px] text-gray-400">{{ $reply->created_at->diffForHumans() }}</span>
                                </div>
                                <button wire:click="delete({{ $reply->id }})" class="text-gray-400 hover:text-red-500 text-xs"><i class="fa-solid fa-times"></i></button>
                            </div>
                            <p class="text-xs text-gray-600">{{ $reply->content }}</p>
                        </div>
                    @endforeach

                    {{-- Form Reply --}}
                    @if($replyingToId === $msg->id)
                        <div class="mt-4 animate-fade-in-down">
                            <textarea wire:model="replyContent" class="w-full text-sm rounded-lg border-gray-300 focus:border-pink-500 mb-2" rows="2" placeholder="Tulis balasan..."></textarea>
                            <div class="flex gap-2 justify-end">
                                <button wire:click="cancelReply" class="text-xs text-gray-500 hover:text-gray-700">Batal</button>
                                <button wire:click="sendReply({{ $msg->id }})" class="bg-pink-600 text-white text-xs px-4 py-2 rounded-lg hover:bg-pink-700">Kirim Balasan</button>
                            </div>
                        </div>
                    @else
                        <button wire:click="setReply({{ $msg->id }})" class="text-xs text-pink-600 hover:underline font-medium">
                            <i class="fa-solid fa-reply mr-1"></i> Balas Pesan
                        </button>
                    @endif
                </div>
            </div>
        @empty
            <div class="text-center py-12 bg-white rounded-xl border border-dashed text-gray-400">
                Belum ada ucapan yang masuk.
            </div>
        @endforelse
        
        {{ $messages->links() }}
    </div>
</div>