<div class="py-6 max-w-4xl mx-auto animate-fade-in-up dashboard-ui">

    <div class="mb-10 text-center">
        <h2 class="font-serif font-bold text-3xl text-[#E0E0E0]">Edit Profil</h2>
        <p class="text-[#A0A0A0] text-sm mt-1">Perbarui informasi pribadi Anda.</p>
    </div>

    <div class="bg-[#1a1a1a] p-8 rounded-3xl border border-[#333333] shadow-xl">
        <form wire:submit="save" class="space-y-6">

            {{-- Avatar Upload --}}
            <div class="flex flex-col items-center gap-4 mb-6">
                <div class="relative group">
                    @if ($newAvatar)
                        <img src="{{ $newAvatar->temporaryUrl() }}"
                            class="w-24 h-24 rounded-full object-cover border-2 border-[#D4AF37]">
                    @elseif($avatar)
                        <img src="{{ $avatar }}" class="w-24 h-24 rounded-full object-cover border-2 border-[#D4AF37]">
                    @else
                        <div
                            class="w-24 h-24 rounded-full bg-gradient-to-br from-[#D4AF37] to-[#B4912F] flex items-center justify-center text-[#121212] font-serif font-bold text-3xl">
                            {{ substr($name, 0, 1) }}
                        </div>
                    @endif

                    <label for="avatar-upload"
                        class="absolute bottom-0 right-0 bg-[#252525] text-[#D4AF37] p-2 rounded-full border border-[#333333] cursor-pointer hover:bg-[#333] transition shadow-md">
                        <i class="fa-solid fa-camera"></i>
                        <input type="file" id="avatar-upload" wire:model="newAvatar" class="hidden" accept="image/*">
                    </label>
                </div>
                <p class="text-xs text-[#888]">Klik ikon kamera untuk mengganti foto.</p>
                @error('newAvatar') <span class="text-red-500 text-xs">{{ $message }}</span> @enderror
            </div>

            {{-- Name --}}
            <div>
                <label class="block text-xs font-bold text-[#A0A0A0] uppercase tracking-wider mb-2">Nama Lengkap</label>
                <input type="text" wire:model="name"
                    class="w-full rounded-xl bg-[#252525] border-[#333333] text-[#E0E0E0] focus:border-[#D4AF37] focus:ring-2 focus:ring-[#D4AF37]/20 transition-all text-sm">
                @error('name') <span class="text-red-500 text-xs mt-1 block">{{ $message }}</span> @enderror
            </div>

            {{-- Email --}}
            <div>
                <label class="block text-xs font-bold text-[#A0A0A0] uppercase tracking-wider mb-2">Email
                    Address</label>
                <input type="email" wire:model="email"
                    class="w-full rounded-xl bg-[#252525] border-[#333333] text-[#E0E0E0] focus:border-[#D4AF37] focus:ring-2 focus:ring-[#D4AF37]/20 transition-all text-sm">
                @error('email') <span class="text-red-500 text-xs mt-1 block">{{ $message }}</span> @enderror
            </div>

            {{-- Phone Number --}}
            <div>
                <label class="block text-xs font-bold text-[#A0A0A0] uppercase tracking-wider mb-2">Nomor
                    Telepon</label>
                <div class="relative">
                    <span class="absolute inset-y-0 left-0 pl-3 flex items-center pointer-events-none text-[#666]">
                        <i class="fa-solid fa-phone"></i>
                    </span>
                    <input type="text" wire:model="phone_number" placeholder="0812..."
                        class="w-full pl-10 rounded-xl bg-[#252525] border-[#333333] text-[#E0E0E0] focus:border-[#D4AF37] focus:ring-2 focus:ring-[#D4AF37]/20 transition-all text-sm">
                </div>
                @error('phone_number') <span class="text-red-500 text-xs mt-1 block">{{ $message }}</span> @enderror
            </div>

            <div class="pt-4 flex justify-end">
                <button type="submit"
                    class="px-8 py-3 bg-[#D4AF37] text-[#121212] rounded-xl font-bold hover:bg-[#B4912F] transition shadow-lg flex items-center gap-2">
                    <span wire:loading.remove>Simpan Perubahan</span>
                    <span wire:loading><i class="fa-solid fa-circle-notch fa-spin"></i> Menyimpan...</span>
                </button>
            </div>

        </form>
    </div>
</div>