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
            ['nama' => 'Marcus Dewantoro', 'nim' => '19240021', 'email' => '19240021@bsi.ac.id', 'password' => 'marcus123', 'role' => 'admin', 'jabatan_id' => 2, 'kelas' => '19.3A.09', 'instagram' => 'https://www.instagram.com/marcus_dewantoro?igsh=MXd6ZmxzZHJqbTRhcw=='],
            ['nama' => 'Christina Yuli Anggita', 'nim' => '19230947', 'email' => '19230947@bsi.ac.id', 'password' => 'chritina123', 'role' => 'sekretaris', 'jabatan_id' => 3, 'kelas' => '19.5A.09', 'instagram' => 'https://www.instagram.com/christa.llen?igsh=b3p1Z3JuMzNrdWho'],
            ['nama' => 'Zahra Salsabila Afifah', 'nim' => '19240328', 'email' => '19240328@bsi.ac.id', 'password' => 'zahra123', 'role' => 'sekretaris', 'jabatan_id' => 3, 'kelas' => '19.3A.09', 'instagram' => 'https://www.instagram.com/zhrsbilaf?igsh=bTNoemFndjluOXEz' ],
            ['nama' => 'Bara Rifki Annajib', 'nim' => '19230480', 'email' => '19230480@bsi.ac.id', 'password' => 'bara123', 'role' => 'bendahara', 'jabatan_id' => 4, 'kelas' => '19.5A.09', 'instagram' => 'https://www.instagram.com/nabara.rifki?igsh=YnhnNmdrczRsOGhs'],
            ['nama' => 'Rifatun Nisa', 'nim' => '19240339', 'email' => '19240339@bsi.ac.id', 'password' => 'rifatun123', 'role' => 'bendahara', 'jabatan_id' => 4, 'kelas' => '19.3A.09', 'instagram' => 'https://www.instagram.com/rftun?igsh=dW1jcGI4eXJqd3cz'],
            ['nama' => 'Dhorifa Habibie Yute Pramono', 'nim' => '19230088', 'email' => '19230088@bsi.ac.id', 'password' => 'dhorifa123', 'role' => 'humas', 'jabatan_id' => 5, 'kelas' => '19.5A.09'],
            ['nama' => 'Aura Ayunda Putri', 'nim' => '19240514', 'email' => '19240514@bsi.ac.id', 'password' => 'aura123', 'role' => 'humas', 'jabatan_id' => 5, 'kelas' => '19.3A.09', 'instagram' => 'https://www.instagram.com/auraynda?igsh=cHhnaXJjZ3VyeDE1'],
            ['nama' => 'Resya Syahroni Putri', 'nim' => '19241343', 'email' => '19241343@bsi.ac.id', 'password' => 'resya123', 'role' => 'humas', 'jabatan_id' => 5, 'kelas' => '19.3A.09', 'instagram' => 'https://www.instagram.com/rcyscp_?igsh=MW0weG0wYWFuNDZ3Yw=='],
            ['nama' => 'Aisyah Atha Khalila', 'nim' => '19242266', 'email' => '19242266@bsi.ac.id', 'password' => 'aisyah123', 'role' => 'humas', 'jabatan_id' => 5, 'kelas' => '19.3A.09', 'instagram' => 'https://www.instagram.com/aisyahath.a?igsh=MWw5dmI0cWNkb3Jkdw=='],
            ['nama' => 'Illona Reva Auryn', 'nim' => '19232016', 'email' => '19232016@bsi.ac.id', 'password' => 'illona123', 'role' => 'pengurus lain', 'jabatan_id' => 6, 'kelas' => '19.5A.09', 'instagram' => 'https://www.instagram.com/illona.rv12_ryn?igsh=MWFkbmd1ZGYyaGsxeQ=='],
            ['nama' => 'Putri Fiki Amalina', 'nim' => '19240981', 'email' => '19240981@bsi.ac.id', 'password' => 'putri123', 'role' => 'pengurus lain', 'jabatan_id' => 6, 'kelas' => '19.3A.09', 'instagram' => 'https://www.instagram.com/ptkyamaa?igsh=MXg4ZXhoOGY1d2Jjbg=='],
            ['nama' => 'Adellima Putri', 'nim' => '19241581', 'email' => '19241581@bsi.ac.id', 'password' => 'adellima123', 'role' => 'pengurus lain', 'jabatan_id' => 6, 'kelas' => '19.3A.09', 'instagram' => 'https://www.instagram.com/_dellimaptri?igsh=MWE1M210YTlwY2JvYQ=='],
            ['nama' => 'Evapras Kurniawan Panji Saputra', 'nim' => '19231373', 'email' => '19231373@bsi.ac.id', 'password' => 'evapras123', 'role' => 'pengurus lain', 'jabatan_id' => 7, 'kelas' => '19.5A.09', 'instagram' => 'https://www.instagram.com/panji_saputra013?igsh=eWhka2o4bWlsc3o3'],
            ['nama' => 'Faiz Aji Nugroho', 'nim' => '19230441', 'email' => '19230441@bsi.ac.id', 'password' => 'faiz123', 'role' => 'pengurus lain', 'jabatan_id' => 7, 'kelas' => '19.5A.09', 'instagram' => 'https://www.instagram.com/faiz_112aji?igsh=MW12dzlkd2lwZDRuZw=='],
            ['nama' => 'Eka Dirga Jayanta', 'nim' => '19240182', 'email' => '19240182@bsi.ac.id', 'password' => 'eka123', 'role' => 'pengurus lain', 'jabatan_id' => 7, 'kelas' => '19.3A.09', 'instagram' => 'https://www.instagram.com/eksdirga?igsh=Mm9qNGdrYndsejJt'],
            ['nama' => 'Reihan Ramadhan Tualeka', 'nim' => '19240652', 'email' => '19240652@bsi.ac.id', 'password' => 'reihan123', 'role' => 'pengurus lain', 'jabatan_id' => 7, 'kelas' => '19.3A.09'],
            ['nama' => 'Indira Akbar Agung Kurniawan', 'nim' => '19230988', 'email' => '19230988@bsi.ac.id', 'password' => 'indira123', 'role' => 'pengurus lain', 'jabatan_id' => 8, 'kelas' => '19.5A.09', 'instagram' => 'https://www.instagram.com/indiraagung2542?igsh=MXB4emtueW9iajJxZg=='],
            ['nama' => 'Dhimas Abdi Pangestu', 'nim' => '19240990', 'email' => '19240990@bsi.ac.id', 'password' => 'dhimas123', 'role' => 'pengurus lain', 'jabatan_id' => 8, 'kelas' => '19.3A.09', 'instagram' => 'https://www.instagram.com/_.dhims?igsh=MTZ4NG95cWdpMGpsZA=='],
            ['nama' => 'Mustaqim Kumara Prabhatakala', 'nim' => '19241642', 'email' => '19241642@bsi.ac.id', 'password' => 'mustaqim123', 'role' => 'pengurus lain', 'jabatan_id' => 8, 'kelas' => '19.3A.09', 'instagram' => 'https://www.instagram.com/mustaqim_kmr_p?igsh=MWtpN2d1OWVjeWIxMA=='],
            ['nama' => 'Ambrosius Roy Kadju', 'nim' => '19241610', 'email' => '19241610@bsi.ac.id', 'password' => 'ambrosius123', 'role' => 'pengurus lain', 'jabatan_id' => 8, 'kelas' => '19.3A.09', 'instagram' => 'https://www.instagram.com/roy.kadju?igsh=bzE3aWU4b3ZzNzY0' ],
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