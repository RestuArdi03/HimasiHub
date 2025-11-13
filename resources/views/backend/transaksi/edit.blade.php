<?php
/**
 * @var \App\Models\Transaksi $transaksi
 * @var \Illuminate\Support\ViewErrorBag $errors
 */
?>
@extends('backend.layouts.app')

@section('title', 'Edit Transaksi')

@section('content')
    <div class="page-heading">
        <div class="page-title">
            <div class="row">
                <div class="col-12 col-md-6 order-md-1 order-last">
                    <h3>Edit Transaksi</h3>
                    <p class="text-subtitle text-muted">Formulir untuk mengubah transaksi pada saldo <strong>{{ $transaksi->saldo->nama }}</strong>.</p>
                </div>
                <div class="col-12 col-md-6 order-md-2 order-first">
                    <nav aria-label="breadcrumb" class="breadcrumb-header float-start float-lg-end">
                        <ol class="breadcrumb">
                            <li class="breadcrumb-item"><a href="{{ route('backend.dashboard') }}">Dashboard</a></li>
                            <li class="breadcrumb-item"><a href="{{ route('backend.saldo.index') }}">Saldo</a></li>
                            <li class="breadcrumb-item"><a href="{{ route('backend.saldo.show', $transaksi->saldo->id) }}">Detail Saldo</a></li>
                            <li class="breadcrumb-item active" aria-current="page">Edit Transaksi</li>
                        </ol>
                    </nav>
                </div>
            </div>
        </div>

        <section class="section">
            <div class="card">
                <div class="card-header">
                    <h4 class="card-title">Formulir Edit Transaksi</h4>
                </div>
                <div class="card-body">
                    <form action="{{ route('backend.transaksi.update', $transaksi->id) }}" method="POST" enctype="multipart/form-data">
                        @csrf
                        @method('PUT')

                        <div class="row">
                            <div class="col-md-6">
                                <div class="mb-3">
                                    <label for="keterangan" class="form-label">Keterangan</label>
                                    <input type="text" class="form-control @error('keterangan') is-invalid @enderror" id="keterangan" name="keterangan" value="{{ old('keterangan', $transaksi->keterangan) }}" required>
                                    @error('keterangan')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                    @enderror
                                </div>

                                <div class="mb-3">
                                    <label for="jenis_transaksi" class="form-label">Jenis Transaksi</label>
                                    <select class="form-select @error('jenis_transaksi') is-invalid @enderror" id="jenis_transaksi" name="jenis_transaksi" required>
                                        <option value="" disabled>-- Pilih Jenis --</option>
                                        @php
                                            $jenis = old('jenis_transaksi', $transaksi->debit > 0 ? 'debit' : 'kredit');
                                        @endphp
                                        <option value="debit" @if($jenis == 'debit') selected @endif>Pemasukan (Debit)</option>
                                        <option value="kredit" @if($jenis == 'kredit') selected @endif>Pengeluaran (Kredit)</option>
                                    </select>
                                    @error('jenis_transaksi')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                    @enderror
                                </div>
                            </div>

                            <div class="col-md-6">
                                <div class="mb-3">
                                    <label for="jumlah" class="form-label">Jumlah (Rp)</label>
                                    @php
                                        $jumlah = old('jumlah', $transaksi->debit > 0 ? $transaksi->debit : $transaksi->kredit);
                                    @endphp
                                    <input type="number" step="0.01" class="form-control @error('jumlah') is-invalid @enderror" id="jumlah" name="jumlah" value="{{ $jumlah }}" required>
                                    @error('jumlah')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                    @enderror
                                </div>

                                <div class="mb-3">
                                    <label for="gambar" class="form-label">Ganti Bukti/Gambar (Opsional)</label>
                                    <input class="form-control @error('gambar') is-invalid @enderror" type="file" id="gambar" name="gambar">
                                    <div class="form-text">Kosongkan jika tidak ingin mengubah gambar. Tipe file: JPG, PNG, GIF. Maks 2MB.</div>
                                    @error('gambar')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                    @enderror

                                    @if($transaksi->gambar)
                                        <div class="mt-2">
                                            <small>Gambar saat ini:</small>
                                            <a href="{{ asset('storage/' . $transaksi->gambar) }}" target="_blank">Lihat Gambar</a>
                                        </div>
                                    @endif
                                </div>
                            </div>
                        </div>

                        <div class="mt-4 d-flex justify-content-end">
                            <a href="{{ route('backend.saldo.show', $transaksi->saldo->id) }}" class="btn btn-secondary me-1">
                                <i class="bi bi-arrow-left"></i> Batal
                            </a>
                            <button type="submit" class="btn btn-primary">
                                <i class="bi bi-save"></i> Simpan Perubahan
                            </button>
                        </div>
                    </form>
                </div>
            </div>
        </section>
    </div>
@endsection