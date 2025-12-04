@extends('layouts.frontend')

@section('title', $konten->judul . ' - HimasiHub')

@section('content')

{{-- Cek jika konten tidak published, maka tampilkan 404 --}}
@if($konten->status !== 'published')
    @php
        abort(404);
    @endphp
@endif
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
                <div class="me-3">
                    <i class="bi bi-eye-fill"></i>
                    <span class="ms-1">{{ $konten->views }}x dilihat</span>
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

            {{-- Bagian Komentar --}}
            <div class="mt-5">
                <h3>Komentar</h3>

                {{-- Form Tambah Komentar --}}
                @auth
                    <div class="card mb-4">
                        <div class="card-body p-4">
                            <h5 class="card-title mb-4">Tinggalkan Komentar</h5>
                            <div class="d-flex align-items-start">
                                <div class="flex-shrink-0 me-3">
                                    {{-- Avatar Pengguna --}}
                                    @if(Auth::user()->foto)
                                        <img src="{{ Str::startsWith(Auth::user()->foto, 'http') ? Auth::user()->foto : Storage::url(Auth::user()->foto) }}" alt="{{ Auth::user()->nama }}" class="rounded-circle" width="50" height="50" style="object-fit: cover;">
                                    @else
                                        <div class="rounded-circle bg-primary text-white d-flex align-items-center justify-content-center" style="width: 50px; height: 50px; font-size: 1.2rem;">
                                            {{ strtoupper(substr(Auth::user()->nama ?? 'U', 0, 1)) }}
                                        </div>
                                    @endif
                                </div>
                                <div class="flex-grow-1">
                                    <form action="{{ route('frontend.komen.store') }}" method="POST">
                                        @csrf
                                        <input type="hidden" name="konten_id" value="{{ $konten->id }}">
                                        <div class="mb-3">
                                            <textarea class="form-control @error('isi') is-invalid @enderror" name="isi" rows="3" placeholder="Tulis komentar Anda sebagai {{ Auth::user()->nama }}..." required>{{ old('isi') }}</textarea>
                                            @error('isi')
                                                <div class="invalid-feedback">{{ $message }}</div>
                                            @enderror
                                        </div>
                                        <button type="submit" class="btn btn-primary">Kirim Komentar</button>
                                    </form>
                                </div>
                            </div>
                        </div>
                    </div>
                @else
                    <div class="alert alert-secondary text-center" role="alert">
                        <a href="{{ route('login') }}" class="alert-link">Masuk</a> untuk meninggalkan komentar.
                    </div>
                @endauth

                {{-- Daftar Komentar --}}
                @if ($konten->komenTerbaru->isNotEmpty())
                    <h4 class="mb-3">Komentar Terbaru</h4>
                    @foreach ($konten->komenTerbaru as $komen)
                        <div class="d-flex mb-4">
                            <div class="flex-shrink-0">
                                {{-- Tampilkan foto profil jika ada, jika tidak, tampilkan inisial --}}
                                @if(optional($komen->user)->foto)
                                    <img src="{{ Str::startsWith(optional($komen->user)->foto, 'http') ? optional($komen->user)->foto : Storage::url(optional($komen->user)->foto) }}" alt="{{ optional($komen->user)->nama }}" class="rounded-circle" width="50" height="50" style="object-fit: cover;">
                                @else
                                    <div class="rounded-circle bg-secondary text-white d-flex align-items-center justify-content-center" style="width: 50px; height: 50px; font-size: 1.2rem;">
                                        {{ strtoupper(substr(optional($komen->user)->nama ?? 'U', 0, 1)) }}
                                    </div>
                                @endif
                            </div>
                            <div class="ms-3 flex-grow-1">
                                <div class="fw-bold">{{ optional($komen->user)->nama ?? 'Pengguna Anonim' }}</div>
                                <div class="text-muted small">{{ $komen->created_at->diffForHumans() }}</div>
                                <p class="mt-1 mb-0">{{ $komen->isi }}</p>
                            </div>
                        </div>
                    @endforeach
                @else
                    <p class="text-muted">Belum ada komentar. Jadilah yang pertama berkomentar!</p>
                @endif

            </div>
        </div>
    </div>
</div>
@endsection