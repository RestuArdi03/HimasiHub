@extends('backend.layouts.app')

@section('title', 'Daftar Saldo')

@section('content')
    <div class="page-heading">
        <div class="page-title">
            <div class="row">
                <div class="col-12 col-md-6 order-md-1 order-last">
                    <h3>Daftar Saldo</h3>
                    <p class="text-subtitle text-muted">Pengelolaan daftar sumber saldo keuangan.</p>
                </div>
                <div class="col-12 col-md-6 order-md-2 order-first">
                    <nav aria-label="breadcrumb" class="breadcrumb-header float-start float-lg-end">
                        <ol class="breadcrumb">
                            <li class="breadcrumb-item"><a href="{{ route('backend.dashboard') }}">Dashboard</a></li>
                            <li class="breadcrumb-item active" aria-current="page">Saldo</li>
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
        {{-- Tombol Aksi --}}
        <div class="mb-3">
            <a href="{{ route('backend.saldo.create') }}" class="btn btn-primary">
                <i class="bi bi-plus-lg"></i> Tambah Saldo
            </a>
            <a href="{{ route('backend.saldo.trash') }}" class="btn btn-danger">
                <i class="bi bi-trash3-fill"></i> Tempat Sampah
            </a>
            <a href="{{ route('backend.saldo.report') }}" class="btn btn-info">
                <i class="bi bi-file-earmark-bar-graph-fill"></i> Laporan Keuangan
            </a>
        </div>

        <section class="section">
            <div class="row">
                {{-- Kolom Kiri: Tabel Saldo --}}
                <div class="col-md-8">
                    <div class="card">
                        <div class="card-header">
                            <h5 class="card-title">Daftar Saldo Aktif</h5>
                        </div>
                        <div class="card-body">
                            <div class="table-responsive">
                                <table class="table table-striped table-hover" id="table1">
                                    <thead>
                                    <tr>
                                        <th>Nama Saldo</th>
                                        <th>Balance</th>
                                        <th>Aksi</th>
                                    </tr>
                                    </thead>
                                    <tbody>
                                    @forelse ($saldos as $saldo)
                                        <tr>
                                            <td>
                                                <a href="{{ route('backend.saldo.show', $saldo) }}">{{ $saldo->nama }}</a>
                                            </td>
                                            <td>Rp {{ number_format($saldo->balance, 2, ',', '.') }}</td>
                                            <td>
                                                <a href="{{ route('backend.saldo.show', $saldo) }}" class="btn btn-sm btn-info" title="Detail">
                                                    <i class="bi bi-eye-fill"></i>
                                                </a>
                                                @if(!in_array($saldo->nama, ['Kas', 'Lain-lain']))
                                                    @can('update', $saldo)
                                                        <a href="{{ route('backend.saldo.edit', $saldo) }}" class="btn btn-sm btn-warning" title="Edit">
                                                            <i class="bi bi-pencil-fill"></i>
                                                        </a>
                                                    @endcan
                                                    @can('delete', $saldo)
                                                        <button type="button" class="btn btn-sm btn-danger" data-bs-toggle="modal" data-bs-target="#deleteModal{{ $saldo->id }}" title="Hapus">
                                                            <i class="bi bi-trash-fill"></i>
                                                        </button>
                                                    @endcan
                                                @endif

                                                {{-- Modal Konfirmasi Hapus --}}
                                                <div class="modal fade" id="deleteModal{{ $saldo->id }}" tabindex="-1" aria-labelledby="deleteModalLabel{{ $saldo->id }}" aria-hidden="true">
                                                    <div class="modal-dialog">
                                                        <div class="modal-content">
                                                            <div class="modal-header">
                                                                <h5 class="modal-title" id="deleteModalLabel{{ $saldo->id }}">Konfirmasi Hapus</h5>
                                                                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                                                            </div>
                                                            <div class="modal-body">
                                                                Apakah Anda yakin ingin menghapus saldo '{{ $saldo->nama }}'?
                                                            </div>
                                                            <div class="modal-footer">
                                                                <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Batal</button>
                                                                <form action="{{ route('backend.saldo.destroy', $saldo) }}" method="POST" class="d-inline">
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
                                            <td colspan="3" class="text-center">Tidak ada data saldo.</td>
                                        </tr>
                                    @endforelse
                                    </tbody>
                                </table>
                            </div>
                            {{-- Pagination --}}
                            <div class="mt-4">
                                {{ $saldos->links() }}
                            </div>
                        </div>
                    </div>
                </div>

                {{-- Kolom Kanan: Total Saldo & Aksi --}}
                <div class="col-md-4">
                    {{-- Total Saldo --}}
                    <div class="card">
                        <div class="card-body px-4 py-4-5">
                            <div class="row">
                                <div class="col-5 d-flex justify-content-start">
                                    <div class="stats-icon purple mb-2">
                                        <i class="iconly-boldWallet"></i>
                                    </div>
                                </div>
                                <div class="col-7">
                                    <h6 class="text-muted font-semibold">Total Saldo</h6>
                                    <h6 class="font-extrabold mb-0">Rp {{ number_format($totalSaldo, 2, ',', '.') }}</h6>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </section>
    </div>
@endsection
