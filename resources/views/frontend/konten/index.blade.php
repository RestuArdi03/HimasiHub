@extends('layouts.frontend')

@section('title', 'Berita & Informasi - HimasiHub')

@section('content')
    <!-- Header Start -->
    <div class="container-fluid bg-primary py-5 mb-5 header-gambar">
        <div class="container py-5">
            <div class="row justify-content-center">
                <div class="col-lg-10 text-center">
                    <h1 class="display-3 text-white text-shadow-lg animated slideInDown">Publikasi</h1>
                    <nav aria-label="breadcrumb">
                        <ol class="breadcrumb justify-content-center">
                            <li class="breadcrumb-item"><a class="text-white text-shadow-lg" href="{{ route('frontend.index') }}">Beranda</a></li>
                            <li class="breadcrumb-item text-white active text-shadow-lg" aria-current="page">Publikasi</li>
                        </ol>
                    </nav>
                </div>
            </div>
        </div>
    </div>
    <!-- Header End -->

    {{-- Mulai Halaman --}}
    <div class="container-xxl py-5">
        <div class="container">
            <div class="text-center wow fadeInUp" data-wow-delay="0.1s">
                <h6 class="section-title bg-white text-center text-primary px-3">Publikasi</h6>
                <h1 class="mb-5">Berita & Artikel</h1>
            </div>

            <div class="row g-5">
                {{-- Daftar Berita --}}
                <div class="col-lg-8">
                    <div class="row">
                        <div class="col-12">
                            @forelse ($konten as $item)
                                <div class="card mb-4 shadow-sm border-0 wow fadeInUp" data-wow-delay="0.1s">
                                    <div class="row g-0">
                                        <div class="col-md-4">
                                            <a href="{{ route('frontend.konten.show', $item->slug) }}">
                                                <img src="{{ Str::startsWith($item->gambar, 'http') ? $item->gambar : Storage::url($item->gambar) }}" class="img-fluid rounded-start" alt="{{ $item->judul }}" style="height: 100%; object-fit: cover; min-height: 220px;">
                                            </a>
                                        </div>
                                        <div class="col-md-8 d-flex flex-column">
                                            <div class="card-body">
                                                <h5 class="card-title fw-bold">
                                                    <a href="{{ route('frontend.konten.show', $item->slug) }}" class="text-decoration-none text-dark">{{ $item->judul }}</a>
                                                </h5>
                                                <p class="card-text text-muted">{{ Str::limit(strip_tags($item->deskripsi), 150) }}</p>
                                            </div>
                                            <div class="card-footer bg-transparent border-0 pt-0 pb-3">
                                                <div class="d-flex justify-content-between align-items-center text-muted small">
                                                    <span>
                                                        <i class="fa fa-user text-primary me-2"></i>
                                                        {{ optional($item->user)->nama ?? 'HIMASI' }}
                                                    </span>
                                                    <span>
                                                        <i class="fa fa-calendar-alt text-primary me-2"></i>
                                                        {{ $item->created_at->translatedFormat('d F Y') }}
                                                    </span>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            @empty
                                {{-- Pesan jika tidak ada berita --}}
                                <div class="text-center py-5 my-5 bg-light rounded-3 wow fadeInUp" data-wow-delay="0.1s">
                                    <h4 class="mb-3">Tidak Ada Hasil</h4>
                                    <p class="text-muted fs-5">
                                        Maaf, tidak ada berita atau informasi yang cocok dengan kriteria Anda.
                                        <br>
                                        <a href="{{ route('frontend.konten.index') }}" class="link-primary mt-2 d-inline-block">Tampilkan semua berita</a>
                                    </p>
                                </div>
                            @endforelse

                            {{-- Paginasi --}}
                            <div class="d-flex justify-content-center mt-5">
                                {{-- Menggunakan withQueryString() agar filter pencarian tidak hilang saat pindah halaman --}}
                                {{-- Menggunakan view pagination::bootstrap-5 agar sesuai dengan tema --}}
                                {{ $konten->withQueryString()->links('pagination::bootstrap-5') }}
                            </div>
                        </div>
                    </div>
                </div>

                {{-- Sidebar untuk Filter dan Pencarian --}}
                <div class="col-lg-4">
                    <div class="p-4 bg-light rounded-3 shadow-sm wow fadeInUp" data-wow-delay="0.2s">
                        <form action="{{ route('frontend.konten.index') }}" method="GET">
                            <div class="mb-4">
                                <label for="search" class="form-label fw-bold">Cari Artikel</label>
                                <input type="search" class="form-control" id="search" name="search" placeholder="Masukkan kata kunci..." value="{{ $request->search ?? '' }}">
                            </div>
                            <div class="mb-3">
                                <label for="start_date" class="form-label fw-bold">Filter Tanggal</label>
                                <input type="date" class="form-control mb-2" id="start_date" name="start_date" value="{{ $request->start_date ?? '' }}" title="Dari Tanggal">
                                <input type="date" class="form-control" id="end_date" name="end_date" value="{{ $request->end_date ?? '' }}" title="Sampai Tanggal">
                            </div>
                            <div class="d-grid gap-2">
                                <button type="submit" class="btn btn-primary"><i class="bi bi-search me-2"></i>Cari</button>
                                <a href="{{ route('frontend.konten.index') }}" class="btn btn-outline-secondary">Reset Filter</a>
                            </div>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection

{{-- Catatan: Layout yang digunakan adalah 'layouts.frontend', sesuai dengan file asli. --}}
