<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\User;
use App\Models\Role;
use App\Models\Anggota; 
use App\Models\Jabatan; 
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Log;
use Illuminate\Validation\Rule;
use Illuminate\Support\Facades\Storage;

class UserController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $users = User::query()
                      ->orderBy('created_at', 'desc')
                      ->paginate(15);
        return view('backend.user.index', compact('users'));
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
    public function show(string $id)
    {
        $user = Auth::user(); 
        $anggota = $user->anggota; 

        return view('backend.user.profil', compact('anggota'));
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(User $user)
    {
        // Otorisasi: Hanya user yang sedang login yang boleh mengedit profilnya sendiri
        // ATAU Admin boleh mengedit user lain (Anda bisa menggunakan Policy di sini)
        if (Auth::id() !== $user->id && !Auth::user()->hasRole('admin')) {
            abort(403, 'Anda tidak diizinkan mengakses halaman ini.');
        }

        $users = User::all();
        $roles = Role::all();
        $jabatan = Jabatan::all();
        
        // Ambil data Anggota yang berelasi, jika ada
        $anggota = $user->anggota;

        return view('backend.user.edit_profil', compact('users', 'user', 'anggota', 'roles', 'jabatan'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, string $id)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(User $user)
    {
        if (!Auth::user()->hasRole('admin')) {
            abort(403, 'Anda tidak memiliki akses untuk menghapus user ini.');
        }

        DB::transaction(function () use ($user) {
            // Putuskan relasi dengan anggota jika ada
            if ($user->anggota) {
                $user->anggota->update(['users_id' => null]);
            }

            // Hapus data diskusi yang terkait dengan user sebelum menghapus user
            DB::table('diskusi')->where('users_id', $user->id)->delete();

            // Hapus foto jika ada
            if ($user->foto && Storage::disk('public')->exists($user->foto)) {
                Storage::disk('public')->delete($user->foto);
            }

            $user->delete();
        });

        return redirect()->route('backend.user.index')->with('success', 'User berhasil dihapus.');
    }
}
