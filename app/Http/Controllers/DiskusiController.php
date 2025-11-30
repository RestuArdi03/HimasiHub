<?php

namespace App\Http\Controllers;

use App\Http\Requests\StoreDiskusiRequest;
use App\Http\Requests\UpdateDiskusiRequest;
use App\Models\Diskusi;
use Illuminate\Support\Facades\Auth;

class DiskusiController extends Controller
{
    /**
     * Menampilkan halaman utama diskusi.
     */
    public function index()
    {
        // Eager load relasi user dan parentMessage untuk efisiensi query
        $diskusi = Diskusi::with(['user', 'parentMessage.user'])
            ->orderBy('created_at', 'asc')
            ->get();

        return view('backend.diskusi.index', compact('diskusi'));
    }

    /**
     * Menyimpan pesan baru ke database.
     */
    public function store(StoreDiskusiRequest $request)
    {
        $this->authorize('create', Diskusi::class);

        $diskusi = Diskusi::create([
            'isi' => $request->isi,
            'users_id' => Auth::id(),
            'parent_id' => $request->parent_id,
        ]);

        // Load relasi untuk dikirim kembali sebagai response JSON
        $diskusi->load(['user', 'parentMessage.user']);

        return response()->json($diskusi);
    }

    /**
     * Mengupdate pesan yang sudah ada.
     */
    public function update(UpdateDiskusiRequest $request, Diskusi $diskusi)
    {
        $this->authorize('update', $diskusi);

        $diskusi->update($request->validated());
        $diskusi->load(['user', 'parentMessage.user']);

        return response()->json($diskusi);
    }

    /**
     * Menghapus pesan.
     */
    public function destroy(Diskusi $diskusi)
    {
        $this->authorize('delete', $diskusi);

        $diskusi->delete();

        return response()->json(['success' => true, 'message' => 'Pesan berhasil dihapus.']);
    }

    /**
     * Fetch pesan baru untuk polling.
     */
    public function fetch()
    {
        $diskusi = Diskusi::with(['user', 'parentMessage.user'])
            ->orderBy('created_at', 'asc')
            ->get();
        return view('backend.diskusi._messages', compact('diskusi'))->render();
    }
}