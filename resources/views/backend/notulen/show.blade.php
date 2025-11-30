@extends('backend.layouts.app')

@section('title', $notulen->judul)
@section('page-heading', $notulen->judul)

@section('content')
<div class="page-heading">
    <div class="page-title">
        <div class="row">
            <div class="col-12 col-md-6 order-md-1 order-last">
                <h3>{{ $notulen->judul }}</h3>
            </div>
            <div class="col-12 col-md-6 order-md-2 order-first">
                <nav aria-label="breadcrumb" class="breadcrumb-header float-start float-lg-end">
                    <ol class="breadcrumb">
                        <li class="breadcrumb-item"><a href="{{ route('backend.dashboard') }}">Dashboard</a></li>
                        <li class="breadcrumb-item"><a href="{{ route('backend.notulen.index') }}">Daftar Notulen</a></li>
                        <li class="breadcrumb-item active" aria-current="page">{{ $notulen->judul }}</li>
                    </ol>
                </nav>
            </div>
        </div>
    </div>

    <section class="section">
        <!-- Info Notulen -->
        <div class="row mb-4">
            <div class="col-12">
                <div class="card">
                    <div class="card-header">
                        <h5 class="mb-0">Informasi Notulen</h5>
                    </div>
                    <div class="card-body">
                        <div class="row">
                            <div class="col-md-6 mb-3">
                                <label class="text-muted small">Judul Rapat</label>
                                <p class="mb-0 fw-600">{{ $notulen->judul_rapat ?? $notulen->judul ?? '-' }}</p>
                            </div>
                            <div class="col-md-6 mb-3">
                                <label class="text-muted small">Tipe Rapat</label>
                                <p class="mb-0 fw-600">{{ $notulen->tipe_rapat ?? '-' }}</p>
                            </div>
                            <div class="col-md-6 mb-3">
                                <label class="text-muted small">Kegiatan</label>
                                <p class="mb-0 fw-600">{{ optional($notulen->kegiatan)->nama ?? '-' }}</p>
                            </div>
                            <div class="col-md-6 mb-3">
                                <label class="text-muted small">Pembuat Notulen</label>
                                <p class="mb-0 fw-600">{{ optional($notulen->users)->nama ?? '-' }}</p>
                            </div>
                            <div class="col-md-6 mb-3">
                                <label class="text-muted small">Pimpinan Rapat</label>
                                <p class="mb-0 fw-600">{{ optional($notulen->pimpinan)->nama ?? $notulen->pimpinan_rapat_nama ?? '-' }}</p>
                            </div>
                            <div class="col-md-6 mb-3">
                                <label class="text-muted small">Notulis</label>
                                <p class="mb-0 fw-600">{{ optional($notulen->notulis)->nama ?? $notulen->notulis_nama ?? '-' }}</p>
                            </div>
                            <div class="col-md-6 mb-3">
                                <label class="text-muted small">Tanggal Rapat</label>
                                <p class="mb-0 fw-600">{{ $notulen->tanggal_rapat ? \Carbon\Carbon::parse($notulen->tanggal_rapat)->format('d F Y') : '-' }}</p>
                            </div>
                            <div class="col-md-6 mb-3">
                                <label class="text-muted small">Waktu</label>
                                <p class="mb-0 fw-600">{{ $notulen->waktu_mulai ?? '-' }} @if($notulen->waktu_selesai) - {{ $notulen->waktu_selesai }} @endif</p>
                            </div>
                            <div class="col-md-6 mb-3">
                                <label class="text-muted small">Lokasi</label>
                                <p class="mb-0 fw-600">{{ $notulen->lokasi ?? '-' }}</p>
                            </div>
                            <div class="col-md-6 mb-3">
                                <label class="text-muted small">Tanggal Dibuat</label>
                                <p class="mb-0 fw-600">{{ $notulen->created_at->format('d F Y, H:i') }}</p>
                            </div>
                            <div class="col-md-6 mb-3">
                                <label class="text-muted small">Tempat Kegiatan</label>
                                <p class="mb-0 fw-600">{{ optional($notulen->kegiatan)->tempat ?? '-' }}</p>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        
            <div class="row mb-4">
                <div class="col-12">
                    <div class="card">
                        <div class="card-header">
                            <h5 class="mb-0">
                                <i class="bi bi-list-check"></i> 
                                Agenda & Keputusan ({{ $notulen->agenda->count() }} Poin)
                            </h5>
                        </div>
                        <div class="card-body">
                            <div class="list-group list-group-flush">
                                @foreach($notulen->agenda as $index => $item)
                                    <button class="list-group-item list-group-item-action text-start" 
                                            type="button" 
                                            data-bs-toggle="collapse" 
                                            data-bs-target="#agenda{{ $index }}" 
                                            aria-expanded="@if($index === 0) true @else false @endif" 
                                            aria-controls="agenda{{ $index }}">
                                        <div class="d-flex justify-content-between align-items-center w-100">
                                            <strong>{{ $index + 1 }}. {{ $item->topik ?? $item->hasil_pembahasan }}</strong>
                                            <i class="bi bi-chevron-down"></i>
                                        </div>
                                        <div id="agenda{{ $index }}" class="collapse @if($index === 0) show @endif mt-2">
                                            <div class="mb-2">
                                                <label class="text-muted small d-block"><strong>Pembahasan:</strong></label>
                                                <div class="content text-body" style="line-height: 1.6;">
                                                    {!! $item->hasil_pembahasan !!}
                                                </div>
                                            </div>
                                            <div>
                                                <label class="text-muted small d-block"><strong>Status/Keputusan:</strong></label>
                                                <p class="mb-0 text-body">{{ $item->status }}</p>
                                            </div>
                                        </div>
                                    </button>
                                @endforeach
                            </div>
                        </div>
                    </div>
                </div>
            </div>

        <!-- Catatan Notulen -->
        <div class="row mb-4">
            <div class="col-12">
                <div class="card">
                    <div class="card-header">
                        <h5 class="mb-0">Catatan Notulen</h5>
                    </div>
                    <div class="card-body">
                        <p class="text-justify">{{ $notulen->catatan_tambahan ?? 'Tidak ada catatan tambahan' }}</p>
                    </div>
                </div>
            </div>
        </div>

        <!-- Dokumentasi -->
        @if($notulen->dokumentasi->count())
            <div class="row mb-4">
                <div class="col-12">
                    <div class="card">
                        <div class="card-header">
                            <h5 class="mb-0">
                                <i class="bi bi-image"></i>
                                Dokumentasi ({{ $notulen->dokumentasi->count() }} File)
                            </h5>
                        </div>
                        <div class="card-body">
                            <div class="row g-3">
                                @foreach($notulen->dokumentasi as $doc)
                                    @if($doc->tipe === 'image')
                                        <div class="col-md-3 col-sm-6">
                                            <a href="{{ asset('storage/' . $doc->path) }}" 
                                               data-bs-toggle="modal" 
                                               data-bs-target="#imageModal"
                                               data-image="{{ asset('storage/' . $doc->path) }}">
                                                <img src="{{ asset('storage/' . $doc->path) }}" 
                                                     alt="Dokumentasi" 
                                                     class="img-thumbnail w-100" 
                                                     style="height: 200px; object-fit: cover;">
                                            </a>
                                        </div>
                                    @else
                                        <div class="col-md-3 col-sm-6">
                                            <a href="{{ asset('storage/' . $doc->path) }}" 
                                               target="_blank" 
                                               class="btn btn-light w-100 text-start">
                                                <i class="bi bi-file-earmark"></i>
                                                <span class="ms-2">{{ basename($doc->path) }}</span>
                                            </a>
                                        </div>
                                    @endif
                                @endforeach
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        @endif

        <!-- Action Buttons -->
        <div class="row">
            <div class="col-12">
                <a href="{{ route('backend.notulen.index') }}" class="btn btn-secondary">
                    <i class="bi bi-arrow-left"></i> Kembali
                </a>
                <a href="{{ route('backend.notulen.edit', $notulen->id) }}" class="btn btn-primary">
                    <i class="bi bi-pencil"></i> Edit
                </a>
                <a href="{{ route('backend.notulen.download', $notulen->id) }}" class="btn btn-success">
                    <i class="bi bi-file-earmark-pdf"></i> Download PDF
                </a>
                <button type="button" class="btn btn-danger" data-bs-toggle="modal" data-bs-target="#deleteModal">
                    <i class="bi bi-trash"></i> Hapus
                </button>
            </div>
        </div>
    </section>
