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
                <li class="sidebar-title">Menu Utama</li>

                <li class="sidebar-item {{ Route::currentRouteName() == 'backend.dashboard' ? 'active' : '' }} ">
                    <a href="{{ route('backend.dashboard') }}" class='sidebar-link'>
                        <i class="bi bi-grid-fill"></i>
                        <span>Dashboard</span>
                    </a>
                </li>

                <li class="sidebar-item {{ Route::currentRouteName() == 'backend.anggota.index' ? 'active' : '' }} ">
                    <a href="{{ route('backend.anggota.index') }}" class='sidebar-link'>
                        <i class="bi bi-people-fill"></i>
                        <span>Anggota</span>
                    </a>
                </li>
                
                <li class="sidebar-item  ">
                    <a href="#" class='sidebar-link'>
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

                <li class="sidebar-item  ">
                    <a href="#" class='sidebar-link'>
                        <i class="bi bi-chat-right-quote-fill"></i>
                        <span>Usulan</span>
                    </a>
                </li>

                {{-- KEUANGAN --}}
                <li class="sidebar-title">Keuangan</li>
                <li class="sidebar-item  has-sub">
                    <a href="#" class='sidebar-link'>
                        <i class="bi bi-cash"></i>
                        <span>Keuangan</span>
                    </a>
                    <ul class="submenu ">
                        <li class="submenu-item ">
                            <a href="{{ route('backend.saldo.index') }}">Saldo</a>
                        </li>
                        <li class="submenu-item ">
                            <a href="#">Transaksi</a>
                        </li>
                        <li class="submenu-item ">
                            <a href="#">Iuran</a>
                        </li>
                    </ul>
                </li>

                
                {{-- PENCATATAN --}}
                <li class="sidebar-title">Pencatatan</li>
                <li class="sidebar-item  ">
                    <a href="#" class='sidebar-link'>
                        <i class="bi bi-journal-text"></i>
                        <span>Pencatatan</span>
                    </a>
                </li>
                
                {{-- PUBLIKASI --}}
                <li class="sidebar-title">Publikasi</li>
                <li class="sidebar-item  ">
                    <a href="#" class='sidebar-link'>
                        <i class="bi bi-share"></i>
                        <span>Publikasi</span>
                    </a>
                </li>

            </ul>
        </div>
    </div>
</div>
