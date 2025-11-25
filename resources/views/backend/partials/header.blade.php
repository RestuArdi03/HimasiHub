<header class="mb-3">
    <nav class="navbar navbar-expand navbar-light ">
        <div class="container-fluid">
            <a href="#" class="burger-btn d-block d-xl-none">
                <i class="bi bi-justify fs-3"></i>
            </a>

            <button class="navbar-toggler" type="button" data-bs-toggle="collapse"
                data-bs-target="#navbarSupportedContent" aria-controls="navbarSupportedContent"
                aria-expanded="false" aria-label="Toggle navigation">
                <span class="navbar-toggler-icon"></span>
            </button>
            <div class="collapse navbar-collapse" id="navbarSupportedContent">
                <ul class="navbar-nav ms-auto mb-2 mb-lg-0">
                    {{-- Anda bisa menambahkan notifikasi atau menu lain di sini --}}
                </ul>
                <div class="dropdown">
                    <a href="#" data-bs-toggle="dropdown" aria-expanded="false">
                        <div class="user-menu d-flex">
                            <div class="user-name text-end me-3">
                                <h6 class="mb-0 text-gray-600">{{ Auth::user()->nama }}</h6>
                                <p class="mb-0 text-sm text-gray-600">{{ ucfirst(Auth::user()->role?->nama_role ?? 'User') }}</p>
                            </div>
                            <div class="user-img d-flex align-items-center">
                                <div class="avatar avatar-md">
                                    <img src="{{ Auth::user()->avatar ?? 'https://www.gravatar.com/avatar/' . md5(strtolower(trim(Auth::user()->email))) . '?d=mp' }}">
                                </div>
                            </div>
                        </div>
                    </a>
                    <ul class="dropdown-menu dropdown-menu-end" aria-labelledby="dropdownMenuButton">
                        <li><h6 class="dropdown-header">Hello, {{ strtok(Auth::user()->nama, " ") }}!</h6></li>
                        <li><a class="dropdown-item" href="#"><i class="icon-mid bi bi-person me-2"></i>Profil Saya</a></li>
                        <li>
                            <a class="dropdown-item" href="{{ route('frontend.index') }}" onclick="submit();">
                                <i class="icon-mid bi bi-house me-2"></i> Halaman Frontend
                            </a>
                        </li>
                        <li><hr class="dropdown-divider"></li>
                        <li>
                            <a class="dropdown-item" href="{{ route('logout') }}" onclick="event.preventDefault(); document.getElementById('logout-form-header').submit();">
                                <i class="icon-mid bi bi-box-arrow-left me-2"></i> Logout
                            </a>
                            <form id="logout-form-header" action="{{ route('logout') }}" method="POST" class="d-none">@csrf</form>
                        </li>
                    </ul>
                </div>
            </div>
        </div>
    </nav>
</header>