</div>

<!-- Image Modal -->
<div class="modal fade" id="imageModal" tabindex="-1" aria-labelledby="imageModalLabel" aria-hidden="true">
    <div class="modal-dialog modal-lg">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="imageModalLabel">Pratinjau Dokumentasi</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body">
                <img id="modalImage" src="" alt="Dokumentasi" class="img-fluid w-100">
            </div>
        </div>
    </div>
</div>

<!-- Delete Confirmation Modal -->
<div class="modal fade" id="deleteModal" tabindex="-1" aria-labelledby="deleteModalLabel" aria-hidden="true">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header bg-danger">
                <h5 class="modal-title text-white" id="deleteModalLabel">
                    <i class="bi bi-exclamation-triangle"></i> Konfirmasi Hapus
                </h5>
                <button type="button" class="btn-close btn-close-white" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body">
                <p>Apakah Anda yakin ingin menghapus notulen <strong>"{{ $notulen->judul }}"</strong>?</p>
                <p class="text-muted small">Notulen akan dipindahkan ke arsip dan dapat dipulihkan kemudian.</p>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Batal</button>
                <form id="deleteForm" method="POST" action="{{ route('backend.notulen.destroy', $notulen->id) }}" style="display: inline;">
                    @csrf
                    @method('DELETE')
                    <button type="submit" class="btn btn-danger">
                        <i class="bi bi-trash"></i> Hapus
                    </button>
                </form>
            </div>
        </div>
    </div>
</div>
@endsection

@push('scripts')
<script>
    // Handle image modal
    const imageModal = document.getElementById('imageModal');
    if (imageModal) {
        imageModal.addEventListener('show.bs.modal', function(event) {
            const link = event.relatedTarget;
            const image = link.getAttribute('data-image');
            const modalImage = document.getElementById('modalImage');
            modalImage.setAttribute('src', image);
        });
    }
</script>
@endpush
