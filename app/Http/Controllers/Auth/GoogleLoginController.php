<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Str;
use Laravel\Socialite\Facades\Socialite;

class GoogleLoginController extends Controller
{
    /**
     * Redirect the user to the Google authentication page.
     */
    public function redirectToGoogle()
    {
        return Socialite::driver('google')->redirect();
    }

    /**
     * Obtain the user information from Google.
     */
    public function handleGoogleCallback()
    {
        try {
            $googleUser = Socialite::driver('google')->user();
  
            // Cari user berdasarkan email.
            $user = User::where('email', $googleUser->getEmail())->first();

            if ($user) {
                // Jika user sudah ada, update google_id dan avatar saja. Nama tidak diubah.
                $user->update([
                    'google_id' => $googleUser->getId(),
                    'avatar' => $googleUser->getAvatar(),
                ]);
            } else {
                // Jika user belum ada, buat user baru dengan semua data.
                $user = User::create([
                    'nama' => $googleUser->getName(),
                    'email' => $googleUser->getEmail(),
                    'google_id' => $googleUser->getId(),
                    'avatar' => $googleUser->getAvatar(),
                    'password' => bcrypt(Str::random(16)),
                ]);
            }
 
            Auth::login($user, true);
 
            if ($user->role) {
                return redirect()->route('backend.dashboard'); // Arahkan ke backend jika role tidak null
            }
    
            return redirect()->route('frontend.index'); // Arahkan ke frontend jika role null
 
        } catch (\Exception $e) {
            // Untuk debugging, Anda bisa log errornya:
            // \Log::error($e->getMessage());
            return redirect('/login')->with('error', 'Terjadi kesalahan saat otentikasi dengan Google. Silakan coba lagi.');
        }
    }
}