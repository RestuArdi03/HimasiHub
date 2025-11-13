<?php
/**
 * @var \App\Models\Saldo $saldo
 * @var \Illuminate\Support\ViewErrorBag $errors
 */
?>
@extends('backend.layouts.app')

@section('title', 'Tambah Transaksi untuk ' . $saldo->nama)

@section('content')
    <div class="page-heading">
        <div class="page-title">
            <div class="row">
                <div class="col-12 col-md-6 order-md-1 order-last">
                    <h3>Tambah Transaksi</h3>
                    <p class="text-subtitle text-muted">Formulir untuk menambah transaksi baru pada saldo <strong>{{ $saldo->nama }}</strong>.</p>
                </div>
                <div class="col-12 col-md-6 order-md-2 order-first">
                    <nav aria-label="breadcrumb" class="breadcrumb-header float-start float-lg-end">
                        <ol class="breadcrumb">
                            <li class="breadcrumb-item"><a href="{{ route('backend.dashboard') }}">Dashboard</a></li>
                            <li class="breadcrumb-item"><a href="{{ route('backend.saldo.index') }}">Saldo</a></li>
                            <li class="breadcrumb-item"><a href="{{ route('backend.saldo.show', $saldo->id) }}">Detail Saldo</a></li>
                            <li class="breadcrumb-item active" aria-current="page">Tambah Transaksi</li>
                        </ol>
                    </nav>
                </div>
            </div>
        </div>

        <section class="section">
            <div class="card">
                <div class="card-header">
                    <h4 class="card-title">Formulir Transaksi</h4>
                </div>
                <div class="card-body">
                    <form action="{{ route('backend.transaksi.store') }}" method="POST" enctype="multipart/form-data">
                        @csrf
                        <input type="hidden" name="saldo_id" value="{{ $saldo->id }}">

                        <div class="row">
                            <div class="col-md-6">
                                <div class="mb-3">
                                    <label for="keterangan" class="form-label">Keterangan</label>
                                    <input type="text" class="form-control @error('keterangan') is-invalid @enderror" id="keterangan" name="keterangan" value="{{ old('keterangan') }}" required>
                                    @error('keterangan')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                    @enderror
                                </div>

                                <div class="mb-3">
                                    <label for="jenis_transaksi" class="form-label">Jenis Transaksi</label>
                                    <select class="form-select @error('jenis_transaksi') is-invalid @enderror" id="jenis_transaksi" name="jenis_transaksi" required>
                                        <option value="" disabled selected>-- Pilih Jenis --</option>
                                        <option value="debit" @if(old('jenis_transaksi') == 'debit') selected @endif>Pemasukan (Debit)</option>
                                        <option value="kredit" @if(old('jenis_transaksi') == 'kredit') selected @endif>Pengeluaran (Kredit)</option>
                                    </select>
                                    @error('jenis_transaksi')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                    @enderror
                                </div>
                            </div>

                            <div class="col-md-6">
                                <div class="mb-3">
                                    <label for="jumlah" class="form-label">Jumlah (Rp)</label>
                                    <input type="number" step="0.01" class="form-control @error('jumlah') is-invalid @enderror" id="jumlah" name="jumlah" value="{{ old('jumlah') }}" required>
                                    @error('jumlah')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                    @enderror
                                </div>

                                <div class="mb-3">
                                    <label for="gambar" class="form-label">Bukti/Gambar (Opsional)</label>
                                    <input class="form-control @error('gambar') is-invalid @enderror" type="file" id="gambar" name="gambar">
                                    <div class="form-text">Tipe file yang diizinkan: JPG, PNG, GIF. Maksimal 2MB.</div>
                                    @error('gambar')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                    @enderror
                                </div>
                            </div>
                        </div>

                        <div class="mt-4 d-flex justify-content-end">
                            <a href="{{ route('backend.saldo.show', $saldo->id) }}" class="btn btn-secondary me-1">
                                <i class="bi bi-arrow-left"></i> Batal
                            </a>
                            <button type="submit" class="btn btn-primary">
                                <i class="bi bi-save"></i> Simpan Transaksi
                            </button>
                        </div>
                    </form>
                </div>
            </div>
        </section>
    </div>
@endsection