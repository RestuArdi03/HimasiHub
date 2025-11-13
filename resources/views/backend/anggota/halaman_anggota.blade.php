@extends('backend.layouts.app')

@section('title', 'Daftar Anggota')

@section('content')

    <div class="page-heading">
        <div class="page-title">
            <div class="row">
                <div class="col-12 col-md-6 order-md-1 order-last">
                    <h3>Daftar Anggota</h3>
                    <p class="text-subtitle text-muted">Pengelolaan daftar anggota/pengurus inti HIMASI UBSI Yogyakarta</p>
                </div>
                <div class="col-12 col-md-6 order-md-2 order-first">
                    <nav aria-label="breadcrumb" class="breadcrumb-header float-start float-lg-end">
                        <ol class="breadcrumb">
                            <li class="breadcrumb-item"><a href="{{ route('backend.dashboard') }}">Dashboard</a></li>
                            <li class="breadcrumb-item active" aria-current="page">Daftar Anggota</li>
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
                <div class="col-12" style="margin-bottom: -20px;">
                    <a href="{{ route('backend.anggota.create') }}" class="btn btn-primary">
                        <i class="bi bi-plus-lg"></i> Tambah Anggota
                    </a>
                    <a href="{{ route('backend.anggota.trash') }}" class="btn btn-danger">
                        <i class="bi bi-trash3-fill"></i> Mantan Anggota
                    </a>
                </div>

                {{-- Data Anggota --}}
                <div class="row justify-content-center g-4"> 
                    @forelse ($anggota as $agt)
                        <div class="col-4 col-sm-4 col-md-3 col-xl-2"> 
                            <div class="card h-100 shadow-sm text-center"> 
                                
                                {{-- Foto--}}
                                <div class="card-content image-sq-container overflow-hidden"> 
                                    <img src="{{ !empty($agt->foto) ? asset('storage/' . $agt->foto) : asset('backend-assets/images/default.png') }}"
                                    class="card-img-top object-fit-cover w-100 h-100" 
                                    alt="{{ $agt->nama }}">
                                </div>
                                
                                <div class="card-body d-flex flex-column justify-content-between"> 
    
                                    {{-- Keterangan --}}
                                    <div>
                                        <h5 class="card-title text-truncate">{{ $agt->nama }}</h5>
                                        <p class="card-text text-truncate text-muted">{{ $agt->jabatan }}</p>
                                    </div>

                                    {{-- Tombol Aksi --}}
                                    <div class="d-flex gap-2 mt-2 justify-content-center"> 
                                        
                                        {{-- Tombol Detail: Gunakan btn-sq dan warna yang sesuai --}}
                                        <a href="{{ route('backend.anggota.show', $agt->id) }}" class="btn btn-info btn-sq" title="Detail">
                                            <i class="bi bi-eye-fill"></i>
                                        </a>
                                        
                                        {{-- Tombol Edit --}}
                                        <a href="{{ route('backend.anggota.edit', $agt) }}" class="btn btn-warning btn-sq" title="Edit">
                                            <i class="bi bi-pencil-fill"></i>
                                        </a>
                                        
                                        {{-- Tombol Hapus --}}
                                        <button type="button" class="btn btn-sm btn-danger" data-bs-toggle="modal" data-bs-target="#deleteModal{{ $agt->id }}" title="Berhentikan">
                                                <i class="bi bi-x-square-fill"></i>
                                        </button>

                                        {{-- Modal Konfirmasi Hapus --}}
                                        <div class="modal fade" id="deleteModal{{ $agt->id }}" tabindex="-1" aria-labelledby="deleteModalLabel{{ $agt->id }}" aria-hidden="true">
                                            <div class="modal-dialog">
                                                <div class="modal-content">
                                                    <div class="modal-header">
                                                        <h5 class="modal-title" id="deleteModalLabel{{ $agt->id }}">Konfirmasi Hapus</h5>
                                                        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                                                    </div>
                                                    <div class="modal-body">
                                                        Apakah Anda yakin ingin memberhentikan anggota '{{ $agt->nama }}'?
                                                    </div>
                                                    <div class="modal-footer">
                                                        <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Batal</button>
                                                        <form action="{{ route('backend.anggota.destroy', $agt->id) }}" method="POST" class="d-inline">
                                                            @csrf
                                                            @method('DELETE')
                                                            <button type="submit" class="btn btn-danger">Berhentikan</button>
                                                        </form>
                                                    </div>
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
                            <h5 class="text-muted">Belum ada data anggota.</h5>
                        </div>
                    @endforelse
                </div>
            </div>
        </section>
    </div>
@endsection
