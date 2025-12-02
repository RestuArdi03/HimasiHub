<?php

namespace App\Http\Controllers\Backend;

use App\Http\Controllers\Controller;
use App\Models\Diskusi;
use App\Models\Kegiatan;
use App\Models\Konten; // Digunakan untuk total berita
use App\Models\User;
use App\Models\Saldo;
use App\Models\Pesan; // Digunakan untuk pesan masuk

class DashboardController extends Controller
{
    /**
     * Display the dashboard page.
     */
    public function index()
    {
        // Ambil total saldo
        $total_saldo = Saldo::sum('balance');

        // Ambil pesan terakhir dari diskusi
        $pesan_terakhir = Diskusi::with('user.role')->latest()->first();

        // Mengambil data untuk ringkasan di dashboard
        $data = [
            'total_posts' => Konten::count(), // Menghitung semua konten sebagai berita
            'total_kegiatan' => Kegiatan::count(),
            'total_users' => User::count(),
            'total_pesan' => Pesan::count(), // Menghitung total pesan masuk
            'kegiatan_terbaru' => Kegiatan::latest()->take(5)->get(),
            'total_saldo' => $total_saldo,
            'pesan_terakhir' => $pesan_terakhir,
        ];

        return view('backend.dashboard', $data);
    }
}
