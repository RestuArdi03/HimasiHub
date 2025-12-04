<?php
/**
 * @var \App\Models\Saldo $saldo
 * @var \Illuminate\Database\Eloquent\Collection|\App\Models\User[] $members
 * @var \Illuminate\Support\Collection $transactions
 * @var int $maxPayments
 * @var float $biayaIuran
 */
?>
@extends('backend.layouts.app')

@section('title', 'Laporan Kas: ' . $saldo->nama)

@section('content')
    <div class="page-heading">
        <div class="page-title">
            <div class="row">
                <div class="col-12 col-md-6 order-md-1 order-last">
                    <h3>Laporan Kas</h3>
                    <p class="text-subtitle text-muted">Ringkasan pembayaran kas oleh anggota.</p>
                </div>
                <div class="col-12 col-md-6 order-md-2 order-first">
                    <nav aria-label="breadcrumb" class="breadcrumb-header float-start float-lg-end">
                        <ol class="breadcrumb">
                            <li class="breadcrumb-item"><a href="{{ route('backend.dashboard') }}">Dashboard</a></li>
                            <li class="breadcrumb-item"><a href="{{ route('backend.saldo.index') }}">Saldo</a></li>
                            <li class="breadcrumb-item active" aria-current="page">Laporan Iuran Kas</li>
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
                    <a href="{{ route('backend.saldo.index') }}" class="btn btn-secondary">
                        <i class="bi bi-arrow-left"></i> Kembali ke Daftar Saldo
                    </a>
                </div>
            </div>
            <div class="card">
                <div class="card-header">
                    <div class="d-flex justify-content-between align-items-center">
                        <div>
                            <h4 class="card-title">Laporan Iuran untuk Saldo: {{ $saldo->nama }}</h4>
                            <p class="text-muted mb-0">
                                Total Saldo Kas: <strong>Rp {{ number_format($saldo->balance, 2, ',', '.') }}</strong> |
                                Nominal per Iuran: <strong>Rp {{ number_format($biayaIuran, 0, ',', '.') }}</strong>
                            </p>
                        </div>
                        @can('update', $saldo)
                        <div>
                            {{-- Tombol Reset Kas --}}
                            <button type="button" class="btn btn-outline-danger" data-bs-toggle="modal" data-bs-target="#resetKasModal">
                                <i class="bi bi-arrow-clockwise"></i> Reset Kas
                            </button>
                            {{-- Tombol Pengaturan --}}
                            <button type="button" class="btn btn-outline-primary ms-2" data-bs-toggle="modal" data-bs-target="#settingsModal">
                                <i class="bi bi-gear-fill"></i> Pengaturan
                            </button>
                        </div>
                        @endcan
                    </div>
                </div>
                <div class="card-body">
                    <div class="table-responsive">
                        <table class="table table-striped table-hover">
                            <thead>
                            <tr>
                                <th>Nama Anggota</th>
                                @for ($i = 1; $i <= $maxPayments; $i++)
                                    <th class="text-center">Iuran Ke-{{ $i }}</th>
                                @endfor
                                <th class="text-center">Total Bayar</th>
                            </tr>
                            </thead>
                            <tbody>
                            @forelse ($members as $member)
                                <tr>
                                    <td>{{ $member->nama }}</td>
                                    @php
                                        $memberTransactions = $transactions->get($member->id, collect());
                                        $totalPaidByMember = $memberTransactions->count();
                                    @endphp

                                    @for ($i = 1; $i <= $maxPayments; $i++)
                                        <td class="text-center">
                                            @php
                                                // Cari transaksi untuk iuran ke-i
                                                $payment = $memberTransactions->firstWhere(function ($trans) use ($i) {
                                                    return (int) preg_replace('/[^0-9]/', '', $trans->keterangan) === $i;
                                                });
                                            @endphp

                                            @if ($payment)
                                                @if ($canManageKas)
                                                    {{-- Jika sudah bayar & punya akses, tampilkan tombol hijau dengan opsi batal --}}
                                                    <div class="btn-group">
                                                        <button type="button" class="btn btn-sm btn-success dropdown-toggle" data-bs-toggle="dropdown" aria-expanded="false" title="Lunas pada {{ $payment->created_at->format('d M Y') }}">
                                                            Lunas
                                                        </button>
                                                        <ul class="dropdown-menu">
                                                            <li>
                                                                <button type="button" class="dropdown-item text-danger" data-bs-toggle="modal" data-bs-target="#unpayModal{{ $payment->id }}">
                                                                    Batalkan
                                                                </button>
                                                            </li>
                                                        </ul>
                                                    </div>

                                                    {{-- Modal Konfirmasi Pembatalan --}}
                                                    <div class="modal fade" id="unpayModal{{ $payment->id }}" tabindex="-1" aria-labelledby="unpayModalLabel{{ $payment->id }}" aria-hidden="true">
                                                        <div class="modal-dialog">
                                                            <div class="modal-content">
                                                                <div class="modal-header">
                                                                    <h5 class="modal-title" id="unpayModalLabel{{ $payment->id }}">Konfirmasi Pembatalan</h5>
                                                                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                                                                </div>
                                                                <div class="modal-body text-start">
                                                                    Apakah Anda yakin ingin membatalkan pembayaran <strong>Iuran ke-{{ $i }}</strong> untuk <strong>{{ $member->nama }}</strong>?
                                                                </div>
                                                                <div class="modal-footer">
                                                                    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Tidak</button>
                                                                    <form action="{{ route('backend.kas.unpay', $payment->id) }}" method="POST" class="d-inline">
                                                                        @csrf
                                                                        @method('DELETE')
                                                                        <button type="submit" class="btn btn-danger">Ya, Batalkan</button>
                                                                    </form>
                                                                </div>
                                                            </div>
                                                        </div>
                                                    </div>
                                                @else
                                                    {{-- Jika sudah bayar & tidak punya akses, tampilkan badge --}}
                                                    <span class="badge bg-success" title="Lunas pada {{ $payment->created_at->format('d M Y') }}">Lunas</span>
                                                @endif
                                            @else
                                                @if ($canManageKas)
                                                    {{-- Jika belum bayar & punya akses, tampilkan tombol merah dengan opsi bayar --}}
                                                    <div class="btn-group">
                                                        <button type="button" class="btn btn-sm btn-danger dropdown-toggle" data-bs-toggle="dropdown" aria-expanded="false" title="Belum Lunas">
                                                            Belum
                                                        </button>
                                                        <ul class="dropdown-menu">
                                                            <li>
                                                                <button type="button" class="dropdown-item text-success" data-bs-toggle="modal" data-bs-target="#payModal{{ $member->id }}_{{ $i }}">
                                                                    Tandai Lunas
                                                                </button>
                                                            </li>
                                                        </ul>
                                                    </div>

                                                    {{-- Modal Konfirmasi Pembayaran --}}
                                                    <div class="modal fade" id="payModal{{ $member->id }}_{{ $i }}" tabindex="-1" aria-labelledby="payModalLabel{{ $member->id }}_{{ $i }}" aria-hidden="true">
                                                        <div class="modal-dialog">
                                                            <div class="modal-content">
                                                                <div class="modal-header">
                                                                    <h5 class="modal-title" id="payModalLabel{{ $member->id }}_{{ $i }}">Konfirmasi Pembayaran</h5>
                                                                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                                                                </div>
                                                                <div class="modal-body text-start">
                                                                    Konfirmasi pembayaran <strong>Iuran ke-{{ $i }}</strong> untuk <strong>{{ $member->nama }}</strong>?
                                                                </div>
                                                                <div class="modal-footer">
                                                                    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Batal</button>
                                                                    <form action="{{ route('backend.kas.pay', ['saldo' => $saldo->id, 'member' => $member->id]) }}" method="POST" class="d-inline">
                                                                        @csrf
                                                                        <input type="hidden" name="iuran_ke" value="{{ $i }}">
                                                                        <button type="submit" class="btn btn-primary">Ya, Konfirmasi</button>
                                                                    </form>
                                                                </div>
                                                            </div>
                                                        </div>
                                                    </div>
                                                @else
                                                    {{-- Jika belum bayar & tidak punya akses, tampilkan badge --}}
                                                    <span class="badge bg-danger" title="Belum Lunas">Belum</span>
                                                @endif
                                            @endif
                                        </td>
                                    @endfor
                                    <td class="text-center fw-bold">
                                        Rp {{ number_format($totalPaidByMember * $biayaIuran, 0, ',', '.') }}
                                    </td>
                                </tr>
                            @empty
                                <tr>
                                    <td colspan="{{ $maxPayments + 2 }}" class="text-center">
                                        Tidak ada data anggota.
                                    </td>
                                </tr>
                            @endforelse
                            </tbody>
                        </table>
                        {{-- Pagination --}} 
                        <div class="mt-4">
                            {{ $members->links('pagination::bootstrap-5') }}
                        </div>
                    </div>
                </div>
            </div>
        </section>
    </div>

    {{-- Modal Pengaturan --}}
    @can('update', $saldo)
    <div class="modal fade" id="settingsModal" tabindex="-1" aria-labelledby="settingsModalLabel" aria-hidden="true">
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="settingsModalLabel">Pengaturan Iuran Kas</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <form action="{{ route('backend.kas.settings', $saldo->id) }}" method="POST">
                    @csrf
                    <div class="modal-body">
                        <div class="mb-3">
                            <label for="iuran_nominal" class="form-label">Nominal per Iuran (Rp)</label>
                            <input type="number" class="form-control @error('iuran_nominal') is-invalid @enderror" id="iuran_nominal" name="iuran_nominal" value="{{ old('iuran_nominal', $saldo->iuran_nominal) }}" required>
                            @error('iuran_nominal')
                            <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>
                        <div class="mb-3">
                            <label for="jumlah_iuran" class="form-label">Jumlah Total Iuran</label>
                            <input type="number" class="form-control @error('jumlah_iuran') is-invalid @enderror" id="jumlah_iuran" name="jumlah_iuran" value="{{ old('jumlah_iuran', $saldo->jumlah_iuran) }}" required>
                            @error('jumlah_iuran')
                            <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                            <div class="form-text">Contoh: 12 untuk iuran bulanan selama setahun.</div>
                        </div>
                    </div>
                    <div class="modal-footer">
                        <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Batal</button>
                        <button type="submit" class="btn btn-primary">Simpan Pengaturan</button>
                    </div>
                </form>
            </div>
        </div>
    </div>
    {{-- Modal Konfirmasi Reset Kas --}}
    @can('update', $saldo)
    <div class="modal fade" id="resetKasModal" tabindex="-1" aria-labelledby="resetKasModalLabel" aria-hidden="true">
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="resetKasModalLabel">Konfirmasi Reset Saldo Kas</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body">
                    <p>Anda yakin ingin mereset saldo "Kas"?</p>
                    <p>Semua transaksi iuran yang ada saat ini akan dipindahkan ke saldo baru bernama "Iuran Kas {{ date('M Y') }}" dan saldo "Kas" akan diatur ulang menjadi Rp 0.</p>
                    <p class="text-danger fw-bold">Tindakan ini tidak dapat dibatalkan!</p>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Batal</button>
                    <form action="{{ route('backend.kas.reset', $saldo->id) }}" method="POST" class="d-inline">
                        @csrf
                        <button type="submit" class="btn btn-danger">Ya, Reset Saldo Kas</button>
                    </form>
                </div>
            </div>
        </div>
    </div>
    @endcan
    @endcan
@endsection