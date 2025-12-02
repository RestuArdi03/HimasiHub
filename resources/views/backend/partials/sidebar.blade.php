<div id="sidebar" class="active">
    <div class="sidebar-wrapper active">

        {{-- SIDEBAR HEADER --}}
        <div class="sidebar-header">
            <div class="d-flex justify-content-between">
                <div class="logo">
                    <a href="{{ route('backend.dashboard') }}"><img src="/backend-assets/images/logo/logo.png" alt="Logo" srcset=""></a>
                </div>
                <div class="toggler">
                    <a href="#" class="sidebar-hide d-xl-none d-block"><i class="bi bi-x bi-middle"></i></a>
                </div>
            </div>
        </div>

        {{-- SIDEBAR MENU --}}
        <div class="sidebar-menu">
            <ul class="menu">

                {{-- UMUM --}}
                <li class="sidebar-title">Menu</li>

                <li class="sidebar-item {{ Route::currentRouteName() == 'backend.dashboard' ? 'active' : '' }} ">
                    <a href="{{ route('backend.dashboard') }}" class='sidebar-link'>
                        <i class="bi bi-grid-fill"></i>
                        <span>Dashboard</span>
                    </a>
                </li>

                <li class="sidebar-item {{ request()->routeIs('backend.anggota.*') ? 'active' : '' }} ">
                    <a href="{{ route('backend.anggota.index') }}" class='sidebar-link'>
                        <i class="bi bi-people-fill"></i>
                        <span>Anggota</span>
                    </a>
                </li>
                
                <li class="sidebar-item  {{ request()->routeIs('backend.user.index') ? 'active' : '' }} ">
                    <a href="{{ route('backend.user.index') }}" class='sidebar-link'>
                        <i class="bi bi-person-fill"></i>
                        <span>Users</span>
                    </a>
                </li>
                
                <li class="sidebar-item  ">
                    <a href="#" class='sidebar-link'>
                        <i class="bi bi-chat-dots-fill"></i>
                        <span>Diskusi</span>
                    </a>
                </li>

                <li class="sidebar-item {{ request()->routeIs('backend.pesan.*') ? 'active' : '' }} ">
                    <a href="{{ route('backend.pesan.index') }}" class='sidebar-link'>
                        <i class="bi bi-chat-right-quote-fill"></i>
                        <span>Pesan</span>
                    </a>
                </li>

                {{-- KEUANGAN --}}
                <li class="sidebar-item {{ request()->routeIs('backend.saldo.*') || request()->routeIs('backend.transaksi.*') || request()->routeIs('backend.kas.*') ? 'active' : '' }} ">
                    <a href="{{ route('backend.saldo.index') }}" class='sidebar-link'>
                        <i class="bi bi-cash"></i>
                        <span>Keuangan</span>
                    </a>
                </li>

                
                {{-- PENCATATAN --}}
                <li class="sidebar-item {{ request()->routeIs('backend.notulen.*') ? 'active' : '' }} ">
                    <a href="{{ route('backend.notulen.index') }}" class='sidebar-link'>
                        <i class="bi bi-journal-text"></i>
                        <span>Pencatatan</span>
                    </a>
                </li>
                
                {{-- PUBLIKASI --}}
                <li class="sidebar-item {{ request()->routeIs('backend.konten.*') ? 'active' : '' }} ">
                    <a href="{{ route('backend.konten.index') }}" class='sidebar-link'>
                        <i class="bi bi-share"></i>
                        <span>Publikasi</span>
                    </a>
                </li>

            </ul>
        </div>
    </div>
</div>
