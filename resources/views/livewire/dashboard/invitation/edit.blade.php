<div class="py-2 animate-fade-in-up">

    {{-- HEADER HEADER --}}
    <div class="flex flex-col md:flex-row justify-between items-start md:items-center mb-8 gap-4">
        <div>
            <div class="flex items-center gap-2 text-[#9A7D4C] text-xs font-bold uppercase tracking-widest mb-1">
                <a href="{{ route('dashboard.index') }}" class="hover:text-[#5E4926] transition flex items-center gap-1">
                    <i class="fa-solid fa-arrow-left"></i> Dashboard
                </a>
                <span>/</span>
                <span>Editor</span>
            </div>
            <h2 class="font-serif font-bold text-3xl text-[#5E4926]">Studio Undangan</h2>
            <p class="text-[#7C6339] text-sm mt-1">Project: <span
                    class="font-semibold italic">{{ $invitation->title }}</span></p>
        </div>

        <div class="flex gap-3">
            <a href="{{ route('invitation.show', $invitation->slug) }}" target="_blank"
                class="px-5 py-2.5 bg-white border border-[#E6D9B8] text-[#7C6339] rounded-xl hover:bg-[#F9F7F2] hover:text-[#B89760] transition font-bold text-xs uppercase tracking-wide flex items-center gap-2 shadow-sm">
                <i class="fa-solid fa-eye"></i> Preview
            </a>
            <button wire:click="save"
                class="px-6 py-2.5 bg-[#B89760] text-white rounded-xl hover:bg-[#9A7D4C] transition font-bold text-xs uppercase tracking-wide flex items-center shadow-lg shadow-[#B89760]/30 transform hover:-translate-y-0.5">
                <span wire:loading.remove wire:target="save" class="flex items-center gap-2"><i
                        class="fa-solid fa-cloud-arrow-up"></i> Simpan Perubahan</span>
                <span wire:loading wire:target="save" class="flex items-center gap-2"><i
                        class="fa-solid fa-circle-notch fa-spin"></i> Menyimpan...</span>
            </button>
        </div>
    </div>

    {{-- ALERT MESSAGE --}}
    @if (session('message'))
        <div
            class="mb-6 bg-[#F2ECDC] border border-[#B89760] text-[#7C6339] px-6 py-4 rounded-xl flex items-center gap-3 shadow-sm relative overflow-hidden">
            <div class="w-1 absolute left-0 top-0 bottom-0 bg-[#B89760]"></div>
            <i class="fa-solid fa-circle-check text-xl text-[#B89760]"></i>
            <span class="font-medium">{{ session('message') }}</span>
        </div>
    @endif

    <div class="grid grid-cols-1 lg:grid-cols-4 gap-8">

        {{-- SIDEBAR NAVIGASI TAB --}}
        <div class="lg:col-span-1">
            <div
                class="bg-white rounded-2xl shadow-[0_4px_20px_rgb(230,217,184,0.3)] border border-[#E6D9B8]/60 overflow-hidden sticky top-24">
                <nav class="flex flex-col p-2 space-y-1">
                    @php
                        $tabs = [
                            'couple' => ['icon' => 'fa-user-group', 'label' => 'Mempelai'],
                            'events' => ['icon' => 'fa-calendar-days', 'label' => 'Rangkaian Acara'],
                            'gallery' => ['icon' => 'fa-images', 'label' => 'Galeri Foto'],
                            'gifts' => ['icon' => 'fa-gift', 'label' => 'Kado Digital'],
                            'theme' => ['icon' => 'fa-palette', 'label' => 'Tema & Musik'],
                        ];
                    @endphp

                    @foreach ($tabs as $key => $tab)
                        <button wire:click="$set('activeTab', '{{ $key }}')"
                            class="px-4 py-3 text-left rounded-xl flex items-center gap-3 transition-all duration-300
                            {{ $activeTab === $key
                                ? 'bg-[#F9F7F2] text-[#B89760] font-bold shadow-sm border border-[#E6D9B8]'
                                : 'text-[#7C6339] hover:bg-[#F9F7F2] hover:text-[#9A7D4C] border border-transparent' }}">
                            <div
                                class="w-8 h-8 rounded-full flex items-center justify-center {{ $activeTab === $key ? 'bg-[#B89760] text-white' : 'bg-[#F2ECDC] text-[#C6AC80]' }}">
                                <i class="fa-solid {{ $tab['icon'] }} text-xs"></i>
                            </div>
                            <span class="text-sm">{{ $tab['label'] }}</span>
                        </button>
                    @endforeach
                </nav>
            </div>
        </div>

        {{-- AREA KONTEN UTAMA --}}
        <div class="lg:col-span-3">
            <div
                class="bg-white rounded-3xl shadow-[0_10px_40px_-10px_rgba(184,151,96,0.1)] border border-[#E6D9B8]/60 p-6 md:p-8 min-h-[500px] relative">

                {{-- Decorative Background --}}
                <div
                    class="absolute top-0 right-0 w-64 h-64 bg-[#F9F7F2] rounded-bl-[100px] -z-0 pointer-events-none opacity-50">
                </div>

                <div class="relative z-10">
                    {{-- TAB COUPLE --}}
                    @if ($activeTab === 'couple')
                        <h3 class="font-serif font-bold text-2xl text-[#5E4926] mb-6 pb-2 border-b border-[#F2ECDC]">
                            Data Pengantin</h3>

                        {{-- === AI ASSISTANT SECTION START (GOLD THEME) === --}}
                        <div
                            class="bg-gradient-to-br from-[#FFFBF2] to-[#F9F7F2] p-6 rounded-2xl border border-[#E6D9B8] mb-8 relative overflow-hidden group">
                            <div
                                class="absolute top-0 right-0 -mt-4 -mr-4 text-[#E6D9B8] opacity-30 group-hover:opacity-50 transition transform group-hover:scale-110">
                                <i class="fa-solid fa-wand-magic-sparkles text-8xl"></i>
                            </div>

                            <div class="relative z-10">
                                <h4 class="font-bold text-[#5E4926] flex items-center gap-2 mb-2 text-lg">
                                    <i class="fa-solid fa-robot text-[#B89760]"></i>
                                    AI Writer Assistant
                                </h4>
                                <p class="text-xs text-[#9A7D4C] mb-5 max-w-lg leading-relaxed">
                                    Bingung merangkai kata puitis? Biarkan AI kami membuatkan kata pengantar yang indah,
                                    menyentuh, dan sesuai dengan gayamu.
                                </p>

                                <div class="flex flex-col md:flex-row gap-4 items-end">
                                    <div class="w-full md:w-1/3">
                                        <label
                                            class="text-[10px] font-bold text-[#7C6339] uppercase tracking-wider mb-1.5 block">Gaya
                                            Bahasa</label>
                                        <div class="relative">
                                            <select wire:model="aiTone"
                                                class="w-full appearance-none rounded-lg bg-white border-[#E6D9B8] text-[#5E4926] text-sm focus:border-[#B89760] focus:ring-[#B89760]">
                                                <option value="islami">Islami & Penuh Doa</option>
                                                <option value="modern">Modern & Casual</option>
                                                <option value="formal">Formal & Puitis</option>
                                            </select>
                                            <div
                                                class="pointer-events-none absolute inset-y-0 right-0 flex items-center px-3 text-[#9A7D4C]">
                                                <i class="fa-solid fa-chevron-down text-xs"></i>
                                            </div>
                                        </div>
                                    </div>

                                    <button wire:click="generateQuote" wire:loading.attr="disabled"
                                        class="px-5 py-2.5 bg-[#5E4926] text-white rounded-lg text-sm font-bold hover:bg-[#403013] shadow-md flex items-center gap-2 disabled:opacity-50 disabled:cursor-wait transition">
                                        <span wire:loading.remove wire:target="generateQuote"
                                            class="flex items-center gap-2"><i
                                                class="fa-solid fa-bolt text-[#F2ECDC]"></i> Generate Sekarang</span>
                                        <span wire:loading wire:target="generateQuote"
                                            class="flex items-center gap-2"><i
                                                class="fa-solid fa-circle-notch fa-spin"></i> Berpikir...</span>
                                    </button>
                                </div>
                            </div>
                        </div>
                        {{-- === AI ASSISTANT SECTION END === --}}

                        <div class="mb-8">
                            <label class="block text-xs font-bold text-[#7C6339] uppercase tracking-wider mb-2">Quote /
                                Kata Pengantar Undangan</label>
                            <textarea wire:model="couple.quote" rows="4"
                                class="w-full rounded-xl bg-[#F9F7F2] border-[#E6D9B8] text-[#5E4926] focus:border-[#B89760] focus:ring-1 focus:ring-[#B89760] shadow-sm transition placeholder-[#C6AC80]"
                                placeholder="Hasil generate AI akan muncul di sini..."></textarea>
                        </div>

                        <div class="grid md:grid-cols-2 gap-8">
                            {{-- Form Pria --}}
                            <div class="space-y-4">
                                <h4 class="font-serif font-bold text-xl text-[#5E4926] border-b border-[#E6D9B8] pb-2">
                                    Mempelai Pria</h4>
                                <div><label class="text-xs text-[#9A7D4C] font-bold">Panggilan</label><input
                                        type="text" wire:model="couple.groom.nickname"
                                        class="w-full rounded-lg bg-[#F9F7F2] border-[#E6D9B8] text-sm"></div>
                                <div><label class="text-xs text-[#9A7D4C] font-bold">Nama Lengkap</label><input
                                        type="text" wire:model="couple.groom.fullname"
                                        class="w-full rounded-lg bg-[#F9F7F2] border-[#E6D9B8] text-sm"></div>
                                <div><label class="text-xs text-[#9A7D4C] font-bold">Nama Ayah</label><input
                                        type="text" wire:model="couple.groom.father"
                                        class="w-full rounded-lg bg-[#F9F7F2] border-[#E6D9B8] text-sm"></div>
                                <div><label class="text-xs text-[#9A7D4C] font-bold">Nama Ibu</label><input
                                        type="text" wire:model="couple.groom.mother"
                                        class="w-full rounded-lg bg-[#F9F7F2] border-[#E6D9B8] text-sm"></div>
                            </div>

                            {{-- Form Wanita --}}
                            <div class="space-y-4">
                                <h4 class="font-serif font-bold text-xl text-[#B89760] border-b border-[#E6D9B8] pb-2">
                                    Mempelai Wanita</h4>
                                <div><label class="text-xs text-[#9A7D4C] font-bold">Panggilan</label><input
                                        type="text" wire:model="couple.bride.nickname"
                                        class="w-full rounded-lg bg-[#F9F7F2] border-[#E6D9B8] text-sm"></div>
                                <div><label class="text-xs text-[#9A7D4C] font-bold">Nama Lengkap</label><input
                                        type="text" wire:model="couple.bride.fullname"
                                        class="w-full rounded-lg bg-[#F9F7F2] border-[#E6D9B8] text-sm"></div>
                                <div><label class="text-xs text-[#9A7D4C] font-bold">Nama Ayah</label><input
                                        type="text" wire:model="couple.bride.father"
                                        class="w-full rounded-lg bg-[#F9F7F2] border-[#E6D9B8] text-sm"></div>
                                <div><label class="text-xs text-[#9A7D4C] font-bold">Nama Ibu</label><input
                                        type="text" wire:model="couple.bride.mother"
                                        class="w-full rounded-lg bg-[#F9F7F2] border-[#E6D9B8] text-sm"></div>
                            </div>
                        </div>
                    @endif

                    {{-- TAB EVENTS --}}
                    @if ($activeTab === 'events')
                        <div class="flex justify-between items-center mb-6 pb-2 border-b border-[#F2ECDC]">
                            <h3 class="font-serif font-bold text-2xl text-[#5E4926]">Rangkaian Acara</h3>
                            <button wire:click="addEvent"
                                class="bg-[#5E4926] text-white text-xs px-4 py-2 rounded-lg font-bold hover:bg-[#403013] shadow-md transition flex items-center gap-2">
                                <i class="fa-solid fa-plus"></i> Tambah Sesi
                            </button>
                        </div>

                        <div class="space-y-6">
                            @foreach ($events as $index => $event)
                                <div
                                    class="bg-[#F9F7F2]/50 p-6 rounded-2xl border border-[#E6D9B8] relative group transition hover:bg-white hover:shadow-sm">
                                    <button wire:click="removeEvent({{ $index }})"
                                        class="absolute top-4 right-4 text-[#C6AC80] hover:text-red-500 transition w-8 h-8 rounded-full bg-white border border-[#E6D9B8] flex items-center justify-center shadow-sm"
                                        title="Hapus Sesi">
                                        <i class="fa-solid fa-trash-can text-xs"></i>
                                    </button>

                                    <div class="grid md:grid-cols-2 gap-5">
                                        <div>
                                            <label class="text-xs font-bold text-[#9A7D4C] uppercase mb-1 block">Judul
                                                Acara</label>
                                            <input type="text" wire:model="events.{{ $index }}.title"
                                                class="w-full rounded-lg bg-white border-[#E6D9B8] text-sm focus:border-[#B89760] focus:ring-[#B89760]">
                                        </div>
                                        <div>
                                            <label
                                                class="text-xs font-bold text-[#9A7D4C] uppercase mb-1 block">Waktu</label>
                                            <input type="datetime-local" wire:model="events.{{ $index }}.date"
                                                class="w-full rounded-lg bg-white border-[#E6D9B8] text-sm focus:border-[#B89760] focus:ring-[#B89760]">
                                        </div>
                                        <div class="md:col-span-2">
                                            <label class="text-xs font-bold text-[#9A7D4C] uppercase mb-1 block">Lokasi
                                                (Gedung/Hotel)</label>
                                            <input type="text" wire:model="events.{{ $index }}.location"
                                                class="w-full rounded-lg bg-white border-[#E6D9B8] text-sm focus:border-[#B89760] focus:ring-[#B89760]">
                                        </div>
                                        <div class="md:col-span-2">
                                            <label class="text-xs font-bold text-[#9A7D4C] uppercase mb-1 block">Alamat
                                                Lengkap</label>
                                            <textarea wire:model="events.{{ $index }}.address" rows="2"
                                                class="w-full rounded-lg bg-white border-[#E6D9B8] text-sm focus:border-[#B89760] focus:ring-[#B89760]"></textarea>
                                        </div>
                                        <div class="md:col-span-2">
                                            <label class="text-xs font-bold text-[#9A7D4C] uppercase mb-1 block">Link
                                                Google Maps</label>
                                            <div class="relative">
                                                <span
                                                    class="absolute inset-y-0 left-0 pl-3 flex items-center pointer-events-none text-[#C6AC80]"><i
                                                        class="fa-solid fa-map-location-dot"></i></span>
                                                <input type="text"
                                                    wire:model="events.{{ $index }}.map_link"
                                                    class="w-full pl-9 rounded-lg bg-white border-[#E6D9B8] text-sm focus:border-[#B89760] focus:ring-[#B89760]">
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            @endforeach
                        </div>
                    @endif

                    {{-- TAB GALLERY --}}
                    @if ($activeTab === 'gallery')
                        <h3 class="font-serif font-bold text-2xl text-[#5E4926] mb-6 pb-2 border-b border-[#F2ECDC]">
                            Galeri Foto</h3>

                        <div
                            class="mb-8 p-8 border-2 border-dashed border-[#E6D9B8] rounded-2xl bg-[#F9F7F2]/50 text-center hover:bg-[#F9F7F2] transition">
                            <div
                                class="w-12 h-12 bg-[#E6D9B8] text-white rounded-full flex items-center justify-center mx-auto mb-3">
                                <i class="fa-solid fa-cloud-arrow-up text-xl"></i>
                            </div>
                            <label class="cursor-pointer">
                                <span class="font-bold text-[#B89760] hover:text-[#9A7D4C] hover:underline">Klik untuk
                                    upload</span>
                                <span class="text-[#7C6339]"> atau drag foto ke sini</span>
                                <input type="file" wire:model="newGalleryImages" multiple class="hidden" />
                            </label>
                            <p class="text-xs text-[#9A7D4C] mt-2">Mendukung format JPG/PNG. Maks 2MB per foto.</p>
                        </div>

                        @if ($newGalleryImages)
                            <div class="mb-6">
                                <p class="text-xs font-bold text-[#7C6339] mb-2 uppercase">Akan diupload:</p>
                                <div class="flex gap-3 overflow-x-auto pb-2">
                                    @foreach ($newGalleryImages as $img)
                                        <img src="{{ $img->temporaryUrl() }}"
                                            class="h-20 w-20 object-cover rounded-lg shadow-sm border border-[#E6D9B8]">
                                    @endforeach
                                </div>
                            </div>
                        @endif

                        <div class="grid grid-cols-2 md:grid-cols-4 gap-4">
                            @foreach ($existingGallery as $index => $path)
                                <div
                                    class="relative group rounded-xl overflow-hidden shadow-sm border border-[#E6D9B8]">
                                    <img src="{{ asset($path) }}" class="w-full h-32 object-cover">
                                    <div
                                        class="absolute inset-0 bg-[#5E4926]/60 opacity-0 group-hover:opacity-100 transition flex items-center justify-center">
                                        <button wire:click="removeGalleryImage({{ $index }})"
                                            class="bg-white text-red-500 px-3 py-1.5 rounded-lg text-xs font-bold shadow-md hover:bg-red-50 transition">
                                            Hapus
                                        </button>
                                    </div>
                                </div>
                            @endforeach
                        </div>
                    @endif

                    {{-- TAB THEME --}}
                    @if ($activeTab === 'theme')
                        <h3 class="font-serif font-bold text-2xl text-[#5E4926] mb-6 pb-2 border-b border-[#F2ECDC]">
                            Tampilan & Musik</h3>

                        <div class="grid md:grid-cols-2 gap-8">
                            <div>
                                <label
                                    class="block text-xs font-bold text-[#7C6339] uppercase tracking-wider mb-2">Pilih
                                    Template</label>
                                <div class="relative">
                                    <select wire:model="theme_template"
                                        class="w-full appearance-none rounded-xl bg-[#F9F7F2] border-[#E6D9B8] text-[#5E4926] p-3 text-sm focus:border-[#B89760] focus:ring-[#B89760]">
                                        <option value="regular">Default White</option>
                                        <option value="rustic">Rustic Garden (Arvaya Special)</option>
                                        <option value="elegant">Elegant Gold</option>
                                    </select>
                                    <div
                                        class="pointer-events-none absolute inset-y-0 right-0 flex items-center px-4 text-[#9A7D4C]">
                                        <i class="fa-solid fa-paintbrush"></i>
                                    </div>
                                </div>
                            </div>

                            <div>
                                <label
                                    class="block text-xs font-bold text-[#7C6339] uppercase tracking-wider mb-2">Warna
                                    Aksen</label>
                                <div class="flex items-center gap-3">
                                    <div
                                        class="relative w-12 h-10 rounded-lg overflow-hidden border border-[#E6D9B8] shadow-sm">
                                        <input type="color" wire:model="theme.primary_color"
                                            class="absolute -top-2 -left-2 w-20 h-20 cursor-pointer p-0 border-0">
                                    </div>
                                    <input type="text" wire:model="theme.primary_color"
                                        class="w-full rounded-xl bg-[#F9F7F2] border-[#E6D9B8] text-[#5E4926] text-sm uppercase">
                                </div>
                            </div>

                            <div class="md:col-span-2">
                                <label
                                    class="block text-xs font-bold text-[#7C6339] uppercase tracking-wider mb-2">Musik
                                    Latar (YouTube URL)</label>
                                <div class="relative">
                                    <span
                                        class="absolute inset-y-0 left-0 pl-3 flex items-center pointer-events-none text-red-500"><i
                                            class="fa-brands fa-youtube"></i></span>
                                    <input type="text" wire:model="theme.music_url"
                                        placeholder="https://youtube.com/watch?v=..."
                                        class="w-full pl-9 rounded-xl bg-[#F9F7F2] border-[#E6D9B8] text-[#5E4926] text-sm focus:border-[#B89760] focus:ring-[#B89760]">
                                </div>
                                <p class="text-xs text-[#9A7D4C] mt-2">Paste link YouTube video. Musik akan diputar
                                    otomatis (sesuai kebijakan browser).</p>
                            </div>
                        </div>
                    @endif

                    {{-- TAB GIFTS --}}
                    @if ($activeTab === 'gifts')
                        <div class="flex justify-between items-center mb-6 pb-2 border-b border-[#F2ECDC]">
                            <h3 class="font-serif font-bold text-2xl text-[#5E4926]">Kado Digital</h3>
                            <button wire:click="addGift"
                                class="bg-[#5E4926] text-white text-xs px-4 py-2 rounded-lg font-bold hover:bg-[#403013] shadow-md transition flex items-center gap-2">
                                <i class="fa-solid fa-plus"></i> Tambah Bank
                            </button>
                        </div>

                        <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
                            @forelse($gifts as $index => $gift)
                                <div
                                    class="bg-gradient-to-br from-[#F9F7F2] to-white p-5 rounded-2xl border border-[#E6D9B8] relative shadow-sm group hover:shadow-md transition">
                                    <button wire:click="removeGift({{ $index }})"
                                        class="absolute top-3 right-3 text-[#C6AC80] hover:text-red-500 w-6 h-6 flex items-center justify-center transition"
                                        title="Hapus">
                                        <i class="fa-solid fa-xmark"></i>
                                    </button>

                                    <div class="space-y-3 pr-6">
                                        <div>
                                            <label
                                                class="text-[10px] font-bold text-[#9A7D4C] uppercase mb-1 block">Bank
                                                / E-Wallet</label>
                                            <select wire:model="gifts.{{ $index }}.bank_name"
                                                class="w-full rounded-lg bg-white border-[#E6D9B8] text-sm py-1.5 font-bold text-[#5E4926]">
                                                <option value="">Pilih...</option>
                                                <option value="BCA">BCA</option>
                                                <option value="BRI">BRI</option>
                                                <option value="Mandiri">Mandiri</option>
                                                <option value="BNI">BNI</option>
                                                <option value="Dana">Dana</option>
                                                <option value="Gopay">Gopay</option>
                                                <option value="Lainnya">Lainnya</option>
                                            </select>
                                        </div>
                                        <div>
                                            <label
                                                class="text-[10px] font-bold text-[#9A7D4C] uppercase mb-1 block">No.
                                                Rekening</label>
                                            <input type="number"
                                                wire:model="gifts.{{ $index }}.account_number"
                                                placeholder="123xxx"
                                                class="w-full rounded-lg bg-white border-[#E6D9B8] text-sm py-1.5 font-mono">
                                        </div>
                                        <div>
                                            <label
                                                class="text-[10px] font-bold text-[#9A7D4C] uppercase mb-1 block">Atas
                                                Nama</label>
                                            <input type="text" wire:model="gifts.{{ $index }}.account_name"
                                                class="w-full rounded-lg bg-white border-[#E6D9B8] text-sm py-1.5">
                                        </div>
                                    </div>
                                </div>
                            @empty
                                <div
                                    class="col-span-full text-center py-10 bg-[#F9F7F2] rounded-xl border-2 border-dashed border-[#E6D9B8]">
                                    <i class="fa-solid fa-gift text-3xl text-[#E6D9B8] mb-3"></i>
                                    <p class="text-[#7C6339] text-sm font-medium">Belum ada data rekening.</p>
                                    <p class="text-[#9A7D4C] text-xs">Tambahkan jika ingin menerima transfer hadiah
                                        dari tamu.</p>
                                </div>
                            @endforelse
                        </div>
                    @endif

                </div>
            </div>
        </div>
    </div>
</div>
