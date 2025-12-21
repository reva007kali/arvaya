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
    $defaultProfile = 'https://ui-avatars.com/api/?background=f3f4f6&color=333&size=200&name=';

    $coverImage = $galleryData['cover'] ?? ($galleryData[0] ?? $defaultCover);
    $groomImage = $galleryData['groom'] ?? $defaultProfile . urlencode($groom['nickname'] ?? 'Groom');
    $brideImage = $galleryData['bride'] ?? $defaultProfile . urlencode($bride['nickname'] ?? 'Bride');
    $moments = $galleryData['moments'] ?? [];
    if (isset($galleryData[0]) && empty($moments)) {
        $moments = $galleryData;
    }

    // Date Parsing
    $eventDate = isset($invitation->event_data[0]['date']) ? \Carbon\Carbon::parse($invitation->event_data[0]['date']) : null;
@endphp

@slot('head')
<title>{{ $groom['nickname'] ?? 'Groom' }} & {{ $bride['nickname'] ?? 'Bride' }} - The Wedding</title>
<link rel="preconnect" href="https://fonts.googleapis.com">
<link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
<!-- Fonts: Cinzel (Serif), Great Vibes (Script), Lato (Body) -->
<link
    href="https://fonts.googleapis.com/css2?family=Cinzel:wght@400;600;800&family=Great+Vibes&family=Lato:wght@300;400;700&display=swap"
    rel="stylesheet">
@endslot

<style>
    :root {
        /* PREMIUM WHITE PALETTE */
        --c-bg-main: #EFEFEF;
        --c-bg-card: #FFFFFF;
        --c-text-main: #333333;
        --c-text-muted: #666666;
        --c-accent: #8B5CF6;
        /* Purple Accent */
        --c-accent-light: #DDD6FE;

        --font-main: 'Cinzel', serif;
        --font-script: 'Great Vibes', cursive;
        --font-body: 'Lato', sans-serif;
    }

    body {
        background-color: var(--c-bg-main);
        color: var(--c-text-main);
        font-family: var(--font-body);
        overflow-x: hidden;
    }

    /* Floral Texture Background */
    .bg-floral-texture {
        background-color: #EFEFEF;
        background-image: url("data:image/svg+xml,%3Csvg width='60' height='60' viewBox='0 0 60 60' xmlns='http://www.w3.org/2000/svg'%3E%3Cg fill='none' fill-rule='evenodd'%3E%3Cg fill='%23ffffff' fill-opacity='0.4'%3E%3Cpath d='M36 34v-4h-2v4h-4v2h4v4h2v-4h4v-2h-4zm0-30V0h-2v4h-4v2h4v4h2V6h4V4h-4zM6 34v-4H4v4H0v2h4v4h2v-4h4v-2H6zM6 4V0H4v4H0v2h4v4h2V6h4V4H6z'/%3E%3C/g%3E%3C/g%3E%3C/svg%3E");
    }

    .font-main {
        font-family: var(--font-main);
    }

    .font-script {
        font-family: var(--font-script);
    }

    .font-body {
        font-family: var(--font-body);
    }

    /* Vertical Text Utility */
    .writing-vertical {
        writing-mode: vertical-rl;
        text-orientation: mixed;
        transform: rotate(180deg);
    }

    /* Custom Scrollbar */
    ::-webkit-scrollbar {
        width: 6px;
    }

    ::-webkit-scrollbar-track {
        background: #f1f1f1;
    }

    ::-webkit-scrollbar-thumb {
        background: #ccc;
        border-radius: 3px;
    }

    ::-webkit-scrollbar-thumb:hover {
        background: #999;
    }

    /* Floating Animation */
    @keyframes floating {
        0% {
            transform: translateY(0px);
        }

        50% {
            transform: translateY(-5px);
        }

        100% {
            transform: translateY(0px);
        }
    }

    .animate-float {
        animation: floating 3s ease-in-out infinite;
        will-change: transform;
    }

    /* Paper Shadow */
    .paper-shadow {
        box-shadow: 0 10px 20px -5px rgba(0, 0, 0, 0.1);
        transform: translateZ(0);
    }
