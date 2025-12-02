<?php
/**
 * @var \App\Models\Anggota $anggota
 */
?>
@extends('backend.layouts.app')

@section('title', 'Detail Anggota: ' . $anggota->nama)

@section('content')
    <div class="page-heading">
        <div class="page-title">
            <div class="row">
                <div class="col-12 col-md-6 order-md-1 order-last">
                    <h3>Detail anggota</h3>
                    <p class="text-subtitle text-muted">Informasi lengkap untuk anggota {{ $anggota->nama }}.</p>
                </div>
                <div class="col-12 col-md-6 order-md-2 order-first">
                    <nav aria-label="breadcrumb" class="breadcrumb-header float-start float-lg-end">
                        <ol class="breadcrumb">
                            <li class="breadcrumb-item"><a href="{{ route('backend.dashboard') }}">Dashboard</a></li>
                            <li class="breadcrumb-item"><a href="{{ route('backend.anggota.index') }}">Daftar Anggota</a></li>
                            <li class="breadcrumb-item active" aria-current="page">Detail Anggota</li>
                        </ol>
                    </nav>
                </div>
            </div>
        </div>

        <section class="section">
            <div class="row">
                {{-- Detail Anggota Card --}}
                <div class="col-md-4">
                    <div class="card">
                        <div class="card-body">
                            {{-- Foto--}}
                            <div class="card-content image-sq-container overflow-hidden"> 
                                <img src="{{ !empty($anggota->foto) ? asset('storage/' . $anggota->foto) : asset('backend-assets/images/default.png') }}"
                                class="card-img-top object-fit-cover w-100 h-100" 
                                alt="{{ $anggota->nama }}">
                            </div>

                            {{-- Tombol Aksi --}}
                            <div class="mt-4 d-flex justify-content-center">
                                <a href="{{ route('backend.anggota.index') }}" class="btn btn-secondary me-2">
                                    <i class="bi bi-arrow-left"></i> Kembali
                                </a>
                                @can('update', $anggota)
                                    <a href="{{ route('backend.anggota.edit', $anggota) }}" class="btn btn-warning me-2">
                                        <i class="bi bi-pencil-fill"></i> Edit
                                    </a>
                                @endcan
                                @can('delete', $anggota)
                                    <button type="button" class="btn btn-danger" data-bs-toggle="modal" data-bs-target="#deleteModal{{ $anggota->id }}" title="Berhentikan">
                                        <i class="bi bi-x-square-fill"></i> Berhentikan
                                    </button>
                                @endcan
                            </div>
                        </div>
                    </div>
                </div>

                {{-- Informasi Anggota Card --}}
                <div class="col-md-8">
                    <div class="card">
                        <div class="card-header">
                            <h4 class="card-title">Data Anggota</h4>
                        </div>
                        <div class="card-body">
                            <div class="table-responsive">
                                <table class="table table-striped table-hover">
                                    <tr>
                                        <td>Nama</td>
                                        <td>{{ $user->nama ?? $anggota->nama ?? '-' }}</td>
                                    </tr>
                                    <tr>
                                        <td>NIM</td>
                                        <td>{{ $anggota->nim ?? '-' }}</td>
                                    </tr>
                                    <tr>
                                        <td>Kelas</td>
                                        <td>{{ $anggota->kelas ?? '-' }}</td>
                                    </tr>
                                    <tr>
                                        <td>Jurusan</td>
                                        <td>{{ $anggota->jurusan ?? '-' }}</td>
                                    </tr>
                                    <tr>
                                        <td>No HP</td>
                                        <td>{{ $anggota->no_hp ?? '-' }}</td>
                                    </tr>
                                    <tr>
                                        <td>Jabatan</td>
                                        <td>{{ $anggota->jabatan->nama_jabatan ?? '-'}}</td>
                                    </tr>
                                    <tr>
                                        <td>Role</td>
                                        <td>{{ $anggota->users->role->nama_role ?? '-'}}</td>
                                    </tr>
                                    <tr>
                                        <td>Alamat</td>
                                        <td>{{ $anggota->alamat ?? '-' }}</td>
                                    </tr>
                                    <tr>
                                        <td>Moto Hidup</td>
                                        <td>{{ $anggota->moto_hidup ?? '-' }}</td>
                                    </tr>
                                    <tr>
                                        <td>Email</td>
                                        <td>{{ $anggota->users->email ?? '-' }}</td>
                                    </tr>
                                    <tr>
                                        <td>TikTok</td>
                                        <td>{{ $anggota->tiktok ?? '-' }}</td>
                                    </tr>
                                    <tr>
                                        <td>Instagram</td>
                                        <td>{{ $anggota->instagram ?? '-' }}</td>
                                    </tr>
                                </table>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </section>
    </div>
@endsection
