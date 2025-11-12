<?php
/**
 * @var \App\Models\Saldo[] $saldo
 */
?>
@extends('backend.layouts.app')

@section('title', 'Tempat Sampah Saldo')

@section('content')
    <div class="page-heading">
        <div class="page-title">
            <div class="row">
                <div class="col-12 col-md-6 order-md-1 order-last">
                    <h3>Tempat Sampah Saldo</h3>
                    <p class="text-subtitle text-muted">Daftar saldo yang telah dihapus.</p>
                </div>
                <div class="col-12 col-md-6 order-md-2 order-first">
                    <nav aria-label="breadcrumb" class="breadcrumb-header float-start float-lg-end">
                        <ol class="breadcrumb">
                            <li class="breadcrumb-item"><a href="{{ route('backend.dashboard') }}">Dashboard</a></li>
                            <li class="breadcrumb-item"><a href="{{ route('backend.saldo.index') }}">Saldo</a></li>
                            <li class="breadcrumb-item active" aria-current="page">Tempat Sampah</li>
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
                    <a href="{{ route('backend.saldo.index') }}" class="btn btn-secondary">
                        <i class="bi bi-arrow-left"></i> Kembali ke Daftar Saldo
                    </a>
                </div>
            </div>

            {{-- Tabel Saldo --}}
            <div class="card">
                <div class="card-header">
                    <h5 class="card-title">Daftar Saldo Dihapus</h5>
                </div>
                <div class="card-body">
                    <div class="table-responsive">
                        <table class="table table-striped table-hover" id="table1">
                            <thead>
                            <tr>
                                <th>Nama Saldo</th>
                                <th>Balance</th>
                                <th>Dibuat Oleh</th>
                                <th>Dihapus Pada</th>
                                <th>Aksi</th>
                            </tr>
                            </thead>
                            <tbody>
                            @forelse ($saldo as $item)
                                <tr>
                                    <td>{{ $item->nama }}</td>
                                    <td>Rp {{ number_format($item->balance, 2, ',', '.') }}</td>
                                    <td>{{ optional($item->user)->nama ?? 'N/A' }}</td>
                                    <td>{{ $item->deleted_at->format('d M Y, H:i') }}</td>
                                    <td>
                                        {{-- Tombol Restore --}}
                                        <form action="{{ route('backend.saldo.restore', $item->id) }}" method="POST" class="d-inline">
                                            @csrf
                                            @method('PUT')
                                            <button type="submit" class="btn btn-sm btn-success" title="Pulihkan">
                                                <i class="bi bi-arrow-counterclockwise"></i>
                                            </button>
                                        </form>

                                        {{-- Tombol Hapus Permanen --}}
                                        <button type="button" class="btn btn-sm btn-danger" data-bs-toggle="modal" data-bs-target="#forceDeleteModal{{ $item->id }}" title="Hapus Permanen">
                                            <i class="bi bi-trash-fill"></i>
                                        </button>

                                        {{-- Modal Konfirmasi Hapus Permanen --}}
                                        <div class="modal fade" id="forceDeleteModal{{ $item->id }}" tabindex="-1" aria-labelledby="forceDeleteModalLabel{{ $item->id }}" aria-hidden="true">
                                            <div class="modal-dialog">
                                                <div class="modal-content">
                                                    <div class="modal-header">
                                                        <h5 class="modal-title" id="forceDeleteModalLabel{{ $item->id }}">Konfirmasi Hapus Permanen</h5>
                                                        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                                                    </div>
                                                    <div class="modal-body">
                                                        <p>Apakah Anda yakin ingin menghapus saldo '<strong>{{ $item->nama }}</strong>' secara permanen?</p>
                                                        <p class="text-danger"><strong>Peringatan:</strong> Tindakan ini tidak dapat diurungkan.</p>
                                                    </div>
                                                    <div class="modal-footer">
                                                        <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Batal</button>
                                                        <form action="{{ route('backend.saldo.forceDelete', $item->id) }}" method="POST" class="d-inline">
                                                            @csrf
                                                            @method('DELETE')
                                                            <button type="submit" class="btn btn-danger">Ya, Hapus Permanen</button>
                                                        </form>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                    </td>
                                </tr>
                            @empty
                                <tr>
                                    <td colspan="5" class="text-center">Tidak ada data saldo yang dihapus.</td>
                                </tr>
                            @endforelse
                            </tbody>
                        </table>
                    </div>
                    {{-- Pagination --}}
                    <div class="mt-4">
                        {{ $saldo->links() }}
                    </div>
                </div>
            </div>
        </section>
    </div>
@endsection