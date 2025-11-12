<?php
/**
 * @var \App\Models\Saldo $saldo
 */
?>
@extends('backend.layouts.app')

@section('title', 'Edit Saldo')

@section('content')
    <div class="page-heading">
        <div class="page-title">
            <div class="row">
                <div class="col-12 col-md-6 order-md-1 order-last">
                    <h3>Edit Saldo</h3>
                    <p class="text-subtitle text-muted">Ubah data sumber saldo keuangan.</p>
                </div>
                <div class="col-12 col-md-6 order-md-2 order-first">
                    <nav aria-label="breadcrumb" class="breadcrumb-header float-start float-lg-end">
                        <ol class="breadcrumb">
                            <li class="breadcrumb-item"><a href="{{ route('backend.dashboard') }}">Dashboard</a></li>
                            <li class="breadcrumb-item"><a href="{{ route('backend.saldo.index') }}">Saldo</a></li>
                            <li class="breadcrumb-item active" aria-current="page">Edit</li>
                        </ol>
                    </nav>
                </div>
            </div>
        </div>

        <section class="section">
            <div class="card">
                <div class="card-header">
                    <h5 class="card-title">Form Edit Saldo: {{ $saldo->nama }}</h5>
                </div>
                <div class="card-body">
                    <form action="{{ route('backend.saldo.update', $saldo) }}" method="POST">
                        @method('PUT')
                        @include('backend.saldo._form')

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