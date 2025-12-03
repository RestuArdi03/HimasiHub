<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\Notulen;
use App\Models\Agenda;
use App\Models\User;
use App\Models\PresensiKehadiran;
use App\Models\Anggota;

class NotulenSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        // Dapatkan data yang diperlukan
        $users = User::limit(3)->get();
        $anggota = Anggota::limit(5)->get();

        // Jika belum ada kegiatan, skip
        if ($users->isEmpty()) {
            $this->command->warn('User tidak ditemukan. Lewati NotulenSeeder.');
            return;
        }

        // Buat notulen pertama
        $userPertama = $users->first();
        $namaPimpinan1 = $userPertama->nama ?? 'Pimpinan Rapat';
        
        $notulen1 = Notulen::create([
            'judul_rapat' => 'Notulen Rapat Koordinasi HIMASI - Bersama pihak GMedia',
            'catatan_tambahan' => 'Rapat membahas kolaborasi dengan GMedia untuk event besar HIMASI tahun ini. Dihadiri oleh ketua, sekretaris, bendahara, dan beberapa anggota inti. Diskusi mencakup timeline, budget, dan tanggung jawab masing-masing divisi.',
            'tanggal_rapat' => now()->format('Y-m-d'),
            'waktu_mulai' => '16:00',
            'waktu_selesai' => '17:45',
            'lokasi' => 'Ruang Rapat HIMASI UBSI Yogyakarta',
            'tipe_rapat' => 'Koordinasi',
            'pimpinan_rapat_nama' => $namaPimpinan1,
            'pimpinan_rapat_id' => $userPertama->id,
            'notulis_nama' => $namaPimpinan1,
            'notulis_id' => $userPertama->id,
        ]);

        // Tambah agenda untuk notulen 1
        Agenda::create([
            'topik' => 'GMedia Collaboration',
            'hasil_pembahasan' => 'Persetujuan Kerjasama dengan GMedia',
            'status' => 'Setujui kerjasama dengan GMedia untuk acara besar, Koordinator: Ketua HIMASI',
            'notulen_id' => $notulen1->id,
        ]);

        Agenda::create([
            'topik' => 'Event Timeline',
            'hasil_pembahasan' => 'Timeline dan Jadwal Event',
            'status' => 'Event akan dilaksanakan pada tanggal 28 November 2025, Koordinator: Humas',
            'notulen_id' => $notulen1->id,
        ]);

        Agenda::create([
            'topik' => 'Budget Allocation',
            'hasil_pembahasan' => 'Alokasi Budget',
            'status' => 'Budget sebesar Rp 50.000.000 untuk acara, Koordinator: Bendahara',
            'notulen_id' => $notulen1->id,
        ]);

        // Tambah presensi untuk notulen 1
        if ($anggota->count() >= 3) {
            foreach ($anggota->take(3) as $member) {
                PresensiKehadiran::create([
                    'peserta_nama' => $member->nama ?? 'Peserta',
                    'user_id' => $users->first()->id ?? null,
                    'presensiable_id' => $notulen1->id,
                    'presensiable_type' => Notulen::class,
                    'keterangan_kehadiran' => 'Hadir',
                ]);
            }
        }

        // Buat notulen kedua
        if ($users->count() > 1) {
            $userKedua = $users->get(1);
            $namaPimpinan2 = $userKedua->nama ?? 'Pimpinan Rapat 2';
            
            $notulen2 = Notulen::create([
                'judul_rapat' => 'Notulen Rapat Rutin Bulanan HIMASI - 24/10/2025',
                'catatan_tambahan' => 'Rapat rutin bulanan membahas progress project-project yang sedang berjalan dan perencanaan bulan depan. Semua divisi melaporkan status mereka masing-masing.',
                'tanggal_rapat' => now()->addDays(3)->format('Y-m-d'),
                'waktu_mulai' => '18:30',
                'waktu_selesai' => '20:00',
                'lokasi' => 'Aula Kampus UBSI',
                'tipe_rapat' => 'Rutin',
                'pimpinan_rapat_nama' => $namaPimpinan2,
                'pimpinan_rapat_id' => $userKedua->id,
                'notulis_nama' => $namaPimpinan2,
                'notulis_id' => $userKedua->id,
            ]);

            // Tambah agenda untuk notulen 2
            Agenda::create([
                'topik' => 'Divisi Progress',
                'hasil_pembahasan' => 'Laporan Progress Divisi',
                'status' => 'Semua divisi melaporkan progress. Ada 3 divisi yang perlu akselerasi program. Tindak lanjut: Review ulang timeline project.',
                'notulen_id' => $notulen2->id,
            ]);

            Agenda::create([
                'topik' => 'Budget Proposal',
                'hasil_pembahasan' => 'Pengajuan Anggaran Baru',
                'status' => 'Pengajuan anggaran untuk program edukasi ditolak sementara, diminta untuk revisi proposal. Deadline resubmisi: 5 November 2025',
                'notulen_id' => $notulen2->id,
            ]);

            // Tambah presensi untuk notulen 2
            if ($anggota->count() >= 4) {
                foreach ($anggota->skip(2)->take(4) as $member) {
                    PresensiKehadiran::firstOrCreate([
                        'peserta_nama' => $member->nama ?? 'Peserta',
                        'user_id' => $users->get(1)->id ?? null,
                        'presensiable_id' => $notulen2->id,
                        'presensiable_type' => Notulen::class,
                        'keterangan_kehadiran' => 'Hadir',
                    ]);
                }
            }
        }

        // Buat notulen ketiga
        if ($users->count() > 2) {
            $userKetiga = $users->get(2);
            $namaPimpinan3 = $userKetiga->nama ?? 'Pimpinan Rapat 3';
            
            $notulen3 = Notulen::create([
                'judul_rapat' => 'Notulen Rapat Evaluasi Kepengurusan HIMASI',
                'catatan_tambahan' => 'Rapat evaluasi kinerja kepengurusan periode saat ini. Dihadiri oleh pimpinan rapat dan ketua-ketua divisi. Diskusi fokus pada pencapaian KPI dan hambatan yang dihadapi.',
                'tanggal_rapat' => now()->addDays(5)->format('Y-m-d'),
                'waktu_mulai' => '14:30',
                'waktu_selesai' => '16:45',
                'lokasi' => 'Ruang Meeting HIMASI',
                'tipe_rapat' => 'Evaluasi',
                'pimpinan_rapat_nama' => $namaPimpinan3,
                'pimpinan_rapat_id' => $userKetiga->id,
                'notulis_nama' => $namaPimpinan3,
                'notulis_id' => $userKetiga->id,
            ]);

            // Tambah agenda untuk notulen 3
            Agenda::create([
                'topik' => 'KPI Achievement',
                'hasil_pembahasan' => 'Pencapaian KPI Kepengurusan',
                'status' => 'Pencapaian KPI sudah mencapai 85% dari target. Beberapa KPI belum tercapai akan dibahas dalam rapat khusus minggu depan.',
                'notulen_id' => $notulen3->id,
            ]);

            Agenda::create([
                'topik' => 'Work Plan Preparation',
                'hasil_pembahasan' => 'Penyusunan Rencana Kerja Kepengurusan Baru',
                'status' => 'Tim inti akan menyusun rencana kerja untuk kepengurusan baru. Deadline: 10 November 2025. Presentasi: 15 November 2025',
                'notulen_id' => $notulen3->id,
            ]);
        }

        $this->command->info('NotulenSeeder berhasil dijalankan.');
    }
}
