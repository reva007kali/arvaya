<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">

<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="csrf-token" content="{{ csrf_token() }}">

    <title>{{ config('app.name', 'UndanganKita') }} - Dashboard</title>

    <!-- Fonts -->
    <link rel="preconnect" href="https://fonts.bunny.net">
    <link href="https://fonts.bunny.net/css?family=figtree:400,500,600&display=swap" rel="stylesheet" />

    <!-- Font Awesome (Untuk Icon Sidebar & Tombol) -->
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">

    <!-- Scripts & Styles -->
    @vite(['resources/css/app.css', 'resources/js/app.js'])

    <!-- Styles Livewire (Otomatis di v3, tapi baik untuk dipastikan urutannya) -->
    @livewireStyles
</head>

<body class="font-sans h-screen flex antialiased bg-gray-50 text-gray-800" x-data="{ sidebarOpen: false }" x-cloak>

    <!-- Mobile Overlay -->
    <div x-show="sidebarOpen" @click="sidebarOpen = false" x-transition.opacity
        class="fixed inset-0 z-20 bg-black/50 lg:hidden"></div>

    <!-- SIDEBAR -->
    <aside :class="sidebarOpen ? 'translate-x-0' : '-translate-x-full'"
        class="fixed h-screen inset-y-0 left-0 z-30 w-64 bg-white border-r border-gray-200 transition-transform duration-300 lg:static lg:translate-x-0">

        <!-- Logo -->
        <div class="flex items-center justify-center h-16 border-b border-gray-100">
            <h1 class="text-xl font-bold text-pink-600">
                <i class="fa-solid fa-heart"></i> UndanganKita
            </h1>
        </div>

        <!-- Navigation Links -->
        <nav class="p-4 space-y-1 overflow-y-auto">

            <a href="{{ route('dashboard.index') }}"
                class="flex items-center px-4 py-3 text-gray-600 rounded-lg hover:bg-pink-50 hover:text-pink-600 transition {{ request()->routeIs('dashboard.index') ? 'bg-pink-50 text-pink-600' : '' }}">
                <i class="fa-solid fa-house w-6"></i>
                <span class="font-medium">Dashboard</span>
            </a>

            <div class="pt-4 pb-2">
                <p class="px-4 text-xs font-semibold text-gray-400 uppercase tracking-wider">Project Undangan</p>
            </div>

            <!-- Contoh Menu Dinamis (Kalau user sedang edit undangan tertentu) -->
            @if (request()->route('invitation'))
                <a href="{{ route('dashboard.invitation.edit', request()->route('invitation')) }}"
                    class="flex items-center px-4 py-2 text-sm text-gray-600 rounded-lg hover:bg-gray-100 {{ request()->routeIs('dashboard.invitation.edit') ? 'bg-gray-100' : '' }}">
                    <i class="fa-solid fa-pen-to-square w-6"></i> Edit Info
                </a>
                <a href="{{ route('dashboard.guests.index', request()->route('invitation')) }}"
                    class="flex items-center px-4 py-2 text-sm text-gray-600 rounded-lg hover:bg-gray-100 {{ request()->routeIs('dashboard.guests.*') ? 'bg-gray-100' : '' }}">
                    <i class="fa-solid fa-users w-6"></i> Data Tamu
                </a>
                <a href="{{ route('dashboard.messages.index', request()->route('invitation')) }}"
                    class="flex items-center px-4 py-2 text-sm text-gray-600 rounded-lg hover:bg-gray-100 {{ request()->routeIs('dashboard.messages.*') ? 'bg-gray-100' : '' }}">
                    <i class="fa-solid fa-envelope-open-text w-6"></i> Ucapan & Doa
                </a>
            @else
                <a href="{{ route('dashboard.create') }}"
                    class="flex items-center px-4 py-2 text-sm text-gray-600 rounded-lg hover:bg-gray-100">
                    <i class="fa-solid fa-plus w-6"></i> Buat Baru
                </a>
            @endif

        </nav>

        <!-- User Profile Bottom -->
        <div class="absolute bottom-0 w-full border-t border-gray-100 p-4 bg-gray-50">
            <div class="flex items-center gap-3">
                <div
                    class="w-10 h-10 rounded-full bg-pink-200 flex items-center justify-center text-pink-700 font-bold">
                    {{ substr(auth()->user()->name, 0, 1) }}
                </div>
                <div>
                    <p class="text-sm font-medium">{{ auth()->user()->name }}</p>
                    <form method="POST" action="{{ route('logout') }}">
                        @csrf
                        <button type="submit" class="text-xs text-red-500 hover:underline">Logout</button>
                    </form>
                </div>
            </div>
        </div>
    </aside>

    <!-- MAIN CONTENT WRAPPER -->
    <div class="flex-1 flex flex-col min-h-screen">

        <!-- Top Navbar (Mobile Hamburger & Title) -->
        <header class="bg-white shadow-sm h-16 flex items-center justify-between px-4 lg:px-8">
            <button @click="sidebarOpen = true" class="lg:hidden text-gray-500 focus:outline-none">
                <i class="fa-solid fa-bars text-2xl"></i>
            </button>

            <h2 class="font-semibold text-lg text-gray-800">
                {{ $header ?? 'Dashboard' }}
            </h2>

            <!-- Slot untuk action button kanan atas (misal: tombol save) -->
            <div class="flex items-center gap-2">
                {{ $actions ?? '' }}
            </div>
        </header>

        <!-- Page Content -->
        <main class=" p-4 lg:p-8 overflow-y-auto">
            <!-- Tempat Notifikasi Global (Toast) -->
            <x-notification-toast />

            {{ $slot }}
        </main>
    </div>

    @livewireScripts
</body>

</html>
