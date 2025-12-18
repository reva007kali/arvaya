<div class="py-6 animate-fade-in-up dashboard-ui max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">

    <div class="mb-10 text-center">
        <h2 class="font-serif font-bold text-3xl text-[#E0E0E0]">Wedding Tips & Assistant</h2>
        <p class="text-[#A0A0A0] text-sm mt-1">Panduan lengkap & teman diskusi untuk hari bahagiamu.</p>
    </div>

    <div class="grid grid-cols-1 lg:grid-cols-12 gap-8 lg:h-[calc(100vh-200px)]">

        {{-- LEFT COLUMN: CHAT ARVAYA (AI) --}}
        <div
            class="lg:col-span-7 flex flex-col bg-[#1a1a1a] rounded-[2rem] border border-[#333333] shadow-xl overflow-hidden relative h-[600px] lg:h-auto">
            {{-- Chat Header --}}
            <div class="bg-[#252525] p-4 border-b border-[#333333] flex items-center justify-between z-10">
                <div class="flex items-center gap-3">
                    <div class="relative">
                        <div
                            class="w-10 h-10 rounded-full bg-gradient-to-br from-[#D4AF37] to-[#B4912F] flex items-center justify-center text-[#121212] shadow-[0_0_10px_rgba(212,175,55,0.5)]">
                            <i class="fa-solid fa-robot text-lg"></i>
                        </div>
                        <span
                            class="absolute bottom-0 right-0 w-3 h-3 bg-green-500 border-2 border-[#252525] rounded-full"></span>
                    </div>
                    <div>
                        <h3 class="font-serif font-bold text-[#E0E0E0]">Arvaya Assistant</h3>
                        <p class="text-[10px] text-[#D4AF37] uppercase tracking-wider font-bold">Online • Marriage
                            Expert</p>
                    </div>
                </div>
                <button wire:click="$set('chatHistory', [])" class="text-[#888] hover:text-red-500 transition text-xs"
                    title="Clear Chat">
                    <i class="fa-solid fa-trash-can"></i>
                </button>
            </div>

            {{-- Chat Messages (Scrollable) --}}
            <div class="flex-1 overflow-y-auto p-4 space-y-4 custom-scrollbar bg-[#121212]" id="chat-container">
                @foreach ($chatHistory as $msg)
                            <div class="flex {{ $msg['role'] === 'user' ? 'justify-end' : 'justify-start' }}">
                                <div class="max-w-[85%] rounded-2xl p-4 text-sm leading-relaxed {{ $msg['role'] === 'user'
                    ? 'bg-[#D4AF37] text-[#121212] rounded-tr-none shadow-md'
                    : 'bg-[#252525] text-[#E0E0E0] rounded-tl-none border border-[#333333]' }}">
                                    {!! nl2br(e($msg['content'])) !!}
                                </div>
                            </div>
                @endforeach

                @if ($isTyping)
                    <div class="flex justify-start animate-pulse">
                        <div
                            class="bg-[#252525] text-[#A0A0A0] rounded-2xl rounded-tl-none p-3 border border-[#333333] flex items-center gap-1">
                            <span class="w-1.5 h-1.5 bg-[#888] rounded-full animate-bounce"></span>
                            <span class="w-1.5 h-1.5 bg-[#888] rounded-full animate-bounce delay-100"></span>
                            <span class="w-1.5 h-1.5 bg-[#888] rounded-full animate-bounce delay-200"></span>
                        </div>
                    </div>
                @endif
            </div>

            {{-- Chat Input --}}
            <div class="p-4 bg-[#252525] border-t border-[#333333]">
                <form wire:submit="sendMessage" class="relative">
                    <input type="text" wire:model="chatInput"
                        class="w-full bg-[#1a1a1a] border border-[#333333] text-[#E0E0E0] rounded-full pl-5 pr-14 py-3 focus:ring-1 focus:ring-[#D4AF37] focus:border-[#D4AF37] transition placeholder-[#666]"
                        placeholder="Tanya Arvaya tentang pernikahan...">
                    <button type="submit"
                        class="absolute right-2 top-1.5 w-10 h-10 bg-[#D4AF37] hover:bg-[#B4912F] text-[#121212] rounded-full flex items-center justify-center transition shadow-lg disabled:opacity-50 disabled:cursor-not-allowed"
                        wire:loading.attr="disabled">
                        <i class="fa-solid fa-paper-plane text-sm"></i>
                    </button>
                </form>
            </div>
        </div>

        {{-- RIGHT COLUMN: GUIDES & TIPS --}}
        <div class="lg:col-span-5 flex flex-col gap-4 lg:overflow-y-auto custom-scrollbar pr-1">

            {{-- Tab Navigation --}}
            <div class="flex gap-2 overflow-x-auto pb-2">
                @foreach (['kua' => 'Syarat KUA', 'surat' => 'Surat Nikah', 'budget' => 'Tips Hemat'] as $key => $label)
                            <button wire:click="setTab('{{ $key }}')" class="px-4 py-2 rounded-full text-xs font-bold whitespace-nowrap transition-all border
                                                            {{ $activeTab === $key
                    ? 'bg-[#D4AF37] text-[#121212] border-[#D4AF37] shadow-lg'
                    : 'bg-[#1a1a1a] text-[#A0A0A0] border-[#333333] hover:border-[#D4AF37] hover:text-[#E0E0E0]' }}">
                                {{ $label }}
                            </button>
                @endforeach
            </div>

            {{-- Content Area --}}
            <div class="bg-[#1a1a1a] rounded-[2rem] border border-[#333333] p-6 shadow-lg flex-1">

                @if ($activeTab === 'kua')
                    <div class="animate-fade-in-up">
                        <h3 class="font-serif font-bold text-xl text-[#D4AF37] mb-4 flex items-center gap-2">
                            <i class="fa-solid fa-mosque"></i> Syarat Nikah di KUA
                        </h3>
                        <div class="space-y-4 text-sm text-[#A0A0A0]">
                            <div class="p-4 bg-[#252525] rounded-xl border-l-4 border-[#D4AF37]">
                                <h5 class="font-bold text-[#E0E0E0] mb-1">Dokumen Utama</h5>
                                <ul class="list-disc pl-4 space-y-1">
                                    <li>Surat Pengantar Nikah dari Kelurahan (N1 - N4)</li>
                                    <li>Fotokopi KTP & KK (Calon Pengantin & Orang Tua)</li>
                                    <li>Fotokopi Akta Kelahiran & Ijazah Terakhir</li>
                                    <li>Pas Foto latar biru (2x3: 4 lembar, 4x6: 2 lembar)</li>
                                </ul>
                            </div>
                            <div class="p-4 bg-[#252525] rounded-xl border-l-4 border-blue-500">
                                <h5 class="font-bold text-[#E0E0E0] mb-1">Kesehatan</h5>
                                <p>Surat keterangan sehat dari Puskesmas & Bukti Imunisasi TT (Tetanus) bagi calon pengantin
                                    wanita.</p>
                            </div>
                            <p class="italic text-xs">*Pastikan mendaftar online via SIMKAH minimal 10 hari kerja sebelum
                                akad.</p>
                        </div>
                    </div>
                @endif

                @if ($activeTab === 'surat')
                    <div class="animate-fade-in-up">
                        <h3 class="font-serif font-bold text-xl text-[#D4AF37] mb-4 flex items-center gap-2">
                            <i class="fa-solid fa-file-contract"></i> Mengurus Surat Nikah
                        </h3>
                        <div class="relative border-l-2 border-[#333333] ml-3 space-y-6">
                            <div class="ml-6 relative">
                                <span
                                    class="absolute -left-[31px] top-0 w-4 h-4 rounded-full bg-[#D4AF37] border-4 border-[#1a1a1a]"></span>
                                <h5 class="font-bold text-[#E0E0E0]">Langkah 1: RT & RW</h5>
                                <p class="text-xs text-[#A0A0A0] mt-1">Minta surat pengantar nikah dari RT dan RW setempat
                                    sesuai KTP.</p>
                            </div>
                            <div class="ml-6 relative">
                                <span
                                    class="absolute -left-[31px] top-0 w-4 h-4 rounded-full bg-[#252525] border border-[#D4AF37]"></span>
                                <h5 class="font-bold text-[#E0E0E0]">Langkah 2: Kelurahan</h5>
                                <p class="text-xs text-[#A0A0A0] mt-1">Bawa surat RT/RW ke Kelurahan untuk mendapatkan form
                                    N1, N2, N4.</p>
                            </div>
                            <div class="ml-6 relative">
                                <span
                                    class="absolute -left-[31px] top-0 w-4 h-4 rounded-full bg-[#252525] border border-[#D4AF37]"></span>
                                <h5 class="font-bold text-[#E0E0E0]">Langkah 3: KUA Kecamatan</h5>
                                <p class="text-xs text-[#A0A0A0] mt-1">Daftarkan berkas ke KUA tempat akad nikah akan
                                    dilaksanakan. Jika beda kecamatan, butuh Surat Numpang Nikah.</p>
                            </div>
                        </div>
                    </div>
                @endif

                @if ($activeTab === 'budget')
                    <div class="animate-fade-in-up">
                        <h3 class="font-serif font-bold text-xl text-[#D4AF37] mb-4 flex items-center gap-2">
                            <i class="fa-solid fa-piggy-bank"></i> Tips Hemat Budget
                        </h3>
                        <div class="grid gap-3">
                            <div class="bg-[#252525] p-3 rounded-xl flex items-start gap-3">
                                <div
                                    class="w-8 h-8 rounded-full bg-green-900/30 text-green-500 flex items-center justify-center shrink-0 mt-1">
                                    <i class="fa-solid fa-mobile-screen"></i>
                                </div>
                                <div>
                                    <h5 class="font-bold text-[#E0E0E0] text-sm">Undangan Digital</h5>
                                    <p class="text-xs text-[#A0A0A0]">Gunakan Arvaya untuk menghemat biaya cetak undangan
                                        fisik yang mahal.</p>
                                </div>
                            </div>
                            <div class="bg-[#252525] p-3 rounded-xl flex items-start gap-3">
                                <div
                                    class="w-8 h-8 rounded-full bg-blue-900/30 text-blue-500 flex items-center justify-center shrink-0 mt-1">
                                    <i class="fa-solid fa-shirt"></i>
                                </div>
                                <div>
                                    <h5 class="font-bold text-[#E0E0E0] text-sm">Sewa Baju Pengantin</h5>
                                    <p class="text-xs text-[#A0A0A0]">Menyewa jauh lebih hemat daripada menjahit baru yang
                                        hanya dipakai sekali.</p>
                                </div>
                            </div>
                            <div class="bg-[#252525] p-3 rounded-xl flex items-start gap-3">
                                <div
                                    class="w-8 h-8 rounded-full bg-purple-900/30 text-purple-500 flex items-center justify-center shrink-0 mt-1">
                                    <i class="fa-solid fa-calendar-day"></i>
                                </div>
                                <div>
                                    <h5 class="font-bold text-[#E0E0E0] text-sm">Pilih Hari Kerja</h5>
                                    <p class="text-xs text-[#A0A0A0]">Venue biasanya memberikan diskon besar untuk acara di
                                        hari biasa (Weekday).</p>
                                </div>
                            </div>
                        </div>
                    </div>
                @endif

            </div>
        </div>
    </div>

    <script>
        // Auto scroll to bottom of chat
        const chatContainer = document.getElementById('chat-container');
        const observer = new MutationObserver(() => {
            chatContainer.scrollTop = chatContainer.scrollHeight;
        });
        observer.observe(chatContainer, { childList: true, subtree: true });
    </script>
</div>