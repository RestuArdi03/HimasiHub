<?php

namespace App\Http\Controllers;

use App\Models\Anggota;
use App\Models\Jabatan;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;

class AnggotaController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $anggota = Anggota::select('anggota.*')
        // Lakukan join ke tabel jabatan
        ->join('jabatan', 'anggota.jabatan_id', '=', 'jabatan.id') 
        // Urutkan berdasarkan kolom 'kode_jabatan' di tabel jabatan
        ->orderBy('jabatan.kode_jabatan', 'asc') 
        ->get();
        return view('backend.anggota.halaman_anggota', compact('anggota'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        $jabatan = Jabatan::all();
        return view('backend.anggota.tambah_anggota', compact('jabatan'));
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
            'jabatan_id'  => 'required|integer|exists:jabatan,id',
            'alamat'   => 'nullable|string|max:255',
            'moto_hidup'   => 'nullable|string|max:255',
            'email'   => 'nullable|string|max:255',
            'tiktok'   => 'nullable|string|max:255',
            'instagram'   => 'nullable|string|max:255',
            'foto'     => 'nullable|image|mimes:jpg,jpeg,png|max:2048',
        ], [
            'foto.image' => 'File harus berupa gambar.',
            'foto.mimes' => 'Format gambar hanya boleh jpg, jpeg, atau png.',
            'foto.max'   => 'Ukuran gambar maksimal 2MB.',
        ]);

        // cek apakah ada file foto
        if ($request->hasFile('foto')) {
            // simpan file ke folder public/storage/foto
            $path = $request->file('foto')->store('foto', 'public');
            // simpan path ke field foto
            $validated['foto'] = $path;
        }

        Anggota::create($validated);

        return redirect()->route('backend.anggota.index')->with('success', 'Data anggota berhasil ditambahkan.');
    }

    /**
     * Display the specified resource.
     */
    public function show(Anggota $anggota)
    {
        return view('backend.anggota.detail_anggota', compact('anggota'));
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Anggota $anggota)
    {   
        $jabatan = Jabatan::all();
        return view('backend.anggota.edit_anggota', [
            'anggota' => $anggota
        ], compact('jabatan'));
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
            'no_hp'     => 'nullable|string|max:20',
            'jabatan_id'  => 'required|integer|exists:jabatan,id',
            'alamat'    => 'nullable|string|max:255',
            'moto_hidup'   => 'nullable|string|max:255',
            'email'   => 'nullable|string|max:255',
            'tiktok'   => 'nullable|string|max:255',
            'instagram'   => 'nullable|string|max:255',
            'foto'      => 'nullable|image|mimes:jpg,jpeg,png|max:2048',
        ], [
            'foto.image' => 'File harus berupa gambar.',
            'foto.mimes' => 'Format gambar hanya boleh jpg, jpeg, atau png.',
            'foto.max'   => 'Ukuran gambar maksimal 2MB.',
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
        $anggota->delete();
        return redirect()->route('backend.anggota.index')->with('success', 'Anggota berhasil diberhentikan.');
    }

    public function trash()
    {
        $anggota = Anggota::query() // Mulai query dengan Anggota::query()
            // dan tambahkan whereNotNull('anggota.deleted_at') untuk memfilter yang terhapus
            ->withTrashed() 
            ->whereNotNull('anggota.deleted_at')
            
            // Pilih kolom yang diperlukan untuk menghindari konflik penamaan
            ->select('anggota.*', 'jabatan.kode_jabatan') 
            
            ->join('jabatan', 'anggota.jabatan_id', '=', 'jabatan.id') 
            
            // Urutkan berdasarkan kolom 'kode_jabatan' di tabel jabatan
            ->orderBy('jabatan.kode_jabatan', 'asc') 
            
            // Panggil get() hanya sekali
            ->get(); 
            
        return view('backend.anggota.mantan_anggota', compact('anggota'));
    }

    /**
     * Memulihkan (restore) anggota yang sudah di-soft-delete.
     */
    public function restore($id)
    {
        // 1. Cari data yang sudah terhapus
        $anggota = Anggota::onlyTrashed()->findOrFail($id); 
        
        // 2. Lakukan pemulihan (mengubah deleted_at menjadi NULL)
        $anggota->restore(); 

        return redirect()->route('backend.anggota.index')
            ->with('success', 'Anggota ' . $anggota->nama . ' berhasil dipulihkan.');
    }
    
    /**
     * Menghapus anggota secara permanen (force delete).
     */
    public function forceDelete($id)
    {
        // 1. Cari data yang sudah terhapus
        $anggota = Anggota::onlyTrashed()->findOrFail($id); 
        
        // 2. Lakukan penghapusan permanen
        $anggota->forceDelete(); 

        return redirect()->route('backend.anggota.trash')
            ->with('success', 'Anggota ' . $anggota->nama . ' berhasil dihapus permanen.');
    }
}
