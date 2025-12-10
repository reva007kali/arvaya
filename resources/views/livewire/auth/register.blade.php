<x-layouts.auth>
    {{-- Main Container dengan Arvaya Style --}}
    <div class="w-full max-w-md mx-auto bg-white p-8 md:p-10 rounded-3xl shadow-[0_10px_40px_-10px_rgba(184,151,96,0.15)] border border-[#E6D9B8] relative overflow-hidden">
        
        {{-- Hiasan Background Abstrak --}}
        <div class="absolute top-0 right-0 w-32 h-32 bg-[#F9F7F2] rounded-bl-full -mr-8 -mt-8 z-0 pointer-events-none"></div>
        <div class="absolute bottom-0 left-0 w-24 h-24 bg-[#F9F7F2] rounded-tr-full -ml-8 -mb-8 z-0 pointer-events-none"></div>

        <div class="relative z-10">
            {{-- HEADER: LOGO & TITLE --}}
            <div class="text-center mb-8">
                {{-- Logo Arvaya --}}
                <a href="/" class="inline-flex items-center gap-2 group mb-4">
                    <div class="w-10 h-10 rounded-full border border-[#B89760] flex items-center justify-center text-[#B89760] group-hover:bg-[#B89760] group-hover:text-white transition duration-500">
                        <span class="font-serif font-bold text-lg">A</span>
                    </div>
                    <div class="flex flex-col text-left">
                        <span class="font-serif font-bold text-xl tracking-widest leading-none text-[#5E4926]">ARVAYA</span>
                        <span class="text-[8px] uppercase tracking-[0.3em] text-[#9A7D4C]">de aure</span>
                    </div>
                </a>

                <h1 class="font-serif text-2xl font-bold text-[#5E4926]">{{ __('Create an Account') }}</h1>
                <p class="text-[#9A7D4C] text-sm mt-1">{{ __('Mulai kisah bahagiamu bersama kami') }}</p>
            </div>

            <!-- Session Status -->
            <x-auth-session-status class="mb-4 text-center" :status="session('status')" />

            <form method="POST" action="{{ route('register.store') }}" class="space-y-5" x-data="{ showPass: false, showConfirm: false }">
                @csrf

                <!-- Name -->
                <div>
                    <label class="block text-xs font-bold text-[#7C6339] uppercase tracking-wider mb-1.5 ml-1">{{ __('Name') }}</label>
                    <input type="text" name="name" :value="old('name')" required autofocus autocomplete="name"
                           class="w-full px-4 py-3 rounded-xl bg-[#F9F7F2] border-[#E6D9B8] text-[#5E4926] placeholder-[#C6AC80] focus:border-[#B89760] focus:ring-1 focus:ring-[#B89760] transition-all text-sm font-medium"
                           placeholder="Nama Lengkap">
                    @error('name') <span class="text-red-500 text-xs mt-1 block ml-1">{{ $message }}</span> @enderror
                </div>

                <!-- Email Address -->
                <div>
                    <label class="block text-xs font-bold text-[#7C6339] uppercase tracking-wider mb-1.5 ml-1">{{ __('Email address') }}</label>
                    <input type="email" name="email" :value="old('email')" required autocomplete="email"
                           class="w-full px-4 py-3 rounded-xl bg-[#F9F7F2] border-[#E6D9B8] text-[#5E4926] placeholder-[#C6AC80] focus:border-[#B89760] focus:ring-1 focus:ring-[#B89760] transition-all text-sm font-medium"
                           placeholder="email@example.com">
                    @error('email') <span class="text-red-500 text-xs mt-1 block ml-1">{{ $message }}</span> @enderror
                </div>

                <!-- Password -->
                <div>
                    <label class="block text-xs font-bold text-[#7C6339] uppercase tracking-wider mb-1.5 ml-1">{{ __('Password') }}</label>
                    <div class="relative">
                        <input :type="showPass ? 'text' : 'password'" name="password" required autocomplete="new-password"
                               class="w-full px-4 py-3 rounded-xl bg-[#F9F7F2] border-[#E6D9B8] text-[#5E4926] placeholder-[#C6AC80] focus:border-[#B89760] focus:ring-1 focus:ring-[#B89760] transition-all text-sm font-medium pr-10"
                               placeholder="********">
                        <button type="button" @click="showPass = !showPass" class="absolute inset-y-0 right-0 pr-3 flex items-center text-[#C6AC80] hover:text-[#B89760] transition">
                            <i class="fa-solid" :class="showPass ? 'fa-eye-slash' : 'fa-eye'"></i>
                        </button>
                    </div>
                    @error('password') <span class="text-red-500 text-xs mt-1 block ml-1">{{ $message }}</span> @enderror
                </div>

                <!-- Confirm Password -->
                <div>
                    <label class="block text-xs font-bold text-[#7C6339] uppercase tracking-wider mb-1.5 ml-1">{{ __('Confirm password') }}</label>
                    <div class="relative">
                        <input :type="showConfirm ? 'text' : 'password'" name="password_confirmation" required autocomplete="new-password"
                               class="w-full px-4 py-3 rounded-xl bg-[#F9F7F2] border-[#E6D9B8] text-[#5E4926] placeholder-[#C6AC80] focus:border-[#B89760] focus:ring-1 focus:ring-[#B89760] transition-all text-sm font-medium pr-10"
                               placeholder="********">
                        <button type="button" @click="showConfirm = !showConfirm" class="absolute inset-y-0 right-0 pr-3 flex items-center text-[#C6AC80] hover:text-[#B89760] transition">
                            <i class="fa-solid" :class="showConfirm ? 'fa-eye-slash' : 'fa-eye'"></i>
                        </button>
                    </div>
                </div>

                <!-- Submit Button -->
                <div class="pt-2">
                    <button type="submit" class="w-full py-3 bg-[#5E4926] text-white rounded-xl font-bold uppercase tracking-wider hover:bg-[#403013] transition shadow-lg shadow-[#5E4926]/20 transform hover:-translate-y-0.5 flex items-center justify-center gap-2">
                        <span>{{ __('Create account') }}</span>
                        <i class="fa-solid fa-arrow-right"></i>
                    </button>
                </div>
            </form>

            <!-- Footer Links -->
            <div class="mt-8 text-center text-sm">
                <span class="text-[#9A7D4C]">{{ __('Already have an account?') }}</span>
                <a href="{{ route('login') }}" class="font-bold text-[#B89760] hover:text-[#5E4926] hover:underline transition ml-1">
                    {{ __('Log in') }}
                </a>
            </div>
        </div>
    </div>
</x-layouts.auth>