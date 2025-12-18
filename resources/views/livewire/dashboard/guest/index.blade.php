<div class="py-2 animate-fade-in-up dashboard-ui">

    {{-- HEADER SECTION --}}
    <div class="flex flex-col md:flex-row justify-between items-start md:items-end mb-8 gap-4">
        <div>
            <div class="flex items-center gap-2 text-[#A0A0A0] text-xs font-bold uppercase tracking-widest mb-1">
                <a href="{{ route('dashboard.index') }}" class="hover:text-[#D4AF37] transition flex items-center gap-1">
                    <i class="fa-solid fa-arrow-left"></i> Dashboard
                </a>
                <span>/</span>
                <span>Management</span>
            </div>
            <h2 class="font-serif font-bold text-3xl text-[#E0E0E0]">Buku Tamu</h2>
            <p class="text-[#A0A0A0] text-sm mt-1">Undangan: <span
                    class="font-semibold italic text-[#D4AF37]">{{ $invitation->title }}</span></p>
        </div>

        {{-- Quick Stats (Ringkasan Kecil) --}}
        <div class="flex gap-3">
            <div class="bg-[#1a1a1a] border border-[#333333] px-4 py-2 rounded-xl shadow-sm text-center">
                <p class="text-[10px] text-[#A0A0A0] font-bold uppercase">Total</p>
                <p class="text-2xl font-sans font-bold text-[#E0E0E0]">{{ $guests->total() }}</p>
            </div>
            <div class="bg-[#1a1a1a] border border-[#333333] px-4 py-2 rounded-xl shadow-sm text-center">
                <p class="text-[10px] text-[#A0A0A0] font-bold uppercase">Hadir</p>
                <p class="text-2xl font-sans font-bold text-green-500">
                    {{ $invitation->guests()->where('rsvp_status', 1)->count() }}
                </p>
            </div>
        </div>
    </div>

    <div class="grid grid-cols-1 lg:grid-cols-3 gap-8">

        {{-- LEFT COLUMN: FORM INPUT --}}
        <div class="lg:col-span-1">
            <div
                class="bg-[#1a1a1a] p-6 rounded-2xl shadow-xl border border-[#333333] sticky top-24">
                <div class="flex items-center gap-3 mb-6 border-b border-[#333333] pb-4">
                    <div class="w-8 h-8 rounded-full bg-[#252525] flex items-center justify-center text-[#D4AF37]">
                        <i class="fa-solid fa-user-plus text-sm"></i>
                    </div>
                    <h3 class="font-serif font-bold text-lg text-[#E0E0E0]">Tambah Tamu</h3>
                </div>

                <form wire:submit="save" class="space-y-5">
                    {{-- Nama --}}
                    <div>
                        <label class="block text-xs font-bold text-[#A0A0A0] uppercase tracking-wider mb-1.5">Nama
                            Tamu</label>
                        <input type="text" wire:model="name" placeholder="Contoh: Bpk. Budi & Keluarga"
                            class="w-full rounded-lg bg-[#252525] border-[#333333] text-[#E0E0E0] placeholder-[#666] focus:border-[#D4AF37] focus:ring-[#D4AF37] text-sm transition shadow-sm">
                        @error('name')
                            <span class="text-red-500 text-xs mt-1 block">{{ $message }}</span>
                        @enderror
                    </div>

                    {{-- WhatsApp --}}
                    <div>
                        <label class="block text-xs font-bold text-[#A0A0A0] uppercase tracking-wider mb-1.5">WhatsApp
                            <span class="text-[#666] font-normal normal-case">(Opsional)</span></label>
                        <div class="relative">
                            <span
                                class="absolute hidden inset-y-0 left-0 pl-3 md:flex items-center pointer-events-none">
                                <i class="fa-brands fa-whatsapp text-green-500/60"></i>
                            </span>
                            <input type="number" wire:model="phone" placeholder="0812..."
                                class="w-full pl-9 rounded-lg bg-[#252525] border-[#333333] text-[#E0E0E0] placeholder-[#666] focus:border-[#D4AF37] focus:ring-[#D4AF37] text-sm transition shadow-sm">
                        </div>
                        <p class="text-[10px] text-[#888] mt-1.5 italic">*Nomor HP diperlukan untuk fitur kirim
                            undangan otomatis.</p>
                        <div x-data="{
                            async pickContacts() {
                                if (!('contacts' in navigator && 'select' in navigator.contacts)) { alert('Browser belum mendukung impor kontak.'); return }
                                try {
                                    const selected = await navigator.contacts.select(['name', 'tel'], { multiple: true });
                                    const out = [];
                                    for (const c of selected) {
                                        const name = Array.isArray(c.name) ? (c.name[0] || '') : (c.name || '');
                                        const tel = Array.isArray(c.tel) ? (c.tel[0] || '') : (c.tel || '');
                                        if (name && tel) out.push({ name, phone: tel });
                                    }
                                    if (out.length) { $wire.importContacts(out) }
                                } catch (e) {}
                            }
                        }" class="mt-3">
                            <button type="button" x-on:click="pickContacts()"
                                class="w-full py-2 bg-[#252525] border border-[#333333] text-[#A0A0A0] rounded-lg text-xs font-bold hover:bg-[#2d2d2d] hover:text-[#D4AF37] transition flex items-center justify-center gap-2">
                                <i class="fa-solid fa-address-book"></i> Import dari Kontak
                            </button>
                            <p class="text-[10px] text-[#666] mt-1">Hanya didukung di browser yang kompatibel.</p>
                        </div>
                    </div>

                    {{-- Kategori --}}
                    <div>
                        <label
                            class="block text-xs font-bold text-[#A0A0A0] uppercase tracking-wider mb-1.5">Kategori</label>
                        <div class="relative">
                            <select wire:model="category"
                                class="w-full appearance-none rounded-lg bg-[#252525] border-[#333333] text-[#E0E0E0] focus:border-[#D4AF37] focus:ring-[#D4AF37] text-sm transition shadow-sm">
                                <option value="Keluarga">Keluarga</option>
                                <option value="Teman Kantor">Teman Kantor</option>
                                <option value="Teman Sekolah">Teman Sekolah</option>
                                <option value="VIP">VIP</option>
                                <option value="Lainnya">Lainnya</option>
                            </select>
                            <div
                                class="pointer-events-none absolute inset-y-0 right-0 flex items-center px-3 text-[#A0A0A0]">
                                <i class="fa-solid fa-chevron-down text-xs"></i>
                            </div>
                        </div>
                    </div>

                    {{-- Button --}}
                    <button type="submit"
                        class="w-full py-3 bg-[#D4AF37] text-[#121212] rounded-lg text-sm font-bold hover:bg-[#B4912F] transition shadow-lg shadow-[#D4AF37]/20 flex items-center justify-center gap-2 group">
                        <i class="fa-solid fa-plus group-hover:rotate-90 transition duration-300"></i> Simpan Data
                    </button>
                </form>
            </div>
        </div>

        {{-- RIGHT COLUMN: GUEST LIST --}}
        <div class="lg:col-span-2">
            <div
                class="bg-[#1a1a1a] rounded-2xl shadow-xl border border-[#333333] overflow-hidden flex flex-col h-full">

                {{-- Toolbar (Search) --}}
                <div
                    class="p-5 border-b border-[#333333] bg-[#252525] flex flex-col sm:flex-row justify-between items-center gap-4">
                    <h3 class="font-serif font-bold text-lg text-[#E0E0E0]">Daftar Tamu</h3>

                    <div class="w-full sm:w-64">
                        <div
                            class="flex items-center gap-3 rounded-full bg-[#1a1a1a] border border-[#333333] px-3 py-2 focus-within:border-[#D4AF37] focus-within:ring-1 focus-within:ring-[#D4AF37]">
                            <i class="fa-solid fa-magnifying-glass text-[#D4AF37] text-xs"></i>
                            <input type="text" wire:model.live="search" placeholder="Cari nama tamu..."
                                   class="flex-1 bg-transparent border-0 focus:ring-0 focus:outline-none text-xs text-[#E0E0E0]">
                            <span wire:loading wire:target="search" class="text-[#D4AF37]">
                                <i class="fa-solid fa-circle-notch fa-spin text-xs"></i>
                            </span>
                        </div>
                    </div>
                    <div class="w-full sm:w-auto">
                        <button wire:click="broadcast"
                                wire:loading.attr="disabled"
                                class="w-full sm:w-auto px-4 py-2 rounded-full bg-[#25D366] text-white text-xs font-bold shadow-sm hover:shadow-md hover:bg-[#20bd5a] transition flex items-center justify-center gap-2">
                            <i class="fa-brands fa-whatsapp"></i> 
                            <span wire:loading.remove wire:target="broadcast">Kirim ke Semua</span>
                            <span wire:loading wire:target="broadcast">Memproses...</span>
                        </button>
                        <p class="text-[10px] text-[#888] mt-1 text-center sm:text-right">Izinkan pop-up agar WhatsApp terbuka</p>
                    </div>
                </div>

                {{-- Table Wrapper --}}
                <div class="overflow-x-auto flex-1">
                    <table class="w-full text-sm text-left">
                        <thead class="bg-[#252525] text-[#A0A0A0] font-bold text-xs uppercase tracking-wider">
                            <tr>
                                <th class="px-6 py-4 rounded-tl-lg">Informasi Tamu</th>
                                <th class="px-6 py-4 text-center">Status RSVP</th>
                                <th class="px-6 py-4">Link & Undangan</th>
                                <th class="px-6 py-4 text-right rounded-tr-lg">Aksi</th>
                            </tr>
                        </thead>
                        <tbody class="divide-y divide-[#333333]">
                            @forelse($guests as $guest)
                                <tr class="hover:bg-[#252525] transition duration-150 group">
                                    {{-- Kolom Nama --}}
                                    <td class="px-6 py-4">
                                        <div class="flex items-center gap-3">
                                            <div
                                                class="w-8 h-8 rounded-full hidden bg-[#252525] text-[#D4AF37] font-serif font-bold md:flex items-center justify-center text-xs shrink-0">
                                                {{ substr($guest->name, 0, 1) }}
                                            </div>
                                            <div>
                                                <p class="font-bold text-[#E0E0E0] text-sm">{{ $guest->name }}</p>
                                                <span
                                                    class="inline-block mt-1 px-2 py-0.5 rounded text-[10px] font-medium bg-[#252525] text-[#A0A0A0] border border-[#333333]">
                                                    {{ $guest->category }}
                                                </span>
                                            </div>
                                        </div>
                                    </td>

                                    {{-- Kolom RSVP --}}
                                    <td class="px-6 py-4 text-center">
                                        @if ($guest->rsvp_status == 1)
                                            <span
                                                class="inline-flex items-center gap-1.5 px-3 py-1 rounded-full text-[10px] font-bold bg-green-900/30 text-green-500 border border-green-900/50">
                                                <i class="fa-solid fa-circle-check"></i> Hadir ({{ $guest->pax }})
                                            </span>
                                        @elseif($guest->rsvp_status == 2)
                                            <span
                                                class="inline-flex items-center gap-1.5 px-3 py-1 rounded-full text-[10px] font-bold bg-red-900/30 text-red-500 border border-red-900/50">
                                                <i class="fa-solid fa-circle-xmark"></i> Tidak
                                            </span>
                                        @else
                                            <span
                                                class="inline-flex items-center gap-1.5 px-3 py-1 rounded-full text-[10px] font-bold bg-gray-900/30 text-gray-400 border border-gray-700">
                                                <i class="fa-regular fa-clock"></i> Pending
                                            </span>
                                        @endif
                                    </td>

                                    {{-- Kolom Action Share --}}
                                    <td class="px-6 py-4">
                                        @php
                                            $link = route('invitation.show', [
                                                'slug' => $invitation->slug,
                                                'to' => $guest->slug,
                                            ]);

                                            $msg = "Kepada Yth. {$guest->name},\n\n";
                                            $msg .=
                                                "Tanpa mengurangi rasa hormat, kami bermaksud mengundang Anda untuk hadir di acara pernikahan kami.\n\n";
                                            $msg .= "Info lengkap & RSVP:\n{$link}\n\n";
                                            $msg .=
                                                "Merupakan suatu kehormatan bagi kami apabila Anda berkenan hadir.\nTerima kasih.";

                                            $waUrl = "https://wa.me/{$guest->phone}?text=" . urlencode($msg);
                                        @endphp

                                        <div class="flex items-center gap-2">
                                            {{-- WA Button --}}
                                            @if ($guest->phone)
                                                <a href="{{ $waUrl }}" target="_blank"
                                                    class="bg-[#25D366] hover:bg-[#20bd5a] text-white px-3 py-1.5 rounded-lg text-xs font-bold transition shadow-sm hover:shadow-md flex items-center gap-1.5">
                                                    <i class="fa-brands fa-whatsapp text-sm"></i> <span
                                                        class="hidden sm:inline">Kirim</span>
                                                </a>
                                            @else
                                                <button disabled
                                                    class="bg-[#252525] text-gray-500 px-3 py-1.5 rounded-lg text-xs font-bold cursor-not-allowed border border-[#333333]">
                                                    <i class="fa-brands fa-whatsapp"></i>
                                                </button>
                                            @endif

                                            {{-- Copy Button --}}
                                            <button
                                                onclick="navigator.clipboard.writeText('{{ $link }}'); alert('Link tersalin!');"
                                                class="bg-[#252525] border border-[#333333] text-[#A0A0A0] hover:bg-[#333] hover:text-[#D4AF37] px-3 py-1.5 rounded-lg text-xs font-bold transition flex items-center gap-1.5"
                                                title="Copy Link">
                                                <i class="fa-regular fa-copy"></i>
                                            </button>
                                        </div>
                                    </td>

                                    {{-- Kolom Hapus --}}
                                    <td class="px-6 py-4 text-right">
                                        <button wire:click="delete({{ $guest->id }})"
                                            wire:confirm="Hapus tamu ini?"
                                            class="w-8 h-8 rounded-full bg-[#252525] border border-red-900/30 text-red-500 hover:bg-red-900/20 hover:text-red-400 hover:border-red-900/50 transition flex items-center justify-center shadow-sm"
                                            title="Hapus Data">
                                            <i class="fa-solid fa-trash-can text-xs"></i>
                                        </button>
                                    </td>
                                </tr>
                            @empty
                                <tr>
                                    <td colspan="4" class="px-6 py-12 text-center">
                                        <div class="flex flex-col items-center justify-center">
                                            <div
                                                class="w-16 h-16 bg-[#252525] rounded-full flex items-center justify-center mb-3 text-[#888]">
                                                <i class="fa-solid fa-user-group text-2xl"></i>
                                            </div>
                                            <h4 class="font-serif font-bold text-[#E0E0E0] text-lg">Belum ada tamu</h4>
                                            <p class="text-[#888] text-xs max-w-xs mt-1">
                                                Mulai tambahkan daftar undangan Anda melalui formulir di sebelah kiri.
                                            </p>
                                        </div>
                                    </td>
                                </tr>
                            @endforelse
                        </tbody>
                    </table>
                </div>

                <div x-data="{
                    queue: [],
                    idx: 0,
                    delay: 1200,
                    start(urls) { this.queue = urls || []; this.idx = 0; if (this.queue.length) this.openNext() },
                    openNext() {
                        if (this.idx >= this.queue.length) { alert('Broadcast selesai'); return }
                        const url = this.queue[this.idx++]
                        window.open(url, '_blank')
                        setTimeout(() => this.openNext(), this.delay)
                    }
                }" x-on:broadcast-wa.window="start($event.detail.urls)"></div>

                {{-- Pagination Footer --}}
                <div class="p-4 border-t border-[#333333] bg-[#252525]">
                    {{ $guests->links() }}
                </div>
            </div>
        </div>
    </div>
</div>