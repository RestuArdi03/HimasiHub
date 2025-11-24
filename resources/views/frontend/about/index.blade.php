@extends('layouts.frontend')

@section('title', 'Tentang Kami - HimasiHub')

@section('content')
    <!-- Anggota Start -->
    <div class="container-xxl py-5">
        <div class="text-center wow fadeInUp" data-wow-delay="0.1s">
            <h6 class="section-title bg-white text-center text-primary px-3">Tentang Kami</h6>
            <h1 class="mb-5">Semua Tentang Himasi</h1>
        </div>
        <div class="row g-5">
            <div class="col-lg-6 wow fadeInUp" data-wow-delay="0.1s" style="min-height: 400px;">
                <div class="position-relative h-100">
                    <img class="img-fluid position-absolute w-100 h-100" src="{{ asset('asset/about.jpg') }}" alt="" style="object-fit: cover;">
                </div>
            </div>
            <div class="col-lg-6 wow fadeInUp" data-wow-delay="0.3s" style="text-align:justify">
                <h3 class="mb-4">Apa Itu Himasi?</h3>
                <p class="mb-4">HIMASI adalah salah satu organisasi kemahasiswaan yang mewadahi mahasiswa Fakultas Teknik dan Informatika, khususnya Program Studi Sistem Informasi Universitas Bina Sarana Informatika Kampus Kota Yogyakarta, dalam bidang akademik maupun non-akademik. Organisasi ini hadir sebagai wadah pengembangan potensi, kreativitas, serta solidaritas mahasiswa, sekaligus menjadi sarana untuk menyalurkan aspirasi, memperluas wawasan, dan meningkatkan kualitas diri melalui berbagai kegiatan yang terarah dan bermanfaat.</p>
                <p class="mb-4">Sebagai organisasi mahasiswa yang berkomitmen pada pengembangan diri, akademik, dan kontribusi sosial, HIMASI senantiasa meneguhkan arah gerak melalui visi, misi, serta maksud dan tujuan yang jelas. Rumusan ini menjadi pedoman bersama dalam setiap langkah, memastikan bahwa setiap program, kegiatan, dan inovasi yang dijalankan senantiasa selaras dengan nilai-nilai organisasi. Dengan landasan tersebut, HIMASI hadir bukan hanya sebagai wadah kebersamaan, tetapi juga sebagai motor penggerak perubahan positif di lingkungan kampus dan masyarakat.</p>
            </div>
        </div>
        {{-- <div class="row g-5 mt-5">
            <div class="col-lg-6 wow fadeInUp" data-wow-delay="0.3s" style="text-align:justify">
                <h3 class="mb-4 mt-5">Visi</h3>
                <p class="mb-4">Menjadikan organisasi dengan meningkatkan jiwa kreatif dan komunikatif yang akan menghasilkan inovasi baru dan berkualitas.</p>
                <h3 class="mb-4">Misi</h3>
                <p class="mb-0"><i class="fa fa-arrow-right text-primary me-2"></i>Melaksanakan pelatihan pendidikan berbasis IT</p>
                <p class="mb-0"><i class="fa fa-arrow-right text-primary me-2"></i>Menciptakan kreatifitas dari ide mahasiswa</p>
                <p class="mb-0"><i class="fa fa-arrow-right text-primary me-2"></i>Memiliki desa binaan yang berfokus pada IT</p>
                <p class="mb-0"><i class="fa fa-arrow-right text-primary me-2"></i>Mengkoordinir kegiatan kemahasiswaan yang bergerak dalam teknologi komputer</p>
            </div>
            <div class="col-lg-6 wow fadeInUp" data-wow-delay="0.1s" style="min-height: 400px;">
                <div class="position-relative h-100">
                    <img class="img-fluid position-absolute w-100 h-100" src="{{ asset('asset/about.jpg') }}" alt="" style="object-fit: cover;">
                </div>
            </div>
        </div> --}}
        <div class="text-center wow fadeInUp mt-5" data-wow-delay="0.1s">
            <h3 class="mb-4">Visi Himasi</h3>
            <p class="mb-4" style="text-align:justify">Menjadikan organisasi yang senantiasa meningkatkan jiwa kreatif dan komunikatif di setiap anggotanya, sehingga mampu melahirkan berbagai gagasan, karya, dan inovasi baru yang berkualitas. Dengan semangat kebersamaan dan keterbukaan, organisasi ini berkomitmen untuk menjadi wadah pengembangan potensi mahasiswa, mendorong terciptanya lingkungan yang produktif, serta menghadirkan solusi dan terobosan yang bermanfaat bagi kampus maupun masyarakat luas..</p>
        </div>
        <div class="text-center wow fadeInUp mt-5" data-wow-delay="0.1s">
            <h3 class="mb-4">Misi Himasi</h3>
            <p class="mb-2" style="text-align:justify"><i class="fa fa-arrow-right text-primary me-2"></i>Menyelenggarakan berbagai bentuk pelatihan dan pendidikan yang berfokus pada penguasaan teknologi informasi, baik dalam bentuk workshop, seminar, maupun kelas intensif.</p>
            <p class="mb-2" style="text-align:justify"><i class="fa fa-arrow-right text-primary me-2"></i>Mendorong dan memfasilitasi mahasiswa untuk mengembangkan ide-ide inovatif melalui kegiatan yang bersifat eksploratif dan kolaboratif.</p>
            <p class="mb-2" style="text-align:justify"><i class="fa fa-arrow-right text-primary me-2"></i>Mengembangkan program desa binaan yang berorientasi pada pemberdayaan masyarakat melalui teknologi informasi.</p>
            <p class="mb-2" style="text-align:justify"><i class="fa fa-arrow-right text-primary me-2"></i>Menjadi pusat koordinasi bagi berbagai kegiatan kemahasiswaan yang berkaitan dengan teknologi komputer, baik dalam lingkup akademik maupun non-akademik.</p>
        </div>
        <div class="text-center wow fadeInUp mt-5" data-wow-delay="0.1s">
            <h3 class="mb-4">Maksud & Tujuan Himasi</h3>
            <p class="mb-2" style="text-align:justify"><i class="fa fa-arrow-right text-primary me-2"></i>Menjadi landasan utama dalam merancang, mengimplementasikan, dan mengevaluasi setiap program kerja HIMASI, agar seluruh kegiatan yang dilaksanakan memiliki arah yang jelas, terukur, dan selaras dengan visi serta misi organisasi.</p>
            <p class="mb-2" style="text-align:justify"><i class="fa fa-arrow-right text-primary me-2"></i>Memastikan keberadaan dan peran aktif mahasiswa Program Studi Sistem Informasi dalam dinamika organisasi kemahasiswaan, baik di tingkat kampus maupun eksternal.</p>
            <p class="mb-2" style="text-align:justify"><i class="fa fa-arrow-right text-primary me-2"></i>Mendorong peningkatan kapasitas dan kompetensi mahasiswa melalui kegiatan yang bersifat edukatif, produktif, dan inspiratif.</p>
            <p class="mb-2" style="text-align:justify"><i class="fa fa-arrow-right text-primary me-2"></i>Menjadi representasi resmi mahasiswa Sistem Informasi dalam berbagai kegiatan, kompetisi, dan forum eksternal yang melibatkan institusi pendidikan tinggi.</p>
        </div>
        <div class="text-center wow fadeInUp mt-5" data-wow-delay="0.1s">
            <h3 class="mb-4">Struktur Organisasi</h3>
            <div class="col-12 text-center wow fadeInUp" data-wow-delay="0.1s">
                <a class="position-relative d-block overflow-hidden" href="">
                    <img class="img-fluid" src="{{ asset('asset/struktur.png') }}" alt="">
                </a>
            </div>
        </div>
    </div>
    <!-- Anggota End -->
@endsection

{{-- Catatan: Layout yang digunakan adalah 'layouts.frontend', sesuai dengan file asli. --}}
