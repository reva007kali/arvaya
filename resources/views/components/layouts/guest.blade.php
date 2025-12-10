<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}" class="scroll-smooth">

<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="csrf-token" content="{{ csrf_token() }}">

    {{-- SEO Meta Tags (Dinamis dari slot 'meta' jika ada) --}}
    @if (isset($meta))
        {{ $meta }}
    @else
        <title>{{ config('app.name', 'Undangan Pernikahan') }}</title>
    @endif

    <!-- Fonts Global (Optional, biasanya tiap tema punya font sendiri) -->
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>

    <!-- Font Awesome (Wajib untuk icon sosmed/navigasi di undangan) -->
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">

    {{-- aos CDN --}}
    <link href="https://unpkg.com/aos@2.3.1/dist/aos.css" rel="stylesheet">

    <!-- Scripts & Styles -->
    @vite(['resources/css/app.css', 'resources/js/app.js'])

    @livewireStyles

    {{-- Slot untuk style tambahan spesifik tema --}}
    {{ $styles ?? '' }}
</head>

<body class="antialiased text-gray-800 bg-gray-50">

    {{-- Tidak ada Navbar, Sidebar, atau Container. --}}
    {{-- Semuanya dikendalikan oleh Component Tema --}}

    {{ $slot }}

    @livewireScripts

    {{-- Slot untuk script tambahan spesifik tema (misal: animasi AOS/GSAP) --}}
    {{ $scripts ?? '' }}
</body>

</html>
