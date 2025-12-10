@props(['invitation', 'guest'])

@php
    // Helper data
    $groom = $invitation->couple_data['groom'] ?? [];
    $bride = $invitation->couple_data['bride'] ?? [];
    $gifts = $invitation->gifts_data ?? [];

    // PERBAIKAN DISINI:
    // Gunakan '?? []' agar jika null dia menjadi array kosong, sehingga tidak error saat diakses key-nya
    $theme = $invitation->theme_config ?? [];

    // Ambil foto pertama atau placeholder
    $coverImage = $invitation->gallery_data[0] ?? 'https://via.placeholder.com/1080x1920?text=Wedding';
@endphp

<div class="font-sans text-gray-800 bg-gray-50 min-h-screen pb-20">

    {{-- CSS Custom --}}
    <style>
        .theme-text {
            color: {{ data_get($theme, 'primary_color', '#d4af37') }};
        }

        .theme-bg {
            background-color: {{ data_get($theme, 'primary_color', '#d4af37') }};
        }

        /* Hover effect */
        .theme-btn:hover {
            background-color: {{ data_get($theme, 'primary_color', '#d4af37') }};
        }
    </style>


    {{-- COVER SECTION --}}
    <section class="relative h-screen flex flex-col justify-center items-center text-center px-6 overflow-hidden">
        {{-- Background Image --}}
        <div class="absolute inset-0 z-0">
            <img src="{{ asset($coverImage) }}" class="w-full h-full object-cover">
            <div class="absolute inset-0 bg-black/40"></div>
        </div>

        {{-- Content --}}
        <div class="relative z-10 text-white animate-fade-in-up">
            <p class="uppercase tracking-widest text-sm mb-4">The Wedding of</p>
            <h1 class="font-serif text-5xl md:text-7xl font-bold mb-4">
                {{ $groom['nickname'] }} <span class="text-yellow-400">&</span> {{ $bride['nickname'] }}
            </h1>
            <p class="text-lg mb-8">{{ \Carbon\Carbon::parse($invitation->event_data[0]['date'])->format('d . m . Y') }}
            </p>

            @if ($guest)
                <div
                    class="bg-white/20 backdrop-blur-sm p-4 rounded-xl border border-white/30 inline-block animate-bounce">
                    <p class="text-xs mb-1">Kepada Yth:</p>
                    <p class="font-bold text-xl">{{ $guest->name }}</p>
                </div>
            @endif

            <div class="mt-12" x-data>
                <a href="#couple" @click="$dispatch('play-music')"
                    class="px-6 py-2 border border-white rounded-full hover:bg-white hover:text-black transition">
                    Buka Undangan
                </a>
            </div>
        </div>
    </section>

    {{-- MEMPELAI SECTION --}}
    <section id="couple" class="py-20 container mx-auto px-6 text-center">
        <p class="italic text-gray-500 mb-6 max-w-2xl mx-auto">
            "{{ $invitation->couple_data['quote'] ?? 'Tanpa mengurangi rasa hormat, kami bermaksud mengundang Bapak/Ibu/Saudara/i...' }}"
        </p>

        <div class="grid md:grid-cols-2 gap-10 items-center mt-12">
            {{-- Pria --}}
            <div class="order-2 md:order-1">
                <h3 class="font-serif text-4xl theme-text font-bold mb-2">{{ $groom['fullname'] }}</h3>
                <p class="text-gray-500 mb-2">Putra dari Bpk. {{ $groom['father'] }} & Ibu {{ $groom['mother'] }}</p>
                <a href="https://instagram.com/{{ $groom['instagram'] }}"
                    class="text-sm text-gray-400 hover:text-pink-600">
                    <i class="fa-brands fa-instagram"></i> {{ $groom['instagram'] }}
                </a>
            </div>

            {{-- Wanita --}}
            <div class="order-1 md:order-2">
                <h3 class="font-serif text-4xl theme-text font-bold mb-2">{{ $bride['fullname'] }}</h3>
                <p class="text-gray-500 mb-2">Putri dari Bpk. {{ $bride['father'] }} & Ibu {{ $bride['mother'] }}</p>
                <a href="https://instagram.com/{{ $bride['instagram'] }}"
                    class="text-sm text-gray-400 hover:text-pink-600">
                    <i class="fa-brands fa-instagram"></i> {{ $bride['instagram'] }}
                </a>
            </div>
        </div>
    </section>

    {{-- ACARA SECTION --}}
    <section class="py-20 bg-gray-100">
        <div class="container mx-auto px-6">
            <h2 class="font-serif text-3xl text-center font-bold mb-12 theme-text">Rangkaian Acara</h2>

            <div
                class="grid grid-cols-1 md:grid-cols-{{ count($invitation->event_data) > 2 ? 3 : 2 }} gap-6 justify-center">
                @foreach ($invitation->event_data as $event)
                    <div
                        class="bg-white p-8 rounded-2xl shadow-sm text-center transform hover:-translate-y-2 transition duration-300">
                        <h3 class="font-bold text-xl mb-4 text-gray-800">{{ $event['title'] }}</h3>

                        <div class="flex items-center justify-center gap-2 text-gray-600 mb-4">
                            <i class="fa-regular fa-calendar"></i>
                            <span>{{ \Carbon\Carbon::parse($event['date'])->translatedFormat('l, d F Y') }}</span>
                        </div>
                        <div class="flex items-center justify-center gap-2 text-gray-600 mb-6">
                            <i class="fa-regular fa-clock"></i>
                            <span>{{ \Carbon\Carbon::parse($event['date'])->format('H:i') }} WIB</span>
                        </div>

                        <p class="font-semibold text-gray-800 mb-1">{{ $event['location'] }}</p>
                        <p class="text-sm text-gray-500 mb-6">{{ $event['address'] }}</p>

                        @if (!empty($event['map_link']))
                            <a href="{{ $event['map_link'] }}" target="_blank"
                                class="px-6 py-2 bg-gray-900 text-white rounded-lg text-sm hover:bg-gray-700">
                                <i class="fa-solid fa-location-dot mr-1"></i> Google Maps
                            </a>
                        @endif
                    </div>
                @endforeach
            </div>
        </div>
    </section>

    {{-- GALERI SECTION --}}
    @if (!empty($invitation->gallery_data))
        <section class="py-20 container mx-auto px-6">
            <h2 class="font-serif text-3xl text-center font-bold mb-12 theme-text">Galeri Kebahagiaan</h2>
            <div class="grid grid-cols-2 md:grid-cols-3 lg:grid-cols-4 gap-4">
                @foreach ($invitation->gallery_data as $photo)
                    <img src="{{ asset($photo) }}"
                        class="w-full h-64 object-cover rounded-lg shadow-sm hover:opacity-90 transition cursor-pointer">
                @endforeach
            </div>
        </section>
    @endif

    {{-- RSVP & GUESTBOOK WRAPPER --}}
    <section class="py-20 bg-gradient-to-b from-white to-pink-50">
        <div class="container mx-auto px-6 max-w-4xl">

            {{-- RSVP Widget --}}
            <div class="mb-16">
                @livewire('frontend.rsvp-form', ['invitation' => $invitation, 'guest' => $guest])
            </div>

            <hr class="border-gray-200 mb-16">

            {{-- GuestBook Widget --}}
            <div>
                @livewire('frontend.guest-book', ['invitation' => $invitation, 'guest' => $guest])
            </div>

        </div>
    </section>

    {{-- GIFT SECTION --}}
    @if (!empty($invitation->gifts_data))
        <section class="py-20 bg-gray-50 container mx-auto px-6 text-center">
            <h2 class="font-serif text-3xl font-bold mb-4 theme-text">Tanda Kasih</h2>
            <p class="text-gray-500 mb-8 max-w-lg mx-auto text-sm">
                Doa restu Anda merupakan karunia yang sangat berarti bagi kami. Namun jika memberi adalah ungkapan tanda
                kasih Anda, kami menerima kado secara cashless.
            </p>

            <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-6 justify-center max-w-4xl mx-auto">
                @foreach ($invitation->gifts_data as $gift)
                    <div class="bg-white p-6 rounded-xl shadow-sm border border-gray-100 flex flex-col items-center">
                        {{-- Icon Bank Sederhana --}}
                        <div class="font-bold text-xl mb-2 text-gray-800">{{ $gift['bank_name'] }}</div>

                        <div class="text-lg font-mono text-gray-600 mb-1 select-all">{{ $gift['account_number'] }}
                        </div>
                        <div class="text-sm text-gray-400 mb-4">a.n {{ $gift['account_name'] }}</div>

                        <button
                            onclick="navigator.clipboard.writeText('{{ $gift['account_number'] }}'); alert('No Rekening Disalin!');"
                            class="px-4 py-1 border border-gray-300 rounded text-xs text-gray-600 hover:bg-gray-100 transition">
                            <i class="fa-regular fa-copy mr-1"></i> Salin Nomor
                        </button>
                    </div>
                @endforeach
            </div>
        </section>
    @endif

    {{-- FOOTER --}}
    <footer class="bg-[#5a4a42] text-[#f3efe8] py-8 text-center text-xs">
        <p>&copy; {{ date('Y') }} {{ $groom['nickname'] ?? 'Groom' }} & {{ $bride['nickname'] ?? 'Bride' }}</p>
    </footer>

    {{-- MUSIC PLAYER (YOUTUBE VERSION - AUTOPLAY READY) --}}
    @if (!empty($theme['music_url']))
        {{-- Container Player --}}
        <div x-data="youtubePlayer('{{ $theme['music_url'] }}')" x-init="initPlayer()" @play-music.window="playMusic()"
            class="fixed bottom-4 left-4 z-50 font-sans">

            {{-- POPUP CONTROLS (Tetap sama seperti sebelumnya) --}}
            <div x-show="isOpen" x-transition:enter="transition ease-out duration-300"
                x-transition:enter-start="opacity-0 translate-y-4" x-transition:enter-end="opacity-100 translate-y-0"
                x-transition:leave="transition ease-in duration-200"
                x-transition:leave-start="opacity-100 translate-y-0" x-transition:leave-end="opacity-0 translate-y-4"
                class="mb-4 bg-white/90 backdrop-blur-md p-3 rounded-xl shadow-2xl border border-white/50 w-64"
                style="display: none;"> {{-- Tambah display none agar tidak kedip saat load --}}

                {{-- Bagian Atas: Controls --}}
                <div class="flex items-center justify-between mb-3 text-pink-600">
                    <button @click="seek(-10)" class="hover:text-pink-800 transition"><i
                            class="fa-solid fa-backward-step text-lg"></i></button>
                    <button @click="togglePlay"
                        class="w-10 h-10 bg-pink-600 text-white rounded-full flex items-center justify-center shadow-lg hover:bg-pink-700 transition">
                        <i class="fa-solid" :class="isPlaying ? 'fa-pause' : 'fa-play pl-1'"></i>
                    </button>
                    <button @click="seek(10)" class="hover:text-pink-800 transition"><i
                            class="fa-solid fa-forward-step text-lg"></i></button>
                </div>

                {{-- Bagian Bawah: Mini Youtube Player --}}
                <div class="relative w-full rounded-lg overflow-hidden bg-black aspect-video border border-gray-200">
                    <div id="yt-player-container"></div>
                    <div class="absolute inset-0 bg-transparent"></div>
                </div>
                <p class="text-[10px] text-gray-400 text-center mt-1">Audio Source: YouTube</p>
            </div>

            {{-- MAIN FLOATING BUTTON (Tetap sama) --}}
            <button @click="isOpen = !isOpen"
                class="w-10 h-10 bg-white/80 backdrop-blur rounded-full shadow-lg flex items-center justify-center text-pink-600 border border-white hover:bg-white transition animate-bounce-slow">
                <template x-if="!isOpen && isPlaying">
                    <i class="fa-solid fa-compact-disc fa-spin text-lg"></i>
                </template>
                <template x-if="isOpen || !isPlaying">
                    <i class="fa-solid fa-music text-lg"></i>
                </template>
            </button>
        </div>

        {{-- SCRIPT UPDATE --}}
        <script>
            document.addEventListener('alpine:init', () => {
                Alpine.data('youtubePlayer', (url) => ({
                    player: null,
                    isPlaying: false,
                    isOpen: false,
                    videoId: '',

                    initPlayer() {
                        const regExp = /^.*(youtu.be\/|v\/|u\/\w\/|embed\/|watch\?v=|&v=)([^#&?]*).*/;
                        const match = url.match(regExp);
                        this.videoId = (match && match[2].length === 11) ? match[2] : null;

                        if (!this.videoId) return;

                        if (!window.YT) {
                            const tag = document.createElement('script');
                            tag.src = "https://www.youtube.com/iframe_api";
                            const firstScriptTag = document.getElementsByTagName('script')[0];
                            firstScriptTag.parentNode.insertBefore(tag, firstScriptTag);

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
                                'autoplay': 1, // Coba autoplay (Works on some desktop)
                                'playsinline': 1,
                                'controls': 0,
                                'loop': 1,
                                'playlist': this.videoId
                            },
                            events: {
                                'onReady': (event) => {
                                    // Usaha pertama: Play langsung saat siap
                                    event.target.playVideo();
                                },
                                'onStateChange': (event) => {
                                    this.isPlaying = (event.data === YT.PlayerState.PLAYING);
                                }
                            }
                        });
                    },

                    // Fungsi ini dipanggil oleh Tombol "Buka Undangan"
                    playMusic() {
                        if (this.player && typeof this.player.playVideo === 'function') {
                            this.player.playVideo();
                            this.isPlaying = true;
                        }
                    },

                    togglePlay() {
                        if (!this.player) return;
                        this.isPlaying ? this.player.pauseVideo() : this.player.playVideo();
                    },

                    seek(seconds) {
                        if (!this.player) return;
                        this.player.seekTo(this.player.getCurrentTime() + seconds, true);
                    }
                }));
            });
        </script>
    @endif

</div>

@section('scripts')
    <script src="https://unpkg.com/aos@2.3.1/dist/aos.js"></script>
    <script>
        AOS.init({
        });
    </script>
@endsection
