<div class="py-6">
    <div class="flex flex-col md:flex-row justify-between items-start md:items-center mb-6 gap-4">
        <div>
            <h2 class="font-bold text-xl text-gray-800">Manajemen Tamu</h2>
            <p class="text-sm text-gray-500">Undangan: {{ $invitation->title }}</p>
        </div>
        <a href="{{ route('dashboard.index') }}" class="text-sm text-gray-600 hover:underline">
            <i class="fa-solid fa-arrow-left"></i> Kembali ke Dashboard
        </a>
    </div>

    <div class="grid grid-cols-1 lg:grid-cols-3 gap-6">
        
        {{-- FORM TAMBAH TAMU --}}
        <div class="lg:col-span-1">
            <div class="bg-white p-6 rounded-xl shadow-sm border border-gray-100 sticky top-6">
                <h3 class="font-bold text-lg mb-4 text-gray-800">Tambah Tamu</h3>
                <form wire:submit="save" class="space-y-4">
                    <div>
                        <label class="block text-xs font-medium text-gray-700 mb-1">Nama Tamu</label>
                        <input type="text" wire:model="name" placeholder="Contoh: Bpk. Budi & Keluarga" class="w-full rounded-lg border-gray-300 focus:border-pink-500 text-sm">
                        @error('name') <span class="text-red-500 text-xs">{{ $message }}</span> @enderror
                    </div>
                    <div>
                        <label class="block text-xs font-medium text-gray-700 mb-1">No. WhatsApp (Opsional)</label>
                        <input type="number" wire:model="phone" placeholder="0812..." class="w-full rounded-lg border-gray-300 focus:border-pink-500 text-sm">
                        <p class="text-[10px] text-gray-400 mt-1">Digunakan untuk tombol kirim otomatis.</p>
                    </div>
                    <div>
                        <label class="block text-xs font-medium text-gray-700 mb-1">Kategori</label>
                        <select wire:model="category" class="w-full rounded-lg border-gray-300 text-sm">
                            <option value="Keluarga">Keluarga</option>
                            <option value="Teman Kantor">Teman Kantor</option>
                            <option value="Teman Sekolah">Teman Sekolah</option>
                            <option value="VIP">VIP</option>
                        </select>
                    </div>
                    <button type="submit" class="w-full py-2 bg-gray-900 text-white rounded-lg text-sm hover:bg-black transition">
                        <i class="fa-solid fa-plus mr-1"></i> Simpan Tamu
                    </button>
                </form>
            </div>
        </div>

        {{-- LIST TAMU & TOMBOL WA --}}
        <div class="lg:col-span-2">
            <div class="bg-white rounded-xl shadow-sm border border-gray-100 overflow-hidden">
                <div class="p-4 border-b bg-gray-50 flex justify-between items-center">
                    <h3 class="font-bold text-gray-700">Daftar Tamu</h3>
                    <input type="text" wire:model.live.debounce.300ms="search" placeholder="Cari nama..." class="text-xs rounded-full border-gray-300 px-4 py-1">
                </div>
                
                <div class="overflow-x-auto">
                    <table class="w-full text-sm text-left">
                        <thead class="bg-gray-50 text-gray-500 font-medium">
                            <tr>
                                <th class="px-4 py-3">Nama</th>
                                <th class="px-4 py-3 text-center">RSVP</th>
                                <th class="px-4 py-3">Aksi (Share)</th>
                                <th class="px-4 py-3 text-right">Hapus</th>
                            </tr>
                        </thead>
                        <tbody class="divide-y divide-gray-100">
                            @forelse($guests as $guest)
                                <tr class="hover:bg-gray-50 transition">
                                    <td class="px-4 py-3">
                                        <p class="font-bold text-gray-800">{{ $guest->name }}</p>
                                        <span class="text-xs text-gray-500 bg-gray-100 px-2 py-0.5 rounded">{{ $guest->category }}</span>
                                    </td>
                                    <td class="px-4 py-3 text-center">
                                        @if($guest->rsvp_status == 1)
                                            <span class="text-xs bg-green-100 text-green-700 px-2 py-1 rounded-full">Hadir ({{ $guest->pax }})</span>
                                        @elseif($guest->rsvp_status == 2)
                                            <span class="text-xs bg-red-100 text-red-700 px-2 py-1 rounded-full">Tidak</span>
                                        @else
                                            <span class="text-xs bg-gray-100 text-gray-500 px-2 py-1 rounded-full">-</span>
                                        @endif
                                    </td>
                                    <td class="px-4 py-3">
                                        @php
                                            // Generate Link
                                            $link = route('invitation.show', ['slug' => $invitation->slug, 'to' => $guest->slug]);
                                            
                                            // Pesan WA Template
                                            $msg = "Kepada Yth. {$guest->name},\n\n";
                                            $msg .= "Tanpa mengurangi rasa hormat, kami mengundang Anda untuk hadir di acara pernikahan kami.\n\n";
                                            $msg .= "Info lengkap & RSVP:\n{$link}\n\n";
                                            $msg .= "Merupakan suatu kehormatan bagi kami apabila Anda berkenan hadir.\nTerima kasih.";
                                            
                                            $waUrl = "https://wa.me/{$guest->phone}?text=" . urlencode($msg);
                                        @endphp

                                        <div class="flex gap-2">
                                            {{-- Tombol WA --}}
                                            @if($guest->phone)
                                                <a href="{{ $waUrl }}" target="_blank" class="bg-green-500 text-white px-3 py-1.5 rounded-md hover:bg-green-600 text-xs flex items-center gap-1">
                                                    <i class="fa-brands fa-whatsapp"></i> Kirim
                                                </a>
                                            @else
                                                <button disabled class="bg-gray-200 text-gray-400 px-3 py-1.5 rounded-md text-xs cursor-not-allowed">
                                                    <i class="fa-brands fa-whatsapp"></i>
                                                </button>
                                            @endif
                                            
                                            {{-- Tombol Copy Link --}}
                                            <button onclick="navigator.clipboard.writeText('{{ $link }}'); alert('Link tersalin!')" 
                                                    class="bg-blue-50 text-blue-600 border border-blue-200 px-3 py-1.5 rounded-md hover:bg-blue-100 text-xs">
                                                <i class="fa-solid fa-copy"></i> Copy
                                            </button>
                                        </div>
                                    </td>
                                    <td class="px-4 py-3 text-right">
                                        <button wire:click="delete({{ $guest->id }})" wire:confirm="Hapus tamu ini?" class="text-red-400 hover:text-red-600">
                                            <i class="fa-solid fa-trash"></i>
                                        </button>
                                    </td>
                                </tr>
                            @empty
                                <tr>
                                    <td colspan="4" class="px-4 py-8 text-center text-gray-400 text-sm">
                                        Belum ada tamu. Tambahkan di formulir samping.
                                    </td>
                                </tr>
                            @endforelse
                        </tbody>
                    </table>
                </div>
                
                <div class="p-4 border-t">
                    {{ $guests->links() }}
                </div>
            </div>
        </div>
    </div>
</div>