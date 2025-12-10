<div class="py-6">
    <div class="flex justify-between items-center mb-6">
        <div>
            <h2 class="font-bold text-xl text-gray-800">Edit Undangan</h2>
            <p class="text-sm text-gray-500">{{ $invitation->title }}</p>
        </div>

        <div class="flex gap-2">
            <a href="{{ route('invitation.show', $invitation->slug) }}" target="_blank"
                class="px-4 py-2 bg-white border text-gray-700 rounded-lg hover:bg-gray-50">
                <i class="fa-solid fa-eye"></i> Preview
            </a>
            <button wire:click="save"
                class="px-4 py-2 bg-pink-600 text-white rounded-lg hover:bg-pink-700 flex items-center">
                <span wire:loading.remove wire:target="save"><i class="fa-solid fa-save mr-2"></i> Simpan</span>
                <span wire:loading wire:target="save"><i class="fa-solid fa-spinner fa-spin mr-2"></i> Saving...</span>
            </button>
        </div>
    </div>

    @if (session('message'))
        <div class="mb-4 bg-green-100 border border-green-400 text-green-700 px-4 py-3 rounded relative">
            {{ session('message') }}
        </div>
    @endif

    <div class="grid grid-cols-1 lg:grid-cols-4 gap-6">

        {{-- SIDEBAR NAVIGASI TAB --}}
        <div class="lg:col-span-1">
            <div class="bg-white rounded-lg shadow-sm overflow-hidden">
                <nav class="flex flex-col">
                    <button wire:click="$set('activeTab', 'couple')"
                        class="px-4 py-3 text-left border-l-4 hover:bg-gray-50 {{ $activeTab === 'couple' ? 'border-pink-500 bg-pink-50 text-pink-700 font-medium' : 'border-transparent text-gray-600' }}">
                        <i class="fa-solid fa-user-group w-5 text-center mr-2"></i> Mempelai
                    </button>
                    <button wire:click="$set('activeTab', 'events')"
                        class="px-4 py-3 text-left border-l-4 hover:bg-gray-50 {{ $activeTab === 'events' ? 'border-pink-500 bg-pink-50 text-pink-700 font-medium' : 'border-transparent text-gray-600' }}">
                        <i class="fa-solid fa-calendar-days w-5 text-center mr-2"></i> Acara
                    </button>
                    <button wire:click="$set('activeTab', 'gallery')"
                        class="px-4 py-3 text-left border-l-4 hover:bg-gray-50 {{ $activeTab === 'gallery' ? 'border-pink-500 bg-pink-50 text-pink-700 font-medium' : 'border-transparent text-gray-600' }}">
                        <i class="fa-solid fa-images w-5 text-center mr-2"></i> Galeri
                    </button>
                    <button wire:click="$set('activeTab', 'gifts')"
                        class="px-4 py-3 text-left border-l-4 hover:bg-gray-50 {{ $activeTab === 'gifts' ? 'border-pink-500 bg-pink-50 text-pink-700 font-medium' : 'border-transparent text-gray-600' }}">
                        <i class="fa-solid fa-gift w-5 text-center mr-2"></i> Kado Digital
                    </button>
                    <button wire:click="$set('activeTab', 'theme')"
                        class="px-4 py-3 text-left border-l-4 hover:bg-gray-50 {{ $activeTab === 'theme' ? 'border-pink-500 bg-pink-50 text-pink-700 font-medium' : 'border-transparent text-gray-600' }}">
                        <i class="fa-solid fa-palette w-5 text-center mr-2"></i> Tema
                    </button>
                </nav>
            </div>
        </div>

        {{-- AREA KONTEN UTAMA --}}
        <div class="lg:col-span-3">
            <div class="bg-white rounded-lg shadow-sm p-6 min-h-[400px]">

                {{-- TAB COUPLE --}}
                @if ($activeTab === 'couple')
                    <h3 class="font-bold text-lg mb-4 border-b pb-2">Data Pengantin</h3>

                    <div class="mb-6">
                        <label class="block text-sm font-medium mb-1">Quote / Kata Pengantar</label>
                        <textarea wire:model="couple.quote" rows="3" class="w-full rounded border-gray-300"></textarea>
                    </div>

                    <div class="grid md:grid-cols-2 gap-8">
                        {{-- Form Pria --}}
                        <div class="space-y-3">
                            <h4 class="font-semibold text-blue-600">Mempelai Pria</h4>
                            <div><label class="text-xs text-gray-500">Panggilan</label><input type="text"
                                    wire:model="couple.groom.nickname" class="w-full rounded text-sm border-gray-300">
                            </div>
                            <div><label class="text-xs text-gray-500">Nama Lengkap</label><input type="text"
                                    wire:model="couple.groom.fullname" class="w-full rounded text-sm border-gray-300">
                            </div>
                            <div><label class="text-xs text-gray-500">Nama Ayah</label><input type="text"
                                    wire:model="couple.groom.father" class="w-full rounded text-sm border-gray-300">
                            </div>
                            <div><label class="text-xs text-gray-500">Nama Ibu</label><input type="text"
                                    wire:model="couple.groom.mother" class="w-full rounded text-sm border-gray-300">
                            </div>
                        </div>

                        {{-- Form Wanita --}}
                        <div class="space-y-3">
                            <h4 class="font-semibold text-pink-600">Mempelai Wanita</h4>
                            <div><label class="text-xs text-gray-500">Panggilan</label><input type="text"
                                    wire:model="couple.bride.nickname" class="w-full rounded text-sm border-gray-300">
                            </div>
                            <div><label class="text-xs text-gray-500">Nama Lengkap</label><input type="text"
                                    wire:model="couple.bride.fullname" class="w-full rounded text-sm border-gray-300">
                            </div>
                            <div><label class="text-xs text-gray-500">Nama Ayah</label><input type="text"
                                    wire:model="couple.bride.father" class="w-full rounded text-sm border-gray-300">
                            </div>
                            <div><label class="text-xs text-gray-500">Nama Ibu</label><input type="text"
                                    wire:model="couple.bride.mother" class="w-full rounded text-sm border-gray-300">
                            </div>
                        </div>
                    </div>
                @endif

                {{-- TAB EVENTS --}}
                @if ($activeTab === 'events')
                    <div class="flex justify-between mb-4 border-b pb-2">
                        <h3 class="font-bold text-lg">Rangkaian Acara</h3>
                        <button wire:click="addEvent"
                            class="bg-gray-800 text-white text-xs px-3 py-1 rounded hover:bg-black">
                            + Tambah Sesi
                        </button>
                    </div>

                    <div class="space-y-6">
                        @foreach ($events as $index => $event)
                            <div class="bg-gray-50 p-4 rounded border relative">
                                <button wire:click="removeEvent({{ $index }})"
                                    class="absolute top-2 right-2 text-red-400 hover:text-red-600" title="Hapus Sesi">
                                    <i class="fa-solid fa-times"></i>
                                </button>

                                <div class="grid md:grid-cols-2 gap-4">
                                    <div>
                                        <label class="text-xs font-semibold">Judul Acara</label>
                                        <input type="text" wire:model="events.{{ $index }}.title"
                                            class="w-full rounded text-sm border-gray-300">
                                    </div>
                                    <div>
                                        <label class="text-xs font-semibold">Waktu</label>
                                        <input type="datetime-local" wire:model="events.{{ $index }}.date"
                                            class="w-full rounded text-sm border-gray-300">
                                    </div>
                                    <div class="md:col-span-2">
                                        <label class="text-xs font-semibold">Lokasi (Gedung/Hotel)</label>
                                        <input type="text" wire:model="events.{{ $index }}.location"
                                            class="w-full rounded text-sm border-gray-300">
                                    </div>
                                    <div class="md:col-span-2">
                                        <label class="text-xs font-semibold">Alamat Lengkap</label>
                                        <textarea wire:model="events.{{ $index }}.address" rows="2"
                                            class="w-full rounded text-sm border-gray-300"></textarea>
                                    </div>
                                    <div class="md:col-span-2">
                                        <label class="text-xs font-semibold">Link Google Maps</label>
                                        <input type="text" wire:model="events.{{ $index }}.map_link"
                                            class="w-full rounded text-sm border-gray-300">
                                    </div>
                                </div>
                            </div>
                        @endforeach
                    </div>
                @endif

                {{-- TAB GALLERY --}}
                @if ($activeTab === 'gallery')
                    <h3 class="font-bold text-lg mb-4 border-b pb-2">Galeri Foto</h3>

                    <div class="mb-4">
                        <input type="file" wire:model="newGalleryImages" multiple
                            class="block w-full text-sm text-gray-500 file:mr-4 file:py-2 file:px-4 file:rounded-full file:border-0 file:text-sm file:font-semibold file:bg-pink-50 file:text-pink-700 hover:file:bg-pink-100" />
                        <p class="text-xs text-gray-500 mt-1">Upload banyak foto sekaligus. Klik Simpan untuk
                            mengupload.</p>
                    </div>

                    @if ($newGalleryImages)
                        <div class="flex gap-2 mb-4 overflow-x-auto">
                            @foreach ($newGalleryImages as $img)
                                <img src="{{ $img->temporaryUrl() }}" class="h-20 w-20 object-cover rounded shadow">
                            @endforeach
                        </div>
                    @endif

                    <div class="grid grid-cols-2 md:grid-cols-4 gap-4 mt-4">
                        @foreach ($existingGallery as $index => $path)
                            <div class="relative group">
                                <img src="{{ asset($path) }}" class="w-full h-32 object-cover rounded shadow-sm">
                                <button wire:click="removeGalleryImage({{ $index }})"
                                    class="absolute inset-0 bg-black/50 text-white opacity-0 group-hover:opacity-100 flex items-center justify-center transition">
                                    Hapus
                                </button>
                            </div>
                        @endforeach
                    </div>
                @endif

                {{-- TAB THEME --}}
                @if ($activeTab === 'theme')
                    <h3 class="font-bold text-lg mb-4 border-b pb-2">Tampilan</h3>

                    <div class="grid md:grid-cols-2 gap-6">
                        <div>
                            <label class="block text-sm font-medium mb-1">Pilih Template</label>
                            <select wire:model="theme_template" class="w-full rounded border-gray-300">
                                <option value="regular">Default White</option>
                                <option value="rustic">Rustic Nature</option>
                                <option value="elegant">Elegant Gold</option>
                            </select>
                        </div>
                        <div>
                            <label class="block text-sm font-medium mb-1">Warna Utama</label>
                            <div class="flex items-center gap-2">
                                <input type="color" wire:model="theme.primary_color"
                                    class="h-10 w-10 p-1 rounded border">
                                <input type="text" wire:model="theme.primary_color"
                                    class="w-full rounded border-gray-300">
                            </div>
                        </div>
                        <div class="md:col-span-2">
                            <label class="block text-sm font-medium mb-1">Musik Latar (URL MP3)</label>
                            <input type="text" wire:model="theme.music_url" placeholder="https://..."
                                class="w-full rounded border-gray-300">
                            <p class="text-xs text-gray-500">Masukkan link file .mp3 langsung.</p>
                        </div>
                    </div>
                @endif

                {{-- konten gift --}}
                @if ($activeTab === 'gifts')
                    <div class="flex justify-between items-center mb-4 border-b pb-2">
                        <h3 class="font-bold text-lg">Amplop Digital / Hadiah</h3>
                        <button wire:click="addGift"
                            class="bg-gray-800 text-white text-xs px-3 py-1 rounded hover:bg-black">
                            + Tambah Bank
                        </button>
                    </div>

                    <div class="space-y-4">
                        @forelse($gifts as $index => $gift)
                            <div class="bg-gray-50 p-4 rounded border relative grid md:grid-cols-3 gap-4">
                                <button wire:click="removeGift({{ $index }})"
                                    class="absolute top-2 right-2 text-red-400 hover:text-red-600">
                                    <i class="fa-solid fa-trash"></i>
                                </button>

                                <div>
                                    <label class="text-xs font-semibold">Nama Bank / Wallet</label>
                                    <select wire:model="gifts.{{ $index }}.bank_name"
                                        class="w-full rounded text-sm border-gray-300">
                                        <option value="">Pilih...</option>
                                        <option value="BCA">BCA</option>
                                        <option value="BRI">BRI</option>
                                        <option value="Mandiri">Mandiri</option>
                                        <option value="BNI">BNI</option>
                                        <option value="Dana">Dana</option>
                                        <option value="Gopay">Gopay</option>
                                        <option value="OVO">OVO</option>
                                        <option value="Lainnya">Lainnya</option>
                                    </select>
                                </div>
                                <div>
                                    <label class="text-xs font-semibold">No. Rekening</label>
                                    <input type="number" wire:model="gifts.{{ $index }}.account_number"
                                        placeholder="123xxx" class="w-full rounded text-sm border-gray-300">
                                </div>
                                <div>
                                    <label class="text-xs font-semibold">Atas Nama</label>
                                    <input type="text" wire:model="gifts.{{ $index }}.account_name"
                                        class="w-full rounded text-sm border-gray-300">
                                </div>
                            </div>
                        @empty
                            <div class="text-center text-gray-400 py-6 border border-dashed rounded">
                                Fitur ini opsional. Tambahkan jika ingin menerima transfer hadiah.
                            </div>
                        @endforelse
                    </div>
                @endif

            </div>
        </div>
    </div>
</div>
