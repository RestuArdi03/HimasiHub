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
    public function index()
    {
        $notulen = Notulen::with('kegiatan', 'users', 'agenda')
            ->orderBy('created_at', 'DESC')
            ->paginate(15);
        
        return view('backend.notulen.index', compact('notulen'));
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
            'pimpinan_rapat' => 'required|exists:users,id',
            'notulis_id' => 'required|exists:users,id',
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
            'pimpinan_rapat_nama' => User::find($validated['pimpinan_rapat'])->nama,
            'notulis_nama' => User::find($validated['notulis_id'])->nama,
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
        $notulen->load('kegiatan', 'users', 'agenda', 'dokumentasi');
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
            'pimpinan_rapat' => 'required|exists:users,id',
            'notulis_id' => 'required|exists:users,id',
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
            'pimpinan_rapat_nama' => User::find($validated['pimpinan_rapat'])->nama,
            'notulis_nama' => User::find($validated['notulis_id'])->nama,
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
        try {
            // Delete related files
            if ($notulen->dokumentasi()->exists()) {
                foreach ($notulen->dokumentasi as $doc) {
                    if ($doc->file_path && file_exists(storage_path('app/public/' . $doc->file_path))) {
                        unlink(storage_path('app/public/' . $doc->file_path));
                    }
                    $doc->delete();
                }
            }

            // Delete related agenda
            if ($notulen->agenda()->exists()) {
                $notulen->agenda()->delete();
            }

            // Delete related presensi kehadiran
            PresensiKehadiran::where('presensiable_id', $notulen->id)
                ->where('presensiable_type', Notulen::class)
                ->delete();

            // Delete the notulen itself
            $notulen->delete();

            return redirect()->route('backend.notulen.index')
                ->with('success', 'Notulen berhasil dihapus beserta semua data terkaitnya.');
        } catch (\Exception $e) {
            return redirect()->route('backend.notulen.index')
                ->with('error', 'Gagal menghapus notulen: ' . $e->getMessage());
        }
    }
}

