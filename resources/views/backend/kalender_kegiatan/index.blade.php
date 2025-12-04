@extends('backend.layouts.app')

@section('title', 'Manajemen Kalender')

@section('content')
<div class="page-heading">
    <div class="page-title">
        <div class="row">
            <div class="col-12 col-md-6 order-md-1 order-last">
                <h3>Manajemen Kalender</h3>
                <p class="text-subtitle text-muted">Kelola acara yang tampil di kalender.</p>
            </div>
            <div class="col-12 col-md-6 order-md-2 order-first">
                <nav aria-label="breadcrumb" class="breadcrumb-header float-start float-lg-end">
                    <ol class="breadcrumb">
                        <li class="breadcrumb-item"><a href="{{ route('backend.dashboard') }}">Dashboard</a></li>
                        <li class="breadcrumb-item active" aria-current="page">Kalender</li>
                    </ol>
                </nav>
            </div>
        </div>
    </div>

    <section class="section">
        <div class="card">
            <div class="card-header">
                <div class="row">
                    <div class="col-md-6">
                        <h5 class="card-title">Daftar Acara Kalender</h5>
                    </div>
                    <div class="col-md-6 text-md-end">
                        @can('create', $kalenderClass)
                            <a href="{{ route('backend.kalender-kegiatan.create') }}" class="btn btn-primary">
                                <i class="bi bi-plus-lg"></i> Tambah Acara
                            </a>
                        @endcan
                    </div>
                </div>
            </div>
            <div class="card-body">
                @include('backend.layouts.partials.alerts')

                <table class="table table-striped" id="table1">
                    <thead>
                        <tr>
                            <th>Judul</th>
                            <th>Waktu Mulai</th>
                            <th>Status Tampil</th>
                            @can('create', $kalenderClass)
                                <th>Aksi</th>
                            @endcan
                        </tr>
                    </thead>
                    <tbody>
                        @forelse ($kegiatan as $item)
                        <tr>
                            <td>{{ $item->judul }}</td>
                            <td>{{ $item->waktu_mulai->format('d M Y, H:i') }}</td>
                            <td>
                                @if($item->status == 'frontend')
                                    <span class="badge bg-info">Frontend</span>
                                @elseif($item->status == 'backend')
                                    <span class="badge bg-warning">Backend</span>
                                @else
                                    <span class="badge bg-success">Keduanya</span>
                                @endif
                            </td>
                            @can('create', $kalenderClass)
                                <td>
                                    @can('update', $item)
                                        <a href="{{ route('backend.kalender-kegiatan.edit', $item->id) }}" class="btn btn-sm btn-warning" title="Edit"><i class="bi bi-pencil-fill"></i></a>
                                    @endcan
                                    @can('delete', $item)
                                        <button type="button" class="btn btn-sm btn-danger" data-bs-toggle="modal" data-bs-target="#deleteModal" data-url="{{ route('backend.kalender-kegiatan.destroy', $item->id) }}" title="Hapus">
                                            <i class="bi bi-trash-fill"></i>
                                        </button>
                                    @endcan
                                </td>
                            @endcan
                        </tr>
                        @empty
                        <tr>
                            <td colspan="@can('create', $kalenderClass) 4 @else 3 @endcan" class="text-center">Tidak ada data acara.</td>
                        </tr>
                        @endforelse
                    </tbody>
                </table>
                <div class="mt-3">
                    {{ $kegiatan->links() }}
                </div>
            </div>
        </div>
    </section>
</div>

@can('create', $kalenderClass)
<!-- Delete Modal -->
<div class="modal fade" id="deleteModal" tabindex="-1" aria-labelledby="deleteModalLabel" aria-hidden="true">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="deleteModalLabel">Konfirmasi Hapus</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body">
                Apakah Anda yakin ingin menghapus acara ini? Tindakan ini tidak dapat dibatalkan.
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Batal</button>
                <form id="deleteForm" method="POST" class="d-inline">
                    @csrf
                    @method('DELETE')
                    <button type="submit" class="btn btn-danger">Hapus</button>
                </form>
            </div>
        </div>
    </div>
</div>
@endcan
@endsection

@push('scripts')
<script>
    const deleteModal = document.getElementById('deleteModal');
    deleteModal.addEventListener('show.bs.modal', event => {
        const button = event.relatedTarget;
        const url = button.getAttribute('data-url');
        const deleteForm = deleteModal.querySelector('#deleteForm');
        deleteForm.setAttribute('action', url);
    });
</script>
@endpush
