<div class="py-6 max-w-4xl mx-auto animate-fade-in-up">

    <div class="mb-8 text-center">
        <h2 class="font-serif font-bold text-3xl text-[#5E4926]">Aktivasi Undangan</h2>
        <p class="text-[#9A7D4C] text-sm mt-1">Pilih paket dan lakukan pembayaran agar undangan bisa diakses tamu.</p>
    </div>

    <div class="grid grid-cols-1 md:grid-cols-2 gap-8">

        {{-- KIRI: PILIH PAKET --}}
        <div class="space-y-6">
            @foreach ($packages as $key => $pkg)
                <label class="block cursor-pointer relative group">
                    <input type="radio" wire:model.live="selectedPackage" value="{{ $key }}"
                        class="peer sr-only">

                    {{-- Card Container --}}
                    <div
                        class="p-6 rounded-2xl border-2 transition-all duration-300 relative overflow-hidden
                        {{ $selectedPackage === $key
                            ? 'bg-white border-[#B89760] shadow-[0_4px_20px_rgba(184,151,96,0.2)]'
                            : 'bg-[#F9F7F2] border-transparent hover:border-[#E6D9B8]' }}">

                        {{-- Header Paket --}}
                        <div class="text-center mb-6 border-b border-dashed border-[#E6D9B8] pb-4">
                            <h3 class="font-serif font-bold text-xl text-[#5E4926] mb-1">{{ $pkg['name'] }}</h3>
                            <span class="text-xs font-bold uppercase tracking-wider text-[#9A7D4C]">
                                {{ $key == 'basic' ? 'Regular' : 'Custom' }}
                            </span>

                            <div class="mt-4 flex flex-col items-center justify-center">
                                {{-- Harga Coret --}}
                                <span class="text-gray-400 text-sm line-through decoration-red-400">
                                    IDR {{ number_format($pkg['original_price'], 0, ',', '.') }}
                                </span>
                                {{-- Harga Asli --}}
                                <span class="text-2xl font-bold text-[#5E4926]">
                                    IDR {{ number_format($pkg['price'], 0, ',', '.') }}
                                </span>
                            </div>
                        </div>

                        {{-- List Fitur (Looping dari 'benefits') --}}
                        <ul class="text-xs text-[#7C6339] space-y-2.5">
                            @foreach ($pkg['benefits'] as $benefit)
                                <li class="flex items-start gap-2.5">
                                    {{-- Icon Check Biru Muda (Sesuai Gambar) --}}
                                    <i class="fa-solid fa-check text-[#5FAEC9] mt-0.5"></i>
                                    <span>{{ $benefit }}</span>
                                </li>
                            @endforeach
                        </ul>

                        {{-- Check Icon Selection (Pojok Kanan) --}}
                        <div
                            class="absolute top-4 right-4 text-[#B89760] opacity-0 peer-checked:opacity-100 transition transform scale-0 peer-checked:scale-100 duration-300">
                            <div
                                class="w-8 h-8 bg-[#B89760] rounded-full flex items-center justify-center text-white shadow-md">
                                <i class="fa-solid fa-check"></i>
                            </div>
                        </div>

                        {{-- Button Fake (Visual Saja) --}}
                        <div class="mt-6 text-center">
                            <div
                                class="w-full py-2 rounded-lg font-bold text-sm transition
                                {{ $selectedPackage === $key ? 'bg-[#E6C65C] text-[#5E4926]' : 'bg-gray-200 text-gray-500' }}">
                                <i class="fa-solid fa-cart-shopping mr-1"></i> Pesan Paket
                            </div>
                        </div>

                    </div>
                </label>
            @endforeach
        </div>

        {{-- KANAN: INSTRUKSI & UPLOAD --}}
        <div class="bg-white p-8 rounded-3xl border border-[#E6D9B8] shadow-sm">
            <h4 class="font-bold text-[#5E4926] mb-4 flex items-center gap-2">
                <i class="fa-solid fa-wallet text-[#B89760]"></i> Transfer Pembayaran
            </h4>

            <div class="bg-[#F9F7F2] p-4 rounded-xl border border-[#F2ECDC] mb-6">
                <p class="text-xs text-[#9A7D4C] uppercase font-bold mb-1">Bank BCA</p>
                <p class="font-mono text-xl font-bold text-[#5E4926] mb-1">123 456 7890</p>
                <p class="text-xs text-[#7C6339]">A.N PT Arvaya De Aure</p>
                <p class="mt-3 text-sm font-bold text-[#B89760]">
                    Total: Rp {{ number_format($packages[$selectedPackage]['price'], 0, ',', '.') }}
                </p>
            </div>

            <form wire:submit="save" class="space-y-4">
                <div>
                    <label class="block text-xs font-bold text-[#7C6339] uppercase mb-2">Upload Bukti Transfer</label>
                    <div
                        class="border-2 border-dashed border-[#E6D9B8] rounded-xl p-6 text-center hover:bg-[#F9F7F2] transition relative">
                        <input type="file" wire:model="proofImage"
                            class="absolute inset-0 w-full h-full opacity-0 cursor-pointer">

                        @if ($proofImage)
                            <img src="{{ $proofImage->temporaryUrl() }}"
                                class="h-32 mx-auto rounded-lg shadow-sm object-cover">
                        @else
                            <i class="fa-solid fa-cloud-arrow-up text-3xl text-[#E6D9B8] mb-2"></i>
                            <p class="text-xs text-[#9A7D4C]">Klik untuk upload (JPG/PNG)</p>
                        @endif
                    </div>
                    @error('proofImage')
                        <span class="text-red-500 text-xs mt-1 block">{{ $message }}</span>
                    @enderror
                </div>

                <button type="submit"
                    class="w-full py-3 bg-[#5E4926] text-white rounded-xl font-bold hover:bg-[#403013] transition shadow-lg flex justify-center gap-2">
                    <span wire:loading.remove>Konfirmasi Pembayaran</span>
                    <span wire:loading><i class="fa-solid fa-circle-notch fa-spin"></i> Sending...</span>
                </button>
            </form>
        </div>

    </div>
</div>
