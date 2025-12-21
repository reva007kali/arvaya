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
    <title>{{ $groom['nickname'] ?? 'Groom' }} & {{ $bride['nickname'] ?? 'Bride' }} - Vintage Classic</title>
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link href="https://fonts.googleapis.com/css2?family=Courier+Prime:ital,wght@0,400;0,700;1,400&family=Charm:wght@400;700&display=swap" rel="stylesheet">
@endslot
<style>
    :root { --c-bg: #F5F5DC; --c-text: #3E2723; --c-accent: #5D4037; --font-main: 'Courier Prime', monospace; --font-script: 'Charm', cursive; }
    body { background-color: var(--c-bg); color: var(--c-text); font-family: var(--font-main); background-image: url('https://www.transparenttextures.com/patterns/old-map.png'); }
    .font-script { font-family: var(--font-script); }
    .paper-frame { border: 8px double #5D4037; padding: 20px; background: rgba(255,255,255,0.4); }
</style>
<div class="min-h-screen py-12 px-4 border-[16px] border-[#3E2723] m-2">
    <section class="min-h-[80vh] flex flex-col justify-center items-center text-center paper-frame relative mb-12">
        <div class="absolute top-4 left-4 w-4 h-4 bg-[#3E2723] rounded-full"></div>
        <div class="absolute top-4 right-4 w-4 h-4 bg-[#3E2723] rounded-full"></div>
        <div class="absolute bottom-4 left-4 w-4 h-4 bg-[#3E2723] rounded-full"></div>
        <div class="absolute bottom-4 right-4 w-4 h-4 bg-[#3E2723] rounded-full"></div>
        <p class="uppercase tracking-widest text-sm mb-6 border-b border-black pb-1">Wedding Announcement</p>
        <h1 class="font-script text-6xl md:text-8xl mb-6">{{ $groom['nickname'] }} <span class="text-4xl">&</span> {{ $bride['nickname'] }}</h1>
        @if($eventDate) <p class="text-lg font-bold">EST. {{ $eventDate->format('Y') }}</p> <p class="mt-2">{{ $eventDate->format('F d, l') }}</p> @endif
        @if($guest) <div class="mt-12 bg-white p-4 border border-black transform -rotate-2"><p class="text-xs uppercase">Special Delivery For:</p><h3 class="text-xl font-bold">{{ $guest->name }}</h3></div> @endif
    </section>
    <section class="max-w-4xl mx-auto grid md:grid-cols-2 gap-12 text-center">
        <div><h2 class="font-script text-4xl mb-2">{{ $groom['fullname'] }}</h2><p class="text-xs uppercase border-t border-black inline-block pt-1">The Groom</p></div>
        <div><h2 class="font-script text-4xl mb-2">{{ $bride['fullname'] }}</h2><p class="text-xs uppercase border-t border-black inline-block pt-1">The Bride</p></div>
    </section>
    @if($invitation->hasFeature('rsvp'))
    <section class="max-w-xl mx-auto mt-24 paper-frame">
        <h2 class="text-center font-bold text-2xl uppercase mb-8 decoration-wavy underline">R.S.V.P</h2>
        <div class="[&_input]:bg-transparent [&_input]:border-b-2 [&_input]:border-[#3E2723] [&_button]:bg-[#3E2723] [&_button]:text-[#F5F5DC] [&_button]:uppercase [&_button]:font-bold">
             @livewire('frontend.rsvp-form', ['invitation' => $invitation, 'guest' => $guest])
        </div>
    </section>
    @endif
</div>
