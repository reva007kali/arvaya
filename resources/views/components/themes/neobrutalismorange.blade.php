@props(['invitation', 'guest'])

@php
    $groom = $invitation->couple_data['groom'] ?? [];
    $bride = $invitation->couple_data['bride'] ?? [];
    $gifts = $invitation->gifts_data ?? [];
    $theme = $invitation->theme_config ?? [];
    $galleryData = $invitation->gallery_data ?? [];

    // Fallback Images
    $defaultCover =
        'https://images.unsplash.com/photo-1519741497674-611481863552?ixlib=rb-1.2.1&auto=format&fit=crop&w=1350&q=80';
    $defaultProfile = 'https://ui-avatars.com/api/?background=FFFFFF&color=111111&size=200&bold=true&name=';

    $coverImage = $galleryData['cover'] ?? ($galleryData[0] ?? $defaultCover);
    $groomImage = $galleryData['groom'] ?? $defaultProfile . urlencode($groom['nickname'] ?? 'Groom');
    $brideImage = $galleryData['bride'] ?? $defaultProfile . urlencode($bride['nickname'] ?? 'Bride');
    $moments = $galleryData['moments'] ?? [];
    if (isset($galleryData[0])) {
        $moments = $galleryData;
    }

    // Date Parsing
    $eventDate = \Carbon\Carbon::parse($invitation->event_data[0]['date']);
@endphp

@slot('head')
    <title>{{ $groom['nickname'] ?? 'Groom' }} & {{ $bride['nickname'] ?? 'Bride' }} - NOISE & LOVE</title>
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <!-- Fonts: Syne (Bold/Display) & Space Mono (Raw/Code) -->
    <link
        href="https://fonts.googleapis.com/css2?family=Space+Mono:ital,wght@0,400;0,700;1,400&family=Syne:wght@400;500;700;800&display=swap"
        rel="stylesheet">
@endslot

<style>
    :root {
        /* NEO-BRUTALISM PALETTE (TWO TONE + WHITE) */
        --color-ink: #111111;
        /* Tone 1: Structure */
        --color-accent: #FF3C00;
        /* Tone 2: Energy */
        --color-paper: #FFFFFF;
        /* Canvas */

        --font-display: 'Syne', sans-serif;
        --font-mono: 'Space Mono', monospace;

        --border-thick: 3px solid var(--color-ink);
        --border-thin: 1px solid var(--color-ink);
        --shadow-hard: 6px 6px 0px 0px var(--color-ink);
        --shadow-hover: 2px 2px 0px 0px var(--color-ink);
    }

    body {
        background-color: var(--color-paper);
        color: var(--color-ink);
        font-family: var(--font-mono);
        overflow-x: hidden;
    }

    .theme-bg {
        background: var(--color-accent);
    }

    /* UTILITY CLASSES FOR BRUTALISM */
    .neo-box {
        background: var(--color-paper);
        border: var(--border-thick);
        box-shadow: var(--shadow-hard);
        transition: all 0.2s ease;
    }

    .neo-box:hover {
        transform: translate(2px, 2px);
        box-shadow: var(--shadow-hover);
    }

    .neo-box-accent {
        background: var(--color-accent);
        color: var(--color-paper);
        border: var(--border-thick);
        box-shadow: var(--shadow-hard);
    }

    .neo-text-stroke {
        -webkit-text-stroke: 1px var(--color-ink);
        color: transparent;
    }

    .font-display {
        font-family: var(--font-display);
    }

    .font-mono {
        font-family: var(--font-mono);
    }

    /* MARQUEE ANIMATION */
    .marquee-container {
        overflow: hidden;
        white-space: nowrap;
        position: relative;
    }

    .marquee-content {
        display: inline-block;
        animation: marquee 15s linear infinite;
    }

    @keyframes marquee {
        0% {
            transform: translateX(0);
        }

        100% {
            transform: translateX(-50%);
        }
    }

    /* GLITCH EFFECT (Simple) */
    .glitch-hover:hover {
        animation: glitch 0.3s cubic-bezier(.25, .46, .45, .94) both infinite;
        color: var(--color-accent);
    }

    @keyframes glitch {
        0% {
            transform: translate(0);
        }

        20% {
            transform: translate(-2px, 2px);
        }

        40% {
            transform: translate(-2px, -2px);
        }

        60% {
            transform: translate(2px, 2px);
        }

        80% {
            transform: translate(2px, -2px);
        }

        100% {
            transform: translate(0);
        }
    }

    /* Custom Scrollbar */
    ::-webkit-scrollbar {
        width: 12px;
    }

    ::-webkit-scrollbar-track {
        background: var(--color-paper);
        border-left: var(--border-thick);
    }

    ::-webkit-scrollbar-thumb {
        background: var(--color-ink);
        border: 2px solid var(--color-paper);
    }

    ::-webkit-scrollbar-thumb:hover {
        background: var(--color-accent);
    }
