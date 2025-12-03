<?php
/**
 * @var \App\Models\Anggota[] $anggota
 */
?>
@extends('backend.layouts.app')

@section('title', 'Mantan Anggota')

@section('content')
    <div class="page-heading">
        <div class="page-title">
            <div class="row">
                <div class="col-12 col-md-6 order-md-1 order-last">
                    <h3>Mantan Anggota</h3>
                    <p class="text-subtitle text-muted">Daftar mantan anggota HIMASI UBSI Yogyakarta.</p>
                </div>
                <div class="col-12 col-md-6 order-md-2 order-first">
                    <nav aria-label="breadcrumb" class="breadcrumb-header float-start float-lg-end">
                        <ol class="breadcrumb">
                            <li class="breadcrumb-item"><a href="{{ route('backend.dashboard') }}">Dashboard</a></li>
                            <li class="breadcrumb-item"><a href="{{ route('backend.anggota.index') }}">Daftar Anggota</a></li>
                            <li class="breadcrumb-item active" aria-current="page">Mantan Anggota</li>
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
                {{-- Tombol Aksi --}}
                <div class="col-12 mb-3">
                    <a href="{{ route('backend.anggota.index') }}" class="btn btn-secondary">
                        <i class="bi bi-arrow-left"></i> Kembali ke Daftar Anggota
                    </a>
                </div>
            </div>

            {{-- DAFTAR MANTAN ANGGOTA --}}
            <div class="row justify-content-center g-4"> 
                @forelse ($anggota as $agt)
                    <div class="col-4 col-sm-4 col-md-3 col-xl-2"> 
                        <div class="card h-100 shadow-sm text-center"> 
                            
                            {{-- Foto--}}
                            <div class="card-content image-sq-container overflow-hidden"> 
                                <img src="{{ !empty($agt->foto) ? asset('storage/' . $agt->foto) : asset('backend-assets/images/default.png') }}"
                                class="card-img-top object-fit-cover w-100 h-100" 
                                alt="{{ $agt->users->nama ?? $agt->nama }}">
                            </div>
                            
                            <div class="card-body d-flex flex-column justify-content-between"> 
                                <div>
                                    <h5 class="card-title text-truncate">{{ $agt->users->nama ?? $agt->nama }}</h5>
                                    <p class="card-text text-truncate text-muted">{{ $agt->jabatan->nama_jabatan }}</p>
                                    {{-- Tampilkan waktu dihapus sebagai info tambahan --}}
                                    <small class="text-danger">Dihentikan/Purnatugas pada: {{ $agt->deleted_at->format('d/m/Y') }}</small> 
                                </div>

                                {{-- Tombol Aksi (RESTORE & FORCE DELETE) --}}
                                <div class="d-flex gap-2 mt-2 justify-content-center"> 
                                    
                                    {{-- 1. Tombol PULIHKAN (RESTORE) --}}
                                    {{-- Membutuhkan Route::put baru: backend.anggota.restore --}}
                                    <form action="{{ route('backend.anggota.restore', $agt->id) }}" method="POST" class="d-inline">
                                        @csrf
                                        @method('PUT')
                                        <button type="submit" class="btn btn-success btn-sq" title="Pulihkan Anggota">
                                            <i class="bi bi-arrow-counterclockwise"></i>
                                        </button>
                                    </form>
                                    
                                    {{-- 2. Tombol HAPUS PERMANEN (FORCE DELETE) --}}
                                    {{-- Membutuhkan Route::delete baru: backend.anggota.forceDelete --}}
                                    <button type="button" class="btn btn-danger btn-sq" data-bs-toggle="modal" data-bs-target="#forceDeleteModal{{ $agt->id }}" title="Hapus Permanen">
                                        <i class="bi bi-x-square-fill"></i>
                                    </button>
                                </div>

                                {{-- Modal Konfirmasi Hapus Permanen --}}
                                <div class="modal fade" id="forceDeleteModal{{ $agt->id }}" tabindex="-1" aria-labelledby="forceDeleteModalLabel{{ $agt->id }}" aria-hidden="true">
                                    <div class="modal-dialog">
                                        <div class="modal-content">
                                            <div class="modal-header">
                                                <h5 class="modal-title" id="forceDeleteModalLabel{{ $agt->id }}">Konfirmasi Hapus PERMANEN</h5>
                                                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                                            </div>
                                            <div class="modal-body text-start text-danger">
                                                ⚠️ Anda yakin ingin menghapus data anggota '{{ $agt->users->nama ?? $agt->nama }}' secara **PERMANEN**? Tindakan ini tidak dapat dibatalkan.
                                            </div>
                                            <div class="modal-footer">
                                                <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Batal</button>
                                                <form action="{{ route('backend.anggota.forceDelete', $agt->id) }}" method="POST" class="d-inline">
                                                    @csrf
                                                    @method('DELETE')
                                                    <button type="submit" class="btn btn-danger">Hapus Permanen</button>
                                                </form>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                @empty
                    <div class="text-center mt-5">
                        <img src="{{ asset('backend-assets/images/empty-box.png') }}" alt="Kosong" width="200" class="mb-3">
                        <h5 class="text-muted">Belum ada data mantan anggota.</h5>
                    </div>
                @endforelse
            </div>
        </section>
    </div>
@endsection