</style>

{{-- ======================================================================= --}}
{{-- LOADING SCREEN --}}
{{-- ======================================================================= --}}
<div id="loading-overlay"
    class="fixed inset-0 z-[9999] bg-[#EFEFEF] flex flex-col items-center justify-center transition-opacity duration-1000">
    <div class="relative w-24 h-24 mb-6">
        <div class="absolute inset-0 border-t-2 border-b-2 border-gray-300 rounded-full animate-spin"></div>
        <div class="absolute inset-0 flex items-center justify-center text-[#333] font-main font-bold text-xl">
            {{ substr($groom['nickname'] ?? 'G', 0, 1) }}&{{ substr($bride['nickname'] ?? 'B', 0, 1) }}
        </div>
    </div>
    <p class="text-[#666] font-main text-xs tracking-[0.4em] uppercase">Loading Invitation</p>

    <button id="open-invitation-btn"
        class="hidden mt-10 px-8 py-2 bg-[#E0E0E0] text-[#333] rounded-full font-main font-bold uppercase tracking-widest hover:bg-[#D1D1D1] transition shadow-sm text-xs">
        Open
    </button>
</div>

<script>
    document.body.style.overflow = 'hidden';
    window.addEventListener('load', function () {
        const btn = document.getElementById('open-invitation-btn');
        setTimeout(() => {
            btn.classList.remove('hidden');
        }, 1000);

        btn.addEventListener('click', function () {
            document.getElementById('loading-overlay').style.opacity = '0';
            document.body.style.overflow = 'auto';
            setTimeout(() => {
                document.getElementById('loading-overlay').remove();
            }, 1000);
            window.dispatchEvent(new CustomEvent('play-music'));
        });
    });
</script>

