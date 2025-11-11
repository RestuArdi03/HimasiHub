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
                            <div class="text-muted">
                                <p class="mb-1"><strong>Dibuat Oleh:</strong> {{ optional($saldo->user)->nama ?? 'N/A' }}</p>
                                <p class="mb-0"><strong>Tanggal Dibuat:</strong> {{ $saldo->created_at->format('d M Y') }}</p>
                            </div>
                            <div class="mt-4">
                                <a href="{{ route('backend.saldo.index') }}" class="btn btn-secondary me-1">
                                    <i class="bi bi-arrow-left"></i> Kembali
                                </a>
                                <a href="{{ route('backend.saldo.edit', $saldo) }}" class="btn btn-warning">
                                    <i class="bi bi-pencil-fill"></i> Edit
                                </a>
                            </div>
                        </div>
                    </div>
                </div>

                {{-- Riwayat Transaksi Card --}}
                <div class="col-md-8">
                    <div class="card">
                        <div class="card-header">
                            <h4 class="card-title">Riwayat Transaksi</h4>
                            {{-- Tombol Tambah Transaksi (jika diperlukan) --}}
                            {{-- <a href="#" class="btn btn-primary float-end">Tambah Transaksi</a> --}}
                        </div>
                        <div class="card-body">
                            <div class="table-responsive">
                                <table class="table table-striped table-hover">
                                    <thead>
                                    <tr>
                                        <th>Tanggal</th>
                                        <th>Keterangan</th>
                                        <th class="text-end">Debit</th>
                                        <th class="text-end">Kredit</th>
                                        <th class="text-end">Saldo Akhir</th>
                                    </tr>
                                    </thead>
                                    <tbody>
                                    @forelse ($saldo->transactions()->orderBy('created_at', 'desc')->get() as $transaksi)
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
