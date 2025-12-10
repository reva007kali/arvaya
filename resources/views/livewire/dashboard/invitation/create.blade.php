<div class="max-w-2xl mx-auto py-6">
    <div class="bg-white p-8 rounded-xl shadow-sm border border-gray-100">
        <h2 class="text-xl font-bold mb-6 text-gray-800">Buat Undangan Baru</h2>
        
        <form wire:submit="save" class="space-y-6">
            
            {{-- Judul --}}
            <div>
                <label class="block text-sm font-medium text-gray-700 mb-1">Judul Undangan</label>
                <input type="text" wire:model.live.debounce.500ms="title" 
                       class="w-full rounded-lg border-gray-300 focus:border-pink-500 focus:ring-pink-500" 
                       placeholder="Contoh: The Wedding of Reza & Adinda">
                @error('title') <span class="text-red-500 text-xs">{{ $message }}</span> @enderror
            </div>

            {{-- Slug --}}
            <div>
                <label class="block text-sm font-medium text-gray-700 mb-1">Link URL</label>
                <div class="flex">
                    <span class="inline-flex items-center px-3 rounded-l-lg border border-r-0 border-gray-300 bg-gray-50 text-gray-500 text-sm">
                        {{ request()->getHost() }}/
                    </span>
                    <input type="text" wire:model.blur="slug" 
                           class="flex-1 block w-full rounded-none rounded-r-lg border-gray-300 focus:border-pink-500 sm:text-sm" 
                           placeholder="reza-adinda">
                </div>
                @error('slug') <span class="text-red-500 text-xs">{{ $message }}</span> @enderror
            </div>

            <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                {{-- Pria --}}
                <div>
                    <label class="block text-sm font-medium text-gray-700 mb-1">Panggilan Pria</label>
                    <input type="text" wire:model="groom_name" class="w-full rounded-lg border-gray-300">
                    @error('groom_name') <span class="text-red-500 text-xs">{{ $message }}</span> @enderror
                </div>
                
                {{-- Wanita --}}
                <div>
                    <label class="block text-sm font-medium text-gray-700 mb-1">Panggilan Wanita</label>
                    <input type="text" wire:model="bride_name" class="w-full rounded-lg border-gray-300">
                    @error('bride_name') <span class="text-red-500 text-xs">{{ $message }}</span> @enderror
                </div>
            </div>

            {{-- Tanggal --}}
            <div>
                <label class="block text-sm font-medium text-gray-700 mb-1">Tanggal Acara</label>
                <input type="date" wire:model="event_date" class="w-full rounded-lg border-gray-300">
                @error('event_date') <span class="text-red-500 text-xs">{{ $message }}</span> @enderror
            </div>

            <div class="pt-4 flex justify-end gap-3">
                <a href="{{ route('dashboard.index') }}" class="px-4 py-2 text-gray-600 hover:bg-gray-100 rounded-lg">Batal</a>
                <button type="submit" class="px-6 py-2 bg-pink-600 text-white rounded-lg hover:bg-pink-700">
                    <span wire:loading.remove>Simpan & Lanjut</span>
                    <span wire:loading>Processing...</span>
                </button>
            </div>
        </form>
    </div>
</div>