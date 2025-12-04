<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use App\Models\KalenderKegiatan;

class KalenderKegiatanSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        KalenderKegiatan::create([
            'judul' => 'Rapat Internal Pengurus',
            'isi' => 'Membahas evaluasi program kerja bulan lalu.',
            'waktu_mulai' => now()->addDays(2)->setTime(10, 0),
            'waktu_selesai' => now()->addDays(2)->setTime(12, 0),
            'status' => 'backend', // Hanya tampil di kalender backend
        ]);

        KalenderKegiatan::create([
            'judul' => 'Webinar Nasional: AI di Dunia Kerja',
            'isi' => 'Webinar terbuka untuk umum mengenai implementasi AI.',
            'waktu_mulai' => now()->addDays(7)->setTime(13, 0),
            'waktu_selesai' => now()->addDays(7)->setTime(15, 0),
            'status' => 'frontend', // Hanya tampil di kalender frontend
        ]);

        KalenderKegiatan::create([
            'judul' => 'Kunjungan Industri ke GMedia',
            'isi' => 'Kunjungan industri untuk anggota HIMASI ke GMedia.',
            'waktu_mulai' => now()->addDays(10)->setTime(9, 0),
            'waktu_selesai' => now()->addDays(10)->setTime(16, 0),
            'status' => 'both', // Tampil di kedua kalender
        ]);

        $this->command->info('KalenderKegiatanSeeder berhasil dijalankan.');
    }
}
