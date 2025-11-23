<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class AnggotaSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        DB::table('anggota')->insert([
            ['nama' => 'Restu Ardi Putranto', 'nim' => '19232150', 'kelas' => '19.5A.09', 'jurusan' => 'Sistem Informasi', 'no_hp' => null, 'jabatan_id' => '1', 'alamat' => null, 'foto' => null, 'created_at' => now(), 'updated_at' => now()],
            ['nama' => 'Marcus Dewantoro', 'nim' => '19240021', 'kelas' => '19.3A.09', 'jurusan' => 'Sistem Informasi', 'no_hp' => null, 'jabatan_id' => '2', 'alamat' => null, 'foto' => null, 'created_at' => now(), 'updated_at' => now()],
            ['nama' => 'Christina Yuli Anggita', 'nim' => '19230947', 'kelas' => '19.5A.09', 'jurusan' => 'Sistem Informasi', 'no_hp' => null, 'jabatan_id' => '3', 'alamat' => null, 'foto' => null, 'created_at' => now(), 'updated_at' => now()],
            ['nama' => 'Zahra Salsabila Afifah', 'nim' => '19240328', 'kelas' => '19.3A.09', 'jurusan' => 'Sistem Informasi', 'no_hp' => null, 'jabatan_id' => '3', 'alamat' => null, 'foto' => null, 'created_at' => now(), 'updated_at' => now()],
            ['nama' => 'Bara Rifki Annajib', 'nim' => '19230480', 'kelas' => '19.5A.09', 'jurusan' => 'Sistem Informasi', 'no_hp' => null, 'jabatan_id' => '4', 'alamat' => null, 'foto' => null, 'created_at' => now(), 'updated_at' => now()],
            ['nama' => 'Rifatun Nisa', 'nim' => '19240339', 'kelas' => '19.3A.09', 'jurusan' => 'Sistem Informasi', 'no_hp' => null, 'jabatan_id' => '4', 'alamat' => null, 'foto' => null, 'created_at' => now(), 'updated_at' => now()],
            ['nama' => 'Dhorifa Habibie Yute Pramono', 'nim' => '19230088', 'kelas' => '19.5A.09', 'jurusan' => 'Sistem Informasi', 'no_hp' => null, 'jabatan_id' => '5', 'alamat' => null, 'foto' => null, 'created_at' => now(), 'updated_at' => now()],
            ['nama' => 'Aura Ayunda Putri', 'nim' => '19240514', 'kelas' => '19.3A.09', 'jurusan' => 'Sistem Informasi', 'no_hp' => null, 'jabatan_id' => '5', 'alamat' => null, 'foto' => null, 'created_at' => now(), 'updated_at' => now()],
            ['nama' => 'Dhimas Abdi Pangestu', 'nim' => '19240990', 'kelas' => '19.3A.09', 'jurusan' => 'Sistem Informasi', 'no_hp' => null, 'jabatan_id' => '5', 'alamat' => null, 'foto' => null, 'created_at' => now(), 'updated_at' => now()],
            ['nama' => 'Eka Dirga Jayanta', 'nim' => '19240182', 'kelas' => '19.3A.09', 'jurusan' => 'Sistem Informasi', 'no_hp' => null, 'jabatan_id' => '5', 'alamat' => null, 'foto' => null, 'created_at' => now(), 'updated_at' => now()],
            ['nama' => 'Putri Fiki Amalina', 'nim' => '19240981', 'kelas' => '19.3A.09', 'jurusan' => 'Sistem Informasi', 'no_hp' => null, 'jabatan_id' => '6', 'alamat' => null, 'foto' => null, 'created_at' => now(), 'updated_at' => now()],
            ['nama' => 'Illona Reva Auryn', 'nim' => '19232016', 'kelas' => '19.5A.09', 'jurusan' => 'Sistem Informasi', 'no_hp' => null, 'jabatan_id' => '6', 'alamat' => null, 'foto' => null, 'created_at' => now(), 'updated_at' => now()],
            ['nama' => 'Aisyah Atha Khalila', 'nim' => '19242266', 'kelas' => '19.3A.09', 'jurusan' => 'Sistem Informasi', 'no_hp' => null, 'jabatan_id' => '6', 'alamat' => null, 'foto' => null, 'created_at' => now(), 'updated_at' => now()],
            ['nama' => 'Adellima Putri', 'nim' => '19241581', 'kelas' => '19.3A.09', 'jurusan' => 'Sistem Informasi', 'no_hp' => null, 'jabatan_id' => '6', 'alamat' => null, 'foto' => null, 'created_at' => now(), 'updated_at' => now()],
            ['nama' => 'Resya Sahroni Putri', 'nim' => '19241343', 'kelas' => '19.3A.09', 'jurusan' => 'Sistem Informasi', 'no_hp' => null, 'jabatan_id' => '7', 'alamat' => null, 'foto' => null, 'created_at' => now(), 'updated_at' => now()],
            ['nama' => 'Indira Akbar Agung Kurniawan', 'nim' => '19230988', 'kelas' => '19.5A.09', 'jurusan' => 'Sistem Informasi', 'no_hp' => null, 'jabatan_id' => '7', 'alamat' => null, 'foto' => null, 'created_at' => now(), 'updated_at' => now()],
            ['nama' => 'Evapras Kurniawan Panji Saputra', 'nim' => '19231373', 'kelas' => '19.5A.09', 'jurusan' => 'Sistem Informasi', 'no_hp' => null, 'jabatan_id' => '7', 'alamat' => null, 'foto' => null, 'created_at' => now(), 'updated_at' => now()],
            ['nama' => 'Faiz Aji Nugroho', 'nim' => '19230441', 'kelas' => '19.5A.09', 'jurusan' => 'Sistem Informasi', 'no_hp' => null, 'jabatan_id' => '8', 'alamat' => null, 'foto' => null, 'created_at' => now(), 'updated_at' => now()],
            ['nama' => 'Mustaqim Kumara Prabhatakala', 'nim' => '19241642', 'kelas' => '19.3A.09', 'jurusan' => 'Sistem Informasi', 'no_hp' => null, 'jabatan_id' => '8', 'alamat' => null, 'foto' => null, 'created_at' => now(), 'updated_at' => now()],
            ['nama' => 'Reihan Ramadhan Tualeka', 'nim' => '19240652', 'kelas' => '19.3A.09', 'jurusan' => 'Sistem Informasi', 'no_hp' => null, 'jabatan_id' => '8', 'alamat' => null, 'foto' => null, 'created_at' => now(), 'updated_at' => now()],
            ['nama' => 'Ambrosius Roy Kadju', 'nim' => '19241610', 'kelas' => '19.3A.09', 'jurusan' => 'Sistem Informasi', 'no_hp' => null, 'jabatan_id' => '8', 'alamat' => null, 'foto' => null, 'created_at' => now(), 'updated_at' => now()],
        ]);
    }
}
