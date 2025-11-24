<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class JabatanSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        DB::table('jabatan')->insert([
            ['nama_jabatan' => 'Ketua', 'kode_jabatan' => '1', 'created_at' => now(), 'updated_at' => now()],
            ['nama_jabatan' => 'Wakil Ketua', 'kode_jabatan' => '2', 'created_at' => now(), 'updated_at' => now()],
            ['nama_jabatan' => 'Sekretaris', 'kode_jabatan' => '3', 'created_at' => now(), 'updated_at' => now()],
            ['nama_jabatan' => 'Bendahara', 'kode_jabatan' => '4', 'created_at' => now(), 'updated_at' => now()],
            ['nama_jabatan' => 'Divisi Humas', 'kode_jabatan' => '5', 'created_at' => now(), 'updated_at' => now()],
            ['nama_jabatan' => 'Divisi Manajer Proyek', 'kode_jabatan' => '6', 'created_at' => now(), 'updated_at' => now()],
            ['nama_jabatan' => 'Divisi PDD', 'kode_jabatan' => '7', 'created_at' => now(), 'updated_at' => now()],
            ['nama_jabatan' => 'Divisi Perlengkapan', 'kode_jabatan' => '8', 'created_at' => now(), 'updated_at' => now()],
        ]);
    }
}
