@extends('backend.layouts.app')

@section('title', 'Laporan Saldo')

@section('content')
    <div class="page-title">
        <div class="row">
            <div class="col-12 col-md-6 order-md-1 order-last">
                <h3>Laporan Saldo</h3>
                <p class="text-subtitle text-muted">Laporan rincian transaksi untuk setiap saldo.</p>
            </div>
            <div class="col-12 col-md-6 order-md-2 order-first">
                <nav aria-label="breadcrumb" class="breadcrumb-header float-start float-lg-end">
                    <ol class="breadcrumb">
                        <li class="breadcrumb-item"><a href="{{ route('backend.dashboard') }}">Dashboard</a></li>
                        <li class="breadcrumb-item"><a href="{{ route('backend.saldo.index') }}">Saldo</a></li>
                        <li class="breadcrumb-item active" aria-current="page">Laporan</li>
                    </ol>
                </nav>
            </div>
        </div>
    </div>
    <div class="row">
        <div class="col-12 mb-3">
            <a href="{{ route('backend.saldo.index') }}" class="btn btn-secondary">
                <i class="bi bi-arrow-left"></i> Kembali ke Daftar Saldo
            </a>
        </div>
    </div>
    <div class="card">
        <div class="card-body">
            <!-- Filter Form -->
            <form id="filterForm" method="GET" action="{{ route('backend.saldo.report') }}">
                <div class="row">
                    <div class="col-md-3">
                        <div class="form-group">
                            <label>Pilih Saldo</label>
                            <!-- Tombol Pemicu Modal -->
                            <button type="button" class="btn btn-outline-primary w-100 text-left" data-bs-toggle="modal" data-bs-target="#saldoModal">
                                Pilih Saldo...
                            </button>
                        </div>
                    </div>
                    <div class="col-md-3">
                        <div class="form-group">
                            <label for="start_date">Tanggal Mulai</label>
                            <input type="date" name="start_date" id="start_date" class="form-control"
                                value="{{ request('start_date') }}">
                        </div>
                    </div>
                    <div class="col-md-3">
                        <div class="form-group">
                            <label for="end_date">Tanggal Selesai</label>
                            <input type="date" name="end_date" id="end_date" class="form-control"
                                value="{{ request('end_date') }}">
                        </div>
                    </div>
                    <div class="col-md-3 align-self-end mb-3">
                        <button type="submit" class="btn btn-primary w-100">
                            <i class="fas fa-filter"></i> Filter
                        </button>
                    </div>
                </div>
            </form>

            <!-- Modal Saldo -->
            <div class="modal fade" id="saldoModal" tabindex="-1" aria-labelledby="saldoModalLabel" aria-hidden="true">
                <div class="modal-dialog modal-dialog-centered">
                    <div class="modal-content">
                        <div class="modal-header">
                            <h5 class="modal-title" id="saldoModalLabel">Pilih Saldo</h5>
                            <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                        </div>
                        <div class="modal-body">
                            @foreach ($allSaldos as $saldo)
                                <div class="form-check">
                                    <input class="form-check-input" type="checkbox" name="saldo_ids[]" value="{{ $saldo->id }}" id="saldo_modal_{{ $saldo->id }}"
                                        {{ in_array($saldo->id, request('saldo_ids', [])) ? 'checked' : '' }} form="filterForm">
                                    <label class="form-check-label" for="saldo_modal_{{ $saldo->id }}">
                                        {{ $saldo->nama }}
                                    </label>
                                </div>
                            @endforeach
                        </div>
                        <div class="modal-footer">
                            <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Tutup</button>
                        </div>
                    </div>
                </div>
            </div>

            <hr>

            <div class="my-4 d-flex justify-content-between align-items-center">
                <h5>Total Keseluruhan Saldo: {{ 'Rp ' . number_format($totalSaldo, 2, ',', '.') }}</h5>
                <button type="submit" name="export" value="pdf" class="btn btn-success" form="filterForm">
                    <i class="fas fa-file-pdf"></i> Export PDF
                </button>
            </div>

            @if ($saldos->isEmpty())
                <div class="alert alert-warning">
                    Tidak ada data saldo untuk ditampilkan. Silakan sesuaikan filter Anda.
                </div>
            @else
                <ul class="nav nav-tabs mb-1" id="saldoTab" role="tablist">
                    @foreach ($saldos as $saldo)
                        <li class="nav-item" role="presentation">
                            <a class="nav-link {{ $loop->first ? 'active' : '' }}" id="tab-{{ $saldo->id }}" data-bs-toggle="tab" href="#content-{{ $saldo->id }}" role="tab" aria-controls="content-{{ $saldo->id }}" aria-selected="{{ $loop->first ? 'true' : 'false' }}">
                                {{ $saldo->nama }}
                            </a>
                        </li>
                    @endforeach
                </ul>

                <div class="tab-content" id="saldoTabContent">
                    @foreach ($saldos as $saldo)
                        <div class="tab-pane fade {{ $loop->first ? 'show active' : '' }}" id="content-{{ $saldo->id }}" role="tabpanel" aria-labelledby="tab-{{ $saldo->id }}">
                            <div class="card card-primary card-outline card-outline-tabs">
                                <div class="card-header p-3">
                                    <div class="d-flex justify-content-between align-items-center">
                                        <h5 class="mb-0">Detail Transaksi: {{ $saldo->nama }}</h5>
                                        <span class="badge badge-primary" style="font-size: 1rem;">Saldo Akhir:
                                            {{ 'Rp ' . number_format($saldo->balance, 2, ',', '.') }}</span>
                                    </div>
                                </div>
                                <div class="card-body">
                                    @if ($saldo->transactions->isEmpty())
                                        <p>Tidak ada transaksi untuk periode yang dipilih.</p>
                                    @else
                                        <div class="table-responsive">
                                            <table class="table table-striped table-bordered">
                                                <thead class="thead-dark">
                                                    <tr>
                                                        <th>Tanggal</th>
                                                        <th>Keterangan</th>
                                                        <th>Debit</th>
                                                        <th>Kredit</th>
                                                        <th>Saldo Akhir</th>
                                                    </tr>
                                                </thead>
                                                <tbody>
                                                    @foreach ($saldo->transactions as $transaction)
                                                        <tr>
                                                            <td>{{ $transaction->created_at->format('d-m-Y H:i') }}</td>
                                                            <td>{{ $transaction->keterangan }}</td>
                                                            <td>{{ 'Rp ' . number_format($transaction->debit, 2, ',', '.') }}</td>
                                                            <td>{{ 'Rp ' . number_format($transaction->kredit, 2, ',', '.') }}</td>
                                                            <td>{{ 'Rp ' . number_format($transaction->saldo_akhir, 2, ',', '.') }}</td>
                                                        </tr>
                                                    @endforeach
                                                </tbody>
                                            </table>
                                        </div>
                                    @endif
                                </div>
                            </div>
                        </div>
                    @endforeach
                </div>
            @endif
        </div>
    </div>
@endsection
