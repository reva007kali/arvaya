@props(['invitation', 'guest'])

@php
    $groom = $invitation->couple_data['groom'] ?? [];
    $bride = $invitation->couple_data['bride'] ?? [];
    $galleryData = $invitation->gallery_data ?? [];
    
    // Default Images
    $defaultCover = 'https://images.unsplash.com/photo-1519741497674-611481863552?ixlib=rb-1.2.1&auto=format&fit=crop&w=1350&q=80';
    $defaultProfile = 'https://ui-avatars.com/api/?background=FFFFFF&color=000000&size=200&name=';

    $coverImage = $galleryData['cover'] ?? ($galleryData[0] ?? $defaultCover);
    $groomImage = $galleryData['groom'] ?? $defaultProfile . urlencode($groom['nickname'] ?? 'Groom');
    $brideImage = $galleryData['bride'] ?? $defaultProfile . urlencode($bride['nickname'] ?? 'Bride');
    $eventDate = isset($invitation->event_data[0]['date']) ? \Carbon\Carbon::parse($invitation->event_data[0]['date']) : null;
@endphp

@slot('head')
    <title>{{ $groom['nickname'] ?? 'Groom' }} & {{ $bride['nickname'] ?? 'Bride' }} - Minimalist</title>
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link href="https://fonts.googleapis.com/css2?family=Inter:wght@300;400;600&family=Mrs+Saint+Delafield&display=swap" rel="stylesheet">
@endslot

<style>
    :root {
        --c-bg-main: #FFFFFF;
        --c-bg-card: #F9FAFB;
        --c-text-main: #18181B;
        --c-text-muted: #71717A;
        --c-accent: #000000;
        
        --font-main: 'Inter', sans-serif;
        --font-script: 'Mrs Saint Delafield', cursive;
    }

    body {
        background-color: var(--c-bg-main);
        color: var(--c-text-main);
        font-family: var(--font-main);
        overflow-x: hidden;
    }

    .font-script { font-family: var(--font-script); }
    
    .vertical-line {
        width: 1px;
        height: 60px;
        background-color: #000;
        margin: 0 auto;
    }
</style>

<div class="min-h-screen flex flex-col items-center">
    
    {{-- HERO --}}
    <section class="w-full min-h-screen flex flex-col justify-between items-center py-12 px-6">
        <div class="text-center" data-anim="fade-down">
            <p class="text-xs uppercase tracking-[0.4em] mb-4 text-gray-500">The Wedding Of</p>
        </div>

        <div class="text-center" data-anim="zoom-in">
            <h1 class="font-script text-6xl md:text-8xl mb-4">{{ $groom['nickname'] }}</h1>
            <span class="text-xl font-light text-gray-400">&</span>
            <h1 class="font-script text-6xl md:text-8xl mt-4">{{ $bride['nickname'] }}</h1>
        </div>
        
        <div class="text-center" data-anim="fade-up">
            @if($eventDate)
                <p class="text-sm uppercase tracking-[0.2em] font-light">{{ $eventDate->format('F d, Y') }}</p>
            @endif
            
            @if ($guest)
                <div class="mt-12">
                     <p class="text-[10px] uppercase tracking-widest text-gray-400 mb-2">Guest</p>
                     <p class="text-lg font-medium">{{ $guest->name }}</p>
                </div>
            @endif
            
            <div class="mt-8 vertical-line"></div>
        </div>
    </section>

    {{-- IMAGE BREAK --}}
    <section class="w-full h-[50vh] bg-gray-100 overflow-hidden">
        <img src="{{ $coverImage }}" class="w-full h-full object-cover grayscale opacity-80">
    </section>

    {{-- DETAILS --}}
    <section class="py-24 px-6 max-w-2xl text-center">
        <h2 class="font-script text-5xl mb-12">The Couple</h2>
        
        <div class="grid md:grid-cols-2 gap-12">
            <div>
                <h3 class="text-xl uppercase tracking-widest mb-2">{{ $groom['fullname'] }}</h3>
                <p class="text-xs text-gray-500 leading-relaxed">Son of {{ $groom['father'] }} <br> & {{ $groom['mother'] }}</p>
            </div>
            <div>
                <h3 class="text-xl uppercase tracking-widest mb-2">{{ $bride['fullname'] }}</h3>
                <p class="text-xs text-gray-500 leading-relaxed">Daughter of {{ $bride['father'] }} <br> & {{ $bride['mother'] }}</p>
            </div>
        </div>
    </section>

    {{-- RSVP --}}
    @if($invitation->hasFeature('rsvp'))
    <section class="w-full py-24 bg-gray-50 px-6">
        <div class="max-w-xl mx-auto">
            <h2 class="text-center text-xs uppercase tracking-[0.4em] mb-12 text-gray-400">Confirmation</h2>
            <div class="[&_input]:bg-white [&_input]:border-gray-200 [&_button]:bg-black [&_button]:text-white [&_button]:uppercase [&_button]:tracking-widest [&_button]:text-xs [&_button]:py-4">
                @livewire('frontend.rsvp-form', ['invitation' => $invitation, 'guest' => $guest])
            </div>
        </div>
    </section>
    @endif
    
    <footer class="py-12 text-center text-[10px] uppercase tracking-widest text-gray-400">
        Minimalist Series by Arvaya
    </footer>

</div>
