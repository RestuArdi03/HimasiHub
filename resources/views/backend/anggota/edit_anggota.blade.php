<?php
/**
 * @var \App\Models\Anggota $anggota
 */
?>
@extends('backend.layouts.app')

@section('title', 'Edit Anggota')

@section('content')
    <div class="page-heading">
        <div class="page-title">
            <div class="row">
                <div class="col-12 col-md-6 order-md-1 order-last">
                    <h3>Edit Anggota</h3>
                    <p class="text-subtitle text-muted">Edit data anggota/pengurus inti HIMASI UBSI Yogyakarta.</p>
                </div>
                <div class="col-12 col-md-6 order-md-2 order-first">
                    <nav aria-label="breadcrumb" class="breadcrumb-header float-start float-lg-end">
                        <ol class="breadcrumb">
                            <li class="breadcrumb-item"><a href="{{ route('backend.dashboard') }}">Dashboard</a></li>
                            <li class="breadcrumb-item"><a href="{{ route('backend.anggota.index') }}">Daftar Anggota</a></li>
                            <li class="breadcrumb-item active" aria-current="page">Edit Anggota</li>
                        </ol>
                    </nav>
                </div>
            </div>
        </div>

        {{-- START: TEMPAT MELETAKKAN PESAN ERROR VALIDASI GLOBAL --}}
        @if ($errors->any())
            <div class="alert alert-danger alert-dismissible fade show" role="alert">
                <h5 class="alert-heading"><i class="bi bi-exclamation-triangle-fill"></i> Validasi Gagal:</h5>
                <ul class="mb-0">
                    @foreach ($errors->all() as $error)
                        <li>{{ $error }}</li>
                    @endforeach
                </ul>
                <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
            </div>
        @endif

        <section class="section">
            <div class="card">
                <div class="card-header">
                    <h5 class="card-title">Form Edit Anggota: {{ $anggota->users->nama ?? $anggota->nama }}</h5>
                </div>
                <div class="card-body">
                    <form action="{{ route('backend.anggota.update', $anggota->id) }}" method="POST" enctype="multipart/form-data">
                        @csrf
                        @method('PUT')
                        @include('backend.anggota.form_anggota')

                        <div class="col-12 d-flex justify-content-end mt-4">
                            <button type="submit" class="btn btn-primary me-1 mb-1">
                                <i class="bi bi-save"></i> Update
                            </button>
                            <a href="{{ route('backend.anggota.index') }}" class="btn btn-light-secondary me-1 mb-1">
                                <i class="bi bi-x-circle"></i> Batal
                            </a>
                        </div>
                    </form>
                </div>
            </div>
        </section>
    </div>
@endsection