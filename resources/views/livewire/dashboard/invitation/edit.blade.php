<div class="py-2 animate-fade-in-up">
    {{-- HEADER --}}
    <div class="flex flex-col md:flex-row justify-between items-start md:items-center mb-8 gap-4">
        <div>
            <div class="flex items-center gap-2 text-[#9A7D4C] text-xs font-bold uppercase tracking-widest mb-1">
                <a href="{{ route('dashboard.index') }}" class="hover:text-[#5E4926] transition flex items-center gap-1">
                    <i class="fa-solid fa-arrow-left"></i> Dashboard
                </a>
                <span>/</span> <span>Editor</span>
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

    {{-- Alert --}}
    @if (session('message'))
        <div
            class="mb-6 bg-[#F2ECDC] border border-[#B89760] text-[#7C6339] px-6 py-4 rounded-xl flex items-center gap-3 shadow-sm relative overflow-hidden">
            <div class="w-1 absolute left-0 top-0 bottom-0 bg-[#B89760]"></div>
            <i class="fa-solid fa-circle-check text-xl text-[#B89760]"></i>
            <span class="font-medium">{{ session('message') }}</span>
        </div>
    @endif

    <div class="grid grid-cols-1 lg:grid-cols-4 gap-8">

        {{-- SIDEBAR NAV --}}
        <div class="lg:col-span-1">
            <div
                class="bg-white rounded-2xl shadow-[0_4px_20px_rgb(230,217,184,0.3)] border border-[#E6D9B8]/60 overflow-hidden sticky top-24">
                <nav class="flex flex-col p-2 space-y-1">
                    @php $tabs = ['couple'=>['icon'=>'fa-user-group','label'=>'Mempelai'], 'events'=>['icon'=>'fa-calendar-days','label'=>'Acara'], 'gallery'=>['icon'=>'fa-images','label'=>'Galeri'], 'gifts'=>['icon'=>'fa-gift','label'=>'Kado'], 'theme'=>['icon'=>'fa-palette','label'=>'Tema & Musik']]; @endphp
                    @foreach ($tabs as $key => $tab)
                        <button wire:click="$set('activeTab', '{{ $key }}')"
                            class="px-4 py-3 text-left rounded-xl flex items-center gap-3 transition-all duration-300 {{ $activeTab === $key ? 'bg-[#F9F7F2] text-[#B89760] font-bold shadow-sm border border-[#E6D9B8]' : 'text-[#7C6339] hover:bg-[#F9F7F2] hover:text-[#9A7D4C] border border-transparent' }}">
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

        {{-- MAIN CONTENT --}}
        <div class="lg:col-span-3">
            <div
                class="bg-white rounded-3xl shadow-[0_10px_40px_-10px_rgba(184,151,96,0.1)] border border-[#E6D9B8]/60 p-6 md:p-8 min-h-[600px] relative">
                <div
                    class="absolute top-0 right-0 w-64 h-64 bg-[#F9F7F2] rounded-bl-[100px] -z-0 pointer-events-none opacity-50">
                </div>
                <div class="relative z-10">

                    {{-- TAB: COUPLE --}}
                    @if ($activeTab === 'couple')
                        <h3 class="font-serif font-bold text-2xl text-[#5E4926] mb-6 pb-2 border-b border-[#F2ECDC]">
                            Data Pengantin</h3>
                        <div
                            class="bg-gradient-to-br from-[#FFFBF2] to-[#F9F7F2] p-6 rounded-2xl border border-[#E6D9B8] mb-8 relative overflow-hidden group">
                            <div
                                class="absolute top-0 right-0 -mt-4 -mr-4 text-[#E6D9B8] opacity-30 group-hover:opacity-50 transition transform group-hover:scale-110">
                                <i class="fa-solid fa-wand-magic-sparkles text-8xl"></i></div>
                            <div class="relative z-10">
                                <h4 class="font-bold text-[#5E4926] flex items-center gap-2 mb-2 text-lg"><i
                                        class="fa-solid fa-robot text-[#B89760]"></i> AI Writer</h4>
                                <div class="flex flex-col md:flex-row gap-4 items-end">
                                    <div class="w-full md:w-1/3">
                                        <select wire:model="aiTone"
                                            class="w-full rounded-lg bg-white border-[#E6D9B8] text-[#5E4926] text-sm focus:border-[#B89760] focus:ring-[#B89760]">
                                            <option value="islami">Islami</option>
                                            <option value="modern">Modern</option>
                                            <option value="formal">Formal</option>
                                        </select>
                                    </div>
                                    <button wire:click="generateQuote" wire:loading.attr="disabled"
                                        class="px-5 py-2.5 bg-[#5E4926] text-white rounded-lg text-sm font-bold hover:bg-[#403013] shadow-md transition disabled:opacity-50">
                                        <span wire:loading.remove>Generate Quote</span><span
                                            wire:loading>Thinking...</span>
                                    </button>
                                </div>
                            </div>
                        </div>
                        <div class="mb-8">
                            <label class="block text-xs font-bold text-[#7C6339] uppercase tracking-wider mb-2">Kata
                                Pengantar</label>
                            <textarea wire:model="couple.quote" rows="4"
                                class="w-full rounded-xl bg-[#F9F7F2] border-[#E6D9B8] text-[#5E4926] focus:border-[#B89760] focus:ring-[#B89760]"></textarea>
                        </div>
                        <div class="grid md:grid-cols-2 gap-8">
                            @foreach (['groom' => 'Mempelai Pria', 'bride' => 'Mempelai Wanita'] as $type => $label)
                                <div class="space-y-4">
                                    <h4
                                        class="font-serif font-bold text-xl text-[#5E4926] border-b border-[#E6D9B8] pb-2">
                                        {{ $label }}</h4>
                                    <div><label class="text-xs text-[#9A7D4C] font-bold">Panggilan</label><input
                                            type="text" wire:model="couple.{{ $type }}.nickname"
                                            class="w-full rounded-lg bg-[#F9F7F2] border-[#E6D9B8] text-sm focus:border-[#B89760] focus:ring-[#B89760]">
                                    </div>
                                    <div><label class="text-xs text-[#9A7D4C] font-bold">Nama Lengkap</label><input
                                            type="text" wire:model="couple.{{ $type }}.fullname"
                                            class="w-full rounded-lg bg-[#F9F7F2] border-[#E6D9B8] text-sm focus:border-[#B89760] focus:ring-[#B89760]">
                                    </div>
                                    <div><label class="text-xs text-[#9A7D4C] font-bold">Ayah</label><input
                                            type="text" wire:model="couple.{{ $type }}.father"
                                            class="w-full rounded-lg bg-[#F9F7F2] border-[#E6D9B8] text-sm focus:border-[#B89760] focus:ring-[#B89760]">
                                    </div>
                                    <div><label class="text-xs text-[#9A7D4C] font-bold">Ibu</label><input
                                            type="text" wire:model="couple.{{ $type }}.mother"
                                            class="w-full rounded-lg bg-[#F9F7F2] border-[#E6D9B8] text-sm focus:border-[#B89760] focus:ring-[#B89760]">
                                    </div>
                                    <div><label class="text-xs text-[#9A7D4C] font-bold">Instagram</label><input
                                            type="text" wire:model="couple.{{ $type }}.instagram"
                                            class="w-full rounded-lg bg-[#F9F7F2] border-[#E6D9B8] text-sm focus:border-[#B89760] focus:ring-[#B89760]">
                                    </div>
                                </div>
                            @endforeach
                        </div>
                    @endif

                    {{-- TAB: EVENTS --}}
                    @if ($activeTab === 'events')
                        <div class="flex justify-between items-center mb-6 pb-2 border-b border-[#F2ECDC]">
                            <h3 class="font-serif font-bold text-2xl text-[#5E4926]">Rangkaian Acara</h3>
                            <button wire:click="addEvent"
                                class="bg-[#5E4926] text-white text-xs px-4 py-2 rounded-lg font-bold hover:bg-[#403013] transition"><i
                                    class="fa-solid fa-plus"></i> Tambah</button>
                        </div>
                        <div class="space-y-6">
                            @foreach ($events as $index => $event)
                                <div
                                    class="bg-[#F9F7F2]/60 p-6 rounded-2xl border border-[#E6D9B8] relative hover:shadow-sm transition">
                                    <button wire:click="removeEvent({{ $index }})"
                                        class="absolute top-4 right-4 text-[#C6AC80] hover:text-red-500 transition"><i
                                            class="fa-solid fa-trash-can"></i></button>
                                    <div class="grid md:grid-cols-2 gap-5">
                                        <div><label
                                                class="text-xs font-bold text-[#9A7D4C] uppercase mb-1 block">Judul</label><input
                                                type="text" wire:model="events.{{ $index }}.title"
                                                class="w-full rounded-lg bg-white border-[#E6D9B8] text-sm focus:border-[#B89760] focus:ring-[#B89760]">
                                        </div>
                                        <div><label
                                                class="text-xs font-bold text-[#9A7D4C] uppercase mb-1 block">Waktu</label><input
                                                type="datetime-local" wire:model="events.{{ $index }}.date"
                                                class="w-full rounded-lg bg-white border-[#E6D9B8] text-sm focus:border-[#B89760] focus:ring-[#B89760]">
                                        </div>
                                        <div class="md:col-span-2"><label
                                                class="text-xs font-bold text-[#9A7D4C] uppercase mb-1 block">Lokasi</label><input
                                                type="text" wire:model="events.{{ $index }}.location"
                                                class="w-full rounded-lg bg-white border-[#E6D9B8] text-sm focus:border-[#B89760] focus:ring-[#B89760]">
                                        </div>
                                        <div class="md:col-span-2"><label
                                                class="text-xs font-bold text-[#9A7D4C] uppercase mb-1 block">Alamat</label>
                                            <textarea wire:model="events.{{ $index }}.address" rows="2"
                                                class="w-full rounded-lg bg-white border-[#E6D9B8] text-sm focus:border-[#B89760] focus:ring-[#B89760]"></textarea>
                                        </div>
                                        <div class="md:col-span-2"><label
                                                class="text-xs font-bold text-[#9A7D4C] uppercase mb-1 block">Map
                                                Link</label><input type="text"
                                                wire:model="events.{{ $index }}.map_link"
                                                class="w-full rounded-lg bg-white border-[#E6D9B8] text-sm focus:border-[#B89760] focus:ring-[#B89760]">
                                        </div>
                                    </div>
                                </div>
                            @endforeach
                        </div>
                    @endif

                    {{-- TAB: GALLERY --}}
                    @if ($activeTab === 'gallery')
                        <h3 class="font-serif font-bold text-2xl text-[#5E4926] mb-6 pb-2 border-b border-[#F2ECDC]">
                            Galeri Foto</h3>
                        <div class="space-y-8">
                            <div class="grid grid-cols-1 md:grid-cols-3 gap-6">
                                @foreach (['cover' => 'Sampul', 'groom' => 'Pria', 'bride' => 'Wanita'] as $key => $label)
                                    <div>
                                        <label
                                            class="block text-xs font-bold text-[#7C6339] uppercase tracking-wider mb-2">{{ $label }}</label>
                                        <div
                                            class="relative group {{ $key == 'cover' ? 'aspect-[9/16]' : 'aspect-square' }} bg-[#F9F7F2] border-2 border-dashed border-[#E6D9B8] rounded-xl overflow-hidden hover:border-[#B89760] transition">
                                            @php
                                                $newVar = 'new' . ucfirst($key);
                                                $hasExisting = !empty($gallery[$key]);
                                            @endphp
                                            @if ($$newVar)
                                                <img src="{{ $$newVar->temporaryUrl() }}"
                                                    class="w-full h-full object-cover">
                                            @elseif ($hasExisting)
                                                <img src="{{ asset($gallery[$key]) }}"
                                                    class="w-full h-full object-cover"><button
                                                    wire:click="removeSpecific('{{ $key }}')"
                                                    class="absolute top-2 right-2 bg-red-500 text-white w-6 h-6 rounded-full flex items-center justify-center shadow-md z-20"><i
                                                        class="fa-solid fa-times text-xs"></i></button>
                                            @else
                                                <div
                                                    class="absolute inset-0 flex flex-col items-center justify-center text-[#C6AC80]">
                                                    <i class="fa-solid fa-cloud-arrow-up text-2xl mb-2"></i><span
                                                        class="text-[10px]">Upload</span></div>
                                            @endif
                                            <input type="file" wire:model="{{ $newVar }}"
                                                class="absolute inset-0 opacity-0 cursor-pointer z-10">
                                            <div wire:loading wire:target="{{ $newVar }}"
                                                class="absolute inset-0 bg-white/80 flex items-center justify-center z-30">
                                                <i class="fa-solid fa-circle-notch fa-spin text-[#B89760]"></i></div>
                                        </div>
                                    </div>
                                @endforeach
                            </div>
                            <hr class="border-[#F2ECDC] border-dashed">
                            <div>
                                <div class="flex justify-between items-center mb-4"><label
                                        class="block text-xs font-bold text-[#7C6339] uppercase tracking-wider">Momen</label><span
                                        class="text-[10px] text-[#9A7D4C]">Total:
                                        {{ count($gallery['moments'] ?? []) }}</span></div>
                                <div
                                    class="mb-6 p-6 border-2 border-dashed border-[#E6D9B8] rounded-2xl bg-[#F9F7F2]/50 text-center hover:bg-[#F9F7F2] transition relative">
                                    <input type="file" wire:model="newMoments" multiple
                                        class="absolute inset-0 w-full h-full opacity-0 cursor-pointer" />
                                    <div class="pointer-events-none"><i
                                            class="fa-solid fa-images text-2xl text-[#E6D9B8] mb-2"></i>
                                        <p class="text-sm font-bold text-[#B89760]">Upload Bulk</p>
                                    </div>
                                </div>
                                @if ($newMoments)
                                    <div class="mb-4 flex gap-2 overflow-x-auto pb-2">
                                        @foreach ($newMoments as $img)
                                            <img src="{{ $img->temporaryUrl() }}"
                                                class="h-16 w-16 object-cover rounded-lg border border-[#E6D9B8]">
                                        @endforeach
                                    </div>
                                @endif
                                <div class="grid grid-cols-3 md:grid-cols-5 gap-4">
                                    @foreach ($gallery['moments'] as $index => $path)
                                        <div class="relative group rounded-lg overflow-hidden shadow-sm aspect-square">
                                            <img src="{{ asset($path) }}" class="w-full h-full object-cover">
                                            <div
                                                class="absolute inset-0 bg-black/50 opacity-0 group-hover:opacity-100 transition flex items-center justify-center">
                                                <button wire:click="removeMoment({{ $index }})"
                                                    class="text-white hover:text-red-400"><i
                                                        class="fa-solid fa-trash-can"></i></button></div>
                                        </div>
                                    @endforeach
                                </div>
                            </div>
                        </div>
                    @endif

                    {{-- TAB: THEME (CORE LOGIC UI) --}}
                    @if ($activeTab === 'theme')
                        <h3 class="font-serif font-bold text-2xl text-[#5E4926] mb-6 pb-2 border-b border-[#F2ECDC]">
                            Tampilan & Musik</h3>

                        {{-- INFO HARGA & TIER --}}
                        <div
                            class="bg-[#F9F7F2] border border-[#E6D9B8] rounded-2xl p-6 mb-8 flex flex-col md:flex-row justify-between items-center gap-4 shadow-sm animate-fade-in-up">
                            <div>
                                <p class="text-xs text-[#9A7D4C] font-bold uppercase tracking-wider mb-1">Paket
                                    Terpilih</p>
                                <h4 class="font-serif font-bold text-2xl text-[#5E4926]">{{ $currentTierName }} Plan
                                </h4>
                                <div class="flex flex-wrap gap-2 mt-2">
                                    @foreach ($currentTierFeatures as $feat)
                                        <span
                                            class="text-[10px] bg-white border border-[#E6D9B8] px-2 py-1 rounded-full text-[#7C6339] flex items-center gap-1"><i
                                                class="fa-solid fa-check text-[#B89760]"></i>
                                            {{ ucwords(str_replace('_', ' ', $feat)) }}</span>
                                    @endforeach
                                </div>
                            </div>
                            <div class="text-right">
                                <p class="text-xs text-[#9A7D4C]">Harga Paket</p>
                                <p class="font-display text-3xl text-[#B89760]">Rp
                                    {{ number_format($currentTemplatePrice, 0, ',', '.') }}</p>
                            </div>
                        </div>

                        {{-- SLIDER --}}
                        <div class="space-y-4">
                            <div class="flex justify-between items-end px-1"><label
                                    class="block text-xs font-bold text-[#7C6339] uppercase tracking-wider">Katalog
                                    Desain</label><span class="text-[10px] text-[#9A7D4C] italic">Geser untuk melihat
                                    opsi &rarr;</span></div>
                            <div class="relative group/slider">
                                <div
                                    class="absolute left-0 top-0 bottom-0 w-8 bg-gradient-to-r from-white to-transparent z-10 pointer-events-none">
                                </div>
                                <div
                                    class="absolute right-0 top-0 bottom-0 w-8 bg-gradient-to-l from-white to-transparent z-10 pointer-events-none">
                                </div>
                                <div
                                    class="flex gap-5 overflow-x-auto pb-8 pt-2 px-1 snap-x snap-mandatory scroll-smooth hide-scrollbar">
                                    @foreach ($availableTemplates as $tpl)
                                        <label class="cursor-pointer relative flex-shrink-0 snap-center group">
                                            <input type="radio" wire:model.live="theme_template"
                                                value="{{ $tpl->slug }}" class="peer sr-only">
                                            <div
                                                class="w-56 transition-all duration-300 transform {{ $theme_template == $tpl->slug ? 'scale-105 -translate-y-2' : 'scale-100 hover:scale-105 opacity-90 hover:opacity-100' }}">
                                                <div
                                                    class="aspect-[9/16] rounded-2xl overflow-hidden shadow-md relative border-4 transition-all duration-300 {{ $theme_template == $tpl->slug ? 'border-[#B89760] shadow-[0_15px_40px_rgba(184,151,96,0.3)] ring-4 ring-[#B89760]/20' : 'border-transparent shadow-sm' }}">
                                                    @if ($tpl->thumbnail)
                                                        <img src="{{ asset('storage/' . $tpl->thumbnail) }}"
                                                            class="w-full h-full object-cover">
                                                    @else
                                                        <div
                                                            class="w-full h-full bg-[#F9F7F2] flex items-center justify-center text-[#C6AC80]">
                                                            <span class="text-xs">No Preview</span></div>
                                                    @endif
                                                    <div
                                                        class="absolute top-0 left-0 right-0 p-2 bg-gradient-to-b from-black/60 to-transparent">
                                                        <span
                                                            class="text-[10px] font-bold uppercase tracking-wider px-2 py-0.5 rounded-full {{ $tpl->tier == 'exclusive' ? 'bg-[#2D2418] text-[#B89760]' : ($tpl->tier == 'premium' ? 'bg-[#B89760] text-white' : 'bg-white text-[#5E4926]') }}">{{ $tpl->tier }}</span>
                                                    </div>
                                                    <div
                                                        class="absolute bottom-0 left-0 right-0 bg-[#F9F7F2] p-2 text-center border-t border-[#E6D9B8]">
                                                        <p class="font-bold text-[#5E4926] text-sm">Rp
                                                            {{ number_format($tpl->price, 0, ',', '.') }}</p>
                                                    </div>
                                                    <div
                                                        class="absolute inset-0 bg-[#B89760]/20 z-10 transition-opacity duration-300 {{ $theme_template == $tpl->slug ? 'opacity-100' : 'opacity-0' }}">
                                                        <div
                                                            class="absolute top-1/2 left-1/2 transform -translate-x-1/2 -translate-y-1/2 bg-[#B89760] text-white w-10 h-10 rounded-full flex items-center justify-center shadow-lg animate-bounce">
                                                            <i class="fa-solid fa-check"></i></div>
                                                    </div>
                                                </div>
                                                <div class="text-center mt-3">
                                                    <p class="font-serif font-bold text-[#5E4926] text-sm">
                                                        {{ $tpl->name }}</p>
                                                </div>
                                            </div>
                                        </label>
                                    @endforeach
                                </div>
                            </div>
                        </div>
                        <hr class="border-[#F2ECDC] border-dashed mb-8">
                        <div class="grid md:grid-cols-2 gap-8">
                            <div class="bg-[#F9F7F2]/50 p-5 rounded-2xl border border-[#E6D9B8]/50">
                                <label
                                    class="block text-xs font-bold text-[#7C6339] uppercase tracking-wider mb-3">Warna
                                    Aksen</label>
                                <div class="flex items-center gap-4">
                                    <div
                                        class="relative w-16 h-16 rounded-2xl overflow-hidden border-2 border-white shadow-md ring-1 ring-[#E6D9B8] cursor-pointer">
                                        <input type="color" wire:model="theme.primary_color"
                                            class="absolute -top-1/2 -left-1/2 w-[200%] h-[200%] cursor-pointer p-0 border-0">
                                    </div>
                                    <div class="flex-1"><input type="text" wire:model="theme.primary_color"
                                            class="w-full rounded-xl bg-white border-[#E6D9B8] text-[#5E4926] font-mono text-sm uppercase focus:border-[#B89760] focus:ring-[#B89760]">
                                    </div>
                                </div>
                            </div>
                            <div class="bg-[#F9F7F2]/50 p-5 rounded-2xl border border-[#E6D9B8]/50">
                                <label
                                    class="block text-xs font-bold text-[#7C6339] uppercase tracking-wider mb-3">Musik
                                    (YouTube)</label>
                                <div class="relative"><span
                                        class="absolute inset-y-0 left-0 pl-3 flex items-center pointer-events-none text-red-500"><i
                                            class="fa-brands fa-youtube text-lg"></i></span><input type="text"
                                        wire:model="theme.music_url" placeholder="..."
                                        class="w-full pl-10 rounded-xl bg-white border-[#E6D9B8] text-[#5E4926] text-sm focus:border-[#B89760] focus:ring-[#B89760]">
                                </div>
                                @if (!empty($theme['music_url']))
                                    <div
                                        class="mt-2 flex items-center gap-2 text-[10px] text-green-600 bg-green-50 px-3 py-1.5 rounded-lg border border-green-100">
                                        <i class="fa-solid fa-circle-check"></i> Musik terdeteksi.</div>
                                @endif
                            </div>
                        </div>
                        <style>
                            .hide-scrollbar::-webkit-scrollbar {
                                display: none;
                            }

                            .hide-scrollbar {
                                -ms-overflow-style: none;
                                scrollbar-width: none;
                            }
                        </style>
                    @endif

                    {{-- TAB: GIFTS --}}
                    @if ($activeTab === 'gifts')
                        <div class="flex justify-between items-center mb-6 pb-2 border-b border-[#F2ECDC]">
                            <h3 class="font-serif font-bold text-2xl text-[#5E4926]">Kado Digital</h3><button
                                wire:click="addGift"
                                class="bg-[#5E4926] text-white text-xs px-4 py-2 rounded-lg font-bold hover:bg-[#403013] transition"><i
                                    class="fa-solid fa-plus"></i> Tambah</button>
                        </div>
                        <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
                            @forelse($gifts as $index => $gift)
                                <div
                                    class="bg-gradient-to-br from-[#F9F7F2] to-white p-5 rounded-2xl border border-[#E6D9B8] relative shadow-sm hover:shadow-md transition">
                                    <button wire:click="removeGift({{ $index }})"
                                        class="absolute top-3 right-3 text-[#C6AC80] hover:text-red-500"><i
                                            class="fa-solid fa-xmark"></i></button>
                                    <div class="space-y-3 pr-6">
                                        <div><label
                                                class="text-[10px] font-bold text-[#9A7D4C] uppercase mb-1 block">Bank</label><select
                                                wire:model="gifts.{{ $index }}.bank_name"
                                                class="w-full rounded-lg bg-white border-[#E6D9B8] text-sm py-1.5 font-bold text-[#5E4926] focus:border-[#B89760] focus:ring-[#B89760]">
                                                <option value="">Pilih...</option>
                                                @foreach (['BCA', 'BRI', 'Mandiri', 'BNI', 'Dana', 'Gopay', 'OVO', 'Lainnya'] as $bank)
                                                    <option value="{{ $bank }}">{{ $bank }}</option>
                                                @endforeach
                                            </select></div>
                                        <div><label
                                                class="text-[10px] font-bold text-[#9A7D4C] uppercase mb-1 block">No.
                                                Rekening</label><input type="number"
                                                wire:model="gifts.{{ $index }}.account_number"
                                                class="w-full rounded-lg bg-white border-[#E6D9B8] text-sm py-1.5 font-mono focus:border-[#B89760] focus:ring-[#B89760]">
                                        </div>
                                        <div><label
                                                class="text-[10px] font-bold text-[#9A7D4C] uppercase mb-1 block">Atas
                                                Nama</label><input type="text"
                                                wire:model="gifts.{{ $index }}.account_name"
                                                class="w-full rounded-lg bg-white border-[#E6D9B8] text-sm py-1.5 focus:border-[#B89760] focus:ring-[#B89760]">
                                        </div>
                                    </div>
                                </div>
                            @empty <div
                                    class="col-span-full text-center py-10 bg-[#F9F7F2] rounded-xl border-2 border-dashed border-[#E6D9B8]">
                                    <i class="fa-solid fa-gift text-3xl text-[#E6D9B8] mb-3"></i>
                                    <p class="text-[#7C6339] text-sm">Belum ada data rekening.</p>
                                </div>
                            @endforelse
                        </div>
                    @endif

                </div>
            </div>
        </div>
    </div>
</div>
