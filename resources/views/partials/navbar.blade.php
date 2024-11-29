<header id="header" class="header sticky-top">
    <div class="branding d-flex align-items-center">
        <div class="container position-relative d-flex align-items-center justify-content-between">
            <a href="{{ route('home') }}" class="logo d-flex align-items-center me-auto">
                <h1 class="sitename">UPT Klinik Bumi Medika ITB</h1>
            </a>

            <nav id="navmenu" class="navmenu">
                <ul class="navbar-nav d-flex flex-row">
                    <li class="nav-item">
                        <a class="nav-link" href="{{ route('home') }}">Beranda</a>
                    </li>
                    @auth
                        <li class="nav-item">
                            <a class="nav-link" href="{{ route('queue.history') }}">Riwayat Panggilan</a>
                        </li>
                        <li class="nav-item">
                            <a class="nav-link" href="{{ route('polis.index') }}">Manajemen Poli</a>
                        </li>
                    @endauth
                   
                </ul>
                <i class="mobile-nav-toggle d-xl-none bi bi-list"></i>
            </nav>

            <ul class="navbar-nav ms-auto d-flex flex-row">
                @auth
                    <li class="nav-item">
                        <form action="{{ route('logout') }}" method="POST" class="d-inline">
                            @csrf
                            <button class="btn cta-btn d-none d-sm-block" type="submit">Logout</button>
                        </form>
                    </li>
                @else
                    <li class="nav-item">
                        <a class="cta-btn d-none d-sm-block" href="{{ route('login') }}">Login</a>
                    </li>
                @endauth
            </ul>
        </div>
    </div>
</header>