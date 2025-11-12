@extends('layouts.auth')

@section('title', 'Login')

@section('content')
<div class="container">
    <div class="row justify-content-center align-items-center min-vh-100">
        <div class="col-lg-5 col-md-7 col-sm-9">

            <div class="text-center mb-4">
                <a href="{{ route('frontend.index') }}">
                    <h2 class="m-0 text-primary"><i class="fa fa-book me-3"></i>HimasiHub</h2>
                </a>
            </div>

            <div class="card shadow-sm border-0">
                <div class="card-body p-4">
                    <div class="text-center mb-4">
                        <h4 class="card-title">Selamat Datang!</h4>
                        <p class="text-muted">Silakan login untuk melanjutkan.</p>
                    </div>

                    @if (session('error'))
                        <div class="alert alert-danger" role="alert">
                            {{ session('error') }}
                        </div>
                    @endif

                    <form method="POST" action="{{ route('login') }}" class="mt-4">
                        @csrf

                        <div class="mb-3">
                            <label for="email" class="form-label">{{ __('Alamat Email') }}</label>
                            <input id="email" type="email" class="form-control form-control-lg @error('email') is-invalid @enderror" name="email" value="{{ old('email') }}" required autocomplete="email" autofocus placeholder="contoh@email.com">
                            @error('email')
                                <span class="invalid-feedback" role="alert">
                                    <strong>{{ $message }}</strong>
                                </span>
                            @enderror
                        </div>

                        <div class="mb-3">
                            <div class="d-flex justify-content-between">
                                <label for="password" class="form-label">{{ __('Password') }}</label>
                                @if (Route::has('password.request'))
                                    <a href="{{ route('password.request') }}" class="text-muted small">Lupa Password?</a>
                                @endif
                            </div>
                            <input id="password" type="password" class="form-control form-control-lg @error('password') is-invalid @enderror" name="password" required autocomplete="current-password" placeholder="Masukkan password">
                            @error('password')
                                <span class="invalid-feedback" role="alert">
                                    <strong>{{ $message }}</strong>
                                </span>
                            @enderror
                        </div>

                        <div class="form-check mb-4">
                            <input class="form-check-input" type="checkbox" name="remember" id="remember" {{ old('remember') ? 'checked' : '' }}>
                            <label class="form-check-label" for="remember">{{ __('Ingat Saya') }}</label>
                        </div>

                        <div class="d-grid gap-2">
                            <button type="submit" class="btn btn-primary btn-lg">{{ __('Login') }}</button>
                            @if (Route::has('google.redirect'))
                                <a href="{{ route('google.redirect') }}" class="btn btn-outline-secondary btn-lg">
                                    <i class="fab fa-google me-2"></i> {{ __('Login dengan Google') }}
                                </a>
                            @endif
                        </div>
                    </form>
                </div>
            </div>
            <div class="text-center mt-4">
                <a href="{{ route('frontend.index') }}" class="text-muted"><i class="fa fa-arrow-left me-2"></i>Kembali ke Beranda</a>
            </div>
        </div>
    </div>
</div>
@endsection
