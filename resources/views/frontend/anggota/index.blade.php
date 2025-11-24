@extends('layouts.frontend')

@section('title', 'Anggota - HimasiHub')

@section('content')
    <!-- Anggota Start -->
    <div class="container-xxl py-5">
        <div class="container">
            <div class="text-center wow fadeInUp" data-wow-delay="0.1s">
                <h6 class="section-title bg-white text-center text-primary px-3">Anggota</h6>
                <h1 class="mb-5">Pengurus Inti Himasi</h1>
            </div>
            <div class="row g-4 justify-content-center">
                @forelse ($anggota as $agt)
                    <div class="col-lg-3 col-md-6 wow fadeInUp" data-wow-delay="0.1s">
                        <div class="team-item bg-light">
                            <div class="overflow-hidden">
                                <img class="img-fluid" src="{{ !empty($agt->foto) ? asset('storage/' . $agt->foto) : asset('backend-assets/images/default.png') }}">
                            </div>
                            <div class="position-relative d-flex justify-content-center" style="margin-top: -23px;">
                                <div class="bg-light d-flex justify-content-center pt-2 px-1">
                                    <a class="btn btn-sm-square btn-primary mx-1" href="https://mail.google.com/mail/?view=cm&fs=1&to={{ $agt->email }}" target="_blank"><i class="bi bi-envelope"></i></=>
                                    <a class="btn btn-sm-square btn-primary mx-1" href="{{ $agt->tiktok }}" target="blank"><i class="bi bi-tiktok"></i></a>
                                    <a class="btn btn-sm-square btn-primary mx-1" href="{{ $agt->instagram }}" target="blank"><i class="bi bi-instagram"></i></a>
                                </div>
                            </div>
                            <div class="text-center p-4">
                                <h5 class="mb-0">{{ $agt->nama }}</h5>
                                <p>{{ $agt->jabatan->nama_jabatan }}</p>
                                <small><em>"{{ $agt->moto_hidup ?? ' - '}}"</em></small>
                            </div>
                        </div>
                    </div>
                @empty
                    <div class="col-12 text-center">
                        <p>Belum ada berita untuk ditampilkan.</p>
                    </div>
                @endforelse
            </div>
        </div>
    </div>
    <!-- Anggota End -->
@endsection

{{-- Catatan: Layout yang digunakan adalah 'layouts.frontend', sesuai dengan file asli. --}}