</style>

{{-- ======================================================================= --}}
{{-- LOADING SCREEN (SYSTEM BOOT STYLE) --}}
{{-- ======================================================================= --}}
<div id="loading-overlay" class="fixed inset-0 z-[9999] bg-white flex flex-col items-center justify-center p-4">
    <div class="w-full max-w-md border-4 border-black p-6 shadow-[8px_8px_0px_0px_#000]">
        <div class="flex justify-between items-end mb-4 font-mono text-sm">
            <span>SYSTEM_BOOT</span>
            <span id="loading-percent">0%</span>
        </div>

        <!-- Progress Bar -->
        <div class="w-full h-8 border-2 border-black p-1">
            <div id="progress-fill" class="h-full bg-[#FF3C00] w-0 transition-all duration-[1500ms] ease-out"></div>
        </div>

        <div class="mt-4 font-mono text-xs space-y-1 opacity-70">
            <p>> Initializing Core Memory...</p>
            <p>> Loading Assets: {{ $groom['nickname'] }} & {{ $bride['nickname'] }}</p>
            <p>> Rendering Love.exe...</p>
        </div>

        <button id="open-invitation-btn"
            class="hidden mt-8 w-full bg-black text-white font-display font-bold text-xl py-3 border-2 border-black hover:bg-[#FF3C00] hover:text-black transition-colors uppercase tracking-wider">
            ENTER EVENT
        </button>
    </div>
</div>

<script>
    document.body.style.overflow = 'hidden';
    window.addEventListener('load', function() {
        const bar = document.getElementById('progress-fill');
        const percent = document.getElementById('loading-percent');
        const btn = document.getElementById('open-invitation-btn');
        const overlay = document.getElementById('loading-overlay');

        // Animasi Loading
        bar.style.width = '100%';
        let count = 0;
        const interval = setInterval(() => {
            count++;
            percent.innerText = count + '%';
            if (count >= 100) clearInterval(interval);
        }, 15);

        setTimeout(() => {
            btn.classList.remove('hidden');
        }, 1600);

        btn.addEventListener('click', function() {
            overlay.style.opacity = '0';
            document.body.style.overflow = 'auto';
            setTimeout(() => {
                overlay.remove();
            }, 500);
            window.dispatchEvent(new CustomEvent('play-music'));
        });
    });
</script>

