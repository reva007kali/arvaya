<div class="bg-white/80 backdrop-blur-md p-6 rounded-xl shadow-lg border border-white/50">
    <h3 class="font-serif text-2xl font-bold text-gray-800 mb-4 text-center">Konfirmasi Kehadiran</h3>

    @if ($isSubmitted)
        <div class="text-center py-6">
            <div class="inline-flex items-center justify-center w-16 h-16 bg-green-100 rounded-full mb-4">
                <i class="fa-solid fa-check text-2xl text-green-600"></i>
            </div>
            <h4 class="text-lg font-semibold text-gray-800">Terima Kasih!</h4>
            <p class="text-gray-600">Konfirmasi Anda telah kami terima.</p>
            <button wire:click="$set('isSubmitted', false)" class="mt-4 text-sm text-pink-600 underline">
                Ubah Konfirmasi
            </button>
        </div>
    @else
        <form wire:submit="save" class="space-y-4 text-left">
            <div>
                <label class="block text-sm font-medium text-gray-700 mb-1">Nama Tamu</label>
                <input type="text" wire:model="name"
                    class="w-full rounded-lg border-gray-300 focus:border-pink-500 focus:ring-pink-500"
                    {{ $guest ? 'readonly' : '' }} placeholder="Nama Lengkap">
                @if ($guest)
                    <p class="text-xs text-green-600 mt-1">*Nama sesuai undangan khusus</p>
                @endif
            </div>

            <div>
                <label class="block text-sm font-medium text-gray-700 mb-1">Nomor WhatsApp (Opsional)</label>
                <input type="text" wire:model="phone"
                    class="w-full rounded-lg border-gray-300 focus:border-pink-500">
            </div>

            <div>
                <label class="block text-sm font-medium text-gray-700 mb-1">Jumlah Hadir</label>
                <select wire:model="pax" class="w-full rounded-lg border-gray-300 focus:border-pink-500">
                    @for ($i = 1; $i <= 5; $i++)
                        <option value="{{ $i }}">{{ $i }} Orang</option>
                    @endfor
                </select>
            </div>

            <div>
                <label class="block text-sm font-medium text-gray-700 mb-1">Konfirmasi</label>
                <div class="flex gap-4">
                    <label class="flex items-center">
                        <input type="radio" wire:model="rsvp_status" value="1"
                            class="text-pink-600 focus:ring-pink-500">
                        <span class="ml-2">Hadir</span>
                    </label>
                    <label class="flex items-center">
                        <input type="radio" wire:model="rsvp_status" value="2"
                            class="text-pink-600 focus:ring-pink-500">
                        <span class="ml-2">Maaf, Tidak Bisa</span>
                    </label>
                </div>
            </div>

            <button type="submit"
                class="w-full py-3 bg-pink-600 text-white font-bold rounded-lg hover:bg-pink-700 transition transform hover:scale-[1.02]">
                <span wire:loading.remove>Kirim Konfirmasi</span>
                <span wire:loading>Memproses...</span>
            </button>
        </form>
    @endif
</div>
