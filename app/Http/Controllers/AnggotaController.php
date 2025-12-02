<?php

namespace App\Http\Controllers;

use App\Models\Anggota;
use App\Models\Jabatan;
use App\Models\User;
use Illuminate\Support\Facades\DB;
use Illuminate\Validation\Rule;
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
        $jabatan = Jabatan::with('role')->get();
        $users = User::all();
        return view('backend.anggota.tambah_anggota', compact('jabatan', 'users'));
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $validated = $request->validate([
            'nama'          => 'required|string|max:255',
            'nim'           => 'required|string|max:50|unique:anggota,nim', 
            'kelas'         => 'required|string|max:50',
            'jurusan'       => 'required|string|max:100',
            'no_hp'         => 'nullable|string|max:20',
            'jabatan_id'    => 'required|integer|exists:jabatan,id',
            'alamat'        => 'nullable|string|max:255',
            'moto_hidup'    => 'nullable|string|max:255',
            'users_id'      => 'required|integer|exists:users,id', // ID User yang sudah ada
            'tiktok'        => 'nullable|string|max:255',
            'instagram'     => 'nullable|string|max:255',
            'foto'          => 'nullable|image|mimes:jpg,jpeg,png|max:2048|dimensions:ratio=1/1',
        ], [
            'foto.image' => 'File harus berupa gambar.',
            'foto.mimes' => 'Format gambar hanya boleh jpg, jpeg, atau png.',
            'foto.max'   => 'Ukuran gambar maksimal 2MB.',
            'foto.dimensions' => 'Foto harus memiliki rasio 1:1.',
        ]);

        // Ambil data jabatan terpilih
        $jabatanTerpilih = Jabatan::findOrFail($validated['jabatan_id']);
        
        // Ambil role_id yang benar dari jabatan (Asumsi ada kolom role_id di tabel jabatan)
        $newRoleId = $jabatanTerpilih->role_id; 

        // Lakukan transaksi untuk memastikan kedua Model (User dan Anggota) terupdate/tercipta
        DB::transaction(function () use ($validated, $request, $newRoleId) {

            // 1. UPDATE ROLE USER YANG SUDAH ADA
            $user = User::findOrFail($validated['users_id']);
            $user->update([
                'role_id' => $newRoleId, // <-- PENTING: Update role_id
            ]);
            
            // 2. SIMPAN FOTO
            if ($request->hasFile('foto')) {
                $validated['foto'] = $request->file('foto')->store('anggota', 'public');
            }

            // 3. BUAT ANGGOTA
            Anggota::create($validated);
        });

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
        $jabatan = Jabatan::with('role')->get(); 
        $users = User::all();
        return view('backend.anggota.edit_anggota', compact('anggota', 'jabatan', 'users'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, Anggota $anggota)
    {
        // Cek ID User terkait
        $userId = $anggota->users_id; 

        // Jika field email TIDAK ADA di form Anda, gunakan email lama:
        $currentEmail = $anggota->user?->email ?? '';

        $validated = $request->validate([
            'nama'      => 'required|string|max:255',
            // KOREKSI: Gunakan Rule::unique untuk mengabaikan NIM yang sedang diedit
            'nim'       => ['required', 'string', 'max:50', Rule::unique('anggota', 'nim')->ignore($anggota->id)], 
            'kelas'     => 'required|string|max:50',
            'jurusan'   => 'required|string|max:100',
            'no_hp'     => 'nullable|string|max:20',
            'jabatan_id' => 'required|integer|exists:jabatan,id',
            'alamat'    => 'nullable|string|max:255',
            'moto_hidup' => 'nullable|string|max:255',
            
            'users_id'  => 'required|integer|exists:users,id', // Dipertahankan untuk field dropdown
            'tiktok'    => 'nullable|string|max:255',
            'instagram' => 'nullable|string|max:255',
            'foto'      => 'nullable|image|mimes:jpg,jpeg,png|max:2048|dimensions:ratio=1/1',
        ], [
            'foto.image' => 'File harus berupa gambar.',
            'foto.mimes' => 'Format gambar hanya boleh jpg, jpeg, atau png.',
            'foto.max'   => 'Ukuran gambar maksimal 2MB.',
            'foto.dimensions' => 'Foto harus memiliki rasio 1:1.',
        ]);

        // --- 1. AMBIL NILAI HIDDEN INPUT KODE ---
        $redirectCode = $request->input('kode'); // Ambil nilai kode (akan bernilai '1' jika dikirim)

        // 1. Ambil Model Jabatan yang baru dipilih
        $jabatanTerpilih = Jabatan::findOrFail($validated['jabatan_id']);
        
        // 2. Dapatkan role_id yang terkait dengan jabatan tersebut
        // (Asumsi kolom role_id ada di tabel jabatan)
        $newRoleId = $jabatanTerpilih->role_id; 

        // --- LOGIKA PENANGANAN FOTO BARU ---
        if ($request->hasFile('foto')) {
            if ($anggota->foto && Storage::disk('public')->exists($anggota->foto)) {
                Storage::disk('public')->delete($anggota->foto);
            }
            $validated['foto'] = $request->file('foto')->store('anggota', 'public');
        }

        // --- PEMBARUAN USER DAN ANGGOTA ---
        // Tambahkan $newRoleId ke variabel yang digunakan oleh closure
        DB::transaction(function () use ($validated, $anggota, $userId, $newRoleId) { 
            
            // 1. UPDATE DATA USER
            $user = User::findOrFail($userId);
            $user->update([
                'nama' => $validated['nama'],
                'role_id' => $newRoleId, 
            ]);
            // 2. UPDATE DATA ANGGOTA (Hapus field yang sudah di update di user)
            // Jika Anda TIDAK memperbarui email di form edit, hapus baris ini
            unset($validated['email']); 
            
            $anggota->update($validated);
        });

        if ($redirectCode == 1) {
            // Jika ini adalah submission dari form Profil Pribadi
            return redirect()->route('backend.dashboard')->with('success', 'Profil berhasil diperbarui.');
        }

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
