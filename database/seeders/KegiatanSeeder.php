<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\PimpinanKegiatan;
use App\Models\Kegiatan;
use App\Models\User;

class KegiatanSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        // Dapatkan user pertama sebagai pimpinan
        $pimpinan = User::first();
        
        if (!$pimpinan) {
            $this->command->warn('User tidak ditemukan. Lewati KegiatanSeeder.');
            return;
        }

        // Buat pimpinan kegiatan
        $pimpinanKegiatan = PimpinanKegiatan::create([
            'users_id' => $pimpinan->id,
        ]);

        // Buat kegiatan
        $kegiatan1 = Kegiatan::create([
            'nama' => 'Rapat Koordinasi HIMASI - Bersama pihak GMedia',
            'tipe' => 'Rapat Koordinasi',
            'waktu_mulai' => now()->setTime(16, 0),
            'tempat' => 'Ruang Rapat HIMASI UBSI Yogyakarta',
            'waktu_selesai' => now()->setTime(17, 45),
            'pimpinan_kegiatan_id' => $pimpinanKegiatan->id,
        ]);

        $kegiatan2 = Kegiatan::create([
            'nama' => 'Rapat Rutin Bulanan HIMASI',
            'tipe' => 'Rapat Rutin',
            'waktu_mulai' => now()->addDays(3)->setTime(18, 30),
            'tempat' => 'Aula Kampus UBSI',
            'waktu_selesai' => now()->addDays(3)->setTime(20, 0),
            'pimpinan_kegiatan_id' => $pimpinanKegiatan->id,
        ]);

        $kegiatan3 = Kegiatan::create([
            'nama' => 'Rapat Evaluasi Kepengurusan HIMASI',
            'tipe' => 'Rapat Evaluasi',
            'waktu_mulai' => now()->addDays(5)->setTime(14, 30),
            'tempat' => 'Ruang Meeting HIMASI',
            'waktu_selesai' => now()->addDays(5)->setTime(16, 45),
            'pimpinan_kegiatan_id' => $pimpinanKegiatan->id,
        ]);

        $this->command->info('KegiatanSeeder berhasil dijalankan.');
    }
}
