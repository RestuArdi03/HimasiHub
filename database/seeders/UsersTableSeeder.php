<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\User;
use App\Models\Anggota;
use App\Models\Role;
use Illuminate\Support\Facades\Hash;

class UsersTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        // Ambil role-role yang dibutuhkan sekali saja untuk efisiensi
        $roles = Role::whereIn('nama_role', ['admin', 'sekretaris', 'bendahara', 'humas', 'pengurus lain'])
            ->pluck('id', 'nama_role');

        // Create admin user
        User::create([
            'nama' => 'Admin HimasiHub',
            'email' => 'admin@himasihub.test',
            'email_verified_at' => now(),
            'password' => Hash::make('admin123'),
            'role_id' => $roles['admin']
        ]);

        // Data anggota
        $anggotaData = [
            ['nama' => 'Restu Ardi Putranto', 'nim' => '19232150', 'email' => '19232150@bsi.ac.id', 'password' => 'restu123', 'role' => 'admin', 'jabatan_id' => 1, 'kelas' => '19.5A.09', 'instagram' => 'https://www.instagram.com/restuardi2003?igsh=MWdhOGI4OWxocGg3Ng=='],
            ['nama' => 'Marcus Dewantoro', 'nim' => '19240021', 'email' => '19240021@bsi.ac.id', 'password' => 'marcus123', 'role' => 'admin', 'jabatan_id' => 2, 'kelas' => '19.3A.09'],
            ['nama' => 'Christina Yuli Anggita', 'nim' => '19230947', 'email' => '19230947@bsi.ac.id', 'password' => 'chritina123', 'role' => 'sekretaris', 'jabatan_id' => 3, 'kelas' => '19.5A.09'],
            ['nama' => 'Zahra Salsabila Afifah', 'nim' => '19240328', 'email' => '19240328@bsi.ac.id', 'password' => 'zahra123', 'role' => 'sekretaris', 'jabatan_id' => 3, 'kelas' => '19.3A.09'],
            ['nama' => 'Bara Rifki Annajib', 'nim' => '19230480', 'email' => '19230480@bsi.ac.id', 'password' => 'bara123', 'role' => 'bendahara', 'jabatan_id' => 4, 'kelas' => '19.5A.09'],
            ['nama' => 'Rifatun Nisa', 'nim' => '19240339', 'email' => '19240339@bsi.ac.id', 'password' => 'rifatun123', 'role' => 'bendahara', 'jabatan_id' => 4, 'kelas' => '19.3A.09'],
            ['nama' => 'Aura Ayunda Putri', 'nim' => '19240514', 'email' => '19240514@bsi.ac.id', 'password' => 'aura123', 'role' => 'humas', 'jabatan_id' => 5, 'kelas' => '19.3A.09'],
            ['nama' => 'Putri Fiki Amalina', 'nim' => '19240981', 'email' => '19240981@bsi.ac.id', 'password' => 'putri123', 'role' => 'pengurus lain', 'jabatan_id' => 6, 'kelas' => '19.3A.09'],
        ];

        foreach ($anggotaData as $data) {
            // Buat user baru
            $user = User::create([
                'nama' => $data['nama'],
                'email' => $data['email'],
                'email_verified_at' => now(),
                'password' => Hash::make($data['password']),
                'role_id' => $roles[$data['role']]
            ]);

            // Buat anggota terkait
            $anggota = Anggota::create([
                'nim' => $data['nim'],
                'kelas' => $data['kelas'],
                'jurusan' => 'Sistem Informasi',
                'jabatan_id' => $data['jabatan_id'],
                'moto_hidup' => \Faker\Factory::create()->sentence(rand(5, 10)),
                'users_id' => $user->id,
                'instagram' => $data['instagram'] ?? null,
            ]);

            // Update user dengan anggota_id
            $user->anggota_id = $anggota->id;
            $user->save();
        }
    }
}