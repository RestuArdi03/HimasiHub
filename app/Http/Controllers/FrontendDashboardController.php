<?php

namespace App\Http\Controllers;

use App\Models\Konten;
use App\Models\Anggota;
use App\Models\Jabatan;
use Illuminate\Http\Request;

class FrontendDashboardController extends Controller
{
    public function index()
    {
        // Ambil 3 konten terbaru untuk ditampilkan di carousel
        $carouselKonten = Konten::latest()->take(3)->get();
        $latestNews = Konten::latest()->take(6)->get();
        $anggota = Anggota::all();
        $jabatan = Jabatan::all();

        return view('frontend.dashboard.index', [
            'carouselKonten' => $carouselKonten,
            'latestNews' => $latestNews,
            'anggota' => $anggota,
            'jabatan' => $jabatan
        ]);
    }
}
