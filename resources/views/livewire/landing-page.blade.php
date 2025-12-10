<div class="bg-white">
    {{-- Navbar Sederhana --}}
    <nav class="container mx-auto px-6 py-4 flex justify-between items-center">
        <div class="text-2xl font-bold text-pink-600 font-serif">UndanganKita</div>
        <div class="space-x-4">
            @auth
                <a href="{{ route('dashboard.index') }}" class="text-gray-700 font-medium hover:text-pink-600">Dashboard</a>
            @else
                <a href="{{ route('login') }}" class="text-gray-700 font-medium hover:text-pink-600">Login</a>
                <a href="{{ route('register') }}" class="px-4 py-2 bg-pink-600 text-white rounded-full hover:bg-pink-700 transition">Buat Undangan</a>
            @endauth
        </div>
    </nav>

    {{-- Hero Section --}}
    <header class="container mx-auto px-6 py-16 text-center">
        <h1 class="text-4xl md:text-6xl font-bold text-gray-900 mb-4 font-serif">
            Bagikan Kebahagiaan <br> <span class="text-pink-600">Tanpa Batas</span>
        </h1>
        <p class="text-lg text-gray-600 mb-8 max-w-2xl mx-auto">
            Buat undangan pernikahan online yang canggih, unik, dan berkesan. 
            Fitur lengkap mulai dari RSVP, kirim WhatsApp otomatis, hingga buku tamu interaktif.
        </p>
        <a href="{{ route('register') }}" class="inline-block px-8 py-3 text-lg font-semibold bg-gray-900 text-white rounded-lg shadow-lg hover:bg-gray-800 transition transform hover:-translate-y-1">
            Mulai Buat Sekarang
        </a>
        
        {{-- Mockup Image (Placeholder) --}}
        <div class="mt-12 rounded-xl overflow-hidden shadow-2xl border border-gray-200">
            <div class="bg-gray-100 h-64 md:h-96 flex items-center justify-center text-gray-400">
                <span class="text-xl">Preview Template Undangan Disini</span>
            </div>
        </div>
    </header>
</div>
