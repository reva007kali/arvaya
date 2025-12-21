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
    <title>{{ $groom['nickname'] ?? 'Groom' }} & {{ $bride['nickname'] ?? 'Bride' }} - Islamic Elegant</title>
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link href="https://fonts.googleapis.com/css2?family=Amiri:ital,wght@0,400;0,700;1,400&family=Lateef&display=swap" rel="stylesheet">
@endslot
<style>
    :root { --c-bg: #F0F9FF; --c-text: #0C4A6E; --c-accent: #D4AF37; --font-main: 'Amiri', serif; --font-script: 'Lateef', cursive; }
    body { background-color: var(--c-bg); color: var(--c-text); font-family: var(--font-main); }
    .font-script { font-family: var(--font-script); }
    .islamic-pattern { background-image: radial-gradient(#D4AF37 1px, transparent 1px); background-size: 20px 20px; }
    .border-ornament { border: 2px solid #D4AF37; padding: 10px; position: relative; }
    .border-ornament::before { content: '❖'; position: absolute; top: -14px; left: 50%; transform: translateX(-50%); background: #F0F9FF; padding: 0 10px; color: #D4AF37; }
</style>
<div class="min-h-screen islamic-pattern">
    <section class="min-h-screen flex flex-col items-center justify-center text-center p-6">
        <div class="bg-white p-8 md:p-16 shadow-2xl rounded-lg border-ornament max-w-2xl w-full" data-anim="zoom-in">
             <p class="text-[#D4AF37] text-xl mb-4">بِسْمِ اللَّهِ الرَّحْمَنِ الرَّحِيم</p>
             <p class="uppercase tracking-widest text-sm mb-8">The Wedding Of</p>
             <h1 class="text-5xl md:text-7xl font-bold text-[#0C4A6E] mb-4">{{ $groom['nickname'] }}</h1>
             <span class="text-4xl text-[#D4AF37]">&</span>
             <h1 class="text-5xl md:text-7xl font-bold text-[#0C4A6E] mt-4">{{ $bride['nickname'] }}</h1>
             
             @if($eventDate)
                 <div class="mt-8 pt-8 border-t border-[#D4AF37]/30">
                     <p class="text-lg font-bold">{{ $eventDate->translatedFormat('l, d F Y') }}</p>
                 </div>
             @endif
             @if($guest)
                 <div class="mt-8 bg-[#F0F9FF] p-4 rounded border border-[#D4AF37]">
                     <p class="text-xs text-[#D4AF37] uppercase">Kepada Yth,</p>
                     <h3 class="text-xl font-bold">{{ $guest->name }}</h3>
                 </div>
             @endif
        </div>
    </section>
    <section class="py-20 px-6">
        <div class="max-w-4xl mx-auto grid md:grid-cols-2 gap-8 text-center">
            <div class="bg-white p-8 rounded-lg shadow-md border-t-4 border-[#D4AF37]">
                <h2 class="text-3xl font-bold mb-2">{{ $groom['fullname'] }}</h2>
                <p class="text-sm text-gray-600">Putra dari {{ $groom['father'] }} & {{ $groom['mother'] }}</p>
            </div>
            <div class="bg-white p-8 rounded-lg shadow-md border-t-4 border-[#D4AF37]">
                <h2 class="text-3xl font-bold mb-2">{{ $bride['fullname'] }}</h2>
                <p class="text-sm text-gray-600">Putri dari {{ $bride['father'] }} & {{ $bride['mother'] }}</p>
            </div>
        </div>
    </section>
    @if($invitation->hasFeature('rsvp'))
    <section class="py-20 px-6">
        <div class="max-w-xl mx-auto bg-white p-8 rounded-lg shadow-xl border border-[#D4AF37]">
            <h2 class="text-center text-3xl font-bold mb-8 text-[#0C4A6E]">Konfirmasi Kehadiran</h2>
            <div class="[&_input]:bg-[#F0F9FF] [&_input]:border-[#D4AF37] [&_button]:bg-[#0C4A6E] [&_button]:text-white">
                @livewire('frontend.rsvp-form', ['invitation' => $invitation, 'guest' => $guest])
            </div>
        </div>
    </section>
    @endif
</div>
