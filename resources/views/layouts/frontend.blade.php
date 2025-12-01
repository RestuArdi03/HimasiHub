<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">

<head>
    <meta charset="utf-8">
    <title>HimasiHub - @yield('title', 'Sistem Informasi')</title>
    <meta content="width=device-width, initial-scale=1.0" name="viewport">
    <meta content="" name="keywords">
    <meta content="" name="description">

    <!-- CSRF Token -->
    <meta name="csrf-token" content="{{ csrf_token() }}">

    <!-- Favicon -->
    <link href="frontend-assets/img/favicon.ico" rel="icon">

    <!-- Google Web Fonts -->
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Heebo:wght@400;500;600&family=Nunito:wght@600;700;800&display=swap" rel="stylesheet">

    <!-- Icon Font Stylesheet -->
    <link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.10.0/css/all.min.css" rel="stylesheet">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.4.1/font/bootstrap-icons.css" rel="stylesheet">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.13.1/font/bootstrap-icons.min.css">

    <!-- Libraries Stylesheet -->
    <link href="{{ asset('lib/animate/animate.min.css') }}" rel="stylesheet">
    <link href="{{ asset('lib/owlcarousel/assets/owl.carousel.min.css') }}" rel="stylesheet">

    <!-- Customized Bootstrap Stylesheet -->
    <link href="{{ asset('frontend-assets/css/bootstrap.min.css') }}" rel="stylesheet">

    <!-- Template Stylesheet -->
    <link href="{{ asset('frontend-assets/css/style.css') }}" rel="stylesheet">
    
    <!-- Custom CSS -->
    <link href="{{ asset('css/style.css') }}" rel="stylesheet">

    @stack('styles')
</head>

