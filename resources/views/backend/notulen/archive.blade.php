@extends('backend.layouts.app')

@section('title', 'Arsip Notulen')
@section('page-heading', 'Arsip Notulen')

@section('content')
<div class="page-heading">
    <div class="page-title">
        <div class="row">
            <div class="col-12 col-md-6 order-md-1 order-last">
                <h3>📋 Arsip Notulen</h3>
                <p class="text-subtitle text-muted">Kelola notulen yang telah diarsipkan.</p>
            </div>
            <div class="col-12 col-md-6 order-md-2 order-first">
                <nav aria-label="breadcrumb" class="breadcrumb-header float-start float-lg-end">
                    <ol class="breadcrumb">
                        <li class="breadcrumb-item"><a href="{{ route('backend.dashboard') }}">Dashboard</a></li>
                        <li class="breadcrumb-item"><a href="{{ route('backend.notulen.index') }}">Daftar Notulen</a></li>
                        <li class="breadcrumb-item active" aria-current="page">Arsip</li>
                    </ol>
                </nav>
            </div>
        </div>
    </div>

    {{-- Tampilkan pesan sukses --}}
    @if (session('success'))
        <div class="alert alert-success alert-dismissible fade show" role="alert">
            {{ session('success') }}
            <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
        </div>
    @endif

    {{-- Tampilkan pesan error --}}
    @if (session('error'))
        <div class="alert alert-danger alert-dismissible fade show" role="alert">
            {{ session('error') }}
            <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
        </div>
    @endif

    <section class="section">
        {{-- Tombol Aksi --}}
        <div class="mb-3">
            <a href="{{ route('backend.notulen.index') }}" class="btn btn-secondary">
                <i class="bi bi-arrow-left"></i> Kembali ke Daftar Notulen
            </a>
        </div>

        <div class="card">
            <div class="card-header">
                <h5 class="card-title">Notulen Terarsip</h5>
            </div>

            <div class="card-body">
                @if($notulen->count())
                    <div class="list-group">
                        @foreach($notulen as $item)
                            <div class="list-group-item list-group-item-action border-bottom py-3">
                                <div class="d-flex w-100 justify-content-between align-items-start">
                                    <div class="flex-grow-1">
                                        <div class="d-flex align-items-center mb-2">
                                            <i class="bi bi-file-earmark-text me-2 text-muted"></i>
                                            <h6 class="mb-0 fw-600">{{ $item->judul }}</h6>
                                        </div>
                                        <p class="mb-2 text-muted small">
                                            {{ Str::limit($item->catatan, 100) }}
                                        </p>
                                        <div class="d-flex gap-3 flex-wrap text-muted small">
                                            <span>
                                                <i class="bi bi-calendar-event"></i>
                                                {{ $item->kegiatan->nama ?? 'N/A' }}
                                            </span>
                                            <span>
                                                <i class="bi bi-person-circle"></i>
                                                {{ optional($item->users)->nama ?? 'N/A' }}
                                            </span>
                                            @if($item->agenda->count())
                                                <span>
                                                    <i class="bi bi-list-check"></i>
                                                    {{ $item->agenda->count() }} Agenda
                                                </span>
                                            @endif
                                        </div>
                                        <div class="text-muted small mt-2">
                                            <i class="bi bi-clock-history"></i>
                                            Diarsipkan: {{ $item->deleted_at?->format('M d, Y H:i') }}
                                        </div>
                                    </div>
                                    <div class="text-end ms-3">
                                        <div class="d-flex gap-2 justify-content-end">
                                            <button class="btn btn-sm btn-success" onclick="restoreNotulen({{ $item->id }}, '{{ addslashes($item->judul) }}')" title="Pulihkan">
                                                <i class="bi bi-arrow-counterclockwise"></i>
                                            </button>
                                            <button class="btn btn-sm btn-danger" onclick="forceDeleteNotulen({{ $item->id }}, '{{ addslashes($item->judul) }}')" title="Hapus Permanen">
                                                <i class="bi bi-trash"></i>
                                            </button>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        @endforeach
                    </div>

                    <!-- Pagination -->
                    <div class="mt-4">
                        {{ $notulen->links() }}
                    </div>
                @else
                    <div class="text-center py-5">
                        <p class="text-muted">Belum ada notulen yang diarsipkan</p>
                    </div>
                @endif
            </div>
        </div>
    </section>
</div>
@endsection

@push('scripts')
<!-- Restore Confirmation Modal -->
<div class="modal fade" id="restoreModal" tabindex="-1" aria-labelledby="restoreModalLabel" aria-hidden="true">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="restoreModalLabel">Pulihkan Notulen</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body">
                <p>Anda yakin ingin memulihkan notulen "<span id="restoreItemTitle"></span>"?</p>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Batal</button>
                <button type="button" class="btn btn-success" id="confirmRestoreBtn">Pulihkan</button>
            </div>
        </div>
    </div>
</div>

<!-- Force Delete Confirmation Modal -->
<div class="modal fade" id="forceDeleteModal" tabindex="-1" aria-labelledby="forceDeleteModalLabel" aria-hidden="true">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="forceDeleteModalLabel">Hapus Permanen</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body">
                <p>Anda yakin ingin menghapus permanen notulen "<span id="forceDeleteItemTitle"></span>"?</p>
                <p class="text-danger mb-0"><small><i class="bi bi-exclamation-triangle"></i> Tindakan ini tidak dapat dibatalkan. Semua data terkait akan dihapus selamanya.</small></p>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Batal</button>
                <button type="button" class="btn btn-danger" id="confirmForceDeleteBtn">Hapus Permanen</button>
            </div>
        </div>
    </div>
</div>

<script>
    let restoreId = null;
    let forceDeleteId = null;

    function restoreNotulen(id, title) {
        restoreId = id;
        document.getElementById('restoreItemTitle').textContent = title;
        const restoreModal = new bootstrap.Modal(document.getElementById('restoreModal'));
        restoreModal.show();
    }

    function forceDeleteNotulen(id, title) {
        forceDeleteId = id;
        document.getElementById('forceDeleteItemTitle').textContent = title;
        const forceDeleteModal = new bootstrap.Modal(document.getElementById('forceDeleteModal'));
        forceDeleteModal.show();
    }

    document.getElementById('confirmRestoreBtn').addEventListener('click', function() {
        if (restoreId) {
            const form = document.createElement('form');
            form.method = 'POST';
            form.action = '/backend/notulen/' + restoreId + '/restore';
            form.innerHTML = '@csrf @method("PUT")';
            document.body.appendChild(form);
            form.submit();
        }
    });

    document.getElementById('confirmForceDeleteBtn').addEventListener('click', function() {
        if (forceDeleteId) {
            const form = document.createElement('form');
            form.method = 'POST';
            form.action = '/backend/notulen/' + forceDeleteId + '/force-delete';
            form.innerHTML = '@csrf @method("DELETE")';
            document.body.appendChild(form);
            form.submit();
        }
    });
</script>
@endpush
