@extends('backend.layouts.app')

@section('title', 'Detail Publikasi')

@section('content')
    <div class="page-heading">
        <div class="page-title">
            <div class="row">
                <div class="col-12 col-md-6 order-md-1 order-last">
                    <h3>Detail Publikasi</h3>
                    <p class="text-subtitle text-muted">Menampilkan detail dari konten publikasi.</p>
                </div>
                <div class="col-12 col-md-6 order-md-2 order-first">
                    <nav aria-label="breadcrumb" class="breadcrumb-header float-start float-lg-end">
                        <ol class="breadcrumb">
                            <li class="breadcrumb-item"><a href="{{ route('backend.dashboard') }}">Dashboard</a></li>
                            <li class="breadcrumb-item"><a href="{{ route('backend.konten.index') }}">Publikasi</a></li>
                            <li class="breadcrumb-item active" aria-current="page">Detail</li>
                        </ol>
                    </nav>
                </div>
            </div>
        </div>

        <section class="section">
            <div class="card">
                <div class="card-body">
                    @if($konten->gambar)
                        <div class="mb-4 text-center">
                            <img src="{{ Storage::url($konten->gambar) }}" class="img-fluid rounded" alt="{{ $konten->judul }}" style="max-height: 400px;">
                        </div>
                    @endif

                    <h1 class="card-title h3">{{ $konten->judul }}</h1>

                    <div class="d-flex align-items-center text-muted mb-4">
                        <div class="me-3">
                            <i class="bi bi-person-fill"></i>
                            <span>{{ optional($konten->user)->nama ?? 'Penulis tidak diketahui' }}</span>
                        </div>
                        <div>
                            <i class="bi bi-calendar-event-fill"></i>
                            <span>{{ $konten->created_at->format('d F Y') }}</span>
                        </div>
                    </div>

                    <div class="fs-5">
                        {!! $konten->deskripsi !!}
                    </div>
                </div>
                <div class="card-footer d-flex justify-content-between">
                    <a href="{{ route('backend.konten.index') }}" class="btn btn-secondary">
                        <i class="bi bi-arrow-left"></i> Kembali
                    </a>
                    <div>
                        <a href="{{ route('backend.konten.edit', $konten) }}" class="btn btn-warning">
                            <i class="bi bi-pencil-fill"></i> Edit
                        </a>
                        <button type="button" class="btn btn-danger" data-bs-toggle="modal" data-bs-target="#deleteModal{{ $konten->id }}">
                            <i class="bi bi-trash-fill"></i> Hapus
                        </button>
                    </div>
                </div>
            </div>
        </section>
    </div>

    {{-- Modal Konfirmasi Hapus --}}
    <div class="modal fade" id="deleteModal{{ $konten->id }}" tabindex="-1" aria-labelledby="deleteModalLabel{{ $konten->id }}" aria-hidden="true">
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="deleteModalLabel{{ $konten->id }}">Konfirmasi Hapus</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body">
                    Apakah Anda yakin ingin menghapus konten '{{ $konten->judul }}'?
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Batal</button>
                    <form action="{{ route('backend.konten.destroy', $konten) }}" method="POST" class="d-inline">
                        @csrf
                        @method('DELETE')
                        <button type="submit" class="btn btn-danger">Hapus</button>
                    </form>
                </div>
            </div>
        </div>
    </div>
@endsection
