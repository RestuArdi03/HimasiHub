@extends('backend.layouts.app')

@section('title', 'Tambah Anggota Baru')

@section('content')
    <div class="page-heading">
        <div class="page-title">
            <div class="row">
                <div class="col-12 col-md-6 order-md-1 order-last">
                    <h3>Tambah Anggota</h3>
                    <p class="text-subtitle text-muted">Tambahkan data anggota baru.</p>
                </div>
                <div class="col-12 col-md-6 order-md-2 order-first">
                    <nav aria-label="breadcrumb" class="breadcrumb-header float-start float-lg-end">
                        <ol class="breadcrumb">
                            <li class="breadcrumb-item"><a href="{{ route('backend.dashboard') }}">Dashboard</a></li>
                            <li class="breadcrumb-item"><a href="{{ route('backend.anggota.index') }}">Daftar Anggota</a></li>
                            <li class="breadcrumb-item active" aria-current="page">Tambah Anggota</li>
                        </ol>
                    </nav>
                </div>
            </div>
        </div>

        <section class="section">
            <div class="card">
                <div class="card-header">
                    <h5 class="card-title">Form Tambah Anggota</h5>
                </div>
                <div class="card-body">
                    <form action="{{ route('backend.anggota.store') }}" method="POST" enctype="multipart/form-data">
                        @csrf
                        @include('backend.anggota.form_anggota')

                        <div class="col-12 d-flex justify-content-end mt-4">
                            <button type="submit" class="btn btn-primary me-1 mb-1">
                                <i class="bi bi-save"></i> Simpan
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