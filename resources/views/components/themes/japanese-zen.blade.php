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
    <title>{{ $groom['nickname'] ?? 'Groom' }} & {{ $bride['nickname'] ?? 'Bride' }} - Japanese Zen</title>
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link href="https://fonts.googleapis.com/css2?family=Noto+Serif+JP:wght@300;400;700&family=Zen+Antique&display=swap" rel="stylesheet">
@endslot
<style>
    :root { --c-bg: #FFF1F2; --c-text: #881337; --c-accent: #BE185D; --font-main: 'Zen Antique', serif; --font-body: 'Noto Serif JP', serif; }
    body { background-color: var(--c-bg); color: var(--c-text); font-family: var(--font-body); }
    .font-title { font-family: var(--font-main); }
    .vertical-jp { writing-mode: vertical-rl; text-orientation: upright; letter-spacing: 0.3em; }
    .sakura-bg { background-image: radial-gradient(#FECDD3 2px, transparent 2px); background-size: 30px 30px; }
</style>
<div class="min-h-screen sakura-bg">
    <section class="h-screen flex items-center justify-center relative overflow-hidden">
        <div class="absolute top-0 right-0 w-32 h-screen border-l border-[#FECDD3] flex items-center justify-center">
             <h1 class="vertical-jp text-4xl font-title text-[#9F1239] opacity-80">{{ $groom['nickname'] }} <span class="my-4 text-sm">TO</span> {{ $bride['nickname'] }}</h1>
        </div>
        <div class="text-left z-10 p-8 bg-white/60 backdrop-blur-sm rounded-lg shadow-sm border border-red-100 mr-24" data-anim="fade-up">
            <p class="text-sm tracking-widest mb-4 text-[#BE185D]">THE WEDDING</p>
            @if($eventDate)
                <div class="text-6xl font-title font-bold text-[#881337] mb-2">{{ $eventDate->format('d') }}</div>
                <div class="text-xl text-[#9F1239] mb-6">{{ $eventDate->format('F Y') }}</div>
            @endif
            @if($guest)
                <div class="border-t border-[#FECDD3] pt-4 mt-4">
                    <p class="text-xs text-[#BE185D]">GUEST</p>
                    <p class="text-lg font-bold">{{ $guest->name }}</p>
                </div>
            @endif
        </div>
        <div class="absolute bottom-10 left-10 w-20 h-20 bg-[#F43F5E] rounded-full opacity-10"></div>
    </section>
    <section class="py-24 px-8 max-w-4xl mx-auto grid md:grid-cols-2 gap-12">
        <div class="text-center md:text-right border-r border-[#FECDD3] pr-8">
            <h2 class="text-3xl font-title mb-2">{{ $groom['fullname'] }}</h2>
            <p class="text-xs text-[#BE185D]">GROOM</p>
        </div>
        <div class="text-center md:text-left pl-8">
            <h2 class="text-3xl font-title mb-2">{{ $bride['fullname'] }}</h2>
            <p class="text-xs text-[#BE185D]">BRIDE</p>
        </div>
    </section>
    @if($invitation->hasFeature('rsvp'))
    <section class="py-24 bg-white px-6 border-y border-[#FECDD3]">
        <div class="max-w-xl mx-auto">
            <h2 class="text-center text-2xl font-title mb-12 tracking-widest">RSVP</h2>
            <div class="[&_input]:bg-[#FFF1F2] [&_input]:border-none [&_button]:bg-[#881337] [&_button]:text-white [&_button]:px-8">
                @livewire('frontend.rsvp-form', ['invitation' => $invitation, 'guest' => $guest])
            </div>
        </div>
    </section>
    @endif
</div>
