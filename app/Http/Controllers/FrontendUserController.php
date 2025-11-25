<?php

namespace App\Http\Controllers;

use App\Http\Requests\UpdateFrontendUserRequest;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Storage;

class FrontendUserController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        //
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        //
    }

    /**
     * Display the specified resource.
     */
    public function show(User $user)
    {
        // You might want to show a public profile page here.
        // For now, we'll assume it redirects to the edit page if it's the user's own profile.
        if (auth()->id() !== $user->id) {
            // Optionally, show a public, read-only view of the user's profile
            // return view('frontend.user.show', compact('user'));
            abort(404); // Or redirect to a different page
        }
        return redirect()->route('frontend.user.edit', $user);
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(User $user)
    {
        if (auth()->id() !== $user->id) { abort(403); }

        return view('frontend.user.edit', compact('user'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(UpdateFrontendUserRequest $request, User $user)
    {
        // Jika pengguna memiliki role_id, jangan izinkan pembaruan nama dan email dari sini.
        if ($user->role_id) {
            $dataToUpdate = [];
        } else {
            // Jika pengguna biasa (tanpa role_id), izinkan pembaruan.
            $dataToUpdate = [
                'nama' => $request->input('nama'),
                'email' => $request->input('email'),
            ];
        }

        if ($request->hasFile('foto')) {
            if ($user->foto && Storage::disk('public')->exists($user->foto)) {
                Storage::disk('public')->delete($user->foto);
            }
            $dataToUpdate['foto'] = $request->file('foto')->store('avatars', 'public');
        }

        // Hanya lakukan pembaruan jika ada data yang perlu diubah.
        if (!empty($dataToUpdate)) {
            $user->update($dataToUpdate);
        }

        return redirect()->route('frontend.user.edit', $user)->with('status', 'profile-updated');
    }

    /**
     * Update the user's password.
     */
    public function updatePassword(Request $request)
    {
        $request->validate([
            'current_password' => ['required', 'current_password'],
            'password' => ['required', 'string', 'min:8', 'confirmed'],
        ]);

        $user = $request->user();

        $user->update([
            'password' => Hash::make($request->password),
        ]);

        return redirect()->route('frontend.user.edit', $user)->with('status', 'password-updated');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(User $user)
    {
        //
    }
}
