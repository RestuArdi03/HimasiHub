<?php
/**
 * @var \App\Models\Saldo $saldo
 * @var \Illuminate\Pagination\LengthAwarePaginator|\App\Models\Transaksi[] $trashedTransactions
 */
?>
@extends('backend.layouts.app')

@section('title', 'Tempat Sampah Transaksi untuk ' . $saldo->nama)

@section('content')
    <div class="page-heading">
        <div class="page-title">
            <div class="row">
                <div class="col-12 col-md-6 order-md-1 order-last">
                    <h3>Tempat Sampah Transaksi</h3>
                    <p class="text-subtitle text-muted">Daftar transaksi yang telah dihapus dari saldo <strong>{{ $saldo->nama }}</strong>.</p>
                </div>
                <div class="col-12 col-md-6 order-md-2 order-first">
                    <nav aria-label="breadcrumb" class="breadcrumb-header float-start float-lg-end">
                        <ol class="breadcrumb">
                            <li class="breadcrumb-item"><a href="{{ route('backend.dashboard') }}">Dashboard</a></li>
                            <li class="breadcrumb-item"><a href="{{ route('backend.saldo.index') }}">Saldo</a></li>
                            <li class="breadcrumb-item"><a href="{{ route('backend.saldo.show', $saldo->id) }}">Detail Saldo</a></li>
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
                <div class="col-12 mb-3">
                    <a href="{{ route('backend.saldo.show', $saldo->id) }}" class="btn btn-secondary">
                        <i class="bi bi-arrow-left"></i> Kembali ke Riwayat Transaksi
                    </a>
                </div>
            </div>

            <div class="card">
                <div class="card-header">
                    <h5 class="card-title">Daftar Transaksi Dihapus</h5>
                </div>
                <div class="card-body">
                    <div class="table-responsive">
                        <table class="table table-striped table-hover">
                            <thead>
                            <tr>
                                <th>Keterangan</th>
                                <th class="text-end">Jumlah</th>
                                <th>Dihapus Pada</th>
                                <th class="text-center">Aksi</th>
                            </tr>
                            </thead>
                            <tbody>
                            @forelse ($trashedTransactions as $transaksi)
                                <tr>
                                    <td>{{ $transaksi->keterangan }}</td>
                                    <td class="text-end {{ $transaksi->debit > 0 ? 'text-success' : 'text-danger' }}">
                                        {{ number_format($transaksi->debit > 0 ? $transaksi->debit : $transaksi->kredit, 2, ',', '.') }}
                                    </td>
                                    <td>{{ $transaksi->deleted_at->format('d M Y, H:i') }}</td>
                                    <td class="text-center">
                                        @can('restore', $transaksi)
                                            {{-- Tombol Restore --}}
                                            <form action="{{ route('backend.transaksi.restore', $transaksi->id) }}" method="POST" class="d-inline">
                                                @csrf
                                                @method('PUT')
                                                <button type="submit" class="btn btn-sm btn-success btn-sq" title="Pulihkan">
                                                    <i class="bi bi-arrow-counterclockwise"></i>
                                                </button>
                                            </form>
                                        @endcan

                                        @can('forceDelete', $transaksi)
                                            {{-- Tombol Hapus Permanen --}}
                                            <button type="button" class="btn btn-sm btn-danger btn-sq" data-bs-toggle="modal" data-bs-target="#forceDeleteModal{{ $transaksi->id }}" title="Hapus Permanen">
                                                <i class="bi bi-trash-fill"></i>
                                            </button>

                                            {{-- Modal Konfirmasi Hapus Permanen --}}
                                            <div class="modal fade" id="forceDeleteModal{{ $transaksi->id }}" tabindex="-1" aria-labelledby="forceDeleteModalLabel{{ $transaksi->id }}" aria-hidden="true">
                                                <div class="modal-dialog">
                                                    <div class="modal-content">
                                                        <div class="modal-header">
                                                            <h5 class="modal-title" id="forceDeleteModalLabel{{ $transaksi->id }}">Konfirmasi Hapus Permanen</h5>
                                                            <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                                                        </div>
                                                        <div class="modal-body">
                                                            <p>Apakah Anda yakin ingin menghapus transaksi '<strong>{{ $transaksi->keterangan }}</strong>' secara permanen?</p>
                                                            <p class="text-danger"><strong>Peringatan:</strong> Tindakan ini tidak dapat diurungkan.</p>
                                                        </div>
                                                        <div class="modal-footer">
                                                            <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Batal</button>
                                                            <form action="{{ route('backend.transaksi.forceDelete', $transaksi->id) }}" method="POST" class="d-inline">
                                                                @csrf
                                                                @method('DELETE')
                                                                <button type="submit" class="btn btn-danger">Ya, Hapus Permanen</button>
                                                            </form>
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>
                                        @endcan
                                    </td>
                                </tr>
                            @empty
                                <tr>
                                    <td colspan="4" class="text-center">Tidak ada transaksi yang dihapus.</td>
                                </tr>
                            @endforelse
                            </tbody>
                        </table>
                    </div>
                    {{-- Pagination --}}
                    <div class="mt-4">
                        {{ $trashedTransactions->links() }}
                    </div>
                </div>
            </div>
        </section>
    </div>
@endsection