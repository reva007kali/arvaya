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
    <title>{{ $groom['nickname'] ?? 'Groom' }} & {{ $bride['nickname'] ?? 'Bride' }} - Tropical Paradise</title>
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link href="https://fonts.googleapis.com/css2?family=Comfortaa:wght@300;400;700&family=Pacifico&display=swap" rel="stylesheet">
@endslot
<style>
    :root { --c-bg: #0F766E; --c-text: #FFEDD5; --c-accent: #C2410C; --font-main: 'Comfortaa', cursive; --font-script: 'Pacifico', cursive; }
    body { background-color: var(--c-bg); color: var(--c-text); font-family: var(--font-main); }
    .font-script { font-family: var(--font-script); }
    .leaf-pattern { background-image: linear-gradient(45deg, #115E59 25%, transparent 25%, transparent 75%, #115E59 75%, #115E59), linear-gradient(45deg, #115E59 25%, transparent 25%, transparent 75%, #115E59 75%, #115E59); background-position: 0 0, 10px 10px; background-size: 20px 20px; opacity: 0.1; }
</style>
<div class="min-h-screen relative overflow-hidden bg-gradient-to-b from-[#0F766E] to-[#134E4A]">
    <div class="absolute inset-0 leaf-pattern"></div>
    <section class="min-h-screen flex flex-col justify-center items-center text-center p-6 relative z-10">
        <div class="bg-white/10 backdrop-blur-md p-10 rounded-3xl border border-[#2DD4BF]/30 shadow-2xl" data-anim="zoom-in">
             <h1 class="font-script text-6xl md:text-8xl text-[#FDBA74] mb-4 drop-shadow-md">{{ $groom['nickname'] }} <br> & <br> {{ $bride['nickname'] }}</h1>
             <p class="uppercase tracking-widest font-bold text-[#CCFBF1] mb-6">Are Getting Married!</p>
             @if($eventDate)
                 <div class="bg-[#FDBA74] text-[#7C2D12] px-6 py-2 rounded-full inline-block font-bold text-lg transform -rotate-2 hover:rotate-0 transition">{{ $eventDate->format('d M Y') }}</div>
             @endif
        </div>
        @if($guest)
             <div class="mt-12 text-[#CCFBF1]">
                 <p class="text-xs uppercase">Special Invite For</p>
                 <h3 class="text-2xl font-bold border-b-2 border-[#FDBA74] inline-block pb-1">{{ $guest->name }}</h3>
             </div>
        @endif
    </section>
    <section class="py-24 px-6 relative z-10">
        <div class="grid md:grid-cols-2 gap-12 max-w-4xl mx-auto">
             <div class="text-center bg-white/5 p-8 rounded-2xl">
                 <h2 class="font-script text-4xl text-[#FDBA74] mb-2">{{ $groom['fullname'] }}</h2>
             </div>
             <div class="text-center bg-white/5 p-8 rounded-2xl">
                 <h2 class="font-script text-4xl text-[#FDBA74] mb-2">{{ $bride['fullname'] }}</h2>
             </div>
        </div>
    </section>
    @if($invitation->hasFeature('rsvp'))
    <section class="py-24 px-6 bg-[#CCFBF1] text-[#0F766E] rounded-t-[60px] relative z-10">
        <div class="max-w-xl mx-auto">
             <h2 class="text-center font-script text-5xl mb-8">Join The Party!</h2>
             <div class="[&_input]:bg-white [&_input]:border-none [&_input]:rounded-xl [&_button]:bg-[#F97316] [&_button]:text-white [&_button]:font-bold [&_button]:rounded-xl">
                 @livewire('frontend.rsvp-form', ['invitation' => $invitation, 'guest' => $guest])
             </div>
        </div>
    </section>
    @endif
</div>
