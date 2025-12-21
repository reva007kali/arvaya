@props(['invitation', 'guest'])
@php
    $groom = $invitation->couple_data['groom'] ?? [];
    $bride = $invitation->couple_data['bride'] ?? [];
    $galleryData = $invitation->gallery_data ?? [];
    $defaultCover = 'https://images.unsplash.com/photo-1519741497674-611481863552?ixlib=rb-1.2.1&auto=format&fit=crop&w=1350&q=80';
    $coverImage = $galleryData['cover'] ?? ($galleryData[0] ?? $defaultCover);
    $eventDate = isset($invitation->event_data[0]['date']) ? \Carbon\Carbon::parse($invitation->event_data[0]['date']) : null;
@endphp
@slot('head')
    <title>{{ $groom['nickname'] ?? 'Groom' }} & {{ $bride['nickname'] ?? 'Bride' }} - Galaxy Night</title>
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link href="https://fonts.googleapis.com/css2?family=Exo+2:wght@300;400;700&family=Orbitron:wght@400;700&display=swap" rel="stylesheet">
@endslot
<style>
    :root { --c-bg: #0F172A; --c-text: #E0E7FF; --c-accent: #818CF8; --font-main: 'Exo 2', sans-serif; --font-title: 'Orbitron', sans-serif; }
    body { background-color: var(--c-bg); color: var(--c-text); font-family: var(--font-main); background: radial-gradient(circle at center, #1E1B4B 0%, #0F172A 100%); }
    .font-title { font-family: var(--font-title); }
    .stars { background-image: url('https://www.transparenttextures.com/patterns/stardust.png'); animation: twinkle 5s infinite alternate; }
    @keyframes twinkle { 0% { opacity: 0.5; } 100% { opacity: 1; } }
    .neon-text { text-shadow: 0 0 10px #818CF8, 0 0 20px #818CF8; }
</style>
<div class="min-h-screen relative overflow-hidden stars">
    <section class="h-screen flex flex-col justify-center items-center text-center p-6 relative z-10">
        <div class="mb-8 relative">
            <div class="absolute inset-0 bg-blue-500 blur-[100px] opacity-20 rounded-full"></div>
            <h1 class="font-title text-6xl md:text-8xl neon-text mb-4 relative z-10">{{ $groom['nickname'] }}</h1>
            <span class="text-2xl font-light text-gray-400 relative z-10">&</span>
            <h1 class="font-title text-6xl md:text-8xl neon-text mt-4 relative z-10">{{ $bride['nickname'] }}</h1>
        </div>
        
        @if($eventDate)
            <div class="border border-[#818CF8] px-8 py-2 rounded-full backdrop-blur-md bg-black/30 shadow-[0_0_15px_rgba(129,140,248,0.5)]">
                <p class="font-title text-xl tracking-widest">{{ $eventDate->format('d . m . Y') }}</p>
            </div>
        @endif
        
        @if($guest)
            <div class="mt-16 text-center">
                 <p class="text-[10px] uppercase tracking-[0.3em] text-[#818CF8] mb-2">Transmission For</p>
                 <h3 class="text-2xl font-bold">{{ $guest->name }}</h3>
            </div>
        @endif
    </section>

    <section class="py-24 px-6 relative z-10">
        <div class="max-w-5xl mx-auto grid md:grid-cols-2 gap-16">
            <div class="bg-black/40 p-8 rounded-2xl border border-[#818CF8]/30 backdrop-blur-sm hover:border-[#818CF8] transition duration-500">
                <h2 class="font-title text-3xl mb-2 text-[#818CF8]">{{ $groom['fullname'] }}</h2>
                <p class="text-sm opacity-70">The Groom</p>
            </div>
            <div class="bg-black/40 p-8 rounded-2xl border border-[#818CF8]/30 backdrop-blur-sm hover:border-[#818CF8] transition duration-500">
                <h2 class="font-title text-3xl mb-2 text-[#818CF8]">{{ $bride['fullname'] }}</h2>
                <p class="text-sm opacity-70">The Bride</p>
            </div>
        </div>
    </section>

    @if($invitation->hasFeature('rsvp'))
    <section class="py-24 px-6 relative z-10">
        <div class="max-w-xl mx-auto bg-black/60 p-8 rounded-2xl border border-[#818CF8] shadow-[0_0_30px_rgba(129,140,248,0.2)]">
            <h2 class="text-center font-title text-3xl mb-8 neon-text">Confirm Presence</h2>
            <div class="[&_input]:bg-[#0F172A] [&_input]:border-[#818CF8] [&_input]:text-[#E0E7FF] [&_button]:bg-[#818CF8] [&_button]:text-black [&_button]:font-bold [&_button]:uppercase [&_button]:tracking-widest [&_button]:shadow-[0_0_15px_rgba(129,140,248,0.6)]">
                @livewire('frontend.rsvp-form', ['invitation' => $invitation, 'guest' => $guest])
            </div>
        </div>
    </section>
    @endif
</div>
