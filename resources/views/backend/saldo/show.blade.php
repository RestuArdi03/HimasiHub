<?php
/**
 * @var \App\Models\Saldo $saldo
 */
?>
@extends('backend.layouts.app')

@section('title', 'Detail Saldo: ' . $saldo->nama)

@section('content')
    <div class="page-heading">
        <div class="page-title">
            <div class="row">
                <div class="col-12 col-md-6 order-md-1 order-last">
                    <h3>Detail Saldo</h3>
                    <p class="text-subtitle text-muted">Informasi lengkap dan riwayat transaksi untuk {{ $saldo->nama }}.</p>
                </div>
                <div class="col-12 col-md-6 order-md-2 order-first">
                    <nav aria-label="breadcrumb" class="breadcrumb-header float-start float-lg-end">
                        <ol class="breadcrumb">
                            <li class="breadcrumb-item"><a href="{{ route('backend.dashboard') }}">Dashboard</a></li>
                            <li class="breadcrumb-item"><a href="{{ route('backend.saldo.index') }}">Saldo</a></li>
                            <li class="breadcrumb-item active" aria-current="page">Detail</li>
                        </ol>
                    </nav>
                </div>
            </div>
        </div>

        <section class="section">
            <div class="row">
                {{-- Detail Saldo Card --}}
                <div class="col-md-4">
                    <div class="card">
                        <div class="card-header">
                            <h4 class="card-title">Informasi Saldo</h4>
                        </div>
                        <div class="card-body">
                            <h5>{{ $saldo->nama }}</h5>
                            <h2 class="font-extrabold mb-0">Rp {{ number_format($saldo->balance, 2, ',', '.') }}</h2>
                            <hr>
                            <div class="text-muted mb-4">
                                <p class="mb-1"><strong>Dibuat Oleh:</strong> {{ optional($saldo->user)->name ?? 'N/A' }}</p>
                                <p class="mb-0"><strong>Tanggal Dibuat:</strong> {{ $saldo->created_at->format('d M Y') }}</p>
                            </div>
                            <div class="d-flex justify-content-start">
                                <a href="{{ route('backend.saldo.index') }}" class="btn btn-secondary me-1">
                                    <i class="bi bi-arrow-left"></i> Kembali
                                </a>
                                @can('update', $saldo)
                                    <a href="{{ route('backend.saldo.edit', $saldo) }}" class="btn btn-warning">
                                        <i class="bi bi-pencil-fill"></i> Edit
                                    </a>
                                @endcan
                            </div>
                        </div>
                    </div>
                </div>

                {{-- Riwayat Transaksi Card --}}
                <div class="col-md-8">
                    <div class="card">
                        <div class="card-header">
                            <div class="d-flex justify-content-between align-items-center">
                                <h4 class="card-title mb-0">Riwayat Transaksi</h4>
                                <div>
                                    @can('create', $transaksiClass)
                                        <a href="{{ route('backend.transaksi.create', ['saldo_id' => $saldo->id]) }}" class="btn btn-primary">
                                            <i class="bi bi-plus-lg"></i> Tambah Transaksi
                                        </a>
                                    @endcan
                                    <a href="{{ route('backend.transaksi.trash', $saldo->id) }}" class="btn btn-danger"><i class="bi bi-trash3-fill"></i> Tempat Sampah</a>
                                </div>                                
                            </div>
                        </div>
                        <div class="card-body">
                            <div class="table-responsive">
                                <table class="table table-striped table-hover">
                                    <thead>
                                    <tr>
                                        <th style="width: 15%;">Tanggal</th>
                                        <th>Keterangan</th>
                                        <th class="text-end">Debit</th>
                                        <th class="text-end">Kredit</th>
                                        <th class="text-end">Saldo Akhir</th>
                                    </tr>
                                    </thead>
                                    <tbody>
                                    @forelse ($saldo->transactions()->orderBy('created_at', 'desc')->orderBy('id', 'desc')->get() as $transaksi)
                                        <tr>
                                            <td>{{ $transaksi->created_at->format('d M Y') }}</td>
                                            <td>
                                                {{ $transaksi->keterangan }}
                                                @if($transaksi->gambar)
                                                    <a href="{{ asset('storage/' . $transaksi->gambar) }}" target="_blank" class="ms-1"><i class="bi bi-paperclip"></i></a>
                                                @endif
                                            </td>
                                            <td class="text-end text-success">
                                                @if($transaksi->debit > 0)
                                                    + {{ number_format($transaksi->debit, 2, ',', '.') }}
                                                @endif
                                            </td>
                                            <td class="text-end text-danger">
                                                @if($transaksi->kredit > 0)
                                                    - {{ number_format($transaksi->kredit, 2, ',', '.') }}
                                                @endif
                                            </td>
                                            <td class="text-end fw-bold">
                                                {{ number_format($transaksi->saldo_akhir, 2, ',', '.') }}
                                            </td>
                                            <td class="text-center">
                                                @can('update', $transaksi)
                                                    <a href="{{ route('backend.transaksi.edit', $transaksi->id) }}" class="btn btn-sm btn-warning btn-sq" title="Edit">
                                                        <i class="bi bi-pencil-fill"></i>
                                                    </a>
                                                @endcan
                                                
                                                @can('delete', $transaksi)
                                                    <button type="button" class="btn btn-sm btn-danger btn-sq" data-bs-toggle="modal" data-bs-target="#deleteModal{{ $transaksi->id }}" title="Hapus">
                                                        <i class="bi bi-trash-fill"></i>
                                                    </button>
                                                @endcan

                                                {{-- Modal Konfirmasi Hapus --}}
                                                <div class="modal fade" id="deleteModal{{ $transaksi->id }}" tabindex="-1" aria-labelledby="deleteModalLabel{{ $transaksi->id }}" aria-hidden="true">
                                                    <div class="modal-dialog">
                                                        <div class="modal-content">
                                                            <div class="modal-header">
                                                                <h5 class="modal-title" id="deleteModalLabel{{ $transaksi->id }}">Konfirmasi Hapus Transaksi</h5>
                                                                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                                                            </div>
                                                            <div class="modal-body text-start">
                                                                <p>Apakah Anda yakin ingin menghapus transaksi ini?</p>
                                                                <p><strong>Keterangan:</strong> {{ $transaksi->keterangan }}</p>
                                                                <p class="text-danger"><strong>Peringatan:</strong> Tindakan ini akan menghitung ulang saldo dan tidak dapat diurungkan dengan mudah.</p>
                                                            </div>
                                                            <div class="modal-footer">
                                                                <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Batal</button>
                                                                <form action="{{ route('backend.transaksi.destroy', $transaksi->id) }}" method="POST" class="d-inline">
                                                                    @csrf
                                                                    @method('DELETE')
                                                                    <button type="submit" class="btn btn-danger">Ya, Hapus</button>
                                                                </form>
                                                            </div>
                                                        </div>
                                                    </div>
                                                </div>
                                            </td>
                                        </tr>
                                    @empty
                                        <tr>
                                            <td colspan="5" class="text-center">Belum ada transaksi untuk saldo ini.</td>
                                        </tr>
                                    @endforelse
                                    </tbody>
                                </table>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </section>
    </div>
@endsection
