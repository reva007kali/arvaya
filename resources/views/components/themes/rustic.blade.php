@props(['invitation', 'guest'])

@php
    // 1. Data Helper & Fallback
    $groom = $invitation->couple_data['groom'] ?? [];
    $bride = $invitation->couple_data['bride'] ?? [];
    $gifts = $invitation->gifts_data ?? [];
    $theme = $invitation->theme_config ?? [];

    // 2. Color Config (RUSTIC PALETTE OVERRIDE)
    // Primary: Sage Green / Wood Brown default
    $primaryColor = data_get($theme, 'primary_color', '#6B705C'); 
    $secondaryColor = '#A5A58D'; // Soft Sage
    $paperColor = '#F2E8CF'; // Cream Paper

    // 3. Image Assets
    $galleryData = $invitation->gallery_data ?? [];
    $defaultCover = 'https://images.unsplash.com/photo-1511795409834-ef04bbd61622?q=80&w=2069&auto=format&fit=crop'; // Rustic Wedding
    $defaultProfile = 'https://ui-avatars.com/api/?background=A5A58D&color=fff&size=200&name=';

    $coverImage = $galleryData['cover'] ?? ($galleryData[0] ?? $defaultCover);
    $groomImage = $galleryData['groom'] ?? $defaultProfile . urlencode($groom['nickname'] ?? 'Groom');
    $brideImage = $galleryData['bride'] ?? $defaultProfile . urlencode($bride['nickname'] ?? 'Bride');
    $moments = $galleryData['moments'] ?? [];

    if (isset($galleryData[0])) {
        $moments = $galleryData;
    }
@endphp

{{-- Load Google Fonts for Rustic Theme --}}
<link rel="preconnect" href="https://fonts.googleapis.com">
<link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
<link href="https://fonts.googleapis.com/css2?family=Cormorant+Garamond:ital,wght@0,400;0,600;1,400;1,600&family=Great+Vibes&family=Plus+Jakarta+Sans:wght@300;400;600&display=swap" rel="stylesheet">

