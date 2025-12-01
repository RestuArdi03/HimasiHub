<?php

namespace App\Http\Controllers;

use App\Models\Kegiatan;
use Illuminate\Http\Request;

class KegiatanController extends Controller
{
    /**
     * Menampilkan halaman kalender kegiatan.
     */
    public function kalender()
    {
        return view('kegiatan.kalender');
    }

    /**
     * Menyediakan data kegiatan untuk kalender (API endpoint).
     */
    public function getEvents(Request $request)
    {
        $events = Kegiatan::all()->map(function ($kegiatan) {
            return [
                'title' => $kegiatan->nama,
                'start' => $kegiatan->waktu_mulai,
                'end' => $kegiatan->waktu_selesai,
                'extendedProps' => [
                    'tipe' => $kegiatan->tipe,
                    'tempat' => $kegiatan->tempat,
                ]
            ];
        });

        return response()->json($events);
    }
}
