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
  
            // Cari user berdasarkan email, atau buat instance baru jika tidak ada.
            $user = User::firstOrNew(['email' => $googleUser->getEmail()]);
 
            // Isi atau update data dari Google.
            $user->fill([
                'nama' => $googleUser->getName(),
                'google_id' => $googleUser->getId(),
                'avatar' => $googleUser->getAvatar(),
            ]);
 
            // Hanya set password jika ini adalah user baru.
            if (!$user->exists) {
                $user->password = bcrypt(Str::random(16));
            }
 
            $user->save();
 
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