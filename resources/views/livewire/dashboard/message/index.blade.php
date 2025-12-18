<div class="py-2 animate-fade-in-up max-w-4xl mx-auto dashboard-ui">

    {{-- HEADER SECTION --}}
    <div class="flex flex-col md:flex-row justify-between items-start md:items-end mb-8 gap-4">
        <div>
            <div class="flex items-center gap-2 text-[#A0A0A0] text-xs font-bold uppercase tracking-widest mb-1">
                <a href="{{ route('dashboard.index') }}" class="hover:text-[#D4AF37] transition flex items-center gap-1">
                    <i class="fa-solid fa-arrow-left"></i> Dashboard
                </a>
                <span>/</span>
                <span>Messages</span>
            </div>
            <h2 class="font-serif font-bold text-3xl text-[#E0E0E0]">Doa & Ucapan</h2>
            <p class="text-[#A0A0A0] text-sm mt-1">Undangan: <span
                    class="font-semibold italic text-[#D4AF37]">{{ $invitation->title }}</span></p>
        </div>
    </div>

    <div class="space-y-6">
        @forelse($messages as $msg)
            <div
                class="group bg-[#1a1a1a] p-6 rounded-2xl shadow-xl border border-[#333333] transition-all hover:border-[#D4AF37]/50">

                {{-- Header Pesan --}}
                <div class="flex justify-between items-start mb-4">
                    <div class="flex items-center gap-4">
                        {{-- Avatar --}}
                        <div
                            class="w-12 h-12 rounded-full bg-[#252525] border border-[#333333] flex items-center justify-center text-[#D4AF37] font-serif font-bold text-lg shadow-sm">
                            {{ substr($msg->sender_name, 0, 1) }}
                        </div>

                        <div>
                            <h4 class="font-serif font-bold text-lg text-[#E0E0E0] leading-tight">
                                {{ $msg->sender_name }}</h4>
                            <div class="flex items-center gap-2 text-xs text-[#A0A0A0] mt-0.5">
                                <i class="fa-regular fa-clock"></i>
                                <span>{{ $msg->created_at->format('d M Y, H:i') }}</span>
                            </div>
                        </div>
                    </div>

                    {{-- Delete Button --}}
                    <button wire:click="delete({{ $msg->id }})" wire:confirm="Hapus pesan ini?"
                        class="text-[#888] hover:text-red-500 transition p-2 rounded-full hover:bg-red-900/20"
                        title="Hapus Pesan">
                        <i class="fa-solid fa-trash-can"></i>
                    </button>
                </div>

                {{-- Isi Pesan --}}
                <div class="pl-16">
                    <div
                        class="text-[#E0E0E0] text-sm leading-relaxed mb-6 bg-[#252525] p-4 rounded-xl border border-[#333333] italic relative">
                        <i class="fa-solid fa-quote-left absolute -top-2 -left-2 text-[#D4AF37] text-xl"></i>
                        {{ $msg->content }}
                    </div>

                    {{-- List Balasan --}}
                    <div
                        class="space-y-4 relative before:absolute before:left-0 before:top-0 before:bottom-0 before:w-0.5 before:bg-[#333333] before:rounded-full pl-6">
                        @foreach ($msg->replies as $reply)
                            <div class="bg-[#252525] p-4 rounded-xl border border-[#333333] relative">
                                {{-- Connector Line --}}
                                <div class="absolute top-6 -left-6 w-6 h-0.5 bg-[#333333]"></div>

                                <div class="flex justify-between items-start mb-2">
                                    <div class="flex items-center gap-2">
                                        <span
                                            class="text-[10px] font-bold bg-[#D4AF37] text-[#121212] px-2 py-0.5 rounded-full border border-[#B4912F] shadow-sm flex items-center gap-1">
                                            <i class="fa-solid fa-crown text-[8px]"></i> Mempelai
                                        </span>
                                        <span
                                            class="text-[10px] text-[#A0A0A0]">{{ $reply->created_at->diffForHumans() }}</span>
                                    </div>
                                    <button wire:click="delete({{ $reply->id }})"
                                        class="text-[#888] hover:text-red-500 text-xs transition">
                                        <i class="fa-solid fa-xmark"></i>
                                    </button>
                                </div>
                                <p class="text-xs text-[#E0E0E0] leading-relaxed">{{ $reply->content }}</p>
                            </div>
                        @endforeach

                        {{-- Form Reply --}}
                        <div class="mt-4">
                            @if ($replyingToId === $msg->id)
                                <div
                                    class="animate-fade-in-down bg-[#1a1a1a] p-4 rounded-xl border border-[#D4AF37] shadow-md relative z-10">
                                    <textarea wire:model="replyContent"
                                        class="w-full text-sm rounded-lg bg-[#252525] border-[#333333] text-[#E0E0E0] placeholder-[#666] focus:border-[#D4AF37] focus:ring-1 focus:ring-[#D4AF37] mb-3 transition-all resize-none"
                                        rows="3" placeholder="Tulis balasan ucapan terima kasih..."></textarea>

                                    <div class="flex gap-2 justify-end">
                                        <button wire:click="cancelReply"
                                            class="text-xs font-bold text-[#A0A0A0] hover:text-[#E0E0E0] px-3 py-2 rounded transition">Batal</button>
                                        <button wire:click="sendReply({{ $msg->id }})"
                                            class="bg-[#D4AF37] hover:bg-[#B4912F] text-[#121212] text-xs font-bold px-4 py-2 rounded-lg shadow-md transition flex items-center gap-2">
                                            <span>Kirim</span> <i class="fa-solid fa-paper-plane"></i>
                                        </button>
                                    </div>
                                </div>
                            @else
                                <button wire:click="setReply({{ $msg->id }})"
                                    class="text-xs text-[#D4AF37] font-bold hover:text-[#B4912F] transition flex items-center gap-2 group/btn">
                                    <div
                                        class="w-6 h-6 rounded-full bg-[#252525] flex items-center justify-center group-hover/btn:bg-[#333] transition">
                                        <i class="fa-solid fa-reply"></i>
                                    </div>
                                    Balas Pesan
                                </button>
                            @endif
                        </div>
                    </div>
                </div>
            </div>
        @empty
            {{-- EMPTY STATE --}}
            <div class="py-16 text-center bg-[#1a1a1a] rounded-2xl border-2 border-dashed border-[#333333]">
                <div
                    class="w-16 h-16 bg-[#252525] rounded-full flex items-center justify-center mx-auto mb-4 text-[#888]">
                    <i class="fa-solid fa-envelope-open text-2xl opacity-50"></i>
                </div>
                <h3 class="font-serif font-bold text-lg text-[#E0E0E0] mb-1">Belum ada ucapan masuk</h3>
                <p class="text-[#A0A0A0] text-xs max-w-xs mx-auto">
                    Ucapan dan doa dari tamu undangan akan muncul di sini setelah undangan disebar.
                </p>
            </div>
        @endforelse

        <div class="pt-4">
            {{ $messages->links() }}
        </div>
    </div>
</div>