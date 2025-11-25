@extends('backend.layouts.app')

@section('title', 'Daftar Notulen')
@section('page-heading', 'Daftar Notulen')

@section('content')
<div class="page-heading">
    <div class="page-title">
        <div class="row">
            <div class="col-12 col-md-6 order-md-1 order-last">
                <h3>📋 Notulen</h3>
                <p class="text-subtitle text-muted">Pantau catatan dan poin tindak lanjut dari setiap rapat.</p>
            </div>
            <div class="col-12 col-md-6 order-md-2 order-first">
                <nav aria-label="breadcrumb" class="breadcrumb-header float-start float-lg-end">
                    <ol class="breadcrumb">
                        <li class="breadcrumb-item"><a href="{{ route('backend.dashboard') }}">Dashboard</a></li>
                        <li class="breadcrumb-item active" aria-current="page">Daftar Notulen</li>
                    </ol>
                </nav>
            </div>
        </div>
    </div>

    <section class="section">
        <div class="card">
            <div class="card-header d-flex justify-content-between align-items-center">
                <span>Semua Notulen</span>
                @if($notulen->count())
                    <div class="btn-group" role="group">
                        <button type="button" class="btn btn-sm btn-outline-secondary" id="btnSort">
                            <i class="bi bi-arrow-up-down"></i> Urutkan
                        </button>
                        <button type="button" class="btn btn-sm btn-outline-secondary" id="btnFilter">
                            <i class="bi bi-funnel"></i> Filter
                        </button>
                        <a href="{{ route('backend.notulen.create') }}" class="btn btn-sm btn-primary">
                            <i class="bi bi-plus"></i> Notulen Baru
                        </a>
                    </div>
                @else
                    <a href="{{ route('backend.notulen.create') }}" class="btn btn-sm btn-primary">
                        <i class="bi bi-plus"></i> Notulen Baru
                    </a>
                @endif
            </div>

            <div class="card-body">
                @if($notulen->count())
                    <div class="list-group">
                        @foreach($notulen as $item)
                            <div class="list-group-item list-group-item-action border-bottom py-3">
                                <div class="d-flex w-100 justify-content-between align-items-start">
                                    <a href="{{ route('backend.notulen.show', $item->id) }}" class="flex-grow-1 text-decoration-none">
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
                                    </a>
                                    <div class="text-end ms-3">
                                        <div class="mb-2">
                                            <small class="text-muted d-block">
                                                {{ $item->created_at->format('M d, Y') }}<br>
                                                {{ $item->created_at->format('H:i') }}
                                            </small>
                                        </div>
                                        <div class="d-flex gap-2 justify-content-end">
                                            @if($item->agenda->count())
                                                <span class="badge bg-info">{{ $item->agenda->count() }} Poin</span>
                                            @else
                                                <span class="badge bg-secondary">Kosong</span>
                                            @endif
                                            <button class="btn btn-sm btn-danger" onclick="deleteNotulen({{ $item->id }}, '{{ $item->judul }}')">
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
                        <p class="text-muted">Belum ada data notulen</p>
                    </div>
                @endif
            </div>
        </div>
    </section>
</div>
@endsection

@push('scripts')
<!-- Delete Confirmation Modal -->
<div class="modal fade" id="deleteModal" tabindex="-1" aria-labelledby="deleteModalLabel" aria-hidden="true">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="deleteModalLabel">Hapus Notulen</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body">
                <p>Anda yakin ingin menghapus notulen "<span id="deleteItemTitle"></span>"?</p>
                <p class="text-warning mb-0"><small><i class="bi bi-exclamation-triangle"></i> Data yang dihapus tidak dapat dikembalikan. Semua agenda, dokumentasi, dan data kehadiran juga akan dihapus.</small></p>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Batal</button>
                <button type="button" class="btn btn-danger" id="confirmDeleteBtn">Hapus</button>
            </div>
        </div>
    </div>
</div>

<script>
    let deleteId = null;

    function deleteNotulen(id, title) {
        deleteId = id;
        document.getElementById('deleteItemTitle').textContent = title;
        const deleteModal = new bootstrap.Modal(document.getElementById('deleteModal'));
        deleteModal.show();
    }

    document.getElementById('confirmDeleteBtn').addEventListener('click', function() {
        if (deleteId) {
            const form = document.createElement('form');
            form.method = 'POST';
            form.action = '/backend/notulen/' + deleteId;
            form.innerHTML = '@csrf @method("DELETE")';
            document.body.appendChild(form);
            form.submit();
        }
    });

    document.getElementById('btnSort')?.addEventListener('click', function() {
        // Implementasi sorting logic
        alert('Sorting feature');
    });

    document.getElementById('btnFilter')?.addEventListener('click', function() {
        // Implementasi filter logic
        alert('Filter feature');
    });
</script>
@endpush
