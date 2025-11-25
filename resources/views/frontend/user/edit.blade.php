@extends('layouts.frontend')

@section('title', __('Edit Profile'))

@section('content')
    <div class="container-xxl py-5">
        <div class="container">
            <div class="text-center wow fadeInUp" data-wow-delay="0.1s">
                <h6 class="section-title bg-white text-center text-primary px-3">Profil</h6>
                <h1 class="mb-5">Edit Profil Anda</h1>
            </div>

            <div class="row g-5">
                {{-- Kolom Informasi Profil --}}
                <div class="col-lg-6 wow fadeInUp" data-wow-delay="0.3s">
                    <div class="card h-100">
                        <div class="card-body p-4 p-sm-5">
                            <h4 class="card-title mb-4">{{ __('Informasi Profil') }}</h4>
                            <p class="card-subtitle mb-4 text-muted">
                                {{ __("Perbarui informasi profil dan alamat email akun Anda.") }}
                            </p>

                            @if ($user->role_id)
                                <div class="alert alert-info" role="alert">
                                    <small><i class="fa fa-info-circle me-2"></i>Nama dan Email tidak dapat diubah karena Anda adalah seorang pengurus.</small>
                                </div>
                            @endif

                            @if (session('status') === 'profile-updated')
                                <div class="alert alert-success" role="alert">
                                    Profil berhasil diperbarui.
                                </div>
                            @endif

                            <form method="post" action="{{ route('frontend.user.update', $user->id) }}" enctype="multipart/form-data">
                                @csrf
                                @method('PUT')

                                <div class="mb-3">
                                    <label for="name" class="form-label">{{ __('Nama') }}</label>
                                    <input id="nama" name="nama" type="text" class="form-control @error('nama') is-invalid @enderror" value="{{ old('nama', $user->nama) }}" required autofocus autocomplete="nama" {{ $user->role_id ? 'readonly' : '' }} />
                                    @error('nama', 'updateProfileInformation')
                                        <div class="invalid-feedback">{{ $message }}</div>
                                    @enderror
                                </div>

                                <div class="mb-3">
                                    <label for="email" class="form-label">{{ __('Email') }}</label>
                                    <input id="email" name="email" type="email" class="form-control @error('email') is-invalid @enderror" value="{{ old('email', $user->email) }}" required autocomplete="email" {{ $user->role_id ? 'readonly' : '' }} />
                                    @error('email', 'updateProfileInformation')
                                        <div class="invalid-feedback">{{ $message }}</div>
                                    @enderror
                                </div>

                                @if (!$user->role_id)
                                    <button type="submit" class="btn btn-primary py-2 px-4 mt-2">{{ __('Simpan') }}</button>
                                @endif
                            </form>
                        </div>
                    </div>
                </div>

                {{-- Kolom Ubah Kata Sandi --}}
                <div class="col-lg-6 wow fadeInUp" data-wow-delay="0.5s">
                    <div class="card h-100">
                        <div class="card-body p-4 p-sm-5">
                            <h4 class="card-title mb-4">{{ __('Ubah Kata Sandi') }}</h4>
                            <p class="card-subtitle mb-4 text-muted">
                                {{ __('Pastikan akun Anda menggunakan kata sandi yang panjang dan acak agar tetap aman.') }}
                            </p>

                            @if (session('status') === 'password-updated')
                                <div class="alert alert-success" role="alert">
                                    Kata sandi berhasil diperbarui.
                                </div>
                            @endif

                            {{-- Anda perlu membuat route ini --}}
                            <form method="post" action="{{ route('frontend.user.password.update') }}">
                                @csrf
                                @method('put')

                                <div class="mb-3">
                                    <label for="current_password" class="form-label">{{ __('Kata Sandi Saat Ini') }}</label>
                                    <input id="current_password" name="current_password" type="password" class="form-control @error('current_password', 'updatePassword') is-invalid @enderror" autocomplete="current-password" />
                                    @error('current_password', 'updatePassword')
                                        <div class="invalid-feedback">{{ $message }}</div>
                                    @enderror
                                </div>

                                <div class="mb-3">
                                    <label for="password" class="form-label">{{ __('Kata Sandi Baru') }}</label>
                                    <input id="password" name="password" type="password" class="form-control @error('password', 'updatePassword') is-invalid @enderror" autocomplete="new-password" />
                                     @error('password', 'updatePassword')
                                        <div class="invalid-feedback">{{ $message }}</div>
                                    @enderror
                                </div>

                                <div class="mb-3">
                                    <label for="password_confirmation" class="form-label">{{ __('Konfirmasi Kata Sandi') }}</label>
                                    <input id="password_confirmation" name="password_confirmation" type="password" class="form-control" autocomplete="new-password" />
                                </div>

                                <button type="submit" class="btn btn-primary py-2 px-4 mt-2">{{ __('Simpan') }}</button>
                            </form>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection
