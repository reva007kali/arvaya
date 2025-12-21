@props(['invitation', 'guest'])

@php
    $groom = $invitation->couple_data['groom'] ?? [];
    $bride = $invitation->couple_data['bride'] ?? [];
    $galleryData = $invitation->gallery_data ?? [];
    
    // Default Images
    $defaultCover = 'https://images.unsplash.com/photo-1519741497674-611481863552?ixlib=rb-1.2.1&auto=format&fit=crop&w=1350&q=80';
    $defaultProfile = 'https://ui-avatars.com/api/?background=ECFCCB&color=166534&size=200&name=';

    $coverImage = $galleryData['cover'] ?? ($galleryData[0] ?? $defaultCover);
    $groomImage = $galleryData['groom'] ?? $defaultProfile . urlencode($groom['nickname'] ?? 'Groom');
    $brideImage = $galleryData['bride'] ?? $defaultProfile . urlencode($bride['nickname'] ?? 'Bride');
    $eventDate = isset($invitation->event_data[0]['date']) ? \Carbon\Carbon::parse($invitation->event_data[0]['date']) : null;
@endphp

@slot('head')
    <title>{{ $groom['nickname'] ?? 'Groom' }} & {{ $bride['nickname'] ?? 'Bride' }} - Botanical Garden</title>
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link href="https://fonts.googleapis.com/css2?family=Merriweather:ital,wght@0,300;0,700;1,300&family=Dancing+Script:wght@400;700&family=Nunito:wght@300;400;600&display=swap" rel="stylesheet">
@endslot

