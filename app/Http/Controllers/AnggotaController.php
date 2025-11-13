<?php

namespace App\Http\Controllers;

use App\Models\Anggota;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;

class AnggotaController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $anggota = Anggota::all();
        return view('backend.anggota.halaman_anggota', compact('anggota'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        return view('backend.anggota.tambah_anggota');
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $validated = $request->validate([
            'nama'     => 'required|string|max:255',
            'nim'      => 'required|string|max:50',
            'kelas'    => 'required|string|max:50',
            'jurusan'  => 'required|string|max:100',
            'no_hp'    => 'nullable|string|max:20',
            'jabatan'  => 'required|string|max:100',
            'alamat'   => 'nullable|string|max:255',
            'foto'     => 'nullable|image|mimes:jpg,jpeg,png|max:2048',
        ]);

        Anggota::create($validated);

        return redirect()->route('backend.anggota.index')->with('success', 'Data anggota berhasil ditambahkan.');
    }

    /**
     * Display the specified resource.
     */
    public function show(Anggota $anggota)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Anggota $anggota)
    {
        return view('backend.anggota.edit_anggota', [
            'anggota' => $anggota
        ]);
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, Anggota $anggota)
    {
        $validated = $request->validate([
            'nama'      => 'required|string|max:255',
            'nim'       => 'required|string|max:50',
            'kelas'     => 'required|string|max:50',
            'jurusan'   => 'required|string|max:100',
            'no_hp'     => 'required|string|max:20',
            'jabatan'   => 'required|string|max:100',
            'alamat'    => 'required|string|max:255',
            'foto'      => 'nullable|image|mimes:jpg,jpeg,png|max:2048',
        ]);

        // --- LOGIKA PENANGANAN FOTO BARU ---
        if ($request->hasFile('foto')) {
            // 1. Hapus foto lama (kecuali jika itu adalah foto default)
            if ($anggota->foto) {
                Storage::disk('public')->delete($anggota->foto);
            }
            
            // 2. Simpan foto baru dan dapatkan path
            $validated['foto'] = $request->file('foto')->store('anggota', 'public');
        }
        // Jika tidak ada file baru di-upload, kolom 'foto' tidak perlu dikirim ke update
        // Laravel secara otomatis mengabaikannya karena tidak ada di $validated tanpa file
        
        // --- KOREKSI KRITIS: Menggunakan update() pada objek model yang ada ---
        $anggota->update($validated);

        return redirect()->route('backend.anggota.index')->with('success', 'Data anggota berhasil diperbarui.');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Anggota $anggota)
    {
        \Log::info('Menghapus anggota: ' . $anggota->id);
        $anggota->delete();
        return redirect()->route('backend.anggota.index')->with('success', 'Data anggota berhasil dihapus.');
    }
}
