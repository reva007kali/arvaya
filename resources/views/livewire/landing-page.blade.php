<div class="">

    <!-- HERO SECTION -->
    <header class="relative min-h-[90vh] flex items-center pt-20 overflow-hidden bg-arvaya-bg">
        <!-- Minimalist Background Decoration -->
        <div class="absolute top-0 right-0 w-1/2 h-full bg-gradient-to-l from-[#1a1a1a] to-transparent opacity-60"></div>
        <div class="absolute bottom-0 left-0 w-96 h-96 bg-arvaya-900 rounded-full blur-3xl opacity-20 -translate-x-1/2 translate-y-1/2"></div>

        <div class="max-w-6xl mx-auto px-6 relative z-10 w-full grid md:grid-cols-2 gap-16 items-center">
            <!-- Left: Content -->
            <div data-aos="fade-up" data-aos-duration="1000">
                <span class="inline-block py-1 px-3 rounded-full bg-arvaya-bg border border-arvaya-400/20 text-arvaya-400 text-xs font-bold uppercase tracking-widest mb-6 shadow-[2px_2px_5px_#0a0a0a,-2px_-2px_5px_#1e1e1e]">
                    Undangan Pernikahan Digital
                </span>

                <h1 class="font-serif text-5xl md:text-7xl font-bold leading-tight mb-6 text-arvaya-100">
                    Rayakan Cinta dengan <span class="italic font-light text-arvaya-400">Elegan.</span>
                </h1>

                <p class="text-lg text-arvaya-200 mb-10 max-w-lg leading-relaxed font-light">
                    Buat undangan digital yang memukau dalam hitungan menit. Dilengkapi AI Assistant, manajemen tamu pintar, dan desain premium tanpa batas.
                </p>

                <div class="flex flex-col sm:flex-row gap-4">
                    @auth
                        <a href="{{ route('dashboard.index') }}"
                            class="px-8 py-4 bg-arvaya-400 text-arvaya-bg rounded-xl font-bold hover:bg-arvaya-300 transition shadow-[4px_4px_10px_#0a0a0a,-4px_-4px_10px_#1e1e1e] text-center hover:scale-[1.02] active:scale-[0.98]">
                            Buka Dashboard
                        </a>
                    @endauth
                    @guest
                        <a href="{{ route('register') }}"
                            class="px-8 py-4 bg-arvaya-400 text-arvaya-bg rounded-xl font-bold hover:bg-arvaya-300 transition shadow-[4px_4px_10px_#0a0a0a,-4px_-4px_10px_#1e1e1e] text-center hover:scale-[1.02] active:scale-[0.98]">
                            Buat Undangan Gratis
                        </a>
                        <a href="#themes"
                            class="px-8 py-4 bg-arvaya-bg text-arvaya-400 rounded-xl font-bold hover:text-arvaya-200 transition shadow-[4px_4px_10px_#0a0a0a,-4px_-4px_10px_#1e1e1e] text-center flex items-center justify-center gap-2 group hover:scale-[1.02] active:scale-[0.98]">
                            <i class="fa-solid fa-play text-xs text-arvaya-400 group-hover:text-arvaya-200 transition"></i>
                            Lihat Demo
                        </a>
                    @endguest
                </div>

                <div class="mt-12 flex items-center gap-4 text-sm text-arvaya-400">
                    <div class="flex -space-x-2">
                        <div class="w-8 h-8 rounded-full bg-arvaya-200 border-2 border-arvaya-bg"></div>
                        <div class="w-8 h-8 rounded-full bg-arvaya-300 border-2 border-arvaya-bg"></div>
                        <div class="w-8 h-8 rounded-full bg-arvaya-400 border-2 border-arvaya-bg"></div>
                    </div>
                    <p class="text-arvaya-200">Bergabung dengan <span class="font-bold text-arvaya-400">2,000+</span> pasangan bahagia.</p>
                </div>
            </div>

            <!-- Right: Clean Visual -->
            <div class="relative hidden md:block" data-aos="fade-left" data-aos-duration="1200">
                <div class="relative z-10 animate-float">
                    <img src="img/hero.png" alt="App Preview"
                        class="rounded-[2rem] w-80 mx-auto shadow-[10px_10px_20px_#0a0a0a,-10px_-10px_20px_#1e1e1e] border-4 border-arvaya-bg rotate-[-2deg] hover:rotate-0 transition duration-700">
                </div>
                <!-- Clean Floating Elements -->
                <div class="absolute top-1/2 -right-4 bg-arvaya-bg p-4 rounded-xl shadow-[5px_5px_10px_#0a0a0a,-5px_-5px_10px_#1e1e1e] animate-bounce-slow">
                    <div class="flex items-center gap-3">
                        <div class="w-10 h-10 rounded-full bg-arvaya-bg shadow-[inset_3px_3px_6px_#0a0a0a,inset_-3px_-3px_6px_#1e1e1e] flex items-center justify-center text-green-500">
                            <i class="fa-brands fa-whatsapp text-xl"></i>
                        </div>
                        <div>
                            <p class="text-xs font-bold text-arvaya-100">Auto-Send</p>
                            <p class="text-[10px] text-arvaya-400">Terkirim ke 500+ tamu</p>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </header>

    <!-- FEATURES SECTION (Clean Grid) -->
    <section id="features" class="py-24 bg-arvaya-bg">
        <div class="max-w-6xl mx-auto px-6">
            <div class="text-center mb-16 max-w-2xl mx-auto" data-aos="fade-up">
                <h2 class="font-serif text-3xl md:text-4xl font-bold mb-4 text-arvaya-100">Fitur Modern untuk <br>Pernikahan Impian</h2>
                <p class="text-arvaya-200">Kami menyederhanakan proses rumit menjadi pengalaman yang menyenangkan.</p>
            </div>

            <div class="grid md:grid-cols-3 gap-8">
                <!-- Card 1 -->
                <div class="p-8 rounded-2xl bg-arvaya-bg shadow-[5px_5px_10px_#0a0a0a,-5px_-5px_10px_#1e1e1e] hover:shadow-[inset_5px_5px_10px_#0a0a0a,inset_-5px_-5px_10px_#1e1e1e] transition duration-300 group"
                    data-aos="fade-up" data-aos-delay="100">
                    <div class="w-12 h-12 rounded-xl bg-arvaya-bg shadow-[3px_3px_6px_#0a0a0a,-3px_-3px_6px_#1e1e1e] text-arvaya-400 flex items-center justify-center text-xl mb-6 group-hover:text-arvaya-200 transition">
                        <i class="fa-solid fa-wand-magic-sparkles"></i>
                    </div>
                    <h3 class="font-serif text-xl font-bold mb-3 text-arvaya-100">AI Writer Assistant</h3>
                    <p class="text-arvaya-200 text-sm leading-relaxed">
                        Bingung merangkai kata? Biarkan AI kami menuliskan doa dan ucapan yang menyentuh hati dalam hitungan detik.
                    </p>
                </div>

                <!-- Card 2 -->
                <div class="p-8 rounded-2xl bg-arvaya-bg shadow-[5px_5px_10px_#0a0a0a,-5px_-5px_10px_#1e1e1e] hover:shadow-[inset_5px_5px_10px_#0a0a0a,inset_-5px_-5px_10px_#1e1e1e] transition duration-300 group"
                    data-aos="fade-up" data-aos-delay="200">
                    <div class="w-12 h-12 rounded-xl bg-arvaya-bg shadow-[3px_3px_6px_#0a0a0a,-3px_-3px_6px_#1e1e1e] text-arvaya-400 flex items-center justify-center text-xl mb-6 group-hover:text-arvaya-200 transition">
                        <i class="fa-solid fa-users-viewfinder"></i>
                    </div>
                    <h3 class="font-serif text-xl font-bold mb-3 text-arvaya-100">Smart Guest Management</h3>
                    <p class="text-arvaya-200 text-sm leading-relaxed">
                        Kelola data tamu, grup, dan status RSVP dalam satu dashboard yang intuitif dan mudah digunakan.
                    </p>
                </div>

                <!-- Card 3 -->
                <div class="p-8 rounded-2xl bg-arvaya-bg shadow-[5px_5px_10px_#0a0a0a,-5px_-5px_10px_#1e1e1e] hover:shadow-[inset_5px_5px_10px_#0a0a0a,inset_-5px_-5px_10px_#1e1e1e] transition duration-300 group"
                    data-aos="fade-up" data-aos-delay="300">
                    <div class="w-12 h-12 rounded-xl bg-arvaya-bg shadow-[3px_3px_6px_#0a0a0a,-3px_-3px_6px_#1e1e1e] text-arvaya-400 flex items-center justify-center text-xl mb-6 group-hover:text-arvaya-200 transition">
                        <i class="fa-solid fa-qrcode"></i>
                    </div>
                    <h3 class="font-serif text-xl font-bold mb-3 text-arvaya-100">Digital Check-in</h3>
                    <p class="text-arvaya-200 text-sm leading-relaxed">
                        Sistem QR Code untuk check-in tamu di hari H. Cepat, aman, dan tercatat otomatis real-time.
                    </p>
                </div>
            </div>
        </div>
    </section>

    <!-- THEMES SECTION -->
    <section id="themes" class="py-24 bg-arvaya-bg relative overflow-hidden">
        <div class="absolute inset-0 bg-gradient-to-b from-[#1a1a1a] to-arvaya-bg opacity-50"></div>
        <div class="max-w-6xl mx-auto px-6 relative z-10">
            <div class="flex flex-col md:flex-row md:items-end justify-between gap-6 mb-12">
                <div>
                    <h2 class="font-serif text-3xl md:text-4xl font-bold text-arvaya-100">Koleksi Tema Eksklusif</h2>
                    <p class="text-arvaya-200 mt-2">Pilih desain yang mencerminkan kepribadian Anda.</p>
                </div>
                
                <div class="flex gap-4">
                    <select wire:model.live="tier"
                        class="px-4 py-2 rounded-lg bg-arvaya-bg text-sm text-arvaya-400 border-none shadow-[3px_3px_6px_#0a0a0a,-3px_-3px_6px_#1e1e1e] focus:ring-0 focus:shadow-[inset_3px_3px_6px_#0a0a0a,inset_-3px_-3px_6px_#1e1e1e]">
                        <option value="all">Semua Kategori</option>
                        <option value="basic">Basic</option>
                        <option value="premium">Premium</option>
                        <option value="exclusive">Exclusive</option>
                    </select>
                </div>
            </div>

            @php $basicFeatures = $tiers['basic']['features'] ?? []; @endphp

            <div class="grid grid-cols-2 sm:grid-cols-3 lg:grid-cols-4 gap-6">
                @forelse ($templates as $tpl)
                    @php
                        $tierMeta = $tiers[$tpl->tier] ?? ['features' => []];
                    @endphp
                    <div class="group cursor-pointer bg-arvaya-bg rounded-2xl p-3 shadow-[5px_5px_10px_#0a0a0a,-5px_-5px_10px_#1e1e1e] hover:scale-[1.02] transition duration-300">
                        <div class="aspect-[9/16] rounded-xl overflow-hidden relative bg-[#1a1a1a] mb-4 shadow-[inset_2px_2px_5px_#0a0a0a,inset_-2px_-2px_5px_#1e1e1e]">
                            @if ($tpl->thumbnail)
                                <img src="{{ asset('storage/' . $tpl->thumbnail) }}" alt="{{ $tpl->name }}"
                                    class="w-full h-full object-cover transition duration-700 group-hover:scale-105 opacity-90 group-hover:opacity-100">
                            @else
                                <div class="w-full h-full flex items-center justify-center text-arvaya-900">
                                    <i class="fa-solid fa-image text-3xl"></i>
                                </div>
                            @endif
                            
                            <div class="absolute top-2 left-2">
                                <span class="px-2 py-1 text-[10px] font-bold rounded-md bg-black/50 backdrop-blur text-arvaya-400 uppercase tracking-wider shadow-sm">
                                    {{ $tpl->tier }}
                                </span>
                            </div>

                            <div class="absolute inset-0 bg-black/60 opacity-0 group-hover:opacity-100 transition flex items-center justify-center gap-2 backdrop-blur-[1px]">
                                <a href="{{ route('invitation.show', $tpl->slug) }}"
                                    class="w-10 h-10 rounded-full bg-arvaya-bg text-arvaya-400 flex items-center justify-center hover:text-white transition shadow-[3px_3px_6px_#000]" title="Preview">
                                    <i class="fa-solid fa-eye"></i>
                                </a>
                                <a href="{{ route('dashboard.create') }}"
                                    class="w-10 h-10 rounded-full bg-arvaya-400 text-arvaya-bg flex items-center justify-center hover:bg-arvaya-300 transition shadow-[3px_3px_6px_#000]" title="Gunakan">
                                    <i class="fa-solid fa-check"></i>
                                </a>
                            </div>
                        </div>
                        <div class="px-1">
                            <h3 class="font-serif font-bold text-arvaya-100 truncate">{{ $tpl->name }}</h3>
                            <div class="flex justify-between items-center mt-1">
                                <p class="text-xs text-arvaya-500 uppercase tracking-wide">{{ $tpl->category ?? 'Wedding' }}</p>
                                <p class="text-sm font-bold text-arvaya-400">Rp {{ number_format($tpl->price, 0, ',', '.') }}</p>
                            </div>
                        </div>
                    </div>
                @empty
                    <div class="col-span-full py-12 text-center text-arvaya-500 bg-arvaya-bg rounded-2xl shadow-[inset_5px_5px_10px_#0a0a0a,inset_-5px_-5px_10px_#1e1e1e]">
                        Tidak ada template ditemukan.
                    </div>
                @endforelse
            </div>
        </div>
    </section>

    <!-- PRICING SECTION (Clean Cards) -->
    <section id="pricing" class="py-24 bg-arvaya-bg">
        <div class="max-w-6xl mx-auto px-6">
            <div class="text-center mb-16" data-aos="fade-up">
                <h2 class="font-serif text-3xl md:text-4xl font-bold mb-4 text-arvaya-100">Investasi Sekali, <br>Aktif Selamanya</h2>
                <p class="text-arvaya-200">Pilih paket yang sesuai dengan kebutuhan acara Anda.</p>
            </div>

            <div class="grid md:grid-cols-3 gap-8 items-start">
                <!-- Basic -->
                <div class="p-8 rounded-3xl bg-arvaya-bg shadow-[10px_10px_20px_#0a0a0a,-10px_-10px_20px_#1e1e1e] transition duration-300" data-aos="fade-up" data-aos-delay="100">
                    <h3 class="font-bold text-arvaya-400 text-lg mb-2">Paket Love</h3>
                    <div class="text-4xl font-serif font-bold text-arvaya-100 mb-6">Rp 150k</div>
                    <p class="text-sm text-arvaya-500 mb-8 pb-8 border-b border-white/5">
                        Cukup untuk acara sederhana dengan fitur essential yang lengkap.
                    </p>
                    <ul class="space-y-4 text-sm text-arvaya-200 mb-8">
                        <li class="flex gap-3"><i class="fa-solid fa-check text-arvaya-400 mt-0.5"></i> Masa Aktif 6 Bulan</li>
                        <li class="flex gap-3"><i class="fa-solid fa-check text-arvaya-400 mt-0.5"></i> Unlimited Tamu</li>
                        <li class="flex gap-3"><i class="fa-solid fa-check text-arvaya-400 mt-0.5"></i> Musik Latar</li>
                        <li class="flex gap-3"><i class="fa-solid fa-check text-arvaya-400 mt-0.5"></i> RSVP & Ucapan</li>
                    </ul>
                    <a href="{{ route('dashboard.index') }}" class="block w-full py-3 rounded-xl bg-arvaya-bg text-arvaya-400 border border-arvaya-400/20 font-bold text-center hover:bg-arvaya-400 hover:text-arvaya-bg transition shadow-[4px_4px_10px_#0a0a0a,-4px_-4px_10px_#1e1e1e]">
                        Pilih Paket
                    </a>
                </div>

                <!-- Premium (Highlighted) -->
                <div class="p-8 rounded-3xl bg-arvaya-bg shadow-[inset_5px_5px_10px_#0a0a0a,inset_-5px_-5px_10px_#1e1e1e] border border-arvaya-400/30 relative transform md:-translate-y-4" data-aos="fade-up" data-aos-delay="200">
                    <div class="absolute top-0 right-0 bg-arvaya-400 text-arvaya-bg text-[10px] font-bold px-4 py-1.5 rounded-bl-xl rounded-tr-2xl uppercase tracking-wider shadow-md">
                        Most Popular
                    </div>
                    <h3 class="font-bold text-arvaya-100 text-lg mb-2">Paket Eternal</h3>
                    <div class="text-4xl font-serif font-bold text-arvaya-400 mb-6">Rp 350k</div>
                    <p class="text-sm text-arvaya-300 mb-8 pb-8 border-b border-white/5">
                        Fitur terlengkap untuk pengalaman undangan digital yang sempurna.
                    </p>
                    <ul class="space-y-4 text-sm text-arvaya-200 mb-8">
                        <li class="flex gap-3"><i class="fa-solid fa-check text-arvaya-400 mt-0.5"></i> <b>Aktif Selamanya</b></li>
                        <li class="flex gap-3"><i class="fa-solid fa-check text-arvaya-400 mt-0.5"></i> Semua Tema Premium</li>
                        <li class="flex gap-3"><i class="fa-solid fa-check text-arvaya-400 mt-0.5"></i> AI Writer Unlimited</li>
                        <li class="flex gap-3"><i class="fa-solid fa-check text-arvaya-400 mt-0.5"></i> Prioritas Support</li>
                        <li class="flex gap-3"><i class="fa-solid fa-check text-arvaya-400 mt-0.5"></i> Galeri Foto & Video HD</li>
                    </ul>
                    <a href="{{ route('dashboard.index') }}" class="block w-full py-3 rounded-xl bg-arvaya-400 text-arvaya-bg font-bold text-center hover:bg-arvaya-300 transition shadow-[4px_4px_10px_#0a0a0a,-4px_-4px_10px_#1e1e1e]">
                        Mulai Sekarang
                    </a>
                </div>

                <!-- Custom -->
                <div class="p-8 rounded-3xl bg-arvaya-bg shadow-[10px_10px_20px_#0a0a0a,-10px_-10px_20px_#1e1e1e] transition duration-300" data-aos="fade-up" data-aos-delay="300">
                    <h3 class="font-bold text-arvaya-400 text-lg mb-2">Custom Design</h3>
                    <div class="text-4xl font-serif font-bold text-arvaya-100 mb-6">Contact</div>
                    <p class="text-sm text-arvaya-500 mb-8 pb-8 border-b border-white/5">
                        Punya desain impian sendiri? Tim kami siap mewujudkannya.
                    </p>
                    <ul class="space-y-4 text-sm text-arvaya-200 mb-8">
                        <li class="flex gap-3"><i class="fa-solid fa-check text-arvaya-400 mt-0.5"></i> Request Desain</li>
                        <li class="flex gap-3"><i class="fa-solid fa-check text-arvaya-400 mt-0.5"></i> Fitur Custom</li>
                        <li class="flex gap-3"><i class="fa-solid fa-check text-arvaya-400 mt-0.5"></i> Pendampingan Penuh</li>
                        <li class="flex gap-3"><i class="fa-solid fa-check text-arvaya-400 mt-0.5"></i> Input Data oleh Tim</li>
                    </ul>
                    <a href="https://wa.me/6282260894009" target="_blank" class="block w-full py-3 rounded-xl bg-arvaya-bg text-arvaya-400 border border-arvaya-400/20 font-bold text-center hover:bg-arvaya-400 hover:text-arvaya-bg transition shadow-[4px_4px_10px_#0a0a0a,-4px_-4px_10px_#1e1e1e]">
                        Hubungi Kami
                    </a>
                </div>
            </div>
        </div>
    </section>

    <!-- TESTIMONIALS (Clean) -->
    <section id="testimonials" class="py-24 bg-arvaya-bg border-t border-white/5 overflow-hidden">
        <div class="max-w-6xl mx-auto px-6 mb-12 text-center">
            <h2 class="font-serif text-3xl font-bold text-arvaya-100">Cerita Bahagia</h2>
        </div>
        
        <div class="relative w-full overflow-hidden mask-gradient-x">
            <div class="flex animate-marquee gap-8 w-max hover:[animation-play-state:paused]">
                <!-- Loop Items -->
                @foreach([1, 2, 3, 4] as $i)
                <div class="w-[400px] p-8 bg-arvaya-bg rounded-2xl shadow-[5px_5px_10px_#0a0a0a,-5px_-5px_10px_#1e1e1e]">
                    <div class="flex text-arvaya-400 mb-4 text-xs gap-1">
                        <i class="fa-solid fa-star"></i><i class="fa-solid fa-star"></i><i class="fa-solid fa-star"></i><i class="fa-solid fa-star"></i><i class="fa-solid fa-star"></i>
                    </div>
                    <p class="text-arvaya-200 text-sm mb-6 leading-relaxed italic">
                        "Platform undangan digital terbaik yang pernah saya coba. Desainnya elegan, tidak norak, dan fiturnya sangat membantu."
                    </p>
                    <div class="flex items-center gap-4">
                        <div class="w-10 h-10 rounded-full bg-arvaya-bg shadow-[inset_2px_2px_5px_#0a0a0a,inset_-2px_-2px_5px_#1e1e1e] flex items-center justify-center text-arvaya-400 font-bold text-xs">
                            {{ substr(['Sarah', 'Raka', 'Andi', 'Bella'][$i-1], 0, 1) }}
                        </div>
                        <div>
                            <div class="text-sm font-bold text-arvaya-100">{{ ['Sarah & Dimas', 'Raka & Bella', 'Andi & Citra', 'Dina & Budi'][$i-1] }}</div>
                            <div class="text-xs text-arvaya-500">Jakarta</div>
                        </div>
                    </div>
                </div>
                @endforeach
            </div>
        </div>
    </section>

    <!-- FLOATING WHATSAPP (Neomorphism) -->
    <a href="https://wa.me/6282260894009" target="_blank"
        class="fixed bottom-8 right-8 z-50 flex items-center justify-center w-14 h-14 bg-[#25D366] text-white rounded-full transition-transform hover:scale-110 active:scale-95 shadow-[5px_5px_15px_#0a0a0a,-5px_-5px_15px_#1e1e1e]">
        <i class="fa-brands fa-whatsapp text-2xl"></i>
    </a>

</div>