<div class="font-sans text-[#4A4A4A] bg-[#F9F5EB] min-h-screen pb-20 overflow-x-hidden selection:bg-[#6B705C] selection:text-white relative">

    {{-- GRAIN TEXTURE OVERLAY --}}
    <div class="fixed inset-0 opacity-[0.03] pointer-events-none z-50 mix-blend-multiply" 
         style="background-image: url('https://www.transparenttextures.com/patterns/cream-paper.png');">
    </div>

    {{-- DYNAMIC STYLES --}}
    <style>
        :root {
            --color-primary: {{ $primaryColor }};
            --color-wood: #8D7B68;
            --color-paper: #F2E8CF;
        }

        .font-handwriting {
            font-family: 'Great Vibes', cursive;
        }

        .font-serif {
            font-family: 'Cormorant Garamond', serif;
        }

        .theme-text {
            color: var(--color-primary);
        }

        .theme-border {
            border-color: var(--color-primary);
        }

        .rustic-card {
            background-color: white;
            border: 1px solid #E5E0D8;
            box-shadow: 0 4px 6px -1px rgba(0, 0, 0, 0.05);
        }

        /* Polaroid Effect */
        .polaroid {
            background: #fff;
            padding: 10px 10px 30px 10px;
            box-shadow: 0 4px 15px rgba(0,0,0,0.1);
            transition: transform 0.3s ease;
        }
        .polaroid:hover {
            transform: scale(1.02) rotate(0deg) !important;
            z-index: 10;
        }

        html { scroll-behavior: smooth; }
    </style>

    {{-- MUSIC PLAYER --}}
    @if (!empty($theme['music_url']))
        <div x-data="youtubePlayer('{{ $theme['music_url'] }}')" x-init="initPlayer()" @play-music.window="playMusic()"
            class="fixed bottom-6 left-6 z-[60] font-sans">
            {{-- Popup --}}
            <div x-show="isOpen" 
                class="mb-4 bg-[#F9F5EB] p-4 rounded-lg shadow-xl border border-[#D7C0AE] w-64 text-center relative"
                style="display: none;"
                x-transition>
                <!-- Tape/Wood decoration -->
                <div class="absolute -top-3 left-1/2 -translate-x-1/2 w-20 h-6 bg-[#D7C0AE]/50 rotate-[-2deg]"></div>
                
                <div class="flex items-center justify-between mb-3 text-[#6B705C]">
                    <button @click="seek(-10)"><i class="fa-solid fa-backward-step"></i></button>
                    <button @click="togglePlay" class="w-8 h-8 rounded-full border border-[#6B705C] flex items-center justify-center hover:bg-[#6B705C] hover:text-white transition">
                        <i class="fa-solid" :class="isPlaying ? 'fa-pause' : 'fa-play pl-1'"></i>
                    </button>
                    <button @click="seek(10)"><i class="fa-solid fa-forward-step"></i></button>
                </div>
                <div class="relative w-full overflow-hidden bg-black aspect-video sepia-[.5]">
                    <div id="yt-player-container"></div>
                    <div class="absolute inset-0 bg-transparent"></div>
                </div>
            </div>

            {{-- Button --}}
            <button @click="isOpen = !isOpen"
                class="w-12 h-12 bg-[#6B705C] text-[#F2E8CF] rounded-full shadow-lg flex items-center justify-center border-4 border-[#F2E8CF] hover:scale-110 transition">
                <i class="fa-solid fa-music animate-spin-slow"></i>
            </button>
        </div>

        {{-- Script (Sama seperti sebelumnya, disederhanakan untuk ringkas) --}}
        <script>
            document.addEventListener('alpine:init', () => {
                Alpine.data('youtubePlayer', (url) => ({
                    player: null, isPlaying: false, isOpen: false, videoId: '',
                    initPlayer() {
                        const match = url.match(/^.*(youtu.be\/|v\/|u\/\w\/|embed\/|watch\?v=|&v=)([^#&?]*).*/);
                        this.videoId = (match && match[2].length === 11) ? match[2] : null;
                        if (!this.videoId) return;
                        if (!window.YT) {
                            const tag = document.createElement('script'); tag.src = "https://www.youtube.com/iframe_api";
                            document.body.appendChild(tag); window.onYouTubeIframeAPIReady = () => this.createPlayer();
                        } else { this.createPlayer(); }
                    },
                    createPlayer() {
                        this.player = new YT.Player('yt-player-container', {
                            height: '100%', width: '100%', videoId: this.videoId,
                            playerVars: { 'autoplay': 1, 'playsinline': 1, 'controls': 0, 'loop': 1, 'playlist': this.videoId },
                            events: { 'onReady': (e) => { e.target.setPlaybackQuality('tiny'); e.target.playVideo(); },
                                      'onStateChange': (e) => { this.isPlaying = (e.data === YT.PlayerState.PLAYING); } }
                        });
                    },
                    playMusic() { if (this.player && this.player.playVideo) { this.player.playVideo(); this.isPlaying = true; } },
                    togglePlay() { if (!this.player) return; this.isPlaying ? this.player.pauseVideo() : this.player.playVideo(); },
                    seek(s) { if (!this.player) return; this.player.seekTo(this.player.getCurrentTime() + s, true); }
                }));
            });
        </script>
    @endif

    {{-- 1. COVER SECTION (Rustic Style) --}}
    <section class="relative h-screen flex flex-col justify-center items-center text-center px-6 overflow-hidden">
        {{-- Background Image with Sepia Overlay --}}
        <div class="absolute inset-0 z-0">
            <img src="{{ asset($coverImage) }}" class="w-full h-full object-cover animate-fade-in transition-transform duration-[20s] hover:scale-110">
            <div class="absolute inset-0 bg-[#3E3830]/40 mix-blend-multiply"></div> {{-- Warm Dark Overlay --}}
            <div class="absolute inset-0 bg-gradient-to-t from-[#3E3830] via-transparent to-[#3E3830]/20"></div>
        </div>

        {{-- Frame Decoration --}}
        <div class="absolute inset-4 md:inset-8 border border-white/30 z-10 pointer-events-none rounded-tl-[3rem] rounded-br-[3rem]"></div>
        <div class="absolute inset-6 md:inset-10 border border-white/20 z-10 pointer-events-none rounded-tl-[3rem] rounded-br-[3rem]"></div>

        {{-- Content --}}
        <div class="relative z-20 text-[#F2E8CF]" data-aos="fade-up" data-aos-duration="1500">
            <p class="uppercase tracking-[0.4em] text-xs md:text-sm mb-4 font-serif">The Wedding of</p>

            <h1 class="font-handwriting text-6xl md:text-8xl mb-2 drop-shadow-md text-white">
                {{ $groom['nickname'] ?? 'Groom' }}
                <br>
                <span class="text-4xl md:text-5xl my-2 block font-serif italic text-[#FFE5B4]">&</span>
                {{ $bride['nickname'] ?? 'Bride' }}
            </h1>

            <div class="flex items-center justify-center gap-4 my-8 opacity-90">
                <span class="h-px w-16 bg-white/60"></span>
                <i class="fa-solid fa-leaf text-xl text-[#FFE5B4]"></i>
                <span class="h-px w-16 bg-white/60"></span>
            </div>

            <p class="text-xl md:text-2xl font-serif tracking-widest border-y border-white/30 py-2 inline-block">
                {{ \Carbon\Carbon::parse($invitation->event_data[0]['date'])->translatedFormat('d . m . Y') }}
            </p>

            @if ($guest)
                <div class="mt-10 backdrop-blur-sm bg-white/10 p-6 shadow-xl border border-white/20 max-w-sm mx-auto relative">
                    {{-- Tape Effect --}}
                    <div class="absolute -top-3 left-1/2 -translate-x-1/2 w-24 h-8 bg-[#D7C0AE] opacity-80 rotate-1 shadow-sm"></div>
                    
                    <p class="text-xs uppercase tracking-wider mb-2 text-white/80 font-sans">Special Invitation For</p>
                    <h3 class="font-serif font-bold text-2xl text-white capitalize">{{ $guest->name }}</h3>
                </div>
            @endif

            <div class="mt-12" x-data>
                <a href="#couple" @click="$dispatch('play-music')"
                    class="group relative px-10 py-3 bg-[#6B705C] text-white font-serif italic text-lg tracking-wide hover:bg-[#585C4C] transition duration-300 shadow-lg border border-[#8D7B68]">
                    <span class="absolute inset-0 border border-white/20 m-1"></span>
                    Buka Undangan
                </a>
            </div>
        </div>
    </section>

    {{-- 2. COUPLE SECTION --}}
    <section id="couple" class="py-24 container mx-auto px-6 text-center relative">
        <div class="relative z-10 max-w-4xl mx-auto" data-aos="fade-up">
            <div class="mb-10 text-[#6B705C]">
                <i class="fa-solid fa-seedling text-3xl mb-4"></i>
                <h2 class="font-serif text-3xl md:text-4xl font-bold mb-6">Mempelai</h2>
                <p class="font-serif italic text-lg md:text-xl text-[#8D7B68] leading-relaxed px-4">
                    "{{ $invitation->couple_data['quote'] ?? 'Dan di antara tanda-tanda kekuasaan-Nya ialah Dia menciptakan untukmu isteri-isteri dari jenismu sendiri...' }}"
                </p>
            </div>
        </div>

        <div class="grid md:grid-cols-2 gap-12 md:gap-24 items-center mt-12 max-w-5xl mx-auto">
            {{-- Groom --}}
            <div class="order-2 md:order-1" data-aos="fade-right">
                <div class="relative mx-auto w-64 h-80 mb-6 p-2 bg-white shadow-xl rotate-[-2deg] transition hover:rotate-0 duration-500 border border-[#E5E0D8]">
                    <img src="{{ asset($groomImage) }}" class="w-full h-full object-cover filter sepia-[0.2]">
                </div>
                <h3 class="font-handwriting text-5xl text-[#6B705C] mb-2">{{ $groom['fullname'] }}</h3>
                <p class="text-[#8D7B68] mb-4 font-serif text-lg">Putra Bpk. {{ $groom['father'] }} <br> & Ibu {{ $groom['mother'] }}</p>
                <a href="https://instagram.com/{{ $groom['instagram'] }}" target="_blank"
                   class="text-[#6B705C] hover:text-[#4A4A4A] text-sm font-bold tracking-widest uppercase border-b border-[#6B705C] pb-1">
                   <i class="fa-brands fa-instagram mr-1"></i> {{ $groom['instagram'] }}
                </a>
            </div>

            {{-- Bride --}}
            <div class="order-1 md:order-2" data-aos="fade-left">
                <div class="relative mx-auto w-64 h-80 mb-6 p-2 bg-white shadow-xl rotate-[2deg] transition hover:rotate-0 duration-500 border border-[#E5E0D8]">
                    <img src="{{ asset($brideImage) }}" class="w-full h-full object-cover filter sepia-[0.2]">
                </div>
                <h3 class="font-handwriting text-5xl text-[#6B705C] mb-2">{{ $bride['fullname'] }}</h3>
                <p class="text-[#8D7B68] mb-4 font-serif text-lg">Putri Bpk. {{ $bride['father'] }} <br> & Ibu {{ $bride['mother'] }}</p>
                <a href="https://instagram.com/{{ $bride['instagram'] }}" target="_blank"
                   class="text-[#6B705C] hover:text-[#4A4A4A] text-sm font-bold tracking-widest uppercase border-b border-[#6B705C] pb-1">
                   <i class="fa-brands fa-instagram mr-1"></i> {{ $bride['instagram'] }}
                </a>
            </div>
        </div>
    </section>

    {{-- 3. EVENTS SECTION --}}
    <section class="py-24 bg-[#EBE5CE] relative">
        {{-- Border pattern top/bottom --}}
        <div class="absolute top-0 left-0 w-full h-2 bg-[url('https://www.transparenttextures.com/patterns/diagmonds-light.png')] opacity-50"></div>

        <div class="container mx-auto px-6 relative z-10">
            <div class="text-center mb-16" data-aos="fade-up">
                <div class="inline-block border-y-2 border-[#6B705C] py-2 mb-4 px-6">
                    <span class="text-[#6B705C] tracking-[0.3em] text-xs font-bold uppercase">Save The Date</span>
                </div>
                <h2 class="font-serif text-4xl md:text-5xl font-bold text-[#4A4A4A]">Rangkaian Acara</h2>
            </div>

            <div class="grid grid-cols-1 md:grid-cols-{{ count($invitation->event_data) > 2 ? 3 : 2 }} gap-8 justify-center max-w-6xl mx-auto">
                @foreach ($invitation->event_data as $event)
                    <div class="bg-[#F9F5EB] p-8 shadow-[0_8px_30px_rgb(0,0,0,0.06)] relative group hover:-translate-y-2 transition duration-500 border-2 border-double border-[#D7C0AE]"
                        data-aos="fade-up">
                        
                        {{-- Corner decoration --}}
                        <div class="absolute top-2 left-2 w-4 h-4 border-t-2 border-l-2 border-[#6B705C]"></div>
                        <div class="absolute top-2 right-2 w-4 h-4 border-t-2 border-r-2 border-[#6B705C]"></div>
                        <div class="absolute bottom-2 left-2 w-4 h-4 border-b-2 border-l-2 border-[#6B705C]"></div>
                        <div class="absolute bottom-2 right-2 w-4 h-4 border-b-2 border-r-2 border-[#6B705C]"></div>

                        <h3 class="font-handwriting text-4xl mb-6 text-[#6B705C]">{{ $event['title'] }}</h3>

                        <div class="space-y-4 font-serif text-[#4A4A4A]">
                            <div class="flex flex-col items-center">
                                <i class="fa-regular fa-calendar text-[#8D7B68] mb-2 text-xl"></i>
                                <span class="font-bold text-lg border-b border-[#D7C0AE] pb-1 mb-1">
                                    {{ \Carbon\Carbon::parse($event['date'])->translatedFormat('l, d F Y') }}
                                </span>
                            </div>

                            <div class="flex flex-col items-center">
                                <i class="fa-regular fa-clock text-[#8D7B68] mb-2 text-xl"></i>
                                <span class="font-bold text-lg">
                                    {{ \Carbon\Carbon::parse($event['date'])->format('H:i') }} WIB
                                </span>
                            </div>
                        </div>

                        <div class="mt-8 pt-6 border-t border-dashed border-[#D7C0AE]">
                            <p class="font-bold text-[#6B705C] mb-1 font-serif text-xl">{{ $event['location'] }}</p>
                            <p class="text-sm text-[#8D7B68] italic px-4 mb-6">{{ $event['address'] }}</p>
                            
                            @if (!empty($event['map_link']))
                                <a href="{{ $event['map_link'] }}" target="_blank"
                                    class="inline-block px-6 py-2 bg-[#6B705C] text-white font-serif italic rounded hover:bg-[#585C4C] transition shadow-md">
                                    <i class="fa-solid fa-map-location-dot mr-2"></i> Lihat Lokasi
                                </a>
                            @endif
                        </div>
                    </div>
                @endforeach
            </div>
        </div>
    </section>

    {{-- 4. GALLERY SECTION (Polaroid Style) --}}
    @if (!empty($moments))
        <section class="py-24 container mx-auto px-6 overflow-hidden">
            <div class="text-center mb-16" data-aos="fade-up">
                <span class="text-6xl font-handwriting text-[#D7C0AE] opacity-50 block -mb-4">Gallery</span>
                <h2 class="font-serif text-4xl font-bold text-[#4A4A4A] relative z-10">Momen Bahagia</h2>
            </div>

            <div class="grid grid-cols-2 md:grid-cols-3 lg:grid-cols-4 gap-6 md:gap-8 px-4">
                @foreach ($moments as $index => $photo)
                    @php 
                        $rotate = rand(-3, 3); // Random rotation for rustic feel
                    @endphp
                    <div class="polaroid" style="transform: rotate({{ $rotate }}deg);" data-aos="zoom-in" data-aos-delay="{{ $index * 100 }}">
                        <div class="w-full aspect-square overflow-hidden bg-gray-100 mb-2 filter sepia-[0.3] hover:sepia-0 transition duration-500">
                            <img src="{{ asset($photo) }}" class="w-full h-full object-cover">
                        </div>
                        {{-- Optional Caption --}}
                        <div class="text-center font-handwriting text-gray-400 text-xl mt-2">
                           #Love
                        </div>
                    </div>
                @endforeach
            </div>
        </section>
    @endif

    {{-- 5. RSVP & GUESTBOOK --}}
    <section class="py-24 bg-[#6B705C]/5 border-y border-[#D7C0AE]">
        <div class="container mx-auto px-6 max-w-4xl">
            <div class="bg-[#F9F5EB] p-8 md:p-12 shadow-xl border border-[#D7C0AE] rounded-sm relative" data-aos="fade-up">
                 {{-- Tape Decoration --}}
                 <div class="absolute -top-4 left-1/2 -translate-x-1/2 w-32 h-8 bg-[#D7C0AE]/80 rotate-1"></div>

                <div class="mb-12">
                    <h3 class="font-serif text-3xl font-bold text-center text-[#6B705C] mb-8 underline decoration-wavy decoration-[#D7C0AE]">Konfirmasi Kehadiran</h3>
                    @livewire('frontend.rsvp-form', ['invitation' => $invitation, 'guest' => $guest])
                </div>

                <div class="flex items-center gap-4 mb-12 justify-center text-[#D7C0AE]">
                    <div class="h-px bg-[#D7C0AE] flex-1"></div>
                    <i class="fa-solid fa-heart"></i>
                    <div class="h-px bg-[#D7C0AE] flex-1"></div>
                </div>

                <div>
                    <h3 class="font-serif text-3xl font-bold text-center text-[#6B705C] mb-8">Ucapan & Doa</h3>
                    @livewire('frontend.guest-book', ['invitation' => $invitation, 'guest' => $guest])
                </div>
            </div>
        </div>
    </section>

    {{-- 6. GIFT SECTION --}}
    @if (!empty($gifts))
        <section class="py-24 container mx-auto px-6 text-center">
            <div class="max-w-2xl mx-auto mb-16" data-aos="fade-up">
                <i class="fa-solid fa-gift text-4xl text-[#6B705C] mb-4"></i>
                <h2 class="font-serif text-4xl font-bold mb-4 text-[#4A4A4A]">Wedding Gift</h2>
                <p class="text-[#8D7B68] font-serif italic">
                    Doa restu Anda merupakan karunia yang sangat berarti bagi kami.
                </p>
            </div>

            <div class="grid grid-cols-1 md:grid-cols-2 gap-6 justify-center max-w-3xl mx-auto">
                @foreach ($gifts as $gift)
                    <div class="bg-[#F9F5EB] p-8 rounded shadow-md border-2 border-dashed border-[#D7C0AE] relative hover:bg-[#F2E8CF] transition"
                        data-aos="flip-up">
                        <div class="font-bold text-xl mb-2 text-[#6B705C] font-serif">{{ $gift['bank_name'] }}</div>
                        
                        <div class="flex justify-center items-center gap-2 mb-4">
                            <span class="text-2xl font-mono text-[#4A4A4A] tracking-wider border-b border-[#8D7B68] pb-1">{{ $gift['account_number'] }}</span>
                            <button onclick="navigator.clipboard.writeText('{{ $gift['account_number'] }}'); alert('Disalin!');"
                                class="text-[#6B705C] hover:text-[#4A4A4A] text-sm ml-2">
                                <i class="fa-regular fa-copy"></i>
                            </button>
                        </div>

                        <div class="text-sm text-[#8D7B68]">a.n <span class="font-bold">{{ $gift['account_name'] }}</span></div>
                    </div>
                @endforeach
            </div>
        </section>
    @endif

    {{-- FOOTER --}}
    <footer class="bg-[#3E3830] text-[#D7C0AE] py-16 text-center relative overflow-hidden">
        <div class="container mx-auto px-6 relative z-10">
            <h2 class="font-handwriting text-5xl mb-6 text-[#F2E8CF]">{{ $groom['nickname'] ?? 'Groom' }} & {{ $bride['nickname'] ?? 'Bride' }}</h2>
            <p class="font-serif italic text-sm opacity-70 mb-8 max-w-md mx-auto">"Terima kasih telah menjadi bagian dari hari bahagia kami."</p>
            
            <div class="flex justify-center items-center gap-4 mb-8">
                <span class="w-12 h-px bg-[#D7C0AE]/30"></span>
                <i class="fa-solid fa-leaf text-[#6B705C]"></i>
                <span class="w-12 h-px bg-[#D7C0AE]/30"></span>
            </div>

            <div class="text-[10px] text-[#8D7B68] font-sans uppercase tracking-widest">
                &copy; {{ date('Y') }} Arvaya Wedding. Made with Love.
            </div>
        </div>
    </footer>

</div>

{{-- AOS Init --}}
<script src="https://unpkg.com/aos@2.3.1/dist/aos.js"></script>
<script>
    AOS.init({ duration: 1200, once: false, offset: 50 });
</script>