<body>
    <!-- Spinner Start -->
    <div id="spinner" class="show bg-white position-fixed translate-middle w-100 vh-100 top-50 start-50 d-flex align-items-center justify-content-center">
        <div class="spinner-border text-primary" style="width: 3rem; height: 3rem;" role="status">
            <span class="sr-only">Loading...</span>
        </div>
    </div>
    <!-- Spinner End -->


    <!-- Navbar Start -->
    <nav class="navbar navbar-expand-lg bg-white navbar-light shadow sticky-top p-0">
        <a href="{{ route('frontend.index') }}" class="navbar-brand d-flex align-items-center px-4 px-lg-5">
            <img src="{{ asset('asset/logo.png') }}" alt="HimasiHub" class="navbar-logo me-2"> 
            <h2 class="text-himasi">HimasiHub</h2>
        </a>
        <button type="button" class="navbar-toggler me-4" data-bs-toggle="collapse" data-bs-target="#navbarCollapse">
            <span class="navbar-toggler-icon"></span>
        </button>
        <div class="collapse navbar-collapse" id="navbarCollapse">
            <div class="navbar-nav ms-auto p-4 p-lg-0">
                <a href="{{ route('frontend.index') }}" class="nav-item d-flex nav-link {{ request()->routeIs('frontend.index') ? 'active' : '' }}">Beranda</a>
                {{-- Contoh rute lain, Anda bisa membuat rute ini di web.php --}}
                <a href="{{ route('frontend.about.index') }}" class="nav-item d-flex nav-link {{ request()->routeIs('frontend.about.*') ? 'active' : '' }}">Tentang Kami</a>
                <a href="{{ route('frontend.konten.index') }}" class="nav-item d-flex nav-link {{ request()->routeIs('frontend.konten.*') ? 'active' : '' }}">Publikasi</a>
                <div class="nav-item d-flex dropdown">
                    <a href="#" class="nav-link dropdown-toggle {{ request()->routeIs('frontend.anggota.*', 'frontend.contact.*', 'frontend.bantuan.*') ? 'active' : '' }}" data-bs-toggle="dropdown">Lain-lain</a>
                    <div class="dropdown-menu fade-down m-0">
                        <a href="{{ route('frontend.anggota.index') }}" class="dropdown-item">Anggota</a>
                        <a href="{{ route('frontend.contact.index') }}" class="dropdown-item">Kontak Kami</a>
                        <a href="{{ route('frontend.bantuan.index') }}" class="dropdown-item">Bantuan</a>
                        <a href="#" class="dropdown-item">Belum ada ide lagi mau diisi apa...</a>
                    </div>
                </div>
                
                @guest
                    {{-- Tautan ini akan muncul di menu mobile --}}
                    <a href="{{ route('login') }}" class="nav-item nav-link d-lg-none">Login</a>
                @else
                    <div class="nav-item dropdown">
                        <a href="#" class="nav-link" data-bs-toggle="dropdown" aria-expanded="false">
                            <div class="d-flex align-items-center">
                                <div class="me-2">
                                    <img src="{{ Auth::user()->avatar ?? 'https://www.gravatar.com/avatar/' . md5(strtolower(trim(Auth::user()->email))) . '?d=mp' }}"
                                        alt="avatar"
                                        class="rounded-circle avatar-img">
                                </div>
                                <div class="d-none d-lg-block">
                                    <div class="user-name">{{ Auth::user()->nama }}</div>
                                </div>
                            </div>
                        </a>
                        <div class="dropdown-menu fade-down m-0">
                            <h6 class="dropdown-header">Hello, {{ strtok(Auth::user()->nama, " ") }}!</h6>
                            @if(Auth::user()->role)
                                <a href="{{ route('backend.dashboard') }}" class="dropdown-item">Dashboard</a>
                            @endif
                            <a class="dropdown-item" href="{{ route('frontend.user.edit', Auth::user()->id) }}">Ubah Profil</a>
                            <hr class="dropdown-divider">
                            <a href="{{ route('logout') }}" class="dropdown-item" onclick="event.preventDefault(); document.getElementById('logout-form').submit();"><i class="fa fa-sign-out-alt me-2"></i>Keluar</a>
                            <form id="logout-form" action="{{ route('logout') }}" method="POST" class="d-none">@csrf</form>
                        </div>
                    </div>
                @endguest
            </div>
            @guest
                <a href="{{ route('login') }}" class="btn btn-primary py-4 px-lg-5 d-none d-lg-block">Login<i class="fa fa-arrow-right ms-3"></i></a>
            @endguest
        </div>
    </nav>
    <!-- Navbar End -->

    <main>
        @yield('content')
    </main>

    <!-- Footer Start -->
    <div class="container-fluid bg-dark text-light footer pt-5 mt-5 wow fadeIn" data-wow-delay="0.1s">
        <div class="container py-5">
            <div class="row g-5">
                <div class="col-lg-3 col-md-6">
                    <a href="{{ route('frontend.index') }}">
                        <img src="{{ asset('asset/logo.png') }}" alt="HimasiHub" class="footer-logo">
                    </a>
                </div>
                <div class="col-lg-3 col-md-6">
                    <h4 class="text-white mb-3">Menu Pintas</h4>
                    <a class="btn btn-link" href="{{ route('frontend.about.index') }}">Tentang Kami</a>
                    <a class="btn btn-link" href="{{ route('frontend.konten.index') }}">Publikasi</a>
                    <a class="btn btn-link" href="{{ route('frontend.anggota.index') }}">Anggota</a>
                    <a class="btn btn-link" href="{{ route('frontend.contact.index') }}">Kontak Kami</a>
                    <a class="btn btn-link" href="{{ route('frontend.bantuan.index') }}">Bantuan</a>
                </div>
                <div class="col-lg-6 col-md-6">
                    <h4 class="text-white mb-3">Hubungi Kami di</h4>
                    <p class="mb-0">Sekretariat:</p>
                    <p class="mb-2">UBSI Yogyakarta, Jl. Ringroad Barat, Gamping Kidul, Ambarketawang, Kec. Gamping, Kabupaten Sleman, Daerah Istimewa Yogyakarta 55184</p>
                    <p class="mb-2"><i class="bi bi-envelope me-2"></i>himasi.yog@bsi.ac.id</p>
                    <p class="mb-2"><i class="bi bi-instagram me-2"></i>@himasi_ubsiyogyakarta</p>
                </div>
            </div>
        </div>
        <div class="container">
            <div class="copyright">
                <div class="row">
                    <div class="col-12 text-center mb-3">
                        &copy; <a class="border-bottom" href="{{ route('frontend.index') }}">HimasiHub</a>, All Right Reserved.
                    </div>
                </div>
            </div>
        </div>
    </div>
    <!-- Footer End -->


    <!-- Back to Top -->
    <a href="#" class="btn btn-lg btn-primary btn-lg-square back-to-top"><i class="bi bi-arrow-up"></i></a>


    <!-- JavaScript Libraries -->
    <script src="https://code.jquery.com/jquery-3.4.1.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.0.0/dist/js/bootstrap.bundle.min.js"></script>
    <script src="{{ asset('lib/wow/wow.min.js') }}"></script>
    <script src="{{ asset('lib/easing/easing.min.js') }}"></script>
    <script src="{{ asset('lib/waypoints/waypoints.min.js') }}"></script>
    <script src="{{ asset('lib/owlcarousel/owl.carousel.min.js') }}"></script>

    <!-- Template Javascript -->
    <script src="{{ asset('frontend-assets/js/main.js') }}"></script>

    {{-- Slot untuk script tambahan dari halaman lain --}}
    @stack('scripts')
</body>

</html>