<div class="relative bg-floral-texture min-h-screen">

    {{-- MUSIC PLAYER --}}
    @if (!empty($theme['music_url']))
        <div x-data="youtubePlayer('{{ $theme['music_url'] }}')" x-init="initPlayer()" @play-music.window="playMusic()"
            class="fixed bottom-6 right-6 z-[900] print:hidden">
            <button @click="togglePlay"
                class="w-10 h-10 bg-white/90 border border-gray-200 rounded-full flex items-center justify-center text-[#333] hover:bg-white transition-all shadow-md">
                <i class="fa-solid" :class="isPlaying ? 'fa-pause' : 'fa-music'"></i>
            </button>
        </div>
    @endif

    {{-- HERO SECTION --}}
    <section
        class="relative min-h-screen w-full flex flex-col justify-center items-center text-center px-6 overflow-hidden">
        <!-- Corner Floral Decoration (CSS Shapes/Images) -->
        <div
            class="absolute top-0 left-0 w-full h-32 bg-[url('https://www.transparenttextures.com/patterns/flower-trail.png')] opacity-30 pointer-events-none">
        </div>
        <div
            class="absolute bottom-0 left-0 w-full h-32 bg-[url('https://www.transparenttextures.com/patterns/flower-trail.png')] opacity-30 pointer-events-none rotate-180">
        </div>

        <div class="relative z-10 space-y-6" data-anim="fade-up">
            <p class="font-main text-[#666] font-bold tracking-[0.1em] text-sm uppercase">The Wedding of</p>

            <div class="py-4">
                <h1 class="font-script text-6xl md:text-7xl lg:text-8xl text-[#111] leading-tight drop-shadow-sm">
                    {{ $groom['nickname'] }}
                    <span class="block text-4xl my-2">&</span>
                    {{ $bride['nickname'] }}
                </h1>
            </div>

            <!-- Bird Icon -->
            <div class="text-[#9ca3af] text-3xl opacity-50 animate-float">
                <i class="fa-solid fa-dove"></i>
            </div>

            @if($eventDate)
                <div class="mt-8 font-main text-[#333] tracking-widest text-sm">
                    {{ $eventDate->translatedFormat('l, d F Y') }}
                </div>
            @endif

            @if ($guest)
                <div class="mt-12">
                    <p class="text-[#888] text-[10px] uppercase tracking-widest mb-2">Special Guest</p>
                    <div class="inline-block px-6 py-2 border-b border-gray-300">
                        <h3 class="text-[#333] font-main text-lg">{{ $guest->name }}</h3>
                    </div>
                </div>
            @endif
        </div>

        <div class="absolute bottom-12 animate-bounce text-[#999]">
            <i class="fa-solid fa-chevron-down text-xs"></i>
        </div>
    </section>

    {{-- QUOTE SECTION --}}
    @if($invitation->theme_config['quote_enabled'] ?? true)
        <section class="py-20 px-6 relative">
            <div class="max-w-2xl mx-auto text-center">
                @php $qs = $invitation->couple_data['quote_structured'] ?? null; @endphp
                <div class="mb-6 text-[#ccc]">
                    <i class="fa-solid fa-quote-left text-2xl"></i>
                </div>

                @if ($qs && ($qs['type'] ?? '') === 'quran')
                    <p class="font-main text-xl text-[#333] mb-3">{{ $qs['arabic'] ?? '' }}</p>
                    <p class="font-body text-sm text-[#555] italic">{{ $qs['translation'] ?? '' }}</p>
                    <p class="font-main text-xs font-bold text-[#888] mt-4 uppercase tracking-widest">{{ $qs['source'] ?? '' }}
                    </p>
                @elseif ($qs && ($qs['type'] ?? '') === 'bible')
                    <p class="font-body text-base text-[#333] italic mb-2">"{{ $qs['verse_text'] ?? '' }}"</p>
                    @if (!empty($qs['translation']))
                        <p class="font-body text-sm text-[#555]">{{ $qs['translation'] }}</p>
                    @endif
                    <p class="font-main text-xs font-bold text-[#888] mt-4 uppercase tracking-widest">{{ $qs['source'] ?? '' }}
                    </p>
                @else
                    <p class="font-script text-3xl text-[#333] leading-relaxed">
                        "{{ $invitation->couple_data['quote'] ?? 'Two souls, one heart.' }}"
                    </p>
                @endif
            </div>
        </section>
    @endif

    {{-- COUPLE PROFILE --}}
    <section class="py-20 px-4">
        <div class="max-w-4xl mx-auto">
            <div class="flex flex-col gap-24">

                <!-- Groom -->
                <div class="flex flex-col md:flex-row items-center justify-center gap-8 relative" data-anim="fade-up">
                    <!-- Vertical Text -->
                    <div class="hidden md:block absolute -left-12 top-0 h-full">
                        <span
                            class="writing-vertical font-script text-5xl text-[#333] opacity-80 h-full flex items-center">Groom</span>
                    </div>
                    <!-- Mobile Title -->
                    <h2 class="md:hidden font-script text-4xl text-[#333] mb-2">Groom</h2>

                    <!-- Photo -->
                    <div class="relative w-64 h-72">
                        <div class="absolute inset-0 border-[3px] border-[#9333EA] translate-x-3 translate-y-3 z-0">
                        </div>
                        <img src="{{ $groomImage }}"
                            class="relative w-full h-full object-cover grayscale z-10 shadow-lg bg-white" alt="Groom">
                    </div>

                    <!-- Details -->
                    <div class="text-center md:text-left">
                        <h3 class="font-main text-2xl font-bold text-[#333] uppercase tracking-widest mb-4">
                            {{ $groom['fullname'] }}</h3>
                        <div class="text-[#666] font-body text-sm leading-relaxed">
                            <p class="font-bold text-xs uppercase tracking-wide mb-1 text-[#888]">Son of:</p>
                            <p>{{ $groom['father'] }}</p>
                            <p>{{ $groom['mother'] }}</p>
                        </div>
                    </div>
                </div>

                <!-- Bride -->
                <div class="flex flex-col md:flex-row-reverse items-center justify-center gap-8 relative"
                    data-anim="fade-up">
                    <!-- Vertical Text -->
                    <div class="hidden md:block absolute -right-12 top-0 h-full">
                        <span
                            class="writing-vertical font-script text-5xl text-[#333] opacity-80 h-full flex items-center rotate-180">Bride</span>
                    </div>
                    <!-- Mobile Title -->
                    <h2 class="md:hidden font-script text-4xl text-[#333] mb-2">Bride</h2>

                    <!-- Photo -->
                    <div class="relative w-64 h-72">
                        <div class="absolute inset-0 border-[3px] border-[#9333EA] -translate-x-3 translate-y-3 z-0">
                        </div>
                        <img src="{{ $brideImage }}"
                            class="relative w-full h-full object-cover grayscale z-10 shadow-lg bg-white" alt="Bride">
                    </div>

                    <!-- Details -->
                    <div class="text-center md:text-right">
                        <h3 class="font-main text-2xl font-bold text-[#333] uppercase tracking-widest mb-4">
                            {{ $bride['fullname'] }}</h3>
                        <div class="text-[#666] font-body text-sm leading-relaxed">
                            <p class="font-bold text-xs uppercase tracking-wide mb-1 text-[#888]">Daughter of:</p>
                            <p>{{ $bride['father'] }}</p>
                            <p>{{ $bride['mother'] }}</p>
                        </div>
                    </div>
                </div>

            </div>
        </div>
    </section>

    {{-- EVENT DETAILS --}}
    @if($invitation->theme_config['events_enabled'] ?? true)
        <section class="py-20 px-6 bg-white/50">
            <div class="max-w-3xl mx-auto text-center" data-anim="fade-up">
                <h2 class="font-main text-2xl text-[#333] uppercase tracking-[0.2em] mb-12">Save The Date</h2>

                <div class="bg-white p-8 md:p-12 shadow-[0_20px_40px_-15px_rgba(0,0,0,0.1)] relative overflow-hidden">
                    <!-- Top Floral Accent -->
                    <div
                        class="absolute -top-10 -right-10 w-32 h-32 bg-[url('https://www.transparenttextures.com/patterns/flower-trail.png')] opacity-10 rotate-45 pointer-events-none">
                    </div>

                    @if($eventDate)
                        <div class="mb-10">
                            <p class="font-script text-4xl text-[#333] mb-2">The Wedding Day</p>
                            <div class="flex items-center justify-center gap-4 text-[#333] font-main text-xl mt-6">
                                <span class="border-b border-gray-300 pb-1">{{ $eventDate->translatedFormat('l') }}</span>
                                <span class="text-4xl font-bold">{{ $eventDate->format('d') }}</span>
                                <span class="border-b border-gray-300 pb-1">{{ $eventDate->translatedFormat('F') }}</span>
                            </div>
                            <p class="mt-4 text-sm text-[#888] tracking-widest">{{ $eventDate->format('Y') }}</p>
                        </div>

                        <div class="w-12 h-px bg-gray-300 mx-auto my-8"></div>

                        <div class="mb-8">
                            <p class="font-bold text-xs text-[#9333EA] uppercase tracking-widest mb-2">Venue</p>
                            <h3 class="font-main text-lg text-[#333]">
                                {{ $invitation->event_data[0]['location'] ?? 'Location TBA' }}</h3>
                            <p class="text-sm text-[#666] mt-2 max-w-sm mx-auto">
                                {{ $invitation->event_data[0]['address'] ?? '' }}</p>
                        </div>

                        @if (!empty($invitation->event_data[0]['map_link']))
                            <a href="{{ $invitation->event_data[0]['map_link'] }}" target="_blank"
                                class="inline-block px-8 py-3 bg-[#333] text-white text-xs font-bold uppercase tracking-widest hover:bg-black transition shadow-lg">
                                View Location
                            </a>
                        @endif
                    @endif
                </div>

                <!-- Countdown -->
                @if($eventDate)
                    <div x-data="countdown('{{ $eventDate->toIso8601String() }}')" x-init="start()"
                        class="flex justify-center gap-8 mt-12 text-[#333]">
                        <div class="text-center">
                            <span class="block text-2xl font-main font-bold" x-text="days">0</span>
                            <span class="text-[9px] uppercase tracking-widest text-[#888]">Days</span>
                        </div>
                        <div class="text-center">
                            <span class="block text-2xl font-main font-bold" x-text="hours">0</span>
                            <span class="text-[9px] uppercase tracking-widest text-[#888]">Hours</span>
                        </div>
                        <div class="text-center">
                            <span class="block text-2xl font-main font-bold" x-text="minutes">0</span>
                            <span class="text-[9px] uppercase tracking-widest text-[#888]">Mins</span>
                        </div>
                    </div>
                @endif
            </div>
        </section>
    @endif

    {{-- DRESS CODE (New Feature) --}}
    @php
        $dressCode = $invitation->dress_code_data ?? [];
        $isDressCodeEnabled = $invitation->hasFeature('dress_code') && ($dressCode['enabled'] ?? false);
    @endphp
    @if($isDressCodeEnabled)
        <section class="py-20 px-6">
            <div class="max-w-2xl mx-auto text-center" data-anim="fade-up">
                <h2 class="font-main text-2xl text-[#333] uppercase tracking-[0.2em] mb-8">
                    {{ $dressCode['title'] ?? 'Dress Code' }}</h2>

                <div class="bg-white p-8 border border-gray-100 shadow-lg">
                    <p class="font-body text-[#555] mb-8">{{ $dressCode['description'] ?? '' }}</p>

                    @if(!empty($dressCode['colors']))
                        <div class="flex flex-wrap justify-center gap-4 mb-8">
                            @foreach($dressCode['colors'] as $color)
                                <div class="flex flex-col items-center gap-2">
                                    <div class="w-12 h-12 rounded-full shadow-md border-4 border-white"
                                        style="background-color: {{ $color }}"></div>
                                </div>
                            @endforeach
                        </div>
                    @endif

                    @if(!empty($dressCode['image']))
                        <div
                            class="mt-6 p-2 bg-white shadow-md inline-block transform -rotate-2 hover:rotate-0 transition duration-500">
                            <img src="{{ asset($dressCode['image']) }}"
                                class="max-w-[200px] object-cover filter grayscale hover:grayscale-0 transition">
                        </div>
                    @endif

                    @if(!empty($dressCode['notes']))
                        <p class="mt-6 text-xs text-[#888] italic">* {{ $dressCode['notes'] }}</p>
                    @endif
                </div>
            </div>
        </section>
    @endif

    {{-- GALLERY --}}
    @if (!empty($moments) && ($invitation->gallery_data['enabled'] ?? true))
        <section class="py-20 bg-white" x-data="{ photoOpen: false, photoSrc: '' }"
            @keydown.escape.window="photoOpen = false">
            <div class="max-w-7xl mx-auto px-4">
                <h2 class="font-main text-2xl text-center text-[#333] mb-12 uppercase tracking-widest">Captured Moments</h2>
                <div class="grid grid-cols-2 md:grid-cols-3 lg:grid-cols-4 gap-4">
                    @foreach ($moments as $photo)
                        <div class="aspect-[3/4] overflow-hidden cursor-pointer group"
                            @click="photoOpen = true; photoSrc = '{{ asset($photo) }}'">
                            <img src="{{ asset($photo) }}"
                                class="w-full h-full object-cover grayscale group-hover:grayscale-0 transition-transform duration-300 hover:scale-105"
                                style="will-change: transform, filter;"
                                loading="lazy" alt="Moment">
                        </div>
                    @endforeach
                </div>
            </div>

            <!-- Modal -->
            <div x-show="photoOpen" x-transition.opacity
                class="fixed inset-0 z-[9999] flex items-center justify-center p-4">
                <div class="absolute inset-0 bg-white/90 backdrop-blur-sm" @click="photoOpen = false"></div>
                <div class="relative max-w-4xl w-full max-h-[90vh]">
                    <button @click="photoOpen = false"
                        class="absolute -top-10 right-0 text-[#333] text-2xl hover:text-black">
                        <i class="fa-solid fa-xmark"></i>
                    </button>
                    <img :src="photoSrc" class="w-full h-full object-contain shadow-2xl">
                </div>
            </div>
        </section>
    @endif

    {{-- RSVP & GIFTS (Paper Card Style) --}}
    @php
        $hasRsvp = $invitation->hasFeature('rsvp') && ($invitation->theme_config['rsvp_enabled'] ?? true);
        $hasGifts = $invitation->theme_config['gifts_enabled'] ?? true;
    @endphp

    @if($hasRsvp || $hasGifts)
        <section class="py-24 px-4 bg-floral-texture overflow-hidden relative">
            <!-- Floating Elements -->
            <div class="absolute top-20 left-10 text-6xl text-gray-200 rotate-12 z-0">
                <i class="fa-solid fa-envelope-open"></i>
            </div>

            <div class="max-w-2xl mx-auto relative z-10">

                {{-- RSVP CARD --}}
                @if($hasRsvp)
                    <div class="bg-[#F5F5F5] p-2 md:p-12 paper-shadow transform mb-16 relative" data-anim="fade-up">
                        <!-- Paper texture overlay -->
                        <div
                            class="absolute inset-0 opacity-50 bg-[url('https://www.transparenttextures.com/patterns/paper.png')] pointer-events-none">
                        </div>

                        <h2 class="font-main text-2xl text-center text-[#333] mb-8 uppercase tracking-[0.2em]">RSVP Form</h2>

                        <!-- Custom Form Styling -->
                        <div
                            class="relative z-10 font-body text-[#333]
                            [&_input]:bg-white [&_input]:border-b-2 [&_input]:border-gray-200 [&_input]:text-[#333] [&_input]:w-full [&_input]:px-3 [&_input]:py-2 [&_input]:mb-6 [&_input]:focus:border-[#333] [&_input]:outline-none [&_input]:transition
                            [&_select]:bg-white [&_select]:border-b-2 [&_select]:border-gray-200 [&_select]:text-[#333] [&_select]:w-full [&_select]:px-3 [&_select]:py-2 [&_select]:mb-6 [&_select]:focus:border-[#333] [&_select]:outline-none
                            [&_textarea]:bg-white [&_textarea]:border-b-2 [&_textarea]:border-gray-200 [&_textarea]:text-[#333] [&_textarea]:w-full [&_textarea]:px-3 [&_textarea]:py-2 [&_textarea]:mb-6 [&_textarea]:focus:border-[#333] [&_textarea]:outline-none
                            [&_label]:text-[#888] [&_label]:text-[10px] [&_label]:uppercase [&_label]:tracking-widest
                            [&_button]:w-full [&_button]:py-3 [&_button]:bg-[#E0E0E0] [&_button]:text-[#333] [&_button]:font-bold [&_button]:uppercase [&_button]:tracking-widest [&_button]:rounded-full [&_button]:shadow-sm [&_button]:hover:bg-[#d5d5d5] [&_button]:transition">

                            @livewire('frontend.rsvp-form', ['invitation' => $invitation, 'guest' => $guest])
                        </div>
                    </div>
                @endif

                {{-- GIFT SECTION --}}
                @if(!empty($gifts) && $hasGifts)
                    <div class="text-center" data-anim="fade-up">
                        <h2 class="font-main text-2xl text-[#333] uppercase tracking-[0.2em] mb-8">Wedding Gift</h2>

                        <!-- Illustration (2 Cards) -->
                        <div class="flex justify-center items-center mb-8 relative h-32">
                            <!-- Card 1 -->
                            <div
                                class="absolute w-24 h-36 border-2 border-[#333] bg-white rounded-lg transform -rotate-12 -translate-x-6 flex items-center justify-center shadow-sm">
                                <span class="font-main text-xs font-bold text-[#333]">Other<br>Gift</span>
                            </div>
                            <!-- Card 2 -->
                            <div
                                class="absolute w-24 h-36 border-2 border-[#333] bg-white rounded-lg transform rotate-6 translate-x-4 flex items-center justify-center shadow-md z-10">
                                <span class="font-main text-xs font-bold text-[#333]">Card<br>Now</span>
                            </div>
                        </div>

                        <div class="flex flex-col items-center gap-6">
                            @foreach ($gifts as $gift)
                                <div class="bg-transparent text-center">
                                    <p class="font-bold text-[#333] uppercase tracking-widest text-sm mb-1">{{ $gift['bank_name'] }}
                                    </p>
                                    <p class="font-main text-lg text-[#333] mb-1">{{ $gift['account_name'] }}</p>
                                    <div class="flex items-center justify-center gap-2">
                                        <span class="font-mono text-[#555] tracking-widest">{{ $gift['account_number'] }}</span>
                                        <button
                                            onclick="navigator.clipboard.writeText('{{ $gift['account_number'] }}'); alert('Copied!')"
                                            class="text-xs text-[#9333EA] hover:underline">
                                            <i class="fa-regular fa-copy"></i>
                                        </button>
                                    </div>
                                </div>
                            @endforeach

                            @if (!empty($theme['gift_address']))
                                <button onclick="alert('{{ $theme['gift_address'] }}')"
                                    class="mt-4 px-6 py-2 bg-[#F5F5F5] rounded-full text-xs font-bold text-[#555] hover:bg-[#E0E0E0] transition shadow-sm">
                                    Other Gift / Address
                                </button>
                            @endif
                        </div>
                    </div>
                @endif

            </div>
        </section>
    @endif

    @if($invitation->hasFeature('guestbook') && ($invitation->theme_config['guest_book_enabled'] ?? true))
        <section class="py-20 px-6 bg-white">
            <div class="max-w-2xl mx-auto text-center">
                <h2 class="font-script text-4xl text-[#333] mb-8">Wishes & Prayers</h2>
                <div class="bg-[#F9FAFB] p-6 rounded-xl border border-gray-100 shadow-inner max-h-[500px] overflow-y-auto">
                    @livewire('frontend.guest-book', ['invitation' => $invitation, 'guest' => $guest])
                </div>
            </div>
        </section>
    @endif

    {{-- THANK YOU --}}
    <section class="py-24 bg-floral-texture text-center px-6">
        <h2 class="font-main text-xl text-[#333] uppercase tracking-[0.2em] mb-4">Thank You</h2>
        
        <p class="font-body text-sm text-[#666] mb-8 max-w-lg mx-auto italic">
            {{ $invitation->theme_config['thank_you_message'] ?? 'Thank you for your prayers and blessings.' }}
        </p>

        <p class="font-script text-3xl text-[#666] mb-8">{{ $groom['nickname'] }} & {{ $bride['nickname'] }}</p>
        <p class="text-xs text-[#999] tracking-widest uppercase">Arvaya De Aure Premium Template</p>
    </section>

</div>

{{-- SCRIPTS --}}
<script>
    function countdown(eventDate) {
        return {
            eventTime: new Date(eventDate).getTime(),
            now: Date.now(),
            start() {
                setInterval(() => {
                    this.now = Date.now()
                }, 1000)
            },
            get diff() { return Math.max(this.eventTime - this.now, 0) },
            get days() { return Math.floor(this.diff / (1000 * 60 * 60 * 24)) },
            get hours() { return Math.floor((this.diff / (1000 * 60 * 60)) % 24) },
            get minutes() { return Math.floor((this.diff / (1000 * 60)) % 60) },
            get seconds() { return Math.floor((this.diff / 1000) % 60) }
        }
    }
</script>