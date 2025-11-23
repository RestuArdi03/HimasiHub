@extends('backend.layouts.app')

@section('title', 'Daftar Publikasi')

@section('content')
    <div class="page-heading">
        <div class="page-title">
            <div class="row">
                <div class="col-12 col-md-6 order-md-1 order-last">
                    <h3>Daftar Publikasi</h3>
                    <p class="text-subtitle text-muted">Pengelolaan daftar konten publikasi.</p>
                </div>
                <div class="col-12 col-md-6 order-md-2 order-first">
                    <nav aria-label="breadcrumb" class="breadcrumb-header float-start float-lg-end">
                        <ol class="breadcrumb">
                            <li class="breadcrumb-item"><a href="{{ route('backend.dashboard') }}">Dashboard</a></li>
                            <li class="breadcrumb-item active" aria-current="page">Publikasi</li>
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

        <section class="section">
            <div class="row">
                {{-- Tombol Aksi --}}
                <div class="col-12 mb-3">
                    @can('konten.create')
                        <a href="{{ route('backend.konten.create') }}" class="btn btn-primary">
                            <i class="bi bi-plus-lg"></i> Tambah Publikasi
                        </a>
                    @endcan
                    {{-- Jika Anda mengimplementasikan SoftDeletes, tombol ini bisa diaktifkan --}}
                    {{-- <a href="#" class="btn btn-danger">
                        <i class="bi bi-trash3-fill"></i> Tempat Sampah
                    </a> --}}
                </div>
            </div>

            {{-- Tabel Konten --}}
            <div class="card">
                <div class="card-header">
                    <h5 class="card-title">Daftar Publikasi</h5>
                </div>
                <div class="card-body">
                    <div class="table-responsive">
                        <table class="table table-striped table-hover" id="table1">
                            <thead>
                            <tr>
                                <th>Gambar</th>
                                <th>Judul</th>
                                <th>Penulis</th>
                                <th>Tanggal</th>
                                <th>Aksi</th>
                            </tr>
                            </thead>
                            <tbody>
                            @forelse ($konten as $item)
                                <tr>
                                    <td>
                                        <img src="{{ Str::startsWith($item->gambar, 'http') ? $item->gambar : Storage::url($item->gambar) }}" alt="{{ $item->judul }}" width="100" class="img-thumbnail">
                                    </td>
                                    <td>
                                        <a href="{{ route('backend.konten.show', $item) }}">{{ $item->judul }}</a>
                                    </td>
                                    <td>{{ optional($item->user)->nama ?? 'N/A' }}</td>
                                    <td>{{ $item->created_at->format('d M Y') }}</td>
                                    <td>
                                        @can('konten.view')
                                            <a href="{{ route('backend.konten.show', $item) }}" class="btn btn-sm btn-info" title="Detail">
                                                <i class="bi bi-eye-fill"></i>
                                            </a>
                                        @endcan
                                        @can('update', $item)
                                            <a href="{{ route('backend.konten.edit', $item) }}" class="btn btn-sm btn-warning" title="Edit">
                                                <i class="bi bi-pencil-fill"></i>
                                            </a>
                                        @endcan
                                        @can('delete', $item)
                                            <button type="button" class="btn btn-sm btn-danger" data-bs-toggle="modal" data-bs-target="#deleteModal{{ $item->id }}" title="Hapus">
                                                <i class="bi bi-trash-fill"></i>
                                            </button>
                                        @endcan

                                        {{-- Modal Konfirmasi Hapus --}}
                                        <div class="modal fade" id="deleteModal{{ $item->id }}" tabindex="-1" aria-labelledby="deleteModalLabel{{ $item->id }}" aria-hidden="true">
                                            <div class="modal-dialog">
                                                <div class="modal-content">
                                                    <div class="modal-header">
                                                        <h5 class="modal-title" id="deleteModalLabel{{ $item->id }}">Konfirmasi Hapus</h5>
                                                        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                                                    </div>
                                                    <div class="modal-body">
                                                        Apakah Anda yakin ingin menghapus konten '{{ $item->judul }}'?
                                                    </div>
                                                    <div class="modal-footer">
                                                        <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Batal</button>
                                                        <form action="{{ route('backend.konten.destroy', $item) }}" method="POST" class="d-inline">
                                                            @csrf
                                                            @method('DELETE')
                                                            <button type="submit" class="btn btn-danger">Hapus</button>
                                                        </form>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                    </td>
                                </tr>
                            @empty
                                <tr>
                                    <td colspan="5" class="text-center">Tidak ada data publikasi.</td>
                                </tr>
                            @endforelse
                            </tbody>
                        </table>
                    </div>
                    {{-- Pagination --}}
                    <div class="mt-4">
                        {{ $konten->links() }}
                    </div>
                </div>
            </div>
        </section>
    </div>
@endsection
