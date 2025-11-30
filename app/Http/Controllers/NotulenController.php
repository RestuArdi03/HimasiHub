<?php

namespace App\Http\Controllers;

use App\Models\Notulen;
use App\Models\Kegiatan;
use App\Models\User;
use App\Models\Anggota;
use App\Models\Agenda;
use App\Models\PresensiKehadiran;
use App\Models\Dokumentasi;
use Illuminate\Http\Request;
use Carbon\Carbon;

class NotulenController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index(Request $request)
    {
        $query = Notulen::with('kegiatan', 'users', 'agenda', 'pimpinan', 'notulis')
            ->whereNull('deleted_at');

        // Filters
        if ($request->filled('q')) {
            $q = $request->get('q');
            $query->where(function($sub) use ($q) {
                $sub->where('judul_rapat', 'like', "%{$q}%")
                    ->orWhere('catatan_tambahan', 'like', "%{$q}%");
            });
        }

        if ($request->filled('tipe_rapat')) {
            $query->where('tipe_rapat', $request->get('tipe_rapat'));
        }

        if ($request->filled('pimpinan')) {
            $query->where('pimpinan_rapat_id', $request->get('pimpinan'));
        }

        if ($request->filled('notulis')) {
            $query->where('notulis_id', $request->get('notulis'));
        }

        if ($request->filled('date_from')) {
            $query->whereDate('tanggal_rapat', '>=', $request->get('date_from'));
        }

        if ($request->filled('date_to')) {
            $query->whereDate('tanggal_rapat', '<=', $request->get('date_to'));
        }

        // Sorting
        $allowedSorts = ['tanggal_rapat', 'created_at', 'tipe_rapat'];
        $sortBy = in_array($request->get('sort_by'), $allowedSorts) ? $request->get('sort_by') : 'created_at';
        $order = $request->get('order') === 'asc' ? 'asc' : 'desc';

        $notulen = $query->orderBy($sortBy, $order)->paginate(15);

        // Pass anggota list for filter selects
        $anggota = Anggota::all();

        return view('backend.notulen.index', compact('notulen', 'anggota'));
    }

    /**
     * Display a listing of archived (soft-deleted) notulen.
     */
    public function archive()
    {
        $notulen = Notulen::onlyTrashed()
            ->with('kegiatan', 'users', 'agenda', 'pimpinan', 'notulis')
            ->orderBy('deleted_at', 'DESC')
            ->paginate(15);
        
        return view('backend.notulen.archive', compact('notulen'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        $kegiatan = Kegiatan::all();
        $users = User::all();
        $anggota = Anggota::all();
        
        return view('backend.notulen.create', compact('kegiatan', 'users', 'anggota'));
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $validated = $request->validate([
            'judul_rapat' => 'required|string|max:255',
            'catatan_tambahan' => 'required|string',
            'tanggal_rapat' => 'required|date',
            'waktu_mulai' => 'required|date_format:H:i',
            'waktu_selesai' => 'nullable|date_format:H:i',
            'lokasi' => 'required|string|max:255',
            'tipe_rapat' => 'required|string|max:255',
            'pimpinan_rapat' => 'required|exists:anggota,id',
            'notulis_id' => 'required|exists:anggota,id',
            'agenda' => 'nullable|array',
            'agenda.*.pembahasan' => 'required_with:agenda|string|max:255',
            'agenda.*.keputusan' => 'required_with:agenda|string|max:255',
            'attendees' => 'nullable|array',
            'attendees.*' => 'exists:anggota,id',
            'dokumentasi' => 'nullable|array|max:5',
            'dokumentasi.*' => 'file|mimes:jpeg,png,jpg,pdf,doc,docx|max:5120',
        ]);

        // Simpan notulen
        $notulen = Notulen::create([
            'judul_rapat' => $validated['judul_rapat'],
            'catatan_tambahan' => $validated['catatan_tambahan'],
            'tanggal_rapat' => $validated['tanggal_rapat'],
            'waktu_mulai' => $validated['waktu_mulai'],
            'waktu_selesai' => $validated['waktu_selesai'],
            'lokasi' => $validated['lokasi'],
            'tipe_rapat' => $validated['tipe_rapat'],
            'pimpinan_rapat_id' => $validated['pimpinan_rapat'],
            'notulis_id' => $validated['notulis_id'],
            'pimpinan_rapat_nama' => optional(Anggota::find($validated['pimpinan_rapat']))->nama ?? null,
            'notulis_nama' => optional(Anggota::find($validated['notulis_id']))->nama ?? null,
        ]);

        // Simpan agenda
        if ($request->has('agenda') && is_array($request->get('agenda'))) {
            foreach ($request->get('agenda') as $agendaData) {
                Agenda::create([
                    'topik' => $agendaData['topik'] ?? $agendaData['pembahasan'] ?? 'Agenda Item',
                    'hasil_pembahasan' => $agendaData['pembahasan'] ?? '',
                    'status' => $agendaData['keputusan'] ?? '',
                    'notulen_id' => $notulen->id,
                ]);
            }
        }

        // Simpan presensi kehadiran (dengan struktur polymorphic baru)
        if ($request->has('attendees') && is_array($request->get('attendees'))) {
            // Link presensi ke notulen yang baru dibuat
            $presensiableId = $notulen->id;
            $presensiableType = Notulen::class;

            foreach ($request->get('attendees') as $anggotaId) {
                $anggota = Anggota::find($anggotaId);
                if ($anggota) {
                    $data = [
                        'peserta_nama' => $anggota->nama,
                        'user_id' => $anggota->users_id ?? null,
                        'presensiable_id' => $presensiableId,
                        'presensiable_type' => $presensiableType,
                        'keterangan_kehadiran' => 'Hadir',
                    ];

                    // Create if not exists (match by peserta_nama + presensiable)
                    PresensiKehadiran::firstOrCreate([
                        'peserta_nama' => $data['peserta_nama'],
                        'presensiable_id' => $data['presensiable_id'],
                        'presensiable_type' => $data['presensiable_type'],
                    ], $data);
                }
            }
        }

        // Handle file upload jika ada
        if ($request->hasFile('dokumentasi')) {
            foreach ($request->file('dokumentasi') as $file) {
                $path = $file->store('dokumentasi', 'public');
                $tipe = in_array($file->getClientOriginalExtension(), ['pdf', 'doc', 'docx']) ? 'file' : 'image';
                Dokumentasi::create([
                    'tipe' => $tipe,
                    'path' => $path,
                    'notulen_id' => $notulen->id,
                ]);
            }
        }

        return redirect()->route('backend.notulen.show', $notulen->id)
            ->with('success', 'Notulen berhasil ditambahkan');
    }

    /**
     * Display the specified resource.
     */
    public function show(Notulen $notulen)
    {
        $notulen->load('kegiatan', 'users', 'agenda', 'dokumentasi', 'pimpinan', 'notulis');
        return view('backend.notulen.show', compact('notulen'));
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Notulen $notulen)
    {
        $kegiatan = Kegiatan::all();
        $users = User::all();
        $anggota = Anggota::all();

        // Existing attendees (peserta_nama) for checking checkboxes
        $existingAttendees = PresensiKehadiran::where('presensiable_id', $notulen->id)
            ->where('presensiable_type', Notulen::class)
            ->pluck('peserta_nama')
            ->toArray();

        $notulen->load('agenda', 'dokumentasi');

        // Ensure tanggal_rapat is a Carbon instance so ->format() works in the view
        try {
            if (! $notulen->tanggal_rapat instanceof Carbon) {
                $notulen->tanggal_rapat = Carbon::parse($notulen->tanggal_rapat);
            }
        } catch (\Exception $e) {
            // If parsing fails, leave the value as-is; the view will fall back to old() or empty
        }

        return view('backend.notulen.edit', compact('notulen', 'kegiatan', 'users', 'anggota', 'existingAttendees'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, Notulen $notulen)
    {
        $validated = $request->validate([
            'judul_rapat' => 'required|string|max:255',
            'catatan_tambahan' => 'required|string',
            'tanggal_rapat' => 'required|date',
            'waktu_mulai' => 'required|date_format:H:i',
            'waktu_selesai' => 'nullable|date_format:H:i',
            'lokasi' => 'required|string|max:255',
            'tipe_rapat' => 'required|string|max:255',
            'pimpinan_rapat' => 'required|exists:anggota,id',
            'notulis_id' => 'required|exists:anggota,id',
            'agenda' => 'nullable|array',
            'agenda.*.pembahasan' => 'required_with:agenda|string',
            'agenda.*.keputusan' => 'required_with:agenda|string',
            'agenda.*.id' => 'nullable|exists:agenda,id',
            'attendees' => 'nullable|array',
            'attendees.*' => 'exists:anggota,id',
            'dokumentasi' => 'nullable|array|max:5',
            'dokumentasi.*' => 'file|mimes:jpeg,png,jpg,pdf,doc,docx|max:5120',
        ]);

        // Update notulen fields
        $notulen->update([
            'judul_rapat' => $validated['judul_rapat'],
            'catatan_tambahan' => $validated['catatan_tambahan'],
            'tanggal_rapat' => $validated['tanggal_rapat'],
            'waktu_mulai' => $validated['waktu_mulai'],
            'waktu_selesai' => $validated['waktu_selesai'] ?? null,
            'lokasi' => $validated['lokasi'],
            'tipe_rapat' => $validated['tipe_rapat'],
            'pimpinan_rapat_id' => $validated['pimpinan_rapat'],
            'notulis_id' => $validated['notulis_id'],
            'pimpinan_rapat_nama' => optional(Anggota::find($validated['pimpinan_rapat']))->nama ?? null,
            'notulis_nama' => optional(Anggota::find($validated['notulis_id']))->nama ?? null,
        ]);

        // Handle agenda: update existing or create new
        if ($request->has('agenda') && is_array($request->get('agenda'))) {
            foreach ($request->get('agenda') as $agendaData) {
                if (!empty($agendaData['id'])) {
                    $agenda = Agenda::find($agendaData['id']);
                    if ($agenda) {
                        $agenda->update([
                            'topik' => $agendaData['topik'] ?? $agendaData['pembahasan'] ?? 'Agenda Item',
                            'hasil_pembahasan' => $agendaData['pembahasan'] ?? '',
                            'status' => $agendaData['keputusan'] ?? '',
                        ]);
                    }
                } else {
                    Agenda::create([
                        'topik' => $agendaData['topik'] ?? $agendaData['pembahasan'] ?? 'Agenda Item',
                        'hasil_pembahasan' => $agendaData['pembahasan'] ?? '',
                        'status' => $agendaData['keputusan'] ?? '',
                        'notulen_id' => $notulen->id,
                    ]);
                }
            }
        }

        // Update presensi: remove existing for this notulen and recreate from attendees
        PresensiKehadiran::where('presensiable_id', $notulen->id)
            ->where('presensiable_type', Notulen::class)
            ->delete();

        if ($request->has('attendees') && is_array($request->get('attendees'))) {
            foreach ($request->get('attendees') as $anggotaId) {
                $anggota = Anggota::find($anggotaId);
                if ($anggota) {
                    PresensiKehadiran::create([
                        'peserta_nama' => $anggota->nama,
                        'user_id' => $anggota->users_id ?? null,
                        'presensiable_id' => $notulen->id,
                        'presensiable_type' => Notulen::class,
                        'keterangan_kehadiran' => 'Hadir',
                    ]);
                }
            }
        }

        // Handle file upload jika ada (menambahkan file baru)
        if ($request->hasFile('dokumentasi')) {
            foreach ($request->file('dokumentasi') as $file) {
                $path = $file->store('dokumentasi', 'public');
                $tipe = in_array($file->getClientOriginalExtension(), ['pdf', 'doc', 'docx']) ? 'file' : 'image';
                Dokumentasi::create([
                    'tipe' => $tipe,
                    'path' => $path,
                    'notulen_id' => $notulen->id,
                ]);
            }
        }

        return redirect()->route('backend.notulen.show', $notulen->id)
            ->with('success', 'Notulen berhasil diperbarui');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Notulen $notulen)
    {
        // Soft delete (archive) the notulen
        $notulen->delete();

        return redirect()->route('backend.notulen.index')
            ->with('success', 'Notulen berhasil diarsipkan.');
    }

    /**
     * Restore a soft-deleted notulen.
     */
    public function restore($id)
    {
        try {
            $notulen = Notulen::withTrashed()->findOrFail($id);
            $notulen->restore();

            return redirect()->route('backend.notulen.archive')
                ->with('success', 'Notulen berhasil dipulihkan.');
        } catch (\Exception $e) {
            return redirect()->route('backend.notulen.archive')
                ->with('error', 'Gagal memulihkan notulen: ' . $e->getMessage());
        }
    }

    /**
     * Permanently delete a soft-deleted notulen.
     */
    public function forceDelete($id)
    {
        try {
            $notulen = Notulen::withTrashed()->findOrFail($id);

            // Delete related files
            if ($notulen->dokumentasi()->exists()) {
                foreach ($notulen->dokumentasi as $doc) {
                    if ($doc->path && file_exists(storage_path('app/public/' . $doc->path))) {
                        unlink(storage_path('app/public/' . $doc->path));
                    }
                    $doc->delete();
                }
            }

            // Delete related agenda
            $notulen->agenda()->forceDelete();

            // Delete related presensi kehadiran
            PresensiKehadiran::where('presensiable_id', $notulen->id)
                ->where('presensiable_type', Notulen::class)
                ->delete();

            // Permanently delete the notulen
            $notulen->forceDelete();

            return redirect()->route('backend.notulen.archive')
                ->with('success', 'Notulen berhasil dihapus secara permanen.');
        } catch (\Exception $e) {
            return redirect()->route('backend.notulen.archive')
                ->with('error', 'Gagal menghapus notulen: ' . $e->getMessage());
        }
    }

    /**
     * Download notulen as PDF
     */
    public function downloadPdf(Notulen $notulen)
    {
        $pdf = app('dompdf.wrapper');
        $pdf->loadView('backend.notulen.pdf', compact('notulen'));

        $fileName = 'notulen-' . ($notulen->id) . '-' . now()->format('Ymd') . '.pdf';
        return $pdf->download($fileName);
    }
}

