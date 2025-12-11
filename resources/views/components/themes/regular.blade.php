@props(['invitation', 'guest'])

@php
    // 1. Data Helper & Fallback
    $groom = $invitation->couple_data['groom'] ?? [];
    $bride = $invitation->couple_data['bride'] ?? [];
    $gifts = $invitation->gifts_data ?? [];
    $theme = $invitation->theme_config ?? [];

    // 2. Color Config
    $primaryColor = data_get($theme, 'primary_color', '#B89760');

    // 3. Image Assets (Support Struktur Baru)
    $galleryData = $invitation->gallery_data ?? [];

    // Fallback Image placeholder
    $defaultCover =
        'https://images.unsplash.com/photo-1519741497674-611481863552?ixlib=rb-1.2.1&auto=format&fit=crop&w=1350&q=80';
    $defaultProfile = 'https://ui-avatars.com/api/?background=F2ECDC&color=5E4926&size=200&name=';

    $coverImage = $galleryData['cover'] ?? ($galleryData[0] ?? $defaultCover);
    $groomImage = $galleryData['groom'] ?? $defaultProfile . urlencode($groom['nickname'] ?? 'Groom');
    $brideImage = $galleryData['bride'] ?? $defaultProfile . urlencode($bride['nickname'] ?? 'Bride');
    $moments = $galleryData['moments'] ?? [];

    // Jika format lama (array biasa), anggap semua adalah moments
    if (isset($galleryData[0])) {
        $moments = $galleryData;
    }
@endphp

