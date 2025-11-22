@extends('layouts.frontend')

@section('title', $konten->judul . ' - HimasiHub')

@section('content')
<div class="container my-5">
    <div class="row justify-content-center">
        <div class="col-lg-8">

            {{-- Tombol Kembali --}}
            <a href="{{ url()->previous() }}" class="btn btn-outline-secondary mb-4"><i class="bi bi-arrow-left"></i> Kembali</a>

            {{-- Gambar Sampul --}}
            @if($konten->gambar)
                <figure class="mb-4">
                    <img src="{{ Str::startsWith($konten->gambar, 'http') ? $konten->gambar : Storage::url($konten->gambar) }}" class="img-fluid rounded-3" alt="Sampul {{ $konten->judul }}" style="width: 100%; height: 450px; object-fit: cover;">
                </figure>
            @endif

            {{-- Judul Konten --}}
            <h1 class="mb-3 display-5 fw-bold">{{ $konten->judul }}</h1>

            {{-- Meta Info: Penulis dan Tanggal --}}
            <div class="d-flex align-items-center text-muted mb-4">
                <div class="me-3">
                    <i class="bi bi-person-fill"></i>
                    <span class="ms-1">{{ optional($konten->user)->nama ?? 'Penulis' }}</span>
                </div>
                <div>
                    <i class="bi bi-calendar-event-fill"></i>
                    <span class="ms-1">{{ $konten->created_at->translatedFormat('d F Y') }}</span>
                </div>
            </div>

            {{-- Isi Konten --}}
            <div class="article-body fs-5">
                {!! $konten->deskripsi !!}
            </div>

            <hr class="my-5">

            {{-- Tombol Share --}}
            <div class="d-flex align-items-center">
                <h5 class="mb-0 me-3">Bagikan:</h5>
                <div>
                    <a href="https://www.facebook.com/sharer/sharer.php?u={{ urlencode(url()->current()) }}" target="_blank" class="btn btn-outline-primary btn-sm me-2" title="Bagikan ke Facebook"><i class="bi bi-facebook"></i></a>
                    <a href="https://twitter.com/intent/tweet?url={{ urlencode(url()->current()) }}&text={{ urlencode($konten->judul) }}" target="_blank" class="btn btn-outline-info btn-sm me-2" title="Bagikan ke Twitter"><i class="bi bi-twitter"></i></a>
                    <a href="https://api.whatsapp.com/send?text={{ urlencode($konten->judul . ' ' . url()->current()) }}" target="_blank" class="btn btn-outline-success btn-sm me-2" title="Bagikan ke WhatsApp"><i class="bi bi-whatsapp"></i></a>
                    <a href="mailto:?subject={{ urlencode($konten->judul) }}&body={{ urlencode('Baca artikel menarik ini: ' . url()->current()) }}" class="btn btn-outline-secondary btn-sm" title="Bagikan via Email"><i class="bi bi-envelope-fill"></i></a>
                </div>
            </div>

            {{-- Placeholder Komentar --}}
            <div class="mt-5">
                <h3>Komentar</h3>
                <p class="text-muted">Fitur komentar akan segera hadir.</p>
                {{-- Anda bisa menambahkan sistem komentar seperti Disqus atau lainnya di sini --}}
            </div>
        </div>
    </div>
</div>
@endsection