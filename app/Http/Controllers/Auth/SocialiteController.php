<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use App\Models\User;
use Illuminate\Support\Facades\Auth;
use Laravel\Socialite\Facades\Socialite;
use Illuminate\Support\Str;

class SocialiteController extends Controller
{
    // 1. Redirect ke Google
    public function redirect()
    {
        return Socialite::driver('google')->redirect();
    }

    // 2. Callback dari Google
    public function callback()
    {
        try {
            // Ambil data user dari Google
            $googleUser = Socialite::driver('google')->user();

            // Cek apakah user sudah ada berdasarkan google_id
            $user = User::where('google_id', $googleUser->getId())->first();

            if (!$user) {
                // Jika tidak ada google_id, cek apakah emailnya sudah terdaftar?
                $user = User::where('email', $googleUser->getEmail())->first();

                if ($user) {
                    // Jika email ada, update google_id-nya (Link Account)
                    $user->update([
                        'google_id' => $googleUser->getId(),
                        'avatar' => $googleUser->getAvatar(),
                    ]);
                } else {
                    // Jika benar-benar user baru, buat akun baru
                    // Password diisi random string karena nullable tapi Auth driver kadang butuh value
                    $user = User::create([
                        'name' => $googleUser->getName(),
                        'email' => $googleUser->getEmail(),
                        'google_id' => $googleUser->getId(),
                        'avatar' => $googleUser->getAvatar(),
                        'password' => null, // Password null karena login via google
                        'role' => 'user',
                    ]);
                }
            }

            // Login User
            Auth::login($user);

            // Redirect ke dashboard (atau halaman yang dituju sebelumnya)
            return redirect()->intended(route('dashboard.index'));

        } catch (\Exception $e) {
            // Jika user cancel atau error
            return redirect()->route('login')->with('status', 'Login Google gagal, silakan coba lagi.');
        }
    }
}