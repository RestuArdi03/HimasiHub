@extends('backend.layouts.app')

@section('title', 'Daftar Anggota')

@section('content')
    <div class="page-heading d-flex align-items-center">
        <h3>
            Daftar Anggota
        </h3>
        <div class="buttons ms-3">
            <a href="{{ route('backend.anggota.create') }}" class="btn btn-success">
                Tambah Anggota
            </a>
        </div>
    </div>
    
    <div class="row justify-content-center">
        @foreach ($anggota as $agt)
            <div class="col-xl-3 col-md-4 col-sm-6 mb-4">
                <div class="card h-100 shadow-sm" style="max-width: 400px;">
                    <div class="card-content">
                        <img src="{{ $agt->foto ? asset('storage/' . $agt->foto) : asset('backend-assets/images/default.png') }}"
                             class="card-img-top img-fluid"
                             style="width: 400px; height: 400px; object-fit: cover"
                             alt="{{ $agt->nama }}">
                        <div class="card-body text-center">
                            <h5 class="card-title">{{ $agt->nama }}</h5>
                            <p class="card-text">{{ $agt->jabatan }}</p>
                        </div>
                    </div>
                </div>
            </div>
        @endforeach
    </div>

@endsection