<style>
    :root {
        --c-bg-main: #F0FDF4;
        --c-bg-card: #FFFFFF;
        --c-text-main: #14532D; /* Dark Green */
        --c-text-muted: #15803D;
        --c-accent: #86EFAC;
        
        --font-main: 'Merriweather', serif;
        --font-script: 'Dancing Script', cursive;
        --font-body: 'Nunito', sans-serif;
    }

    body {
        background-color: var(--c-bg-main);
        color: var(--c-text-main);
        font-family: var(--font-body);
        overflow-x: hidden;
    }

    .bg-leaf-texture {
        background-color: #F0FDF4;
        background-image: url("data:image/svg+xml,%3Csvg width='20' height='20' viewBox='0 0 20 20' xmlns='http://www.w3.org/2000/svg'%3E%3Cpath d='M1 1h2v2H1V1zm4 4h2v2H5V5zm4 4h2v2H9V9zm4 4h2v2h-2v-2zm4 4h2v2h-2v-2z' fill='%2315803D' fill-opacity='0.05' fill-rule='evenodd'/%3E%3C/svg%3E");
    }

    .font-main { font-family: var(--font-main); }
    .font-script { font-family: var(--font-script); }
    .text-green-800 { color: #166534; }
    
    .leaf-border {
        border: 1px solid #86EFAC;
        border-radius: 50% 50% 0 50%;
    }
</style>

<div class="relative bg-leaf-texture min-h-screen">
    
    {{-- HERO --}}
    <section class="min-h-screen flex flex-col justify-center items-center text-center px-6 relative overflow-hidden">
        <!-- Leaves Decoration (CSS) -->
        <div class="absolute -top-10 -left-10 w-40 h-40 bg-[#BBF7D0] rounded-full mix-blend-multiply filter blur-xl opacity-70 animate-blob"></div>
        <div class="absolute -bottom-10 -right-10 w-40 h-40 bg-[#86EFAC] rounded-full mix-blend-multiply filter blur-xl opacity-70 animate-blob animation-delay-2000"></div>

        <div class="z-10 bg-white/60 backdrop-blur-sm p-12 rounded-[50px] shadow-sm border border-green-100" data-anim="zoom-in">
            <p class="font-main text-xs tracking-widest uppercase mb-4 text-green-800">We Are Getting Married</p>
            <h1 class="font-script text-6xl md:text-8xl text-[#14532D] mb-2">
                {{ $groom['nickname'] }} <br> <span class="text-3xl text-[#15803D]">&</span> <br> {{ $bride['nickname'] }}
            </h1>
            
            @if($eventDate)
                <div class="mt-6 font-main font-bold text-[#14532D]">
                    {{ $eventDate->translatedFormat('d . m . Y') }}
                </div>
            @endif

            @if ($guest)
                <div class="mt-8 pt-6 border-t border-green-200">
                    <p class="text-[10px] uppercase tracking-widest text-[#15803D] mb-1">To:</p>
                    <h3 class="font-main text-xl font-bold">{{ $guest->name }}</h3>
                </div>
            @endif
        </div>
    </section>

    {{-- COUPLE --}}
    <section class="py-20 px-4">
        <div class="max-w-4xl mx-auto flex flex-col md:flex-row gap-12 justify-center items-center">
            <!-- Groom -->
            <div class="text-center group" data-anim="fade-up">
                <div class="w-48 h-48 mx-auto mb-4 overflow-hidden leaf-border shadow-lg transform group-hover:scale-105 transition duration-500">
                    <img src="{{ $groomImage }}" class="w-full h-full object-cover">
                </div>
                <h2 class="font-script text-3xl text-green-800">{{ $groom['fullname'] }}</h2>
            </div>

            <div class="text-2xl text-[#86EFAC] font-script">&</div>

            <!-- Bride -->
            <div class="text-center group" data-anim="fade-up">
                 <div class="w-48 h-48 mx-auto mb-4 overflow-hidden leaf-border shadow-lg transform scale-x-[-1] group-hover:scale-x-[-1] group-hover:scale-105 transition duration-500">
                    <img src="{{ $brideImage }}" class="w-full h-full object-cover transform scale-x-[-1]">
                </div>
                <h2 class="font-script text-3xl text-green-800">{{ $bride['fullname'] }}</h2>
            </div>
        </div>
    </section>

    {{-- COUNTDOWN --}}
    @if($eventDate)
    <section class="py-20 bg-[#ECFCCB]/30">
        <div class="max-w-3xl mx-auto text-center" x-data="countdown('{{ $eventDate->toIso8601String() }}')" x-init="start()">
             <h2 class="font-main text-2xl text-green-800 mb-8">Counting Down the Days</h2>
             <div class="flex justify-center gap-4 md:gap-8 font-main text-[#14532D]">
                 <div class="bg-white p-4 rounded-xl shadow-sm min-w-[80px]">
                     <span class="block text-3xl font-bold" x-text="days">0</span>
                     <span class="text-xs">Days</span>
                 </div>
                 <div class="bg-white p-4 rounded-xl shadow-sm min-w-[80px]">
                     <span class="block text-3xl font-bold" x-text="hours">0</span>
                     <span class="text-xs">Hours</span>
                 </div>
                 <div class="bg-white p-4 rounded-xl shadow-sm min-w-[80px]">
                     <span class="block text-3xl font-bold" x-text="minutes">0</span>
                     <span class="text-xs">Mins</span>
                 </div>
             </div>
        </div>
    </section>
    @endif

    {{-- RSVP --}}
    @if($invitation->hasFeature('rsvp'))
    <section class="py-20 px-6">
        <div class="max-w-xl mx-auto bg-white p-8 rounded-2xl shadow-lg border-t-4 border-[#86EFAC]" data-anim="fade-up">
            <h2 class="font-script text-4xl text-center text-green-800 mb-8">R.S.V.P</h2>
             <div class="[&_input]:bg-[#F0FDF4] [&_input]:border-green-100 [&_input]:text-green-800 [&_button]:bg-[#15803D] [&_button]:text-white [&_button]:rounded-xl">
                @livewire('frontend.rsvp-form', ['invitation' => $invitation, 'guest' => $guest])
            </div>
        </div>
    </section>
    @endif

</div>

<script>
    function countdown(date) {
        return {
            target: new Date(date).getTime(),
            now: new Date().getTime(),
            days: 0, hours: 0, minutes: 0, seconds: 0,
            start() {
                setInterval(() => {
                    this.now = new Date().getTime();
                    const d = this.target - this.now;
                    if(d > 0) {
                        this.days = Math.floor(d / (1000 * 60 * 60 * 24));
                        this.hours = Math.floor((d % (1000 * 60 * 60 * 24)) / (1000 * 60 * 60));
                        this.minutes = Math.floor((d % (1000 * 60 * 60)) / (1000 * 60));
                        this.seconds = Math.floor((d % (1000 * 60)) / 1000);
                    }
                }, 1000);
            }
        }
    }
</script>
