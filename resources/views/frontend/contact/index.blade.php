@extends('layouts.frontend')

@section('title', 'Kontak Kami - HimasiHub')

@section('content')
    <!-- Header Start -->
    <div class="container-fluid bg-primary py-5 mb-5 header-gambar">
        <div class="container py-5">
            <div class="row justify-content-center">
                <div class="col-lg-10 text-center">
                    <h1 class="display-3 text-white text-shadow-lg animated slideInDown">Kontak Kami</h1>
                    <nav aria-label="breadcrumb">
                        <ol class="breadcrumb justify-content-center">
                            <li class="breadcrumb-item"><a class="text-white text-shadow-lg" href="{{ route('frontend.index') }}">Beranda</a></li>
                            <li class="breadcrumb-item text-white active text-shadow-lg" aria-current="page">Kontak Kami</li>
                        </ol>
                    </nav>
                </div>
            </div>
        </div>
    </div>
    <!-- Header End -->

    <!-- Contact Start -->
    <div class="container-xxl py-5">
        <div class="container">
            <div class="text-center wow fadeInUp" data-wow-delay="0.1s">
                <h6 class="section-title bg-white text-center text-primary px-3">Kontak Kami</h6>
                <h1 class="mb-5">Hubungi Kami Sesuai Keperluan Anda</h1>
            </div>
            <div class="row g-4">
                <div class="col-lg-4 col-md-6 wow fadeInUp" data-wow-delay="0.1s">
                    <h5>Hubungi Kami</h5>
                    <p class="mb-4" style="text-align:justify">Halaman ini disediakan untuk Anda yang ingin terhubung dengan HIMASI UBSI Yogyakarta. Silakan kirim pertanyaan, saran, atau permintaan informasi melalui formulir email dan media sosial kami, atau bisa langsung datangi kami pada alamat yang tertera.</p>
                    <div class="d-flex align-items-center mb-3">
                        <a href="https://maps.app.goo.gl/MYNaBq3LUtDJ9ScbA" target="_blank">
                            <div class="d-flex align-items-center justify-content-center flex-shrink-0 bg-primary" style="width: 50px; height: 50px;">
                                <i class="bi bi-geo-alt-fill text-white"></i>
                            </div>
                        </a>
                        <div class="ms-3">
                            <h5 class="text-primary">Sekretariat</h5>
                            <p class="mb-0">UBSI Yogyakarta, Jl. Ringroad Barat, D.I.Y</p>
                        </div>
                    </div>
                    <div class="d-flex align-items-center mb-3">
                        <a href="https://www.instagram.com/himasi_ubsiyogyakarta" target="_blank">
                            <div class="d-flex align-items-center justify-content-center flex-shrink-0 bg-primary" style="width: 50px; height: 50px;">
                                <i class="bi bi-instagram text-white"></i>
                            </div>
                        </a>
                        <div class="ms-3">
                            <h5 class="text-primary">Instagram</h5>
                            <p class="mb-0">@himasi_ubsiyogyakarta</p>
                        </div>
                    </div>
                    <div class="d-flex align-items-center">
                        <a href="https://mail.google.com/mail/?view=cm&fs=1&to=himasi.yog@bsi.ac.id" target="_blank">
                            <div class="d-flex align-items-center justify-content-center flex-shrink-0 bg-primary" style="width: 50px; height: 50px;">
                                <i class="bi bi-envelope text-white"></i>
                            </div>
                        </a>    
                        <div class="ms-3">
                            <h5 class="text-primary">Email</h5>
                            <p class="mb-0">himasi.yog@bsi.ac.id</p>
                        </div>
                    </div>
                </div>
                <div class="col-lg-4 col-md-6 wow fadeInUp" data-wow-delay="0.3s">
                    <iframe class="position-relative rounded w-100 h-100"
                        src="https://www.google.com/maps/embed?pb=!1m18!1m12!1m3!1d1013.9187064751442!2d110.32540408045921!3d-7.802309077120493!2m3!1f0!2f0!3f0!3m2!1i1024!2i768!4f13.1!3m3!1m2!1s0x2e7af8015817dcb3%3A0x44265c0cf8f29b43!2sUniversitas%20Bina%20Sarana%20Informatika%20Kampus%20Yogyakarta%20(UBSI%20Yogyakarta)!5e0!3m2!1sid!2sid!4v1763960584679!5m2!1sid!2sid"
                        frameborder="0" style="min-height: 300px; border:0;" allowfullscreen="" aria-hidden="false"
                        tabindex="0"></iframe>
                </div>
                <div class="col-lg-4 col-md-12 wow fadeInUp" data-wow-delay="0.5s">

                    {{-- START: NOTIFIKASI --}}
                    @if (session('success'))
                        <div class="alert alert-success alert-dismissible fade show" role="alert">
                            {{ session('success') }}
                            <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
                        </div>
                    @endif

                    @if (session('error'))
                        {{-- Pesan error jika Anda menggunakannya di Controller --}}
                        <div class="alert alert-danger alert-dismissible fade show" role="alert">
                            {{ session('error') }}
                            <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
                        </div>
                    @endif
                    {{-- END: NOTIFIKASI --}}

                    @php
                        // Tentukan kondisi jika user belum login
                        $isGuest = !Auth::check(); 
                    @endphp

                    <form action="{{ route('frontend.pesan.store') }}" method="POST">
                        @csrf
                        <div class="row g-3">
                            <div class="col-12">
                                <div class="form-floating">
                                    <input type="text" 
                                        class="form-control" 
                                        id="subjek" 
                                        name="subjek" 
                                        placeholder="Subjek" 
                                        required
                                        {{-- Kunci jika belum login --}}
                                        @if ($isGuest) 
                                            readonly 
                                            data-bs-toggle="modal" 
                                            data-bs-target="#loginPromptModal"
                                        @endif
                                    >
                                    <label for="subjek">Subjek</label>
                                </div>
                            </div>
                            <div class="col-12">
                                <div class="form-floating">
                                    <textarea class="form-control" 
                                            placeholder="Masukkan pesan" 
                                            id="pesan" 
                                            name="pesan" 
                                            style="height: 225px" 
                                            required
                                            {{-- Kunci jika belum login --}}
                                            @if ($isGuest) 
                                                readonly 
                                                data-bs-toggle="modal" 
                                                data-bs-target="#loginPromptModal"
                                            @endif
                                    ></textarea>
                                    <label for="pesan">Pesan</label>
                                </div>
                            </div>
                            <div class="col-12">
                                {{-- Tombol Kirim: Disabled jika belum login --}}
                                <button class="btn btn-primary w-100 py-3" type="submit" {{ $isGuest ? 'disabled' : '' }}>Kirim Pesan</button>
                            </div>
                        </div>
                    </form>
                </div>
                @guest
                <div class="modal fade" id="loginPromptModal" tabindex="-1" aria-labelledby="loginPromptModalLabel" aria-hidden="true">
                    <div class="modal-dialog modal-sm">
                        <div class="modal-content">
                            <div class="modal-header bg-warning text-white">
                                <h5 class="modal-title" id="loginPromptModalLabel">Akses Terbatas</h5>
                                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                            </div>
                            <div class="modal-body text-center">
                                <p>Anda harus **Login** terlebih dahulu untuk dapat mengisi dan mengirim pesan.</p>
                            </div>
                            <div class="modal-footer justify-content-center">
                                <a href="{{ route('login') }}" class="btn btn-primary w-100">
                                    <i class="bi bi-box-arrow-in-right"></i> Login Sekarang
                                </a>
                            </div>
                        </div>
                    </div>
                </div>
                @endguest
            </div>
        </div>
    </div>
    <!-- Contact End -->
@endsection

{{-- Catatan: Layout yang digunakan adalah 'layouts.frontend', sesuai dengan file asli. --}}
