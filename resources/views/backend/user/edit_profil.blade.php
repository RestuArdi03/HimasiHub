<?php
/**
 * @var \App\Models\Ang $anggota
 */
?>
@extends('backend.layouts.app')

@section('title', 'Edit User')

@section('content')
    <div class="page-heading">
        <div class="page-title">
            <div class="row">
                <div class="col-12 col-md-6 order-md-1 order-last">
                    <h3>Edit Profil</h3>
                    <p class="text-subtitle text-muted">Edit profil anda sesuai data terbaru anda.</p>
                </div>
                <div class="col-12 col-md-6 order-md-2 order-first">
                    <nav aria-label="breadcrumb" class="breadcrumb-header float-start float-lg-end">
                        <ol class="breadcrumb">
                            <li class="breadcrumb-item"><a href="{{ route('backend.dashboard') }}">Dashboard</a></li>
                            <li class="breadcrumb-item active" aria-current="page">Edit Profil</li>
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
                    <h5 class="card-title">Form Edit Profil</h5>
                </div>
                <div class="card-body">
                    <form action="{{ route('backend.anggota.update', $anggota->id) }}" method="POST" enctype="multipart/form-data">
                        @csrf
                        @method('PUT')

                        {{-- HIDDEN --}}
                        <input type="hidden" name="kode" value="1">
                        <input type="hidden" name="nama" value="{{ $anggota->nama ?? '' }}">
                        <input type="hidden" name="nim" value="{{ $anggota->nim ?? '' }}">
                        <input type="hidden" name="kelas" value="{{ $anggota->kelas ?? '' }}">
                        <input type="hidden" name="jurusan" value="{{ $anggota->jurusan ?? '' }}">
                        <input type="hidden" name="jabatan_id" value="{{ $anggota->jabatan_id ?? '' }}">
                        <input type="hidden" name="users_id" value="{{ $anggota->users_id ?? '' }}">

                        
                        <div class="row">
                            <div class="col-md-6 mb-2">
                                <div class="form-group">
                                    <label for="nama">Nama</label>
                                    <input type="text" class="form-control @error('nama') is-invalid @enderror" id="nama" name="nama"
                                        value="{{ old('nama', $anggota->users->nama ?? '') }}" placeholder="Masukkan nama lengkap anggota" required disabled>
                                    @error('nama')
                                    <div class="invalid-feedback">
                                        {{ $message }}
                                    </div>
                                    @enderror
                                </div>
                            </div>
                            <div class="col-md-6 mb-2">
                                <div class="form-group">
                                    <label for="nim">NIM</label>
                                    <input type="text" class="form-control @error('nim') is-invalid @enderror" id="nim" name="nim"
                                        value="{{ old('nim', $anggota->nim ?? '') }}" placeholder="Masukkan NIM anggota" required disabled >
                                    @error('nim')
                                    <div class="invalid-feedback">
                                        {{ $message }}
                                    </div>
                                    @enderror
                                </div>
                            </div>
                            <div class="col-md-6 mb-2">
                                <label for="kelas">Kelas</label>
                                <fieldset class="form-group">
                                    <select class="form-select" id="kelas" name="kelas" required disabled> >
                                        <option value=""  {{ old('kelas', $anggota->kelas ?? '') == '' ? 'selected' : '' }}>Pilih Kelas</option>
                                        <option value="19.1A.09" {{ old('kelas', $anggota->kelas ?? '') == '19.1A.09' ? 'selected' : '' }}>19.1A.09</option>
                                        <option value="19.2A.09" {{ old('kelas', $anggota->kelas ?? '') == '19.2A.09' ? 'selected' : '' }}>19.2A.09</option>
                                        <option value="19.3A.09" {{ old('kelas', $anggota->kelas ?? '') == '19.3A.09' ? 'selected' : '' }}>19.3A.09</option>
                                        <option value="19.4A.09" {{ old('kelas', $anggota->kelas ?? '') == '19.4A.09' ? 'selected' : '' }}>19.4A.09</option>
                                        <option value="19.5A.09" {{ old('kelas', $anggota->kelas ?? '') == '19.5A.09' ? 'selected' : '' }}>19.5A.09</option>
                                    </select>
                                </fieldset>
                                @error('kelas')
                                    <div class="invalid-feedback">
                                        {{ $message }}
                                    </div>
                                @enderror
                            </div>
                            <div class="col-md-6 mb-2">
                                <label for="jurusan">Jurusan</label>
                                <fieldset class="form-group">
                                    <select class="choices form-select" id="jurusan" name="jurusan" required disabled> >
                                        <option value=""  {{ old('jurusan', $anggota->jurusan ?? '') == '' ? 'selected' : '' }}>Pilih Jurusan</option>
                                        <option value="Sistem Informasi" {{ old('jurusan', $anggota->jurusan ?? '') == 'Sistem Informasi' ? 'selected' : '' }}>Sistem Informasi</option>
                                    </select>
                                </fieldset>
                                @error('jurusan')
                                    <div class="invalid-feedback">
                                        {{ $message }}
                                    </div>
                                @enderror
                            </div>
                            <div class="col-md-6 mb-2">
                                <div class="form-group">
                                    <label for="no_hp">No HP</label>
                                    <input type="number" class="form-control @error('no_hp') is-invalid @enderror" id="no_hp" name="no_hp"
                                        value="{{ old('no_hp', $anggota->no_hp ?? '') }}" placeholder="Masukkan No HP anggota">
                                    @error('no_hp')
                                    <div class="invalid-feedback">
                                        {{ $message }}
                                    </div>
                                    @enderror
                                </div>
                            </div>
                            <div class="col-md-6 mb-2">
                                <label for="_id">Jabatan</label>
                                <fieldset class="form-group">
                                    <select class="choices form-select" id="jabatan_id" name="jabatan_id" required disabled> >
                                        <option value=""  selected>Pilih Jabatan</option>

                                        {{-- Dapatkan ID role anggota saat ini untuk pre-selection --}}
                                        @php
                                            $currentRoleId = old('role_id', $anggota->users->role_id ?? ''); 
                                        @endphp
                                        
                                        @foreach ($jabatan as $jab)
                                            @php
                                                // 1. Ambil role_id dari relasi Model Jabatan
                                                $roleId = $jab->role->id ?? ''; 
                                                $selectedValue = old('jabatan_id', $anggota->jabatan_id ?? '');
                                            @endphp

                                            <option 
                                                value="{{ $jab->id }}"
                                                {{-- Tambahkan atribut data-role-id untuk JS --}}
                                                data-role-id="{{ $roleId }}" 
                                                {{ $selectedValue == $jab->id ? 'selected' : '' }}>
                                                {{ $jab->nama_jabatan }} (Role: {{ $jab->role->nama_role ?? 'N/A' }})
                                            </option>
                                        @endforeach
                                    </select>
                                </fieldset>
                                @error('jabatan_id')
                                    <div class="invalid-feedback">
                                        {{ $message }}
                                    </div>
                                @enderror
                            </div>
                            {{-- FIELD TERSEMBUNYI UNTUK MENYIMPAN ROLE_ID --}}
                            <input type="hidden" name="role_id" id="role_id_input" value="{{ $currentRoleId }}">

                            <div class="col-md-6 mb-2">
                                <div class="form-group">
                                    <label for="alamat">Alamat</label>
                                    <input type="text" class="form-control @error('alamat') is-invalid @enderror" id="alamat" name="alamat"
                                        value="{{ old('alamat', $anggota->alamat ?? '') }}" placeholder="Masukkan alamat lengkap anggota">
                                    @error('alamat')
                                    <div class="invalid-feedback">
                                        {{ $message }}
                                    </div>
                                    @enderror
                                </div>
                            </div>
                            <div class="col-md-6 mb-2">
                                <div class="form-group">
                                    <label for="moto_hidup">Moto Hidup</label>
                                    <input type="text" class="form-control @error('moto_hidup') is-invalid @enderror" id="moto_hidup" name="moto_hidup"
                                        value="{{ old('moto_hidup', $anggota->moto_hidup ?? '') }}" placeholder="Masukkan moto hidup anggota">
                                    @error('moto_hidup')
                                    <div class="invalid-feedback">
                                        {{ $message }}
                                    </div>
                                    @enderror
                                </div>
                            </div>
                            <div class="col-md-6 mb-2">
                                <label for="_id">Email</label>
                                <fieldset class="form-group">
                                    <select class="choices form-select" id="users_id" name="users_id" required disabled> >
                                        <option value=""  selected>Pilih Email</option>
                                    
                                            {{-- Loop untuk mengisi opsi dari data tabel jabatan --}}
                                            @foreach ($users as $user)
                                                
                                                {{-- Dapatkan nilai yang tersimpan/lama untuk perbandingan --}}
                                                @php
                                                    $selectedValue = old('users_id', $anggota->users_id ?? '');
                                                @endphp

                                                <option value="{{ $user->id }}"
                                                    {{ $selectedValue == $user->id ? 'selected' : '' }}>
                                                    {{ $user->email }}
                                                </option>
                                            @endforeach
                                    </select>
                                </fieldset>
                                @error('users_id')
                                    <div class="invalid-feedback">
                                        {{ $message }}
                                    </div>
                                @enderror
                            </div>
                            <div class="col-md-6 mb-2">
                                <div class="form-group">
                                    <label for="tiktok">Tiktok</label>
                                    <input type="text" class="form-control @error('tiktok') is-invalid @enderror" id="tiktok" name="tiktok"
                                        value="{{ old('tiktok', $anggota->tiktok ?? '') }}" placeholder="Masukkan link TikTok anggota">
                                    @error('tiktok')
                                    <div class="invalid-feedback">
                                        {{ $message }}
                                    </div>
                                    @enderror
                                </div>
                            </div>
                            <div class="col-md-6 mb-2">
                                <div class="form-group">
                                    <label for="instagram">Instagram</label>
                                    <input type="text" class="form-control @error('instagram') is-invalid @enderror" id="instagram" name="instagram"
                                        value="{{ old('instagram', $anggota->instagram ?? '') }}" placeholder="Masukkan link Instagram anggota">
                                    @error('instagram')
                                    <div class="invalid-feedback">
                                        {{ $message }}
                                    </div>
                                    @enderror
                                </div>
                            </div>
                            <div class="col-md-6 mb-2">
                                <div class="form-group">
                                    <label for="foto">Foto (rasio 1x1)</label>
                                    <input type="file" class="form-control @error('foto') is-invalid @enderror" id="foto" name="foto"
                                        value="{{ old('foto', $anggota->foto ?? '') }}" placeholder="Tambahkan foto anggota" disabled>
                                    @error('foto')
                                    <div class="invalid-feedback">
                                        {{ $message }}
                                    </div>
                                    @enderror
                                </div>
                            </div>
                            
                        </div>

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