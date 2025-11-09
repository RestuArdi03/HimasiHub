@extends('backend.layouts.app')

@section('title', 'Tambah Anggota')
@section('page-heading', 'Form Tambah Anggota')

@section('content')
<div class="card">
    <div class="card-body">
        <form action="{{ route('backend.anggota.store') }}" method="POST" enctype="multipart/form-data">
            @csrf

            <div class="mb-3">
                <label for="nama" class="form-label">Nama</label>
                <input type="text" name="nama" class="form-control" required>
            </div>

            <div class="mb-3">
                <label for="nim" class="form-label">NIM</label>
                <input type="text" name="nim" class="form-control" required>
            </div>

            <div class="mb-3">
                <label for="kelas" class="form-label">Kelas</label>
                <input type="text" name="kelas" class="form-control" required>
            </div>

            <div class="mb-3">
                <label for="jurusan" class="form-label">Jurusan</label>
                <input type="text" name="jurusan" class="form-control" required>
            </div>

            <div class="mb-3">
                <label for="no_hp" class="form-label">No HP</label>
                <input type="text" name="no_hp" class="form-control" required>
            </div>

            <div class="mb-3">
                <label for="jabatan" class="form-label">Jabatan</label>
                <input type="text" name="jabatan" class="form-control" required>
            </div>

            <div class="mb-3">
                <label for="alamat" class="form-label">Alamat</label>
                <textarea name="alamat" class="form-control" rows="2" required></textarea>
            </div>

            <div class="mb-3">
                <label for="foto" class="form-label">Foto</label>
                <input type="file" name="foto" class="form-control">
            </div>

            <button type="submit" class="btn btn-primary">Simpan</button>
        </form>
    </div>
</div>
@endsection
