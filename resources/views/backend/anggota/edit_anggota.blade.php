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

        <section class="section">
            <div class="card">
                <div class="card-header">
                    <h5 class="card-title">Form Edit Anggota: {{ $anggota->nama }}</h5>
                </div>
                <div class="card-body">
                    <form action="{{ route('backend.anggota.update', $anggota) }}" method="POST">
                        @method('PUT')
                        @csrf
                        @include('backend.anggota.form_anggota')

                        <div class="col-12 d-flex justify-content-end mt-4">
                            <button type="submit" class="btn btn-primary me-1 mb-1">
                                <i class="bi bi-save"></i> Update
                            </button>
                            <a href="{{ route('backend.saldo.index') }}" class="btn btn-light-secondary me-1 mb-1">
                                <i class="bi bi-x-circle"></i> Batal
                            </a>
                        </div>
                    </form>
                </div>
            </div>
        </section>
    </div>
@endsection