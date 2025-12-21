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
    <title>{{ $groom['nickname'] ?? 'Groom' }} & {{ $bride['nickname'] ?? 'Bride' }} - Dark Romance</title>
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link href="https://fonts.googleapis.com/css2?family=Cinzel:wght@400;700&family=Rouge+Script&display=swap" rel="stylesheet">
@endslot
<style>
    :root { --c-bg: #1F0404; --c-text: #FECACA; --c-accent: #7F1D1D; --font-main: 'Cinzel', serif; --font-script: 'Rouge Script', cursive; }
    body { background-color: var(--c-bg); color: var(--c-text); font-family: var(--font-main); }
    .font-script { font-family: var(--font-script); }
    .rose-gradient { background: linear-gradient(to bottom, #00000000, #1F0404); }
</style>
<div class="min-h-screen relative overflow-hidden">
    <div class="absolute inset-0 bg-[url('https://www.transparenttextures.com/patterns/dark-matter.png')] opacity-20"></div>
    <section class="h-screen flex flex-col justify-center items-center text-center px-4 relative">
        <div class="absolute inset-0 bg-cover bg-center opacity-30" style="background-image: url('{{ $coverImage }}')"></div>
        <div class="absolute inset-0 rose-gradient"></div>
        <div class="z-10 relative" data-anim="fade-up">
            <h1 class="font-script text-7xl md:text-9xl text-red-200 drop-shadow-lg mb-4">{{ $groom['nickname'] }} <br> & <br> {{ $bride['nickname'] }}</h1>
            @if($eventDate) <p class="text-xl tracking-[0.3em] text-red-100 uppercase border-y border-red-900 py-2 inline-block">{{ $eventDate->format('d . m . Y') }}</p> @endif
        </div>
    </section>
    <section class="py-24 px-6 text-center">
        <h2 class="text-3xl text-red-300 mb-12 uppercase tracking-widest border-b border-red-900 inline-block pb-2">The Couple</h2>
        <div class="flex flex-col md:flex-row justify-center gap-12 text-red-100">
            <div><h3 class="text-2xl mb-2">{{ $groom['fullname'] }}</h3><p class="text-xs text-red-400">The Groom</p></div>
            <div><h3 class="text-2xl mb-2">{{ $bride['fullname'] }}</h3><p class="text-xs text-red-400">The Bride</p></div>
        </div>
    </section>
    @if($invitation->hasFeature('rsvp'))
    <section class="py-24 px-6 bg-[#2a0505]">
        <div class="max-w-xl mx-auto border border-red-900 p-8 rounded shadow-[0_0_50px_rgba(127,29,29,0.3)]">
            <h2 class="text-center font-script text-5xl mb-8 text-red-200">Rsvp</h2>
            <div class="[&_input]:bg-[#1F0404] [&_input]:border-red-900 [&_input]:text-red-100 [&_button]:bg-red-900 [&_button]:text-white">
                @livewire('frontend.rsvp-form', ['invitation' => $invitation, 'guest' => $guest])
            </div>
        </div>
    </section>
    @endif
</div>