{{-- CONTENT --}}
<div class="relative bg-white selection:bg-[#FF3C00] selection:text-white">

    {{-- MUSIC PLAYER (CASSETTE / RETRO WIDGET) --}}
    @if (!empty($theme['music_url']))
        <div x-data="youtubePlayer('{{ $theme['music_url'] }}')" x-init="initPlayer()" @play-music.window="playMusic()"
            class="fixed bottom-6 right-6 z-[990] font-mono print:hidden">

            <!-- Toggle Button (Mini Square) -->
            <button x-show="!isOpen" @click="isOpen = true"
                class="w-12 h-12 bg-[#FF3C00] border-2 border-black shadow-[4px_4px_0px_0px_#000] flex items-center justify-center hover:-translate-y-1 transition-transform">
                <i class="fa-solid fa-play text-white animate-pulse"></i>
            </button>

            <!-- Expanded Player (Retro Box) -->
            <div x-show="isOpen" x-transition
                class="w-[260px] bg-white border-2 border-black shadow-[6px_6px_0px_0px_#000] p-3">

                <div class="flex justify-between items-center mb-2 border-b-2 border-black pb-1">
                    <span class="text-xs font-bold bg-black text-white px-1">AUDIO.MP3</span>
                    <button @click="isOpen = false" class="text-xs hover:text-[#FF3C00]">[X]</button>
                </div>

                <!-- Visualizer Placeholder -->
                <div class="h-8 flex items-end gap-[2px] mb-3 opacity-50">
                    <template x-for="i in 20">
                        <div class="w-full bg-black" :style="`height: ${Math.random() * 100}%`"></div>
                    </template>
                </div>

                <!-- Controls -->
                <div class="flex items-center justify-between gap-2">
                    <button @click="togglePlay"
                        class="flex-1 bg-black text-white py-1 text-sm font-bold hover:bg-[#FF3C00]">
                        <span x-text="isPlaying ? 'PAUSE' : 'PLAY'"></span>
                    </button>
                </div>
            </div>
            <div class="hidden">
                <div id="yt-player-container"></div>
            </div>
        </div>
    @endif

    {{-- SECTION 1: HERO (NEWSPAPER / POSTER STYLE) --}}
    <section class="min-h-screen flex flex-col border-b-4 border-black">
        <!-- Top Bar -->
        <div class="flex justify-between items-center px-4 py-3 border-b-4 border-black bg-[#FF3C00]">
            <span class="font-mono font-bold text-white text-xs md:text-sm">VOL. 01 — LOVE EDITION</span>
            <span
                class="font-mono font-bold text-white text-xs md:text-sm">{{ strtoupper($eventDate->translatedFormat('l, d F Y')) }}</span>
        </div>

        <!-- Main Title Area -->
        <div class="flex-1 flex flex-col md:flex-row">
            <!-- Left: Text -->
            <div
                class="w-full md:w-1/2 p-6 md:p-12 flex flex-col justify-center border-b-4 md:border-b-0 md:border-r-4 border-black relative overflow-hidden">
                <!-- Background decorative text -->
                <div
                    class="absolute -left-10 top-0 text-[200px] leading-none font-display font-black text-gray-100 -z-10 select-none">
                    WE<br>DD<br>ING
                </div>

                <div
                    class="bg-white/80 backdrop-blur-sm p-4 border-2 border-black shadow-[8px_8px_0px_0px_#000] mb-8 inline-block w-fit rotate-[-2deg]">
                    <span class="font-mono text-sm tracking-widest uppercase">Official Invitation</span>
                </div>

                <h1 class="text-6xl md:text-8xl font-display font-black uppercase leading-[0.9] tracking-tighter mb-4">
                    {{ $groom['nickname'] }}<br>
                    <span class="text-transparent text-stroke-black neo-text-stroke">&</span><br>
                    {{ $bride['nickname'] }}
                </h1>

                <p class="font-mono text-sm md:text-base max-w-sm border-l-4 border-[#FF3C00] pl-4 mt-4">
                    WE ARE GETTING MARRIED. NO TURNING BACK NOW. YOU ARE INVITED TO WITNESS THE MADNESS.
                </p>

                @if ($guest)
                    <div class="mt-10 p-4 border-2 border-dashed border-black">
                        <p class="font-mono text-xs text-gray-500 uppercase">Special Guest:</p>
                        <h3 class="font-display font-bold text-2xl uppercase glitch-hover cursor-default">
                            {{ $guest->name }}</h3>
                    </div>
                @endif
            </div>

            <!-- Right: Image -->
            <div class="w-full md:w-1/2 relative bg-black group overflow-hidden">
                <img src="{{ $coverImage }}"
                    class="w-full h-full object-cover grayscale group-hover:grayscale-0 transition-all duration-700 opacity-80 group-hover:opacity-100">

                <!-- Sticker overlay -->
                <div
                    class="absolute bottom-10 right-10 bg-white border-2 border-black p-4 rotate-3 shadow-[6px_6px_0px_0px_#FF3C00]">
                    <p class="font-display font-bold text-xl text-center leading-none">SAVE<br>THE<br>DATE</p>
                </div>
            </div>
        </div>

        <!-- Marquee Bottom -->
        <div class="py-3 bg-black text-white border-t-4 border-black marquee-container">
            <div class="marquee-content font-mono font-bold text-lg">
                THE WEDDING OF {{ strtoupper($groom['nickname']) }} AND {{ strtoupper($bride['nickname']) }} +++
                CELEBRATE LOVE +++ DON'T BE LATE +++
                THE WEDDING OF {{ strtoupper($groom['nickname']) }} AND {{ strtoupper($bride['nickname']) }} +++
                CELEBRATE LOVE +++ DON'T BE LATE +++
            </div>
        </div>
    </section>

    {{-- SECTION 2: QUOTE (BOLD TYPOGRAPHY) --}}
    <section class="p-8 md:p-20 bg-[#F0F0F0] border-b-4 border-black flex items-center justify-center">
        <div class="max-w-4xl text-center relative">
            <i class="fa-solid fa-quote-right absolute -top-10 -left-10 text-6xl text-black/10"></i>

            <h2 class="font-display font-bold text-3xl md:text-5xl uppercase leading-tight">
                "{{ $invitation->couple_data['quote'] ?? 'Love is not about staring at each other, but staring together in the same direction.' }}"
            </h2>

            <div
                class="mt-8 inline-block px-4 py-1 bg-[#FF3C00] text-white font-mono text-sm font-bold border-2 border-black shadow-[4px_4px_0px_0px_#000]">
                QS AR-RUM : 21
            </div>
        </div>
    </section>

    {{-- SECTION 3: THE COUPLE (WANTED POSTER / PROFILE CARDS) --}}
    <section class="p-4 md:p-12">
        <div class="text-center mb-12">
            <h2 class="font-display font-black text-5xl md:text-7xl uppercase inline-block border-b-8 border-[#FF3C00]">
                The Suspects
            </h2>
        </div>

        <div class="grid grid-cols-1 md:grid-cols-2 gap-8 max-w-6xl mx-auto">

            <!-- Groom Card -->
            <div class="neo-box p-6 relative group bg-white">
                <div class="absolute top-4 right-4 bg-black text-white text-xs font-mono px-2 py-1">GROOM</div>
                <div class="w-full aspect-square border-2 border-black mb-6 overflow-hidden">
                    <img src="{{ $groomImage }}"
                        class="w-full h-full object-cover grayscale group-hover:grayscale-0 transition duration-500">
                </div>
                <h3 class="font-display font-black text-4xl uppercase mb-2">{{ $groom['fullname'] }}</h3>
                <div class="h-1 w-20 bg-[#FF3C00] mb-4"></div>
                <div class="font-mono text-sm space-y-1">
                    <p class="font-bold">SON OF:</p>
                    <p>Mr. {{ $groom['father'] }}</p>
                    <p>Mrs. {{ $groom['mother'] }}</p>
                </div>
            </div>

            <!-- Bride Card -->
            <div class="neo-box p-6 relative group bg-white md:mt-12"> <!-- Offset for visual interest -->
                <div
                    class="absolute top-4 right-4 bg-[#FF3C00] text-white text-xs font-mono px-2 py-1 border border-black">
                    BRIDE</div>
                <div class="w-full aspect-square border-2 border-black mb-6 overflow-hidden">
                    <img src="{{ $brideImage }}"
                        class="w-full h-full object-cover grayscale group-hover:grayscale-0 transition duration-500">
                </div>
                <h3 class="font-display font-black text-4xl uppercase mb-2">{{ $bride['fullname'] }}</h3>
                <div class="h-1 w-20 bg-black mb-4"></div>
                <div class="font-mono text-sm space-y-1">
                    <p class="font-bold">DAUGHTER OF:</p>
                    <p>Mr. {{ $bride['father'] }}</p>
                    <p>Mrs. {{ $bride['mother'] }}</p>
                </div>
            </div>

        </div>
    </section>

    {{-- SECTION 4: EVENT DETAILS (TICKET / CALENDAR) --}}
    <section class="border-y-4 border-black bg-[#FF3C00] text-white">
        <div class="flex flex-col lg:flex-row">

            <!-- Left: Calendar Visual -->
            <div
                class="w-full lg:w-1/3 p-8 border-b-4 lg:border-b-0 lg:border-r-4 border-black bg-white text-black flex flex-col justify-center items-center">
                <div class="text-center">
                    <p class="font-mono text-xl uppercase tracking-widest mb-2">Save The Date</p>
                    <div class="text-9xl font-display font-black leading-none tracking-tighter">
                        {{ $eventDate->format('d') }}
                    </div>
                    <div class="text-4xl font-display font-bold uppercase border-y-4 border-black py-2 my-2">
                        {{ $eventDate->translatedFormat('F') }}
                    </div>
                    <div
                        class="text-9xl font-display font-black leading-none tracking-tighter text-transparent neo-text-stroke">
                        {{ $eventDate->format('Y') }}
                    </div>
                </div>
            </div>

            <!-- Right: Details -->
            <div class="w-full lg:w-2/3 p-8 md:p-16 flex flex-col justify-center relative overflow-hidden">
                <!-- Abstract Lines -->
                <div class="absolute top-0 right-0 w-64 h-64 border-l-2 border-b-2 border-black opacity-20"></div>

                <h2
                    class="font-display font-bold text-4xl mb-8 uppercase underline decoration-4 decoration-black underline-offset-8">
                    {{ $invitation->event_data[0]['title'] }}
                </h2>

                <div class="grid grid-cols-1 md:grid-cols-2 gap-8 font-mono">
                    <div>
                        <h4 class="font-bold bg-black text-white inline-block px-2 mb-2">TIME</h4>
                        <p class="text-xl font-bold">{{ $eventDate->format('H:i') }} WIB - FINISH</p>
                    </div>
                    <div>
                        <h4 class="font-bold bg-black text-white inline-block px-2 mb-2">LOCATION</h4>
                        <p class="text-lg leading-tight font-bold">{{ $invitation->event_data[0]['location'] }}</p>
                        <p class="text-sm mt-2 opacity-90">{{ $invitation->event_data[0]['address'] }}</p>
                    </div>
                </div>

                <!-- Countdown Blocks -->
                <div x-data="countdown('{{ $eventDate->toIso8601String() }}')" x-init="start()" class="flex flex-wrap gap-4 mt-12">

                    <template x-for="(val, label) in {Days: days, Hours: hours, Mins: minutes, Secs: seconds}">
                        <div class="neo-box bg-white text-black p-3 w-20 md:w-24 text-center">
                            <div class="font-display font-black text-2xl md:text-3xl" x-text="val"></div>
                            <div class="font-mono text-[10px] uppercase border-t-2 border-black mt-1 pt-1"
                                x-text="label"></div>
                        </div>
                    </template>
                </div>

                @if (!empty($invitation->event_data[0]['map_link']))
                    <a href="{{ $invitation->event_data[0]['map_link'] }}" target="_blank"
                        class="mt-10 inline-block bg-black text-white font-display font-bold text-lg px-8 py-4 border-2 border-white hover:bg-white hover:text-black hover:border-black transition-colors w-fit shadow-[6px_6px_0px_0px_rgba(0,0,0,0.5)]">
                        GET DIRECTIONS <i class="fa-solid fa-arrow-right ml-2"></i>
                    </a>
                @endif
            </div>
        </div>
    </section>

    {{-- SECTION 5: GALLERY (CONTACT SHEET / MASONRY) --}}
    @if (!empty($moments))
        <section class="p-4 md:p-12 bg-[#F0F0F0]">
            <div class="flex justify-between items-end mb-8 border-b-4 border-black pb-2">
                <h2 class="font-display font-black text-4xl md:text-6xl uppercase">Evidence</h2>
                <span class="font-mono text-sm hidden md:block">/// GALLERY_FILES_V.1.0</span>
            </div>

            <div class="grid grid-cols-2 md:grid-cols-3 lg:grid-cols-4 gap-4">
                @foreach ($moments as $index => $photo)
                    <div
                        class="relative group border-2 border-black bg-white p-2 shadow-[4px_4px_0px_0px_#000] hover:shadow-[8px_8px_0px_0px_#FF3C00] transition-all duration-300">
                        <div class="aspect-[3/4] overflow-hidden bg-gray-200 border border-black">
                            <img src="{{ asset($photo) }}"
                                class="w-full h-full object-cover grayscale group-hover:grayscale-0 transition-all duration-500 scale-100 group-hover:scale-110">
                        </div>
                        <div
                            class="absolute top-0 left-0 bg-[#FF3C00] text-white text-[10px] font-mono px-1 opacity-0 group-hover:opacity-100 transition">
                            IMG_00{{ $index + 1 }}
                        </div>
                    </div>
                @endforeach
            </div>
        </section>
    @endif

    {{-- SECTION 6: GIFT (BANK TRANSFER FORM) --}}
    @if (!empty($gifts))
        <section class="p-8 md:p-20 border-t-4 border-black">
            <div class="max-w-3xl mx-auto">
                <h2 class="font-display font-black text-center text-4xl mb-2">SEND LOVE</h2>
                <p class="font-mono text-center text-sm mb-10 opacity-70">DIGITAL TRANSFER PROTOCOL</p>

                <div class="grid gap-8">
                    @foreach ($gifts as $gift)
                        <div class="neo-box p-0 bg-white relative overflow-hidden group">
                            <!-- Header Strip -->
                            <div class="h-10 bg-black flex items-center px-4 justify-between text-white">
                                <span class="font-mono font-bold">{{ strtoupper($gift['bank_name']) }}</span>
                                <div class="w-3 h-3 bg-[#FF3C00] rounded-full animate-pulse"></div>
                            </div>

                            <div class="p-8 flex flex-col md:flex-row justify-between items-center gap-6">
                                <div class="text-center md:text-left">
                                    <p class="font-mono text-xs uppercase text-gray-500 mb-1">Account Number</p>
                                    <h3 class="font-display font-black text-3xl md:text-4xl tracking-widest group-hover:text-[#FF3C00] transition-colors cursor-pointer"
                                        onclick="navigator.clipboard.writeText('{{ $gift['account_number'] }}'); alert('COPIED');">
                                        {{ chunk_split($gift['account_number'], 4, ' ') }}
                                    </h3>
                                    <p class="font-mono text-sm font-bold mt-2 uppercase">A/N
                                        {{ $gift['account_name'] }}</p>
                                </div>

                                <button onclick="navigator.clipboard.writeText('{{ $gift['account_number'] }}')"
                                    class="px-6 py-2 border-2 border-black bg-white hover:bg-black hover:text-white font-mono font-bold text-sm uppercase transition-colors shadow-[2px_2px_0px_0px_#000] active:shadow-none active:translate-x-[2px] active:translate-y-[2px]">
                                    Copy
                                </button>
                            </div>

                            <!-- Decorative Barcode -->
                            <div
                                class="h-4 bg-[url('data:image/png;base64,iVBORw0KGgoAAAANSUhEUgAAAAQAAAABCAYAAAD5PA/NAAAAFklEQVR4AWP4z8DAwMTAwMDAxMQAwQAqeQH96/52aAAAAABJRU5ErkJggg==')] w-full opacity-20">
                            </div>
                        </div>
                    @endforeach
                </div>
            </div>
        </section>
    @endif

    {{-- SECTION 7: RSVP & FORM (BRUTALIST INPUTS) --}}
    <section class="bg-[#111] text-white p-8 md:p-20 border-t-4 border-black">
        <div class="max-w-4xl mx-auto">
            <div class="bg-white text-black border-4 border-[#FF3C00] p-6 md:p-10 shadow-[10px_10px_0px_0px_#333]">
                <h2 class="font-display font-black text-3xl mb-6 uppercase border-b-4 border-black inline-block">RSVP
                    HERE</h2>

                <!-- Styling Override for Livewire Component content inside -->
                <div
                    class="font-mono [&_input]:border-2 [&_input]:border-black [&_input]:rounded-none [&_input]:p-3 [&_input]:w-full [&_input]:font-mono [&_input]:bg-gray-50 [&_input]:mb-4
                            [&_textarea]:border-2 [&_textarea]:border-black [&_textarea]:rounded-none [&_textarea]:p-3 [&_textarea]:w-full [&_textarea]:font-mono
                            [&_button]:bg-black [&_button]:text-white [&_button]:font-display [&_button]:font-bold [&_button]:uppercase [&_button]:py-3 [&_button]:px-6 [&_button]:border-2 [&_button]:border-transparent [&_button]:hover:bg-[#FF3C00] [&_button]:hover:border-black [&_button]:transition-colors [&_button]:shadow-[4px_4px_0px_0px_#CCC]
                            [&_label]:font-bold [&_label]:uppercase [&_label]:text-xs [&_label]:mb-1 [&_label]:block">

                    @livewire('frontend.rsvp-form', ['invitation' => $invitation, 'guest' => $guest])
                </div>

                <div class="my-10 border-t-4 border-dotted border-black"></div>

                <h2 class="font-display font-black text-3xl mb-6 uppercase border-b-4 border-black inline-block">WISHES
                </h2>

                <div
                    class="font-mono [&_.card]:border-2 [&_.card]:border-black [&_.card]:mb-4 [&_.card]:p-4 [&_.card]:shadow-[4px_4px_0px_0px_#DDD]">
                    @livewire('frontend.guest-book', ['invitation' => $invitation, 'guest' => $guest])
                </div>
            </div>
        </div>
    </section>

    {{-- FOOTER --}}
    <footer class="bg-white border-t-4 border-black py-12 flex flex-col items-center justify-center text-center">
        <h1 class="font-display font-black text-4xl md:text-6xl mb-4 tracking-tighter">THANK YOU</h1>
        <div class="w-16 h-2 bg-[#FF3C00] mb-6"></div>

        <a href="https://arvayadeaure.com" target="_blank" class="group relative inline-block">
            <div
                class="absolute inset-0 bg-black translate-x-1 translate-y-1 group-hover:translate-x-2 group-hover:translate-y-2 transition-transform">
            </div>
            <div
                class="relative border-2 border-black bg-white px-6 py-2 font-mono font-bold text-sm uppercase group-hover:-translate-y-1 transition-transform">
                Created by Arvaya De Aure
            </div>
        </a>
        <p class="font-mono text-[10px] mt-6 opacity-50">© 2025 ALL RIGHTS RESERVED. NO REFUNDS.</p>
    </footer>

</div>

{{-- COUNTDOWN SCRIPT (REQUIRED) --}}
<script>
    function countdown(eventDate) {
        return {
            eventTime: new Date(eventDate).getTime(),
            now: Date.now(),
            timer: null,
            start() {
                this.timer = setInterval(() => {
                    this.now = Date.now()
                }, 1000)
            },
            get diff() {
                return Math.max(this.eventTime - this.now, 0)
            },
            get days() {
                return Math.floor(this.diff / (1000 * 60 * 60 * 24))
            },
            get hours() {
                return Math.floor((this.diff / (1000 * 60 * 60)) % 24)
            },
            get minutes() {
                return Math.floor((this.diff / (1000 * 60)) % 60)
            },
            get seconds() {
                return Math.floor((this.diff / 1000) % 60)
            }
        }
    }
</script>
