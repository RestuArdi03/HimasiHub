@extends('layouts.frontend')

@section('title', 'Kontak Kami - HimasiHub')

@section('content')
    <!-- Header Start -->
    <div class="container-fluid bg-primary py-5 mb-5 header-gambar">
        <div class="container py-5">
            <div class="row justify-content-center">
                <div class="col-lg-10 text-center">
                    <h1 class="display-3 text-white text-shadow-lg animated slideInDown">Bantuan</h1>
                    <nav aria-label="breadcrumb">
                        <ol class="breadcrumb justify-content-center">
                            <li class="breadcrumb-item"><a class="text-white text-shadow-lg" href="{{ route('frontend.index') }}">Beranda</a></li>
                            <li class="breadcrumb-item text-white active text-shadow-lg" aria-current="page">Bantuan</li>
                        </ol>
                    </nav>
                </div>
            </div>
        </div>
    </div>
    <!-- Header End -->

    <!-- 404 Start -->
    <div class="container-xxl py-5 wow fadeInUp" data-wow-delay="0.1s">
        <div class="container text-center">
            <div class="row justify-content-center">
                <div class="col-lg-6">
                    <i class="bi bi-exclamation-triangle display-1 text-primary"></i>
                    <h1 class="display-1">404</h1>
                    <h1 class="mb-4">Halaman Tidak Ditemukan</h1>
                    <p class="mb-4">Mohon maaf halaman yang anda tuju belum tersedia. Halaman yang anda tuju masih dalam tahap pengembangan.</p>
                    <a class="btn btn-primary rounded-pill py-3 px-5" href="{{ route('frontend.index') }}">Kembali ke Beranda</a>
                </div>
            </div>
        </div>
    </div>
    <!-- 404 End -->
@endsection

{{-- Catatan: Layout yang digunakan adalah 'layouts.frontend', sesuai dengan file asli. --}}