<div
    class="font-sans text-[#5E4926] bg-[#F9F7F2] min-h-screen pb-20 overflow-x-hidden selection:bg-[#B89760] selection:text-white">

    {{-- DYNAMIC STYLES --}}
    <style>
        :root {
            --color-primary: {{ $primaryColor }};
        }

        .theme-text {
            color: var(--color-primary);
        }

        .theme-bg {
            background-color: var(--color-primary);
        }

        .theme-border {
            border-color: var(--color-primary);
        }

        .theme-btn:hover {
            background-color: var(--color-primary);
            color: white;
        }

        html {
            scroll-behavior: smooth;
        }

        .font-display {
            font-family: 'Cinzel Decorative', cursive;
        }

        .font-serif {
            font-family: 'Cormorant Garamond', serif;
        }
    </style>

    {{-- MUSIC PLAYER (YOUTUBE INTEGRATION) --}}
    @if (!empty($theme['music_url']))
        <div x-data="youtubePlayer('{{ $theme['music_url'] }}')" x-init="initPlayer()" @play-music.window="playMusic()"
            class="fixed bottom-6 left-6 z-50 font-sans">

            {{-- POPUP CONTROLS --}}
            <div x-show="isOpen" x-transition:enter="transition ease-out duration-300"
                x-transition:enter-start="opacity-0 translate-y-4" x-transition:enter-end="opacity-100 translate-y-0"
                x-transition:leave="transition ease-in duration-200" x-transition:leave-start="opacity-100 translate-y-0"
                x-transition:leave-end="opacity-0 translate-y-4"
                class="mb-4 bg-white/90 backdrop-blur-md p-3 rounded-2xl shadow-[0_8px_30px_rgb(0,0,0,0.12)] border border-white/50 w-64"
                style="display: none;">

                <div class="flex items-center justify-between mb-3 theme-text">
                    <button @click="seek(-10)" class="hover:opacity-70 transition"><i
                            class="fa-solid fa-backward-step text-lg"></i></button>
                    <button @click="togglePlay"
                        class="w-10 h-10 theme-bg text-white rounded-full flex items-center justify-center shadow-lg hover:opacity-90 transition">
                        <i class="fa-solid" :class="isPlaying ? 'fa-pause' : 'fa-play pl-1'"></i>
                    </button>
                    <button @click="seek(10)" class="hover:opacity-70 transition"><i
                            class="fa-solid fa-forward-step text-lg"></i></button>
                </div>

                <div class="relative w-full rounded-lg overflow-hidden bg-black aspect-video border border-gray-200">
                    <div id="yt-player-container"></div>
                    <div class="absolute inset-0 bg-transparent"></div>
                </div>
            </div>

            {{-- FLOATING BUTTON --}}
            <button @click="isOpen = !isOpen"
                class="w-12 h-12 bg-[#F9F7F2]/80 backdrop-blur rounded-full shadow-lg flex items-center justify-center theme-text border border-white/50 hover:bg-white transition animate-[bounce_3s_infinite]">
                <template x-if="!isOpen && isPlaying">
                    <i class="fa-solid fa-compact-disc fa-spin text-xl"></i>
                </template>
                <template x-if="isOpen || !isPlaying">
                    <i class="fa-solid fa-music text-xl"></i>
                </template>
            </button>
        </div>

        {{-- SCRIPT PLAYER --}}
        <script>
            document.addEventListener('alpine:init', () => {
                Alpine.data('youtubePlayer', (url) => ({
                    player: null,
                    isPlaying: false,
                    isOpen: false,
                    videoId: '',
                    initPlayer() {
                        const match = url.match(
                            /^.*(youtu.be\/|v\/|u\/\w\/|embed\/|watch\?v=|&v=)([^#&?]*).*/);
                        this.videoId = (match && match[2].length === 11) ? match[2] : null;
                        if (!this.videoId) return;
                        if (!window.YT) {
                            const tag = document.createElement('script');
                            tag.src = "https://www.youtube.com/iframe_api";
                            document.body.appendChild(tag);
                            window.onYouTubeIframeAPIReady = () => this.createPlayer();
                        } else {
                            this.createPlayer();
                        }
                    },
                    createPlayer() {
                        this.player = new YT.Player('yt-player-container', {
                            height: '100%',
                            width: '100%',
                            videoId: this.videoId,
                            playerVars: {
                                'autoplay': 1,
                                'playsinline': 1,
                                'controls': 0,
                                'loop': 1,
                                'playlist': this.videoId
                            },
                            events: {
                                'onReady': (e) => {
                                    e.target.setPlaybackQuality('tiny');
                                    e.target.playVideo();
                                },
                                'onStateChange': (e) => {
                                    this.isPlaying = (e.data === YT.PlayerState.PLAYING);
                                }
                            }
                        });
                    },
                    playMusic() {
                        if (this.player && this.player.playVideo) {
                            this.player.playVideo();
                            this.isPlaying = true;
                        }
                    },
                    togglePlay() {
                        if (!this.player) return;
                        this.isPlaying ? this.player.pauseVideo() : this.player.playVideo();
                    },
                    seek(s) {
                        if (!this.player) return;
                        this.player.seekTo(this.player.getCurrentTime() + s, true);
                    }
                }));
            });
        </script>
    @endif

    {{-- 1. COVER SECTION --}}
    <section
        class="relative h-screen flex flex-col justify-center items-center text-center px-6 overflow-hidden bg-black">
        {{-- Background Image --}}
        <div class="absolute inset-0 z-0">
            <img src="{{ asset($coverImage) }}"
                class="w-full h-full object-cover opacity-60 transition-transform duration-[10s] hover:scale-110">
            <div class="absolute inset-0 bg-gradient-to-b from-black/30 via-transparent to-black/60"></div>
        </div>

        {{-- Content --}}
        <div class="relative z-10 text-white animate-fade-in-up max-w-4xl mx-auto" data-aos="zoom-in"
            data-aos-duration="1500">
            <p class="uppercase tracking-[0.3em] text-sm mb-6 text-yellow-100/80 font-sans">The Wedding of</p>

            <h1 class="font-display text-5xl md:text-8xl mb-4 leading-tight drop-shadow-lg text-[#F9F7F2]">
                {{ $groom['nickname'] ?? 'Groom' }}
                <span class="theme-text font-serif italic mx-2">&</span>
                {{ $bride['nickname'] ?? 'Bride' }}
            </h1>

            <div class="flex items-center justify-center gap-4 my-8">
                <div class="h-[1px] w-12 bg-white/50"></div>
                <p class="text-xl md:text-2xl font-serif italic tracking-widest">
                    {{ \Carbon\Carbon::parse($invitation->event_data[0]['date'])->translatedFormat('d . m . Y') }}
                </p>
                <div class="h-[1px] w-12 bg-white/50"></div>
            </div>

            @if ($guest)
                <div
                    class="mt-8 bg-white/10 backdrop-blur-md p-6 rounded-2xl border border-white/20 inline-block animate-float shadow-2xl">
                    <p class="text-[10px] uppercase tracking-wider mb-2 text-white/80">Kepada Yth. Bapak/Ibu/Saudara/i
                    </p>
                    <h3 class="font-serif font-bold text-2xl md:text-3xl text-[#F9F7F2]">{{ $guest->name }}</h3>
                </div>
            @endif

            <div class="mt-12" x-data>
                <a href="#couple" @click="$dispatch('play-music')"
                    class="group relative px-8 py-3 bg-[#F9F7F2] text-[#5E4926] rounded-full font-bold uppercase tracking-widest text-xs hover:bg-[#B89760] hover:text-white transition-all duration-300 shadow-[0_0_20px_rgba(255,255,255,0.3)] hover:shadow-[0_0_30px_rgba(184,151,96,0.6)] cursor-pointer overflow-hidden inline-flex items-center gap-2">
                    <i class="fa-solid fa-envelope-open"></i>
                    Buka Undangan
                </a>
            </div>
        </div>

        <div class="absolute bottom-10 animate-bounce text-white/50">
            <i class="fa-solid fa-chevron-down text-2xl"></i>
        </div>
    </section>

    {{-- 2. COUPLE SECTION --}}
    <section id="couple" class="py-24 container mx-auto px-6 text-center relative overflow-hidden">
        {{-- Decoration --}}
        <div
            class="absolute top-0 right-0 -mr-20 -mt-20 w-96 h-96 theme-bg rounded-full mix-blend-multiply filter blur-3xl opacity-10 pointer-events-none">
        </div>

        <div class="relative z-10" data-aos="fade-up">
            <i class="fa-solid fa-quote-left text-4xl theme-text opacity-30 mb-6 block"></i>
            <p class="font-serif text-xl md:text-2xl text-[#7C6339] mb-8 max-w-3xl mx-auto leading-relaxed italic">
                "{{ $invitation->couple_data['quote'] ?? 'Dan di antara tanda-tanda (kebesaran)-Nya ialah Dia menciptakan pasangan-pasangan untukmu dari jenismu sendiri, agar kamu cenderung dan merasa tenteram kepadanya...' }}"
            </p>
            <div class="w-24 h-1 theme-bg mx-auto rounded-full mb-16"></div>
        </div>

        <div class="grid md:grid-cols-2 gap-16 items-center mt-12 max-w-5xl mx-auto">
            {{-- Pria --}}
            <div class="order-2 md:order-1 group" data-aos="fade-right">
                <div class="relative inline-block mb-6">
                    <div
                        class="absolute inset-0 border-2 theme-border rounded-full transform translate-x-2 translate-y-2 transition group-hover:translate-x-0 group-hover:translate-y-0">
                    </div>
                    <img src="{{ asset($groomImage) }}"
                        class="w-48 h-48 rounded-full object-cover relative z-10 shadow-lg border-4 border-white">
                </div>
                <h3 class="font-display text-4xl theme-text mb-2">{{ $groom['fullname'] }}</h3>
                <p class="text-[#7C6339] mb-4 font-serif italic text-lg">Putra dari Bpk. {{ $groom['father'] }} & Ibu
                    {{ $groom['mother'] }}</p>
                <a href="https://instagram.com/{{ $groom['instagram'] }}" target="_blank"
                    class="inline-flex items-center gap-2 px-4 py-2 bg-[#F9F7F2] border border-[#E6D9B8] rounded-full text-xs font-bold text-[#9A7D4C] theme-btn transition">
                    <i class="fa-brands fa-instagram"></i> {{ $groom['instagram'] }}
                </a>
            </div>

            {{-- Wanita --}}
            <div class="order-1 md:order-2 group" data-aos="fade-left">
                <div class="relative inline-block mb-6">
                    <div
                        class="absolute inset-0 border-2 theme-border rounded-full transform -translate-x-2 translate-y-2 transition group-hover:translate-x-0 group-hover:translate-y-0">
                    </div>
                    <img src="{{ asset($brideImage) }}"
                        class="w-48 h-48 rounded-full object-cover relative z-10 shadow-lg border-4 border-white">
                </div>
                <h3 class="font-display text-4xl theme-text mb-2">{{ $bride['fullname'] }}</h3>
                <p class="text-[#7C6339] mb-4 font-serif italic text-lg">Putri dari Bpk. {{ $bride['father'] }} & Ibu
                    {{ $bride['mother'] }}</p>
                <a href="https://instagram.com/{{ $bride['instagram'] }}" target="_blank"
                    class="inline-flex items-center gap-2 px-4 py-2 bg-[#F9F7F2] border border-[#E6D9B8] rounded-full text-xs font-bold text-[#9A7D4C] theme-btn transition">
                    <i class="fa-brands fa-instagram"></i> {{ $bride['instagram'] }}
                </a>
            </div>
        </div>
    </section>

    {{-- 3. EVENTS SECTION --}}
    <section class="py-24 bg-[#E6D9B8]/20 relative">
        <div class="container mx-auto px-6">
            <div class="text-center mb-16" data-aos="fade-up">
                <span class="text-[#9A7D4C] uppercase tracking-[0.3em] text-xs font-bold block mb-2">Save The
                    Date</span>
                <h2 class="font-display text-4xl md:text-5xl font-bold text-[#5E4926]">Rangkaian Acara</h2>
            </div>

            <div
                class="grid grid-cols-1 md:grid-cols-{{ count($invitation->event_data) > 2 ? 3 : 2 }} gap-8 justify-center max-w-6xl mx-auto">
                @foreach ($invitation->event_data as $event)
                    <div class="bg-white p-10 rounded-t-[50px] rounded-b-2xl shadow-[0_10px_40px_-10px_rgba(184,151,96,0.1)] border border-[#E6D9B8]/50 text-center relative group hover:-translate-y-2 transition duration-500"
                        data-aos="fade-up" data-aos-delay="100">
                        {{-- Decorative Line --}}
                        <div class="absolute top-0 left-1/2 transform -translate-x-1/2 w-16 h-1 theme-bg rounded-b-lg">
                        </div>

                        <h3 class="font-serif font-bold text-3xl mb-6 theme-text">{{ $event['title'] }}</h3>

                        <div class="space-y-6">
                            <div class="flex items-center justify-center gap-3">
                                <div
                                    class="w-10 h-10 rounded-full bg-[#F9F7F2] flex items-center justify-center theme-text border border-[#E6D9B8]">
                                    <i class="fa-regular fa-calendar-check"></i>
                                </div>
                                <div class="text-left">
                                    <p class="text-[10px] text-[#9A7D4C] uppercase font-bold">Tanggal</p>
                                    <p class="font-serif text-lg text-[#5E4926]">
                                        {{ \Carbon\Carbon::parse($event['date'])->translatedFormat('l, d F Y') }}</p>
                                </div>
                            </div>

                            <div class="flex items-center justify-center gap-3">
                                <div
                                    class="w-10 h-10 rounded-full bg-[#F9F7F2] flex items-center justify-center theme-text border border-[#E6D9B8]">
                                    <i class="fa-regular fa-clock"></i>
                                </div>
                                <div class="text-left">
                                    <p class="text-[10px] text-[#9A7D4C] uppercase font-bold">Waktu</p>
                                    <p class="font-serif text-lg text-[#5E4926]">
                                        {{ \Carbon\Carbon::parse($event['date'])->format('H:i') }} WIB - Selesai</p>
                                </div>
                            </div>
                        </div>

                        <hr class="my-6 border-[#F2ECDC]">

                        <div class="mb-6">
                            <p class="font-bold text-[#5E4926] mb-1">{{ $event['location'] }}</p>
                            <p class="text-sm text-[#7C6339] leading-relaxed px-4">{{ $event['address'] }}</p>
                        </div>

                        @if (!empty($event['map_link']))
                            <a href="{{ $event['map_link'] }}" target="_blank"
                                class="inline-block px-8 py-3 bg-[#5E4926] text-white rounded-full text-xs font-bold uppercase tracking-wider hover:bg-[#403013] transition shadow-lg theme-btn">
                                <i class="fa-solid fa-location-arrow mr-2"></i> Google Maps
                            </a>
                        @endif
                    </div>
                @endforeach
            </div>
        </div>
    </section>

    {{-- 4. GALLERY SECTION --}}
    @if (!empty($moments))
        <section class="py-24 container mx-auto px-6">
            <div class="text-center mb-16" data-aos="fade-up">
                <i class="fa-solid fa-camera-retro text-3xl text-[#E6D9B8] mb-4"></i>
                <h2 class="font-display text-4xl md:text-5xl font-bold text-[#5E4926]">Galeri Kebahagiaan</h2>
            </div>

            <div class="grid grid-cols-2 md:grid-cols-4 gap-4 auto-rows-[200px]" data-aos="fade-up">
                @foreach ($moments as $index => $photo)
                    <div
                        class="relative group overflow-hidden rounded-2xl shadow-md border border-[#E6D9B8]/50 {{ $index % 3 == 0 ? 'md:col-span-2 md:row-span-2 h-full' : '' }}">
                        <img src="{{ asset($photo) }}"
                            class="w-full h-full object-cover transition duration-700 group-hover:scale-110">
                        <div class="absolute inset-0 bg-black/20 group-hover:bg-black/40 transition"></div>
                    </div>
                @endforeach
            </div>
        </section>
    @endif

    {{-- 5. RSVP & GUESTBOOK WRAPPER --}}
    <section class="py-24 bg-gradient-to-b from-[#F9F7F2] to-[#E6D9B8]/30">
        <div class="container mx-auto px-6 max-w-4xl">

            <div class="mb-20" data-aos="zoom-in">
                @livewire('frontend.rsvp-form', ['invitation' => $invitation, 'guest' => $guest])
            </div>

            <div class="flex items-center gap-4 mb-20 justify-center opacity-50">
                <div class="h-px theme-bg w-20"></div>
                <i class="fa-solid fa-heart theme-text"></i>
                <div class="h-px theme-bg w-20"></div>
            </div>

            <div data-aos="fade-up">
                @livewire('frontend.guest-book', ['invitation' => $invitation, 'guest' => $guest])
            </div>
        </div>
    </section>

    {{-- 6. GIFT SECTION --}}
    @if (!empty($gifts))
        <section class="py-24 bg-white container mx-auto px-6 text-center">
            <div class="max-w-2xl mx-auto mb-12" data-aos="fade-up">
                <div
                    class="w-16 h-16 bg-[#F9F7F2] rounded-full flex items-center justify-center mx-auto mb-6 theme-text border border-[#E6D9B8]">
                    <i class="fa-solid fa-gift text-2xl"></i>
                </div>
                <h2 class="font-display text-4xl font-bold mb-4 text-[#5E4926]">Tanda Kasih</h2>
                <p class="text-[#7C6339] text-sm leading-relaxed">
                    Tanpa mengurangi rasa hormat, bagi Bapak/Ibu/Saudara/i yang ingin memberikan tanda kasih untuk kami,
                    dapat melalui:
                </p>
            </div>

            <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-6 justify-center max-w-4xl mx-auto">
                @foreach ($gifts as $gift)
                    <div class="bg-gradient-to-br from-[#F9F7F2] to-white p-8 rounded-2xl shadow-[0_10px_30px_-10px_rgba(0,0,0,0.05)] border border-[#E6D9B8] relative group hover:-translate-y-1 transition duration-300"
                        data-aos="flip-up">
                        <div
                            class="absolute top-0 left-0 w-full h-1 theme-bg rounded-t-2xl opacity-0 group-hover:opacity-100 transition">
                        </div>

                        <div class="font-bold text-2xl mb-1 text-[#5E4926]">{{ $gift['bank_name'] }}</div>
                        <p class="text-xs text-[#9A7D4C] uppercase tracking-widest mb-6">Bank Transfer / E-Wallet</p>

                        <div
                            class="bg-white border border-[#E6D9B8] p-3 rounded-lg mb-4 flex justify-between items-center">
                            <span
                                class="text-lg font-mono text-[#5E4926] font-bold tracking-wide">{{ $gift['account_number'] }}</span>
                            <button
                                onclick="navigator.clipboard.writeText('{{ $gift['account_number'] }}'); alert('No Rekening Disalin!');"
                                class="theme-text hover:text-[#5E4926] transition" title="Copy">
                                <i class="fa-regular fa-copy"></i>
                            </button>
                        </div>

                        <div class="text-sm text-[#7C6339]">a.n <span
                                class="font-bold">{{ $gift['account_name'] }}</span></div>
                    </div>
                @endforeach
            </div>
        </section>
    @endif

    {{-- FOOTER --}}
    <footer class="bg-[#2D2418] text-[#E6D9B8] py-12 text-center relative overflow-hidden">
        <div class="absolute top-0 left-0 w-full h-1 bg-gradient-to-r from-[#2D2418] via-[#B89760] to-[#2D2418]"></div>

        <div class="container mx-auto px-6">
            <h2 class="font-display text-3xl mb-4 text-white">{{ $groom['nickname'] ?? 'Groom' }} <span
                    class="font-serif italic theme-text">&</span> {{ $bride['nickname'] ?? 'Bride' }}</h2>
            <p class="text-xs tracking-[0.2em] opacity-50 uppercase mb-8">Terima Kasih Atas Doa & Restu Anda</p>
            <div class="text-[10px] text-[#9A7D4C]">
                &copy; {{ date('Y') }} Arvaya De Aure. All rights reserved.
            </div>
        </div>
    </footer>

</div>

{{-- GLOBAL SCRIPTS FOR THEME --}}
<script src="https://unpkg.com/aos@2.3.1/dist/aos.js"></script>
<script>
    AOS.init({
        duration: 1000,
        once: false,
        offset: 50,
    });
</script>
