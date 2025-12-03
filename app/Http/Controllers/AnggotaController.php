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
        // Ambil hanya user yang belum menjadi anggota
        $users = User::whereNull('anggota_id')->orderBy('nama')->get();
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
            'users_id'      => 'required|integer|exists:users,id|unique:anggota,users_id', // ID User yang sudah ada
            'tiktok'        => 'nullable|string|max:255',
            'instagram'     => 'nullable|string|max:255',
            'foto'          => 'nullable|image|mimes:jpg,jpeg,png|max:2048|dimensions:ratio=1/1',
        ], [
            'foto.image' => 'File harus berupa gambar.',
            'foto.mimes' => 'Format gambar hanya boleh jpg, jpeg, atau png.',
            'foto.max'   => 'Ukuran gambar maksimal 2MB.',
            'foto.dimensions' => 'Foto harus memiliki rasio 1:1.',
            'users_id.unique' => 'User ini sudah terdaftar sebagai anggota.',
        ]);

        // Ambil data jabatan terpilih
        $jabatanTerpilih = Jabatan::findOrFail($validated['jabatan_id']);
        
        $newRoleId = $jabatanTerpilih->role_id; 

        // Lakukan transaksi untuk memastikan Anggota dibuat dan User diupdate
        DB::transaction(function () use ($validated, $request, $newRoleId) {
            // 1. SIMPAN FOTO
            if ($request->hasFile('foto')) {
                $validated['foto'] = $request->file('foto')->store('anggota', 'public');
            }

            // 2. BUAT ANGGOTA BARU
            $anggota = Anggota::create($validated);

            // 3. UPDATE USER TERKAIT
            $user = User::findOrFail($validated['users_id']);
            $user->update([
                'nama' => $validated['nama'], // Update nama user
                'role_id' => $newRoleId,
                'anggota_id' => $anggota->id, // Set anggota_id pada user
            ]);
        }, 3); // Retry 3 times on deadlock

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
        // Ambil user yang belum jadi anggota, DAN user yang sedang diedit saat ini
        $users = User::whereNull('anggota_id')->orWhere('id', $anggota->users_id)->orderBy('nama')->get();
        return view('backend.anggota.edit_anggota', compact('anggota', 'jabatan', 'users'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, Anggota $anggota)
    {
        $oldUserId = $anggota->users_id;

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
            
            'users_id'  => ['required', 'integer', 'exists:users,id', Rule::unique('anggota', 'users_id')->ignore($anggota->id)],
            'tiktok'    => 'nullable|string|max:255',
            'instagram' => 'nullable|string|max:255',
            'foto'      => 'nullable|image|mimes:jpg,jpeg,png|max:2048|dimensions:ratio=1/1',
        ], [
            'foto.image' => 'File harus berupa gambar.',
            'foto.mimes' => 'Format gambar hanya boleh jpg, jpeg, atau png.',
            'foto.max'   => 'Ukuran gambar maksimal 2MB.',
            'foto.dimensions' => 'Foto harus memiliki rasio 1:1.',
            'users_id.unique' => 'User ini sudah terdaftar sebagai anggota lain.',
        ]);

        $jabatanTerpilih = Jabatan::findOrFail($validated['jabatan_id']);
        $newRoleId = $jabatanTerpilih->role_id; 
        $newUserId = $validated['users_id'];

        // --- LOGIKA PENANGANAN FOTO BARU ---
        if ($request->hasFile('foto')) {
            if ($anggota->foto && Storage::disk('public')->exists($anggota->foto)) {
                Storage::disk('public')->delete($anggota->foto);
            }
            $validated['foto'] = $request->file('foto')->store('anggota', 'public');
        }

        // --- PEMBARUAN USER DAN ANGGOTA ---
        DB::transaction(function () use ($validated, $anggota, $oldUserId, $newUserId, $newRoleId) {
            
            // 1. UPDATE DATA ANGGOTA
            $anggota->update($validated);

            // 2. JIKA USER DIGANTI, RESET USER LAMA
            if ($oldUserId != $newUserId) {
                $oldUser = User::find($oldUserId); // find() can return null
                if ($oldUser) {
                    $oldUser->update([
                        'anggota_id' => null,
                        'role_id' => null, // Atau set ke role default 'user'
                    ]);
                }
            }

            // 3. UPDATE USER BARU
            $newUser = User::find($newUserId);
            if ($newUser) {
                $newUser->update([
                    'nama' => $validated['nama'], // Update nama user
                    'anggota_id' => $anggota->id, 
                    'role_id' => $newRoleId
                ]);
            }
        });

        return redirect()->route('backend.anggota.index')->with('success', 'Data anggota berhasil diperbarui.');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Anggota $anggota)
    {
        // Reset user yang terkait sebelum soft delete
        DB::transaction(function () use ($anggota) {
            $user = $anggota->users;
            if ($user) {
                $user->update([
                    'anggota_id' => null,
                    'role_id' => null, // Atau set ke role default 'user'
                ]);
            }
        });
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
