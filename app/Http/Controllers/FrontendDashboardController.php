<?php

namespace App\Http\Controllers;

use App\Models\Konten;
use Illuminate\Http\Request;

class FrontendDashboardController extends Controller
{
    public function index()
    {
        // Ambil 3 konten terbaru untuk ditampilkan di carousel
        $carouselKonten = Konten::latest()->take(3)->get();
        $latestNews = Konten::latest()->take(6)->get();

        return view('frontend.dashboard.index', [
            'carouselKonten' => $carouselKonten,
            'latestNews' => $latestNews
        ]);
    }
}
