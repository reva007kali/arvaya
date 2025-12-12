<x-layouts.auth>
    {{-- Main Container dengan Arvaya Style --}}
    <div
        class="w-full max-w-md mx-auto bg-white p-8 md:p-10 rounded-3xl shadow-[0_10px_40px_-10px_rgba(184,151,96,0.15)] border border-[#E6D9B8] relative overflow-hidden">

        {{-- Hiasan Background Abstrak --}}
        <div class="absolute top-0 right-0 w-32 h-32 bg-[#F9F7F2] rounded-bl-full -mr-8 -mt-8 z-0 pointer-events-none">
        </div>
        <div class="absolute bottom-0 left-0 w-24 h-24 bg-[#F9F7F2] rounded-tr-full -ml-8 -mb-8 z-0 pointer-events-none">
        </div>

        <div class="relative z-10">
            {{-- HEADER: LOGO & TITLE --}}
            <div class="text-center mb-8">
                {{-- Logo Arvaya --}}
                <a href="/" class="inline-flex items-center gap-2 group mb-4">
                    <div
                        class="w-10 h-10 rounded-full border border-[#B89760] flex items-center justify-center text-[#B89760] group-hover:bg-[#B89760] group-hover:text-white transition duration-500">
                        <span class="font-serif font-bold text-lg">A</span>
                    </div>
                    <div class="flex flex-col text-left">
                        <span
                            class="font-serif font-bold text-xl tracking-widest leading-none text-[#5E4926]">ARVAYA</span>
                        <span class="text-[8px] uppercase tracking-[0.3em] text-[#9A7D4C]">de aure</span>
                    </div>
                </a>

                <h1 class="font-serif text-2xl font-bold text-[#5E4926]">{{ __('Welcome Back') }}</h1>
                <p class="text-[#9A7D4C] text-sm mt-1">{{ __('Masuk untuk mengelola undanganmu') }}</p>
            </div>

            <!-- Session Status -->
            <x-auth-session-status class="mb-4 text-center" :status="session('status')" />

            <form method="POST" action="{{ route('login.store') }}" class="space-y-5" x-data="{ showPass: false }">
                @csrf

                <!-- Email Address -->
                <div>
                    <label
                        class="block text-xs font-bold text-[#7C6339] uppercase tracking-wider mb-1.5 ml-1">{{ __('Email address') }}</label>
                    <input type="email" name="email" :value="old('email')" required autofocus autocomplete="email"
                        class="w-full px-4 py-3 rounded-xl bg-[#F9F7F2] border-[#E6D9B8] text-[#5E4926] placeholder-[#C6AC80] focus:border-[#B89760] focus:ring-1 focus:ring-[#B89760] transition-all text-sm font-medium"
                        placeholder="email@example.com">
                    @error('email')
                        <span class="text-red-500 text-xs mt-1 block ml-1">{{ $message }}</span>
                    @enderror
                </div>

                <!-- Password -->
                <div>
                    <div class="flex justify-between items-center mb-1.5 ml-1">
                        <label
                            class="block text-xs font-bold text-[#7C6339] uppercase tracking-wider">{{ __('Password') }}</label>
                        @if (Route::has('password.request'))
                            <a href="{{ route('password.request') }}"
                                class="text-[10px] font-bold text-[#B89760] hover:text-[#5E4926] hover:underline transition">
                                {{ __('Forgot password?') }}
                            </a>
                        @endif
                    </div>

                    <div class="relative">
                        <input :type="showPass ? 'text' : 'password'" name="password" required
                            autocomplete="current-password"
                            class="w-full px-4 py-3 rounded-xl bg-[#F9F7F2] border-[#E6D9B8] text-[#5E4926] placeholder-[#C6AC80] focus:border-[#B89760] focus:ring-1 focus:ring-[#B89760] transition-all text-sm font-medium pr-10"
                            placeholder="********">
                        <button type="button" @click="showPass = !showPass"
                            class="absolute inset-y-0 right-0 pr-3 flex items-center text-[#C6AC80] hover:text-[#B89760] transition">
                            <i class="fa-solid" :class="showPass ? 'fa-eye-slash' : 'fa-eye'"></i>
                        </button>
                    </div>
                    @error('password')
                        <span class="text-red-500 text-xs mt-1 block ml-1">{{ $message }}</span>
                    @enderror
                </div>

                <!-- Remember Me -->
                <div class="flex items-center ml-1">
                    <label class="inline-flex items-center cursor-pointer">
                        <input type="checkbox" name="remember"
                            class="rounded border-[#E6D9B8] text-[#B89760] shadow-sm focus:ring-[#B89760] focus:ring-opacity-50">
                        <span class="ml-2 text-sm text-[#7C6339]">{{ __('Remember me') }}</span>
                    </label>
                </div>

                <!-- Submit Button -->
                <div class="pt-2">
                    <button type="submit"
                        class="w-full py-3 bg-[#5E4926] text-white rounded-xl font-bold uppercase tracking-wider hover:bg-[#403013] transition shadow-lg shadow-[#5E4926]/20 transform hover:-translate-y-0.5 flex items-center justify-center gap-2"
                        data-test="login-button">
                        <span>{{ __('Log in') }}</span>
                        <i class="fa-solid fa-arrow-right-to-bracket"></i>
                    </button>
                </div>

                {{-- PEMISAH --}}
                <div class="relative my-6">
                    <div class="absolute inset-0 flex items-center">
                        <div class="w-full border-t border-[#E6D9B8]"></div>
                    </div>
                    <div class="relative flex justify-center text-xs uppercase">
                        <span class="bg-white px-2 text-[#9A7D4C]">Or continue with</span>
                    </div>
                </div>

                {{-- TOMBOL GOOGLE (Arvaya Style) --}}
                <a href="{{ route('auth.google') }}"
                    class="w-full py-3 bg-white border border-[#E6D9B8] rounded-xl flex items-center justify-center gap-3 text-[#5E4926] font-bold text-sm hover:bg-[#F9F7F2] hover:border-[#B89760] transition shadow-sm group">

                    {{-- Google Icon SVG --}}
                    <svg class="h-5 w-5" viewBox="0 0 24 24" xmlns="http://www.w3.org/2000/svg">
                        <path
                            d="M22.56 12.25c0-.78-.07-1.53-.2-2.25H12v4.26h5.92c-.26 1.37-1.04 2.53-2.21 3.31v2.77h3.57c2.08-1.92 3.28-4.74 3.28-8.09z"
                            fill="#4285F4" />
                        <path
                            d="M12 23c2.97 0 5.46-.98 7.28-2.66l-3.57-2.77c-.98.66-2.23 1.06-3.71 1.06-2.86 0-5.29-1.93-6.16-4.53H2.18v2.84C3.99 20.53 7.7 23 12 23z"
                            fill="#34A853" />
                        <path
                            d="M5.84 14.09c-.22-.66-.35-1.36-.35-2.09s.13-1.43.35-2.09V7.07H2.18C1.43 8.55 1 10.22 1 12s.43 3.45 1.18 4.93l2.85-2.84z"
                            fill="#FBBC05" />
                        <path
                            d="M12 5.38c1.62 0 3.06.56 4.21 1.64l3.15-3.15C17.45 2.09 14.97 1 12 1 7.7 1 3.99 3.47 2.18 7.07l3.66 2.84c.87-2.6 3.3-4.53 6.16-4.53z"
                            fill="#EA4335" />
                    </svg>

                    <span class="group-hover:text-[#B89760] transition">Google Account</span>
                </a>
            </form>

            <!-- Footer Links -->
            @if (Route::has('register'))
                <div class="mt-8 text-center text-sm">
                    <span class="text-[#9A7D4C]">{{ __('Don\'t have an account?') }}</span>
                    <a href="{{ route('register') }}"
                        class="font-bold text-[#B89760] hover:text-[#5E4926] hover:underline transition ml-1">
                        {{ __('Sign up') }}
                    </a>
                </div>
            @endif
        </div>
    </div>
</x-layouts.auth>
