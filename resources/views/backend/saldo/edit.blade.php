<?php
/**
 * @var \App\Models\Saldo $saldo
 * @var \Illuminate\Support\ViewErrorBag $errors
 */
?>
@extends('backend.layouts.app')

@section('title', 'Edit Saldo: ' . $saldo->nama)

@section('content')
    <div class="page-heading">
        <div class="page-title">
            <div class="row">
                <div class="col-12 col-md-6 order-md-1 order-last">
                    <h3>Edit Saldo</h3>
                    <p class="text-subtitle text-muted">Mengubah nama untuk saldo {{ $saldo->nama }}.</p>
                </div>
                <div class="col-12 col-md-6 order-md-2 order-first">
                    <nav aria-label="breadcrumb" class="breadcrumb-header float-start float-lg-end">
                        <ol class="breadcrumb">
                            <li class="breadcrumb-item"><a href="{{ route('backend.dashboard') }}">Dashboard</a></li>
                            <li class="breadcrumb-item"><a href="{{ route('backend.saldo.index') }}">Saldo</a></li>
                            <li class="breadcrumb-item"><a href="{{ route('backend.saldo.show', $saldo->id) }}">Detail Saldo</a></li>
                            <li class="breadcrumb-item active" aria-current="page">Edit Saldo</li>
                        </ol>
                    </nav>
                </div>
            </div>
        </div>

        <section class="section">
            <div class="card">
                <div class="card-header">
                    <h4 class="card-title">Formulir Edit Saldo</h4>
                </div>
                <div class="card-body">
                    <form action="{{ route('backend.saldo.update', $saldo->id) }}" method="POST">
                        @csrf
                        @method('PUT')

                        <div class="row">
                            <div class="col-md-6">
                                <div class="mb-3">
                                    <label for="nama" class="form-label">Nama Saldo</label>
                                    <input type="text" class="form-control @error('nama') is-invalid @enderror" id="nama" name="nama" value="{{ old('nama', $saldo->nama) }}" required>
                                    @error('nama')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                    @enderror
                                </div>
                            </div>
                            <div class="col-md-6">
                                <div class="mb-3">
                                    <label class="form-label">Saldo Saat Ini (Read-only)</label>
                                    <input type="text" class="form-control" value="Rp {{ number_format($saldo->balance, 2, ',', '.') }}" readonly disabled>
                                    <div class="form-text">Saldo hanya dapat diubah melalui penambahan/pengurangan transaksi.</div>
                                </div>
                            </div>
                        </div>

                        <div class="mt-3 d-flex justify-content-end">
                            <a href="{{ route('backend.saldo.show', $saldo->id) }}" class="btn btn-secondary me-1">
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