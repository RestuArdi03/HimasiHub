<!-- About Start -->
    <div class="container-xxl py-5">
        <div class="container">
            <div class="row g-5">
                <div class="col-lg-6 wow fadeInUp text-center" data-wow-delay="0.1s">
                    <h6 class="section-title bg-white text-center text-primary px-3">Kalender Kegiatan</h6>
                    <h1 class="mb-4">Jadwal Acara</h1>
                    @include('frontend.dashboard._calendar')
                </div>
                <div class="col-lg-6 wow fadeInUp text-center" data-wow-delay="0.3s">
                    <h6 class="section-title bg-white text-center text-primary px-3">Tentang Kami</h6>
                    <h1 class="mb-4 text-center">Apa Itu Himasi?</h1>
                    <p class="mb-4 text-start">HIMASI adalah salah satu organisasi kemahasiswaan yang mewadahi mahasiswa Fakultas Teknik dan Informatika Prodi Sistem Informasi Universitas Bina Sarana Informatika Kampus Kota Yogyakarta dalam bidang akademik maupun non akademik.</p>
                    <p class="mb-4 text-start">Sebagai organisasi mahasiswa yang berkomitmen pada pengembangan diri, akademik, dan kontribusi sosial, HIMASI senantiasa meneguhkan arah gerak melalui visi, misi, serta maksud dan tujuan yang jelas. Rumusan ini menjadi pedoman bersama dalam setiap langkah, memastikan bahwa setiap program, kegiatan, dan inovasi yang dijalankan senantiasa selaras dengan nilai-nilai organisasi. Dengan landasan tersebut, HIMASI hadir bukan hanya sebagai wadah kebersamaan, tetapi juga sebagai motor penggerak perubahan positif di lingkungan kampus dan masyarakat.</p>
                    <a class="btn btn-primary py-3 px-5 mt-2" href="{{ route('frontend.about.index') }}">Read More</a>
                </div>
            </div>
        </div>
    </div>
    <!-- About End -->