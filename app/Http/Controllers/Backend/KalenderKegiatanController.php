<?php

namespace App\Http\Controllers\Backend;

use App\Http\Controllers\Controller;
use App\Models\KalenderKegiatan;
use Illuminate\Http\Request;

class KalenderKegiatanController extends Controller
{

    public function index(Request $request)
    {
        $query = KalenderKegiatan::query();
        if ($request->filled('q')) {
            $query->where('judul', 'like', '%' . $request->q . '%');
        }
        $kegiatan = $query->orderBy('waktu_mulai', 'desc')->paginate(10);
        $kalenderClass = KalenderKegiatan::class;
        return view('backend.kalender_kegiatan.index', compact('kegiatan', 'kalenderClass'));
    }

    public function create()
    {
        return view('backend.kalender_kegiatan.create');
    }

    public function store(Request $request)
    {
        $validated = $request->validate([
            'judul' => 'required|string|max:255',
            'isi' => 'nullable|string',
            'waktu_mulai' => 'required|date',
            'waktu_selesai' => 'nullable|date|after_or_equal:waktu_mulai',
            'status' => 'required|in:frontend,backend,both',
        ]);

        KalenderKegiatan::create($validated);

        return redirect()->route('backend.kalender-kegiatan.index')->with('success', 'Kegiatan kalender berhasil ditambahkan.');
    }

    public function show(KalenderKegiatan $kalenderKegiatan)
    {
        return view('backend.kalender_kegiatan.show', compact('kalenderKegiatan'));
    }

    public function edit(KalenderKegiatan $kalenderKegiatan)
    {
        // Otorisasi ditangani oleh __construct -> authorizeResource
        return view('backend.kalender_kegiatan.edit', compact('kalenderKegiatan'));
    }

    public function update(Request $request, KalenderKegiatan $kalenderKegiatan)
    {
        // Otorisasi ditangani oleh __construct -> authorizeResource
        $validated = $request->validate([
            'judul' => 'required|string|max:255',
            'isi' => 'nullable|string',
            'waktu_mulai' => 'required|date',
            'waktu_selesai' => 'nullable|date|after_or_equal:waktu_mulai',
            'status' => 'required|in:frontend,backend,both',
        ]);

        $kalenderKegiatan->update($validated);

        return redirect()->route('backend.kalender-kegiatan.index')->with('success', 'Kegiatan kalender berhasil diperbarui.');
    }

    public function destroy(KalenderKegiatan $kalenderKegiatan)
    {
        $kalenderKegiatan->delete();
        return redirect()->route('backend.kalender-kegiatan.index')->with('success', 'Kegiatan kalender berhasil dihapus.');
    }

    /**
     * Menyediakan data kegiatan untuk kalender (API endpoint).
     */
    public function getEvents(Request $request)
    {
        $query = KalenderKegiatan::query();

        // Filter berdasarkan 'context' dari request (frontend/backend)
        if ($request->get('context') === 'frontend') {
            $query->whereIn('status', ['frontend', 'both']);
        } else { // Default ke backend jika tidak ada context atau context=backend
            $query->whereIn('status', ['backend', 'both']);
        }

        $events = $query->get()->map(function ($kegiatan) {
            return [
                'title' => $kegiatan->judul,
                'start' => $kegiatan->waktu_mulai->toIso8601String(),
                'end' => $kegiatan->waktu_selesai ? $kegiatan->waktu_selesai->toIso8601String() : null,
                'extendedProps' => [
                    'tempat' => $kegiatan->isi, // Kita gunakan 'isi' sebagai 'tempat' di tooltip
                    'tipe' => 'Acara', // Bisa dihardcode atau ditambahkan field baru jika perlu
                ]
            ];
        });

        return response()->json($events);
    }
}
