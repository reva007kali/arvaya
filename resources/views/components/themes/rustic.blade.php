@props(['invitation', 'guest'])

@php
    $groom = $invitation->couple_data['groom'] ?? [];
    $bride = $invitation->couple_data['bride'] ?? [];
    $theme = $invitation->theme_config ?? [];
    $gifts = $invitation->gifts_data ?? [];
    $coverImage = $invitation->gallery_data[0] ?? null;
@endphp

<!-- Import Font Rustic (Playfair Display & Dancing Script) -->
<style>
    @import url('https://fonts.googleapis.com/css2?family=Dancing+Script:wght@400;700&family=Playfair+Display:ital,wght@0,400;0,700;1,400&display=swap');
    
    .font-script { font-family: 'Dancing Script', cursive; }
    .font-serif { font-family: 'Playfair Display', serif; }
    
    .bg-paper {
        background-color: #fdfbf7;
        background-image: url("data:image/svg+xml,%3Csvg width='6' height='6' viewBox='0 0 6 6' xmlns='http://www.w3.org/2000/svg'%3E%3Cg fill='%23d4c5a0' fill-opacity='0.2' fill-rule='evenodd'%3E%3Cpath d='M5 0h1L0 6V5zM6 5v1H5z'/%3E%3C/g%3E%3C/svg%3E");
    }
</style>

<div class="font-serif text-[#5a4a42] bg-paper min-h-screen pb-20 overflow-x-hidden">

    {{-- COVER --}}
    <section class="min-h-screen flex flex-col justify-center items-center text-center p-6 relative">
        {{-- Ornamen Bunga (Bisa pakai img tag dengan absolute position di pojok) --}}
        
        <div class="border-2 border-[#8c7b70] p-8 md:p-12 relative z-10 max-w-lg w-full bg-white/50 backdrop-blur-sm shadow-xl" data-aos="zoom-in">
            <p class="uppercase tracking-[0.2em] text-xs mb-6">The Wedding Of</p>
            
            <h1 class="font-script text-5xl md:text-6xl mb-2 text-[#8c7b70]">
                {{ $groom['nickname'] ?? 'Groom' }}
            </h1>
            <span class="font-script text-3xl text-[#bcaaa4]">&</span>
            <h1 class="font-script text-5xl md:text-6xl mt-2 mb-8 text-[#8c7b70]">
                {{ $bride['nickname'] ?? 'Bride' }}
            </h1>

            <p class="text-lg italic border-t border-b border-[#8c7b70] py-4 inline-block px-8 mb-8">
                {{ \Carbon\Carbon::parse($invitation->event_data[0]['date'] ?? now())->format('d . m . Y') }}
            </p>

            @if($guest)
                <div class="mt-4">
                    <p class="text-xs italic mb-1">Special Guest:</p>
                    <h3 class="text-xl font-bold">{{ $guest->name }}</h3>
                </div>
            @endif
        </div>
    </section>

    {{-- COUPLE --}}
    <section class="py-20 px-6 container mx-auto text-center">
        <img src="https://ui-avatars.com/api/?name={{ $groom['nickname'] }}+{{ $bride['nickname'] }}&background=8c7b70&color=fff&size=128" 
             class="w-32 h-32 rounded-full mx-auto border-4 border-white shadow-lg mb-8">
             
        <p class="max-w-xl mx-auto italic mb-12 text-sm leading-loose">
            "{{ $invitation->couple_data['quote'] ?? 'Mencintai bukan hanya saling memandang, tetapi melihat ke arah yang sama.' }}"
        </p>
    </section>

    {{-- EVENTS (Timeline Style) --}}
    <section class="py-20 bg-[#f3efe8]">
        <div class="container mx-auto px-6 max-w-3xl">
            <h2 class="font-script text-4xl text-center mb-12">Save The Date</h2>
            
            <div class="space-y-8 relative before:absolute before:inset-0 before:ml-5 before:-translate-x-px md:before:mx-auto md:before:translate-x-0 before:h-full before:w-0.5 before:bg-gradient-to-b before:from-transparent before:via-slate-300 before:to-transparent">
                @foreach($invitation->event_data as $event)
                    <div class="relative flex items-center justify-between md:justify-normal md:odd:flex-row-reverse group is-active">
                        <!-- Icon -->
                        <div class="flex items-center justify-center w-10 h-10 rounded-full border border-white bg-slate-300 group-[.is-active]:bg-[#8c7b70] text-slate-500 group-[.is-active]:text-100 shadow shrink-0 md:order-1 md:group-odd:-translate-x-1/2 md:group-even:translate-x-1/2">
                            <i class="fa-solid fa-heart text-white text-xs"></i>
                        </div>
                        
                        <!-- Card -->
                        <div class="w-[calc(100%-4rem)] md:w-[calc(50%-2.5rem)] bg-white p-4 rounded border border-slate-200 shadow">
                            <h3 class="font-bold text-lg mb-1">{{ $event['title'] }}</h3>
                            <time class="block mb-2 text-xs font-medium uppercase text-gray-500">
                                {{ \Carbon\Carbon::parse($event['date'])->translatedFormat('l, d F Y - H:i') }}
                            </time>
                            <p class="text-sm text-gray-600">{{ $event['location'] }}</p>
                            @if(!empty($event['map_link']))
                                <a href="{{ $event['map_link'] }}" class="text-xs text-[#8c7b70] underline mt-2 inline-block">View Map</a>
                            @endif
                        </div>
                    </div>
                @endforeach
            </div>
        </div>
    </section>

    {{-- WIDGETS (RSVP & GUESTBOOK) --}}
    <section class="py-20 px-6 container mx-auto max-w-4xl">
        <div class="bg-white p-8 shadow-xl rounded-sm border-t-8 border-[#8c7b70]">
            @livewire('frontend.rsvp-form', ['invitation' => $invitation, 'guest' => $guest])
            
            <div class="my-12 h-px bg-gray-200"></div>
            
            @livewire('frontend.guest-book', ['invitation' => $invitation, 'guest' => $guest])
        </div>
    </section>

    {{-- GIFT --}}
    @if(!empty($gifts))
        <section class="py-12 text-center">
            <h2 class="font-script text-3xl mb-6">Wedding Gift</h2>
            <div class="flex flex-wrap justify-center gap-4">
                @foreach($gifts as $gift)
                    <div class="bg-white border border-[#8c7b70] px-6 py-4 rounded shadow-sm">
                        <p class="font-bold">{{ $gift['bank_name'] }}</p>
                        <p class="font-mono text-lg">{{ $gift['account_number'] }}</p>
                        <p class="text-xs">a.n {{ $gift['account_name'] }}</p>
                    </div>
                @endforeach
            </div>
        </section>
    @endif
    
    <footer class="bg-[#5a4a42] text-[#f3efe8] py-8 text-center text-xs">
        <p>&copy; {{ date('Y') }} {{ $groom['nickname'] ?? 'Groom' }} & {{ $bride['nickname'] ?? 'Bride' }}</p>
    </footer>
</div>