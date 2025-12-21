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
    <title>{{ $groom['nickname'] ?? 'Groom' }} & {{ $bride['nickname'] ?? 'Bride' }} - Bohemian Dream</title>
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link href="https://fonts.googleapis.com/css2?family=Josefin+Sans:wght@300;400;600&family=Sacramento&display=swap" rel="stylesheet">
@endslot
<style>
    :root { --c-bg: #FFF7ED; --c-text: #9A3412; --c-accent: #C2410C; --font-main: 'Josefin Sans', sans-serif; --font-script: 'Sacramento', cursive; }
    body { background-color: var(--c-bg); color: var(--c-text); font-family: var(--font-main); }
    .font-script { font-family: var(--font-script); }
    .arch-shape { border-radius: 200px 200px 0 0; }
</style>
<div class="min-h-screen bg-[#FFF7ED]">
    <section class="min-h-screen flex flex-col items-center justify-center p-6 text-center">
        <div class="w-full max-w-md h-[400px] bg-[#FFEDD5] arch-shape overflow-hidden relative mb-8 shadow-xl">
             <img src="{{ $coverImage }}" class="w-full h-full object-cover opacity-80 mix-blend-multiply">
             <div class="absolute bottom-0 w-full p-8 bg-gradient-to-t from-[#9A3412] to-transparent text-[#FFF7ED]">
                 <p class="font-script text-4xl">{{ $groom['nickname'] }} & {{ $bride['nickname'] }}</p>
             </div>
        </div>
        <div data-anim="fade-up">
            <p class="uppercase tracking-[0.3em] text-sm mb-4">We Are Getting Married</p>
            @if($eventDate) <h2 class="text-3xl font-bold mb-2">{{ $eventDate->format('d . m . Y') }}</h2> <p class="text-sm text-[#C2410C]">{{ $invitation->event_data[0]['location'] ?? 'Venue' }}</p> @endif
            @if($guest) <div class="mt-8 border-t border-[#C2410C] pt-4"><p class="text-xs uppercase">Special Guest</p><h3 class="text-xl">{{ $guest->name }}</h3></div> @endif
        </div>
    </section>
    <section class="py-20 px-6">
        <div class="grid md:grid-cols-2 gap-12 max-w-4xl mx-auto">
            <div class="text-center">
                <h3 class="font-script text-5xl mb-2 text-[#C2410C]">{{ $groom['fullname'] }}</h3>
                <p class="text-sm">Son of {{ $groom['father'] }} & {{ $groom['mother'] }}</p>
            </div>
            <div class="text-center">
                <h3 class="font-script text-5xl mb-2 text-[#C2410C]">{{ $bride['fullname'] }}</h3>
                <p class="text-sm">Daughter of {{ $bride['father'] }} & {{ $bride['mother'] }}</p>
            </div>
        </div>
    </section>
    @if($invitation->hasFeature('rsvp'))
    <section class="py-20 bg-[#FFEDD5] px-6 rounded-t-[50px]">
        <div class="max-w-xl mx-auto">
            <h2 class="text-center font-bold text-3xl mb-8 text-[#9A3412]">RSVP</h2>
            <div class="[&_input]:bg-white [&_input]:border-none [&_input]:rounded-lg [&_button]:bg-[#9A3412] [&_button]:text-white [&_button]:rounded-full">
                @livewire('frontend.rsvp-form', ['invitation' => $invitation, 'guest' => $guest])
            </div>
        </div>
    </section>
    @endif
